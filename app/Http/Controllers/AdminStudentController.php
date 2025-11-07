<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminStudentController extends Controller
{
    /**
     * Display list of student accounts.
     */
    public function index(): View
    {
        $students = User::where('role', 'mahasiswa')
                       ->orderBy('name')
                       ->get();
                       
        return view('admin.students.index', compact('students'));
    }

    /**
     * Remove the specified student account.
     */
    public function destroy(int $id)
    {
        $student = User::where('role', 'mahasiswa')->findOrFail($id);
        
        // Hapus proposal terkait jika ada
        $student->proposals()->delete();
        
        // Hapus akun mahasiswa
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Akun mahasiswa berhasil dihapus.');
    }
}