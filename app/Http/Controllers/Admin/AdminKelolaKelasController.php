<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminKelolaKelasController extends Controller
{
    public function index()
    {
        confirmDelete('Hapus Kelas', 'Apakah kamu yakin ingin menghapus kelas?');
        return view('admin.kelola.kelas.index', [], ['menu_type' => 'kelola-kelas']);
    }

    public function store(Request $request, $id = null) 
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        Kelas::updateOrCreate(
            ['id' => $id],
            ['nama' => $request->nama]
        );

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function delete($id)
    {
        $data = Kelas::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function data(Request $request)
    {
        $length = intval($request->input('length', 15));
        $start = intval($request->input('start', 0));
        $search = $request->input('search');
        $columns = $request->input('columns');
        $order = $request->input('order');

        $data = Kelas::query();

        if (!empty($order)) {
            $order = $order[0];
            $orderBy = $order['column'];
            $orderDir = $order['dir'];

            if (isset($columns[$orderBy]['data'])) {
                $data->orderBy($columns[$orderBy]['data'], $orderDir);
            } else {
                $data->orderBy('nama', 'asc');
            }
        } else {
            $data->orderBy('nama', 'asc');
        }

        $count = $data->count();
        $countFiltered = $count;

        if (!empty($search['value'])) {
            $data->where('nama', 'LIKE', '%' . $search['value'] . '%');
            $countFiltered = $data->count();
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

    public function dataById($id)
    {
        $data = Kelas::find($id);

        return response()->json($data);
    }
}
