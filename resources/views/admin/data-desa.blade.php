@extends('layouts.app')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Hi, welcome back {{ Auth::user()->name }}</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Tabel</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Arsip</a></li>
        </ol>
    </div>
</div>
<!-- row -->
<div class="row">
    <div class="col-xl-12 col-xxl-12">
        <div class="card">
            <div class="card-header">
                
                <h4 class="card-title">Daftar Desa di kecamatan {{ $namaKecamatan }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive table-striped">
                    <table class="table text-dark table-responsive-sm display" id="example" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Nama Desa</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($desa as $item)
                                <tr>
                                    <td> {{ $item->nama }} </td>
                                    <td> {{ $item->total }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection