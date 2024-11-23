<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporController extends Controller
{
    public function lapor()
    {
        // Ambil data jenis dari database
        $jenisList = Jenis::with('kategori')->get(); // Menyertakan relasi kategori jika ada
        
        // Kirim variabel $jenisList ke view
        return view('lapor', compact('jenisList'));
    }
}