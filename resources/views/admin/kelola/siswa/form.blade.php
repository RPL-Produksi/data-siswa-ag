@extends('layouts.app')
@section('title', 'Form Siswa')

@push('css')
    {{-- CSS Only For This Page --}}
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2-bootstrap-5-theme.css') }}">
@endpush

@section('content')
    <div class="row">
        @include('templates.feedbacks')
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="text-danger">Form Siswa</h4>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.kelola.siswa.store', @$siswa->id) }}" class="form-group form-with-loading"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" name="nis" id="nis"
                                        value="{{ @old('nis', @$siswa->nis) }}" placeholder="Masukkan NIS" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="{{ @old('nama', @$siswa->nama) }}" placeholder="Masukkan Nama" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <select name="kelas_id" id="kelas" class="form-control select-kelas" required>
                                        <option value="" @selected(old('kelas_id', @$siswa->kelas_id) == '')>Pilih Kelas</option>
                                        @foreach ($kelas as $item)
                                            <option @selected(old('kelas_id', @$siswa->kelas_id) == $item->id) value="{{ $item->id }}">
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    @php
                                        $agama = ['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghuchu'];
                                    @endphp

                                    <label for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-control select-agama" required>
                                        <option value="" @selected(old('agama', @$siswa->agama) == '')>Pilih Agama</option>
                                        @foreach ($agama as $item)
                                            <option value="{{ $item }}" @selected(old('agama', @$siswa->agama) == $item)>
                                                {{ ucfirst($item) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="ttl">Tempat Tanggal Lahir</label>
                                    <input type="text" class="form-control" name="ttl" id="ttl"
                                        value="{{ @old('ttl', @$siswa->ttl) }}" placeholder="Masukkan Tempat Tanggal Lahir"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    @php
                                        $jenis_kelamin = [
                                            'L' => 'Laki-Laki',
                                            'P' => 'Perempuan',
                                        ];
                                    @endphp

                                    <label for="">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="" class="form-control select-jenkel" required>
                                        <option value="" @selected(old('jenis_kelamin', @$siswa->jenis_kelamin))>Pilih Jenis Kelamin</option>
                                        @foreach ($jenis_kelamin as $key => $value)
                                            <option value="{{ $key }}" @selected(old('jenis_kelamin', @$siswa->jenis_kelamin) == $key)>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Ayah</label>
                                    <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                                        value="{{ @old('nama_ayah', @$siswa->nama_ayah) }}"
                                        placeholder="Masukkan Nama Ayah" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Ibu</label>
                                    <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                                        value="{{ @old('nama_ibu', @$siswa->nama_ibu) }}" placeholder="Masukkan Nama Ibu"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Anak Ke</label>
                                    <input type="number" class="form-control" name="anak_ke" id="anak_ke"
                                        value="{{ @old('anak_ke', @$siswa->anak_ke) }}"placeholder="Masukkan Anak Ke"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Domisili</label>
                                    <input type="text" class="form-control" name="domisili" id="domisili"
                                        value="{{ @old('domisili', @$siswa->domisili) }}"placeholder="Masukkan Domisili"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5">{{ @old('alamat', @$siswa->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{ route('admin.kelola.siswa') }}" class="btn btn-link" type="button">Batal</a>
                            <button type="submit" class="btn btn-danger btn-loading">
                                <span class="btn-text">Tambah</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- JS Only For This Page --}}
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select-kelas').select2({
                theme: 'bootstrap-5',
                tags: true,
                placeholder: 'Pilih Kelas',
                allowClear: true
            });

            $('.select-agama').select2({
                theme: 'bootstrap-5',
                tags: true,
                placeholder: 'Pilih Agama',
                allowClear: true
            });

            $('.select-jenkel').select2({
                theme: 'bootstrap-5',
                tags: true,
                placeholder: 'Pilih Jenis Kelamin',
                allowClear: true
            });
        });
    </script>
@endpush
