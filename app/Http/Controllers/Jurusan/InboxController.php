<?php

namespace App\Http\Controllers\Jurusan;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\User;
use App\Notifications\ProposalActionAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class InboxController extends Controller
{
    /**
     * Display inbox - proposals that need Ketua Jurusan action.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Proposal::with(['user', 'dosenKjfd'])
            ->needsKetuaAction();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by bidang minat
        if ($request->filled('bidang')) {
            $query->where('bidang_minat', $request->bidang);
        }

        // Filter by aging
        if ($request->filled('aging')) {
            $aging = (int) $request->aging;
            if ($aging > 0) {
                $query->aging($aging);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
            });
        }

        // Sort by created_at (oldest first by default for inbox)
        $sort = $request->get('sort', 'oldest');
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $proposals = $query->paginate(15);

        // Statistics for cards
        $stats = [
            'total' => Proposal::needsKetuaAction()->count(),
            'waiting_verification' => Proposal::where('status', 'menunggu_verifikasi')->count(),
            'waiting_kjfd' => Proposal::where('status', 'menunggu_verifikasi_dosen_kjfd')->count(),
            'needs_revision' => Proposal::where('status', 'revisi')->count(),
            'aging' => Proposal::needsKetuaAction()->aging(3)->count(),
        ];

        return view('jurusan.inbox.index', compact('proposals', 'stats'));
    }

    /**
     * Display proposal detail in modal/page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $proposal = Proposal::with(['user', 'dosenKjfd'])->findOrFail($id);
        
        return view('jurusan.inbox.show', compact('proposal'));
    }

    /**
     * Trigger notification to related roles based on proposal status.
     * POST /jurusan/inbox/{id}/notify
     */
    public function notify(Request $request, int $id)
    {
        $proposal = Proposal::with('dosenKjfd')->findOrFail($id);

        [$recipients, $targetType] = $this->resolveRecipients($proposal);

        if ($recipients->isEmpty()) {
            return back()->with('error', 'Tidak ditemukan penerima notifikasi untuk status ini.');
        }

        $sent = 0;
        $skipped = 0;
        $nextAvailableTime = null;
        
        foreach ($recipients as $user) {
            $key = "notify:proposal:{$proposal->id}:user:{$user->id}";
            $expiryKey = $key . ':expiry';
            
            if (!Cache::has($key)) {
                // Kirim notifikasi dan simpan cache dengan expiry time
                $user->notify(new ProposalActionAlert($proposal, $targetType, $request->user()));
                $expiryTime = now()->addMinutes(10);
                Cache::put($key, 1, $expiryTime);
                Cache::put($expiryKey, $expiryTime->timestamp, $expiryTime);
                $sent++;
            } else {
                $skipped++;
                // Ambil waktu expiry dari cache
                $expiryTimestamp = Cache::get($expiryKey);
                if ($expiryTimestamp) {
                    $expiryTime = \Carbon\Carbon::createFromTimestamp($expiryTimestamp);
                    if (!$nextAvailableTime || $expiryTime->lt($nextAvailableTime)) {
                        $nextAvailableTime = $expiryTime;
                    }
                }
            }
        }

        // Clear sidebar cache so badge updates if needed
        app(\App\Services\SidebarService::class)->clearCache();

        // Pesan sukses dengan info rate limiting
        if ($sent > 0 && $skipped === 0) {
            return back()->with('success', "Notifikasi berhasil dikirim ke {$sent} penerima.");
        } elseif ($sent > 0 && $skipped > 0) {
            $message = "Notifikasi dikirim ke {$sent} penerima. {$skipped} notifikasi dilewati karena baru saja dikirim.";
            if ($nextAvailableTime && $nextAvailableTime->isFuture()) {
                $minutesLeft = now()->diffInMinutes($nextAvailableTime, true);
                $minutesLeft = ceil($minutesLeft); // Bulatkan ke atas
                if ($minutesLeft > 0) {
                    $message .= " Anda dapat mengirim ulang dalam {$minutesLeft} menit.";
                }
            }
            return back()->with('warning', $message);
        } else {
            // Semua dilewati
            $message = "Notifikasi tidak dikirim. Notifikasi untuk proposal ini baru saja dikirim.";
            if ($nextAvailableTime && $nextAvailableTime->isFuture()) {
                $minutesLeft = now()->diffInMinutes($nextAvailableTime, true);
                $minutesLeft = ceil($minutesLeft); // Bulatkan ke atas
                if ($minutesLeft > 0) {
                    $message .= " Silakan coba lagi dalam {$minutesLeft} menit.";
                } else {
                    $message .= " Silakan coba lagi sebentar lagi.";
                }
            }
            return back()->with('info', $message);
        }
    }

    /**
     * Determine recipients based on proposal status and bidang.
     * @return array{0:\Illuminate\Support\Collection,1:string}
     */
    private function resolveRecipients(Proposal $proposal): array
    {
        // Status "menunggu_verifikasi" -> kirim ke Admin
        if ($proposal->status === 'menunggu_verifikasi') {
            $admins = User::where('role', 'admin')->get();
            return [$admins, 'admin'];
        }

        // Status "menunggu_verifikasi_dosen_kjfd" atau "revisi" -> kirim ke Dosen KJFD sesuai bidang
        if (in_array($proposal->status, ['menunggu_verifikasi_dosen_kjfd', 'revisi'])) {
            // If specific dosen KJFD assigned, notify that person
            if ($proposal->dosen_kjfd_id) {
                $user = User::where('id', $proposal->dosen_kjfd_id)->where('role', 'dosen_kjfd')->get();
                if ($user->isNotEmpty()) {
                    return [$user, 'dosen_kjfd'];
                }
            }

            // else, notify all dosen_kjfd in same bidang if possible
            $bidangCode = $this->mapBidangToCode($proposal->bidang_minat);
            $byBidang = User::where('role', 'dosen_kjfd')
                ->where(function ($q) use ($proposal, $bidangCode) {
                    $q->where('bidang', $proposal->bidang_minat)
                      ->orWhere('bidang', $bidangCode)
                      ->orWhereNull('bidang');
                })->get();

            if ($byBidang->isNotEmpty()) {
                return [$byBidang, 'dosen_kjfd'];
            }

            // fallback: all dosen_kjfd
            $allKjfd = User::where('role', 'dosen_kjfd')->get();
            return [$allKjfd, 'dosen_kjfd'];
        }

        // Default: no recipients
        return [collect(), 'unknown'];
    }

    private function mapBidangToCode(string $bidang): string
    {
        return match($bidang) {
            'Business Intelligence' => 'bi',
            'Data Engineering' => 'de',
            'Information Management' => 'im',
            'Information Retrieval' => 'ir',
            default => strtolower(str_replace(' ', '-', $bidang)),
        };
    }
}
