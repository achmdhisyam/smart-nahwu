<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKuis extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kuis';

    protected $fillable = [
        'user_id',
        'kuis_id',
        'skor',
        'data_jawaban'
    ];

    protected $casts = [
        'data_jawaban' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kuis()
    {
        return $this->belongsTo(BuatKuis::class, 'kuis_id');
    }
}
