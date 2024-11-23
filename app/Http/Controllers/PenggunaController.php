<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function pengguna(){
        $users = User::all();
        return view('admin.pengguna', compact('users'));
    }

    // PenggunaController.php
// PenggunaController.php
public function tambahAkun(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role_id' => 'required|in:1,2' // Validate role to be either 1 or 2
    ]);

    // Create the user with the selected role
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id,
    ]);

    return redirect()->route('pengguna')->with('success', 'User added successfully.');
}


public function hapusAkun($id) {
    $user = User::findOrFail($id);  // Get the user by ID
    $user->delete();  // Delete the user
    return redirect()->route('pengguna')->with('success', 'User deleted successfully.');
}

}
