namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        return view('mahasiswa.dashboard');
    }

    public function storeProposal(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nim' => 'required|string',
            'judul_proposal' => 'required|string',
            'bidang_minat' => 'required|string',
            'file_proposal' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_proposal')) {
            $filePath = $request->file('file_proposal')->store('proposals', 'public');
        }

        Proposal::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => $request->nama_lengkap,
            'nim' => $request->nim,
            'judul_proposal' => $request->judul_proposal,
            'bidang_minat' => $request->bidang_minat,
            'file_proposal' => $filePath,
        ]);

        return redirect()->route('mahasiswa.status')->with('success', 'Proposal berhasil diajukan!');
    }

    public function status()
    {
        $proposals = Proposal::where('user_id', Auth::id())->get();
        return view('mahasiswa.status', compact('proposals'));
    }
}
