<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasUuids;

    protected $fillable = [
        'nis',
        'nama',
        'domisili',
        'alamat',
        'agama',
        'ttl',
        'jenis_kelamin',
        'nama_ayah',
        'nama_ibu',
        'anak_ke',
        'photo',
        'kelas_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
