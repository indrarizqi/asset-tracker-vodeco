<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:super_admin,admin'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Edit User
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update User
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:super_admin,admin'],
            ]);
            
            // Cegah Super Admin menurunkan jabatannya sendiri
            if (Auth::id() == $user->id && $request->role != 'super_admin') {
                return back()->with('error', 'Demi keamanan, Anda tidak bisa menurunkan jabatan sendiri. Silakan buat Super Admin lain dulu.');
            }
        
        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Update password HANYA JIKA diisi (biar gak reset kalau kosong)
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data user diperbarui!');
    }

    // Hapus User
    public function destroy(User $user)
    {
        // Super Admin tidak boleh menghapus diri sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Super Admin!');
        }

        // Jika yang dihapus Super Admin, pastikan bukan yang terakhir
        if ($user->role === 'super_admin') {
            $superAdminCount = User::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Tidak dapat menghapus Super Admin terakhir. Sistem harus memiliki minimal satu Super Admin!');
            }
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
