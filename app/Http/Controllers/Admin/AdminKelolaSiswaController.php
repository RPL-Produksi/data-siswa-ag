<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminKelolaSiswaController extends Controller
{
    public function index()
    {
        confirmDelete('Hapus Siswa', 'Apakah kamu yakin ingin menghapus siswa?');
        return view('admin.kelola.siswa.index', [], ['menu_type' => 'kelola-siswa']);
    }

    public function form($id = null)
    {
        $data['siswa'] = Siswa::where('id', $id)->first();
        $data['kelas'] = Kelas::orderBy('nama', 'asc')->get();
        return view('admin.kelola.siswa.form', [], ['menu_type' => 'kelola-siswa'])->with($data);
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'nama' => 'required',
            'domisili' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'anak_ke' => 'required',
            'photo' => 'nullable|file',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $input = $request->all();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $storedFile = $file->storeAs('siswa/photo', $file->hashName());
            $input['photo'] = Storage::url($storedFile);
        }

        Siswa::updateOrCreate(['id' => $id], $input);
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
