<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;
    protected $table = 'pelaporan';

    protected $fillable = [
        'judul',
        'kategori_id',
        'jenis_id',
        'deskripsi',
        'tanggal_laporan',
        'media',
        'nama_pelapor',
        'user_id',
        'lokasi',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusLaporan::class, 'status_id');
    }

    // Relasi ke model Jenis
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    // Relasi ke model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke model Voting
    public function votings()
    {
        return $this->hasMany(Voting::class, 'laporan_id');
    }

   // Menghitung total upvotes
   public function getUpVoteCountAttribute()
   {
       return $this->votings()->where('up_vote', 1)->count();  // Menggunakan up_vote = 1 untuk menghitung upvotes
   }

   // Menghitung total downvotes
   public function getDownVoteCountAttribute()
   {
       return $this->votings()->where('down_vote', 1)->count();  // Menggunakan down_vote = 1 untuk menghitung downvotes
   }
   
   protected static function boot()
    {
        parent::boot();

        // Event deleting untuk menghapus relasi
        static::deleting(function ($laporan) {
            $laporan->votings()->delete(); // Menghapus semua voting terkait
        });
    }
}