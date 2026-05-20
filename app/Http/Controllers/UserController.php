<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
    $users = \App\Models\User::orderBy('role', 'asc')->get();
    return view('admin.users.index', compact('users'));
}

public function create() {
    return view('admin.users.create');
}

    public function store(Request $request) {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return back()->with('success', 'User berhasil ditambah!');
    }

    public function destroy(User $user) {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }


public function edit(User $user) {
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, User $user) {
    $data = $request->only(['name', 'email', 'role']);
    if ($request->password) {
        $data['password'] = Hash::make($request->password);
    }
    $user->update($data);
    return redirect()->route('users.index')->with('success', 'User diupdate!');
}
}