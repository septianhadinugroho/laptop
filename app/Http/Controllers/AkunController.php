<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    public function akun()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Mengirim data user ke view akun
        return view('akun', compact('user'));
    }
    // profile admin
    public function profile(){
        return view('admin.profile');
    }
}
