@extends('layouts.app')
@section('title', 'Kelola Kelas')

@push('css')
    {{-- CSS Only For This Page --}}
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title text-danger">Kelola Kelas</h4>
                        </div>
                        <button class="btn btn-danger" data-target="#tambahKelasModal" data-toggle="modal">
                            <i class="fa-regular fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered w-100 nowrap" id="table-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahKelasModal" tabindex="-1" role="dialog" aria-labelledby="tambahKelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKelasModalLabel">Tambah Kelas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.kelola.kelas.store') }}" method="POST" class="form-with-loading">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Masukkan nama kelas" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-loading">
                            <span class="btn-text">Tambah</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editKelasModal" tabindex="-1" role="dialog" aria-labelledby="editKelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKelasModalLabel">Tambah Kelas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="editKelasForm" action="" method="POST" class="form-with-loading">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="editNama">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama" id="editNama"
                                placeholder="Masukkan nama kelas" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-loading">
                            <span class="btn-text">Ubah</span>
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
    <script>
        $(document).ready(() => {
            $('#table-1').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.kelola.kelas.data') }}",
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
                        data: 'nama',
                        orderable: true,
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            const deleteUrl = "{{ route('admin.kelola.kelas.delete', ':id') }}"

                            let editBtn =
                                `<a onclick="edit('${row.id}')" class="btn btn-danger mr-1"><i class="fa-regular fa-edit"></i></a>`;
                            let deleteBtn =
                                `<a href="${deleteUrl.replace(':id', row.id)}" class="btn btn-primary" data-confirm-delete="true"><i class="fa-regular fa-trash"></i></a>`;
                            return `${editBtn}${deleteBtn}`;
                        }
                    }
                ],
            });
        })
    </script>
    <script>
        const edit = (id) => {
            $.getJSON(`${window.location.origin}/admin/kelola/kelas/data/${id}`, (data) => {
                const updateUrl = "{{ route('admin.kelola.kelas.store', ':id') }}"

                $('#editKelasForm').attr('action', updateUrl.replace(':id', id))
                $('#editNama').val(data.nama)

                const myModal = new bootstrap.Modal(document.getElementById('editKelasModal'))
                myModal.show()
            })
        }
    </script>
@endpush
