<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaidahGramatika extends Model
{
    use HasFactory;

    protected $table = 'kaidah_gramatika';

    protected $fillable = [
        'bab_id',
        'kode_kaidah',
        'teks_kaidah'
    ];

    public function bab()
    {
        return $this->belongsTo(BabJurumiyah::class, 'bab_id');
    }
}
