<?php

namespace App\Http\Controllers; // Pastikan namespace ini benar

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Halaman untuk Supervisor mendaftarkan Karyawan
    public function indexKaryawan() {
        $users = User::where('section', Auth::user()->section)
                    ->where('role', 'Karyawan')
                    ->latest()
                    ->get();
        return view('spv.users.index', compact('users'));
    }

    // Proses Simpan Karyawan oleh Supervisor
    public function storeKaryawanBySpv(Request $request) {
        $spv = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Karyawan',
            'department' => $spv->department,
            'section' => $spv->section,
        ]);

        return back()->with('success', 'Karyawan baru berhasil didaftarkan ke tim Anda.');
    }

    // Halaman untuk Admin SDM mendaftarkan Struktural (Manager/SPV)
    public function index() {
        $users = User::whereIn('role', ['Manager', 'Supervisor'])->latest()->get();
        // Mengambil data pejabat struktural (Manager & Supervisor)
        $users = \App\Models\User::whereIn('role', ['Manager', 'Supervisor'])
                    ->orderBy('department', 'asc')
                    ->get();
                    
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'department' => 'required',
            'section' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password), // Password di-encrypt            
            'role' => $request->role,
            'department' => $request->department,
            'section' => $request->section,
        ]);

        return back()->with('success', 'Akun berhasil dibuat dan siap digunakan.');
    }
}