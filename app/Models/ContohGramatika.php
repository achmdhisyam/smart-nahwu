<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContohGramatika extends Model
{
    use HasFactory;

    protected $table = 'contoh_gramatika';

    protected $fillable = [
        'bab_id',
        'teks_arab',
        'terjemahan'
    ];

    public function bab()
    {
        return $this->belongsTo(BabJurumiyah::class, 'bab_id');
    }
}
