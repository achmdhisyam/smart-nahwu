<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresPengguna extends Model
{
    use HasFactory;

    protected $table = 'progres_pengguna';

    protected $fillable = [
        'user_id',
        'bab_id',
        'jumlah_percobaan',
        'skor_terbaik',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bab()
    {
        return $this->belongsTo(BabJurumiyah::class, 'bab_id');
    }
}
