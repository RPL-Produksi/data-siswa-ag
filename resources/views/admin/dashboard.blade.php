@extends('layouts.app')
@section('title', 'Dashboard')

@push('css')
    {{-- CSS Only For This Page --}}
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger collapsed" role="button" data-toggle="collapse" data-target="#changelogItems"
                aria-expanded="false">
                Changelog
                <ul class="collapse" id="changelogItems">
                    <li>Perbaikan Loader</li>
                    <li>Perbaikan Fitur Submit Form</li>
                    <li>Perbaikan Login</li>
                    <li>Menambah Fitur Profile</li>
                    <li>Menambah Password Pada Pemilu Yang Private</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- JS Only For This Page --}}
@endpush
