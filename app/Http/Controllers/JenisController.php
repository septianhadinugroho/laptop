<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function jenis(){
        return view('admin.jenis');
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name_jenis' => 'required|string|max:255',
            'kategori_id' => 'required|integer|exists:kategori,id', // Validasi untuk kategori_id yang valid
        ]);

        // Menambahkan jenis baru ke dalam database
        Jenis::create([
            'name_jenis' => $request->name_jenis,
            'kategori_id' => $request->kategori_id, // Pastikan kategori_id ada dan diisi
        ]);

        // Redirect atau beri respons berhasil
        return redirect()->route('jenis')->with('success', 'Jenis berhasil ditambahkan!');
    }

}
