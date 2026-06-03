<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HurufTugas extends Model
{
    use HasFactory;

    protected $table = 'huruf_tugas';

    protected $fillable = [
        'bab_id',
        'kata',
        'jenis_partikel'
    ];

    public function bab()
    {
        return $this->belongsTo(BabJurumiyah::class, 'bab_id');
    }
}
