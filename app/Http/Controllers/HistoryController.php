<?php

namespace App\Http\Controllers;

use App\Models\HistoryLaporan;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function history()
    {
        $user = auth()->user();

        // Fetch the user's reports with related status, jenis, and kategori
        $pelaporans = Pelaporan::where('user_id', $user->id)
            ->whereNotNull('user_id')  // Pastikan user_id tidak null
            ->with(['status', 'jenis', 'kategori']) // Menambahkan relasi jika diperlukan
            ->get();

        // Pass the reports to the view
        return view('history', compact('pelaporans')); // Pastikan nama variabel sesuai
    }

    // history hal admin
        public function historylaporan()
    {
        $history = HistoryLaporan::with(['pelaporan.status', 'pelaporan.jenis', 'pelaporan.kategori'])
            ->get();
    
        return view('admin.historylaporan', compact('history'));
    }
}