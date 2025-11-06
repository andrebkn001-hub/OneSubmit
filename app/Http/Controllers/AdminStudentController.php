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
                       ->select('name', 'nim', 'email')
                       ->orderBy('name')
                       ->get();
                       
        return view('admin.students.index', compact('students'));
    }
}