<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pelaporan;
use App\Models\Voting;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function voting()
    {
        // Mengambil user yang sedang login
        $user = Auth::user();
    
        // Mengambil laporan kategori 'Berat' dengan jumlah upvote dan downvote, dan hanya yang belum selesai
        $laporanBerat = Pelaporan::where('kategori_id', 2)
            ->where('status_id', '!=', 3) // Hanya laporan yang belum selesai
            ->with([
                'votings' => function ($query) {
                    $query->selectRaw('sum(up_vote) as upvote_count, sum(down_vote) as downvote_count');
                }
            ])
            ->get()
            ->map(function ($item) {
                $item->media = json_decode($item->media); // Decode JSON media
                // Hitung net votes
                $totalUpvotes = Voting::where('laporan_id', $item->id)->sum('up_vote');
                $totalDownvotes = Voting::where('laporan_id', $item->id)->sum('down_vote');
                $item->net_votes = max(0, $totalUpvotes - $totalDownvotes); // Net vote tidak boleh minus
                return $item;
            });
    
        // Urutkan laporan berdasarkan net_votes (vote terbesar di atas)
        $laporanBerat = $laporanBerat->sortByDesc('net_votes');
    
        // Mengirim data user dan laporan ke view voting
        return view('voting', compact('user', 'laporanBerat'));
    }    

    // Proses upvote atau downvote
    public function vote($id, Request $request)
    {
        // Validasi input
        $request->validate([
            'change' => 'required|string|in:up,down',
        ]);
    
        $change = $request->input('change');
        $userId = Auth::id(); // ID user yang login
    
        // Cari atau buat record voting untuk user dan laporan ini
        $voting = Voting::firstOrNew(
            ['user_id' => $userId, 'laporan_id' => $id],
            ['up_vote' => 0, 'down_vote' => 0]
        );
    
        // Cek apakah user sudah memilih jenis vote yang sama
        if ($change === 'up' && $voting->up_vote === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memilih upvote untuk laporan ini.',
            ]);
        }
    
        if ($change === 'down' && $voting->down_vote === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memilih downvote untuk laporan ini.',
            ]);
        }
    
        // Hitung total upvote dan downvote untuk laporan ini sebelum perubahan
        $totalUpvotes = Voting::where('laporan_id', $id)->sum('up_vote');
        $totalDownvotes = Voting::where('laporan_id', $id)->sum('down_vote');
        $netVotes = max(0, $totalUpvotes - $totalDownvotes);
    
        // Cek jika mencoba downvote dengan jumlah vote 0
        if ($change === 'down' && $netVotes === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa memberikan downvote karena jumlah vote masih 0.',
            ]);
        }
    
        // Update voting
        if ($change === 'up') {
            $voting->up_vote = 1; // Berikan upvote
            $voting->down_vote = 0; // Hapus downvote jika ada
        } elseif ($change === 'down') {
            $voting->up_vote = max(0, $voting->up_vote - 1); // Kurangi upvote jika memilih downvote
            $voting->down_vote = 0; // Tidak perlu menambah downvote
        }
    
        // Simpan perubahan
        $voting->save();
    
        // Hitung ulang jumlah vote
        $totalUpvotes = Voting::where('laporan_id', $id)->sum('up_vote');
        $totalDownvotes = Voting::where('laporan_id', $id)->sum('down_vote');
        $netVotes = max(0, $totalUpvotes - $totalDownvotes); // Pastikan netVotes tidak minus
    
        return response()->json([
            'success' => true,
            'message' => $change === 'up' ? 'Upvote berhasil diberikan.' : 'Downvote berhasil diberikan.',
            'netVotes' => $netVotes,
        ]);
    }                      
}