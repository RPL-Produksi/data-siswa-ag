<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminKelolaKelasController extends Controller
{
    public function index()
    {
        $data['kelas'] = Kelas::orderBy('nama', 'asc')->get();

        return view('admin.kelola.kelas.index', [], ['menu_type' => 'kelola-kelas'])->with($data);
    }
}
