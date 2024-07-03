@extends('layouts.app')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Hi, Selamat Datang {{ Auth::user()->name }}</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Daftar Masyarakat</a></li>
        </ol>
    </div>
</div>
<!-- row -->
<div class="row">
    <div class="col-xl-12 col-xxl-12">
        <div class="card">
            <div class="card-header">
                
                <h4 class="card-title">Daftar Masyarakat</h4>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-dark table-responsive-sm display" id="example" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($masyarakat as $a)
                                <tr>
                                    <td> {{ $a->name }} </td>
                                    <td> {{ $a->kecamatan }} </td>
                                    <td> {{ $a->desa }} </td>
                                    <td class="d-flex justify-content-center">
                                        {{-- <button type="button" style="width: 61px; margin-right: 2%" data-toggle="modal" data-target="#editModal{{ $a->id_arkep }}" class="btn btn-rounded btn-info btn-xs">Edit</button> --}}
                                        <form action="{{ route('admin.delete-masyarakat', ['id' => $a->nik]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            
                                            <button type="submit" style="width: 61px" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($masyarakat as $a)
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{ $a->id_arkep }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $a->id_arkep }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $a->id_arkep }}">Edit Arsip</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label>Kategori</label>
                                                        <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                                            <option @if ($a->kategori == 'Kartu Keluarga') selected @endif value="Kartu Keluarga">Kartu Keluarga</option>
                                                            <option @if ($a->kategori == 'Akte Kelahiran') selected @endif value="Akte Kelahiran">Akte Kelahiran</option>
                                                            <option @if ($a->kategori == 'Lain - Lain') selected @endif value="Lain - Lain">Lain - Lain</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi:</label>
                                                        <textarea name="deskripsi_arkep" placeholder="Isi Deskripsi" class="form-control">{{ $a->deskripsi_arkep }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
