<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    protected $kelasId;

    public function __construct($kelasId)
    {
        $this->kelasId = $kelasId;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        Siswa::create([
            'nis' => $row[1],
            'nama' => $row[2],
            'agama' => $row[3],
            'ttl' => $row[4],
            'jenis_kelamin' => $row[5],
            'nama_ayah' => $row[6],
            'nama_ibu' => $row[7],
            'anak_ke' => $row[8],
            'domisili' => $row[9],
            'alamat' => $row[10],
            'kelas_id' => $this->kelasId
        ]);
    }
}
