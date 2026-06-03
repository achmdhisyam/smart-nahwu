<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencapaian extends Model
{
    use HasFactory;

    protected $table = 'pencapaian';

    protected $fillable = [
        'kode_pencapaian',
        'judul',
        'deskripsi',
        'ikon_pencapaian'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pencapaian_user', 'pencapaian_id', 'user_id')
                    ->withPivot('terbuka_pada')
                    ->withTimestamps();
    }
}
