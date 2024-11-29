<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;

class AdminVotingController extends Controller
{
    /**
     * Menampilkan laporan dengan total upvote
     */
    public function index()
    {
        // Ambil semua laporan dengan kategori berat (kategori_id = 2) beserta jumlah upvote
        $laporans = Pelaporan::where('kategori_id', 2) // Filter berdasarkan kategori_id = 2
        ->withCount([
            'votings as total_upvotes' => function ($query) {
                $query->selectRaw('sum(up_vote)'); // Hitung total upvote
            }
        ])
        ->orderByDesc('total_upvotes') // Urutkan berdasarkan jumlah upvote terbanyak
        ->get();

        // Kirim data laporan ke view
        return view('admin.voting', compact('laporans'));
    }
}