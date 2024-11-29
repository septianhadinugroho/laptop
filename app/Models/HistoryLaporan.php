<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLaporan extends Model
{
    use HasFactory;

    protected $table = 'history_laporan';

    protected $fillable = [
        'id',
        'laporan_id',
        'user_id',
        'tanggal_selesai',
    ];

    // Relasi ke Pelaporan jika diperlukan
    public function pelaporan()
    {
        return $this->belongsTo(Pelaporan::class, 'laporan_id');
    }

}