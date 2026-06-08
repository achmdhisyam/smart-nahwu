<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabJurumiyah extends Model
{
    use HasFactory;

    protected $table = 'bab_jurumiyah';

    protected $fillable = [
        'induk_id',
        'judul',
        'definisi',
        'matan_arab',
        'nomor_urut',
        'langkah_belajar'
    ];

    public function induk()
    {
        return $this->belongsTo(BabJurumiyah::class, 'induk_id');
    }

    public function anak()
    {
        return $this->hasMany(BabJurumiyah::class, 'induk_id');
    }

    public function kaidahGramatika()
    {
        return $this->hasMany(KaidahGramatika::class, 'bab_id');
    }

    public function contohGramatika()
    {
        return $this->hasMany(ContohGramatika::class, 'bab_id');
    }

    public function hurufTugas()
    {
        return $this->hasMany(HurufTugas::class, 'bab_id');
    }

    public function buatKuis()
    {
        return $this->hasOne(BuatKuis::class, 'bab_id');
    }

    public function progresPengguna()
    {
        return $this->hasMany(ProgresPengguna::class, 'bab_id');
    }
}
