<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminKelolaSiswaController extends Controller
{
    public function index()
    {
        $data['kelas'] = Kelas::orderBy('nama', 'asc')->get();

        confirmDelete('Hapus Siswa', 'Apakah kamu yakin ingin menghapus siswa?');
        return view('admin.kelola.siswa.index', [], ['menu_type' => 'kelola-siswa'])->with($data);
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
        return redirect()->route('admin.kelola.siswa')->with('success', 'Data berhasil disimpan');
    }

    public function data(Request $request)
    {
        $length = intval($request->input('length', 15));
        $start = intval($request->input('start', 0));
        $search = $request->input('search');
        $columns = $request->input('columns');
        $order = $request->input('order');

        $data = Siswa::query()->with('kelas')->select('siswas.*');

        if (!empty($search['value'])) {
            $searchValue = $search['value'];
            $data->where(function ($query) use ($searchValue) {
                $query->where('siswas.nama', 'LIKE', "%{$searchValue}%")
                    ->orWhere('siswas.nis', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('kelas', function ($q) use ($searchValue) {
                        $q->where('nama', 'LIKE', "%{$searchValue}%");
                    });
            });
        }

        $count = Siswa::count();
        $countFiltered = $data->count();

        if (!empty($order)) {
            $order = $order[0];
            $orderByIndex = $order['column'];
            $orderDir = $order['dir'];

            if (isset($columns[$orderByIndex]['data'])) {
                $columnName = $columns[$orderByIndex]['data'];

                if ($columnName == 'nama') {
                    $data->orderBy('siswas.nama', $orderDir);
                } elseif ($columnName == 'kelas.nama') {
                    $data->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
                        ->orderBy('kelas.nama', $orderDir);
                }
            } else {
                $data->orderBy('siswas.nama', 'asc');
            }
        } else {
            $data->orderBy('siswas.nama', 'asc');
        }

        $data = $data->skip($start)->take($length)->get();

        $response = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $count,
            "recordsFiltered" => $countFiltered,
            "limit" => $length,
            "data" => $data
        ];

        return response()->json($response);
    }

    public function delete($id)
    {
        $data = Siswa::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function importSiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required',
            'file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        Excel::import(new SiswaImport($request->kelas_id), $request->file('file'));
        return redirect()->back()->with('success', 'Data berhasil diimport');
    }
}
