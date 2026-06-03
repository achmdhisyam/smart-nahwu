<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAnalisis extends Model
{
    use HasFactory;

    protected $table = 'riwayat_analisis';

    protected $fillable = [
        'user_id',
        'input_text',
        'text_hash',
        'hasil_analisis'
    ];

    protected $casts = [
        'hasil_analisis' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
