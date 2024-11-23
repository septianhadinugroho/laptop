<?php

namespace App\Http\Controllers;

use App\Models\HistoryLaporan;
use App\Models\Pelaporan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $userCount = User::where('role_id', '!=', 1)->count();
        $laporanCount = Pelaporan::count();
        $historyCount = HistoryLaporan::count();

        $laporanPerBulan = Pelaporan::selectRaw('MONTH(tanggal_laporan) as bulan, COUNT(*) as jumlah')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        return view('admin.dashboard', ['user_count' => $userCount, 'laporan_count' => $laporanCount, 'history_count' => $historyCount, 'laporan_per_bulan' => $laporanPerBulan]);
    }
}
