<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index
    public function index()
    {
        //search by name, pagination 10
        $users = User::where('name', 'like', '%' . request('name') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    //create
    public function create()
    {
        return view('pages.users.create');
    }

    //store
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255', // Validasi nama, wajib diisi, string, dan maksimal 255 karakter
            'email' => 'required|email|unique:users,email', // Wajib diisi, format email, dan harus unik di tabel users
            'phone' => 'nullable|string|max:15', // Tidak wajib, string, dan maksimal 15 karakter
            'role' => 'required|in:admin,staff,supervisor', // Wajib diisi, harus salah satu dari pilihan (admin, user, manager)
            'password' => 'required|string|min:8', // Wajib diisi, minimal 8 karakter, dan harus ada konfirmasi password
            'position' => 'required|string|max:100', // Wajib diisi, string, maksimal 100 karakter
            'department' => 'nullable|string|max:100', // Tidak wajib, string, maksimal 100 karakter
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'position' => $request->position,
            'department' => $request->department,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    //edit
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    //update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'position' => $request->position,
            'department' => $request->department,
        ]);

        //if password filled
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    //destroy
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
