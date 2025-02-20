@extends('layouts.app')
@section('title', 'Kelola Siswa')

@push('css')
    {{-- CSS Only For This Page --}}
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2-bootstrap-5-theme.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title text-danger">Kelola Siswa</h4>
                        </div>
                        <a href="{{ route('admin.kelola.siswa.form') }}" class="btn btn-danger mr-2">
                            <i class="fa-regular fa-plus"></i>
                        </a>
                        <button class="btn btn-success" data-target="#importSiswaModal" data-toggle="modal"><i
                                class="fa-regular fa-file-excel"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered w-100 nowrap" id="table-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Agama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importSiswaModal" tabindex="-1" role="dialog" aria-labelledby="importSiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importSiswaModalLabel">Import Data Siswa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.kelola.siswa.import') }}" method="POST" enctype="multipart/form-data"
                    class="form-with-loading">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas_id" id="import-kelas-select" class="form-control select-kelas">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File CSV | Excel</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <div class="form-group align-items-center">
                            <label for="table">Contoh Table</label>
                            <span class="text-danger">*tidak di beri header</span>
                            <a href="{{ asset('assets/Data Siswa (Contoh).xlsx') }}"
                                class="btn btn-danger float-right mb-2"><i class="fa-regular fa-download"></i></a>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>123456789</td>
                                            <td>John Doe</td>
                                            <td>Islam</td>
                                            <td>Sukabumi, 01 Januari 2000</td>
                                            <td>L/P</td>
                                            <td>Ada</td>
                                            <td>Lovelace</td>
                                            <td>1</td>
                                            <td>Kota</td>
                                            <td>Jl. Pelabuhan</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                            <td>...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-loading">
                            <span class="btn-text">Import</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(() => {
            $('#table-1').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.kelola.siswa.data') }}",
                    data: function(e) {
                        return e;
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: null,
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            let pageInfo = $('#table-1').DataTable().page.info();
                            return meta.row + 1 + pageInfo.start;
                        }
                    },
                    {
                        data: 'nis',
                        orderable: false,
                    },
                    {
                        data: 'nama',
                        orderable: true,
                    },
                    {
                        data: 'kelas.nama',
                        orderable: true,
                    },
                    {
                        data: 'agama',
                        orderable: false,
                        className: 'text-capitalize'
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            const deleteUrl = "{{ route('admin.kelola.siswa.delete', ':id') }}";
                            const editForm = "{{ route('admin.kelola.siswa.form', ':id') }}";

                            let editBtn =
                                `<a href="${editForm.replace(":id", row.id)}" class="btn btn-danger mr-1"> <i class="fa-regular fa-edit"></i></a>`;
                            let deleteBtn =
                                `<a href="${deleteUrl.replace(':id', row.id)}" class="btn btn-primary"data-confirm-delete="true"><i class="fa-regular fa-trash"></i></a>`;
                            return `${editBtn}${deleteBtn}`;
                        }
                    }
                ],
            });
        });
    </script>
    <script>
        $(document).ready(() => {
            $('.select-kelas').select2({
                theme: 'bootstrap-5',
                tags: true,
                placeholder: 'Pilih Kelas',
                allowClear: true
            })
        })
    </script>
@endpush
