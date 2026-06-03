<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuatKuis extends Model
{
    use HasFactory;

    protected $table = 'buat_kuis';

    protected $fillable = [
        'bab_id',
        'judul',
        'data_pertanyaan'
    ];

    protected $casts = [
        'data_pertanyaan' => 'array'
    ];

    public function bab()
    {
        return $this->belongsTo(BabJurumiyah::class, 'bab_id');
    }

    public function riwayatKuis()
    {
        return $this->hasMany(RiwayatKuis::class, 'kuis_id');
    }
}
