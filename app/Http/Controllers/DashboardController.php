<?php

namespace App\Http\Controllers;

use App\Models\HistoryLaporan;
use App\Models\Pelaporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function calculateWeeks($year, $month)
    {
        $weeks = [];
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Iterasi setiap minggu
        $currentWeekStart = $startOfMonth->copy();
        while ($currentWeekStart <= $endOfMonth) {
            $currentWeekEnd = $currentWeekStart->copy()->endOfWeek();

            // Pastikan akhir minggu tidak melebihi akhir bulan
            if ($currentWeekEnd > $endOfMonth) {
                $currentWeekEnd = $endOfMonth;
            }

            $weeks[] = [
                'start' => $currentWeekStart->copy(),
                'end' => $currentWeekEnd->copy(),
            ];

            // Pindah ke minggu berikutnya
            $currentWeekStart = $currentWeekEnd->copy()->addDay();
        }

        return $weeks;
    }

    public function dashboard(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $userCount = User::where('role_id', '!=', 1)->count();
        $laporanCount = Pelaporan::count();
        $historyCount = HistoryLaporan::count();

        // Data laporan per minggu
        $weeks = $this->calculateWeeks($tahun, $bulan);
        $laporanPerMinggu = collect($weeks)->map(function ($week) use ($bulan, $tahun) {
            $jumlah = Pelaporan::whereBetween('tanggal_laporan', [$week['start'], $week['end']])
                ->whereMonth('tanggal_laporan', $bulan)
                ->whereYear('tanggal_laporan', $tahun)
                ->count();

            return [
                'minggu' => $week['start']->format('d M') . ' - ' . $week['end']->format('d M'),
                'jumlah' => $jumlah,
            ];
        });



        // Data laporan per bulan
        $laporanPerBulan = DB::table('pelaporan')
            ->selectRaw('MONTH(tanggal_laporan) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_laporan', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $laporanPerTahun = DB::table('pelaporan')
            ->selectRaw('YEAR(tanggal_laporan) as tahun, COUNT(*) as jumlah')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

                return view('admin.dashboard', [
                    'user_count' => $userCount,
                    'laporan_count' => $laporanCount,
                    'history_count' => $historyCount,
                    'laporan_per_minggu' => $laporanPerMinggu,
                    'laporan_per_bulan' => $laporanPerBulan,
                    'laporan_per_tahun' => $laporanPerTahun,
                    'selected_bulan' => $bulan,
                    'selected_tahun' => $tahun,
        ]);
    }
}