<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;
     // Tentukan nama tabel jika tidak menggunakan konvensi penamaan Laravel
     protected $table = 'voting';

     // Field yang bisa diisi secara massal
     protected $fillable = [
        'laporan_id',
        'user_id',
        'up_vote', // Jumlah upvote
        'down_vote', // Jumlah downvote
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Pelaporan (laporan_id adalah foreign key)
    public function laporan()
    {
        return $this->belongsTo(Pelaporan::class, 'laporan_id');
    }

    // Method untuk menambahkan upvote
    public function addUpvote()
    {
        $this->increment('up_vote');
    }

    // Method untuk menambahkan downvote
    public function addDownvote()
    {
        $this->increment('down_vote');
    }
}
