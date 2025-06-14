<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';
    protected $primaryKey = 'NoAnggotaM';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'NoAnggotaM',
        'NIS',
        'NamaAnggota',
        'TTL',
        'Jenis_Kelamin',
        'Alamat',
        'Kelas',
        'NoTelp',
        'NamaOrtu',
        'NoTelpOrtu',
    ];

    protected $casts = [
        'TTL' => 'datetime',
    ];

    public function peminjaman_siswa()
    {
        return $this->hasMany(PeminjamanSiswa::class, 'NoAnggotaM', 'NoAnggotaM');
    }

    public function pengembalian_siswa()
    {
        return $this->hasManyThrough(
            PengembalianSiswa::class,
            'NoAnggotaM',
            'NoPinjamM',
            'NoAnggotaM',
            'NoPinjamM'
        );
    }
}
