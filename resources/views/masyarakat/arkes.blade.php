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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Daftar Arsip</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Arsip Kesehatan</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-4 col-xxl-4">
            <div class="card">
                <div class="card-header">
                    
                    <h4 class="card-title">Arsip Kesehatan</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form text-dark">
                        <form action="{{ route('masyarakat.arkes-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="text-danger">Upload file | jpeg,png,jpg,pdf | max:2MB</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Pilih File">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message == 'The image failed to upload.' ? 'Ukuran maksimal 2MB' : $message ; }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="BPJS">BPJS</option>
                                    <option value="Rekam Medis">Rekam Medis</option>
                                    <option value="Lain Lain">Lain Lain</option>
                                </select>
                                @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="text-dark">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi_arkes" placeholder="Isi Deskripsi (Optional)" rows="4" id="comment"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                        
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-8 col-xxl-8">
            <div class="card">
                <div class="card-header">
                    
                    <h4 class="card-title">Arsip Kesehatan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arkes as $a)
                                    <tr>
                                        <td> {{ $a->kategori }} </td>
                                        <td> {{ $a->users->masyarakat->name }} </td>
                                        <td class="text-center">
                                            @if ($a->deskripsi_arkes == NULL)
                                                -
                                            @else
                                            {{ $a->deskripsi_arkes }}                                                         
                                            @endif
                                        </td>
                                        <td>{{ $a->created_at->format('l, d-m-Y') }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ $a->url }}" download="{{ $a->nama_arkes }}" style="margin-right: 2%" class="btn btn-rounded btn-success btn-xs">Download</a>
                                            <a href="{{ $a->url }}" target="_blank" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Lihat</a>
                                            <button type="button" style="width: 61px; margin-right: 2%" data-toggle="modal" data-target="#editModal{{ $a->id_arkes }}" class="btn btn-rounded btn-info btn-xs">Edit</button>
                                            <form id="deleteForm{{ $a->id_arkes }}" action="{{ route('masyarakat.arkes-destroy', ['id_arkes' => $a->id_arkes]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                    <button type="submit" style="width: 61px" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    {{-- VALIDASI DELETE --}}
                                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        $(document).ready(function(){
                                            $('#deleteForm{{ $a->id_arkes }}').submit(function(e){
                                                e.preventDefault();
                                                Swal.fire({
                                                    title: 'Apakah Anda yakin?',
                                                    text: "Anda tidak akan dapat mengembalikan ini!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Ya, hapus saja!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        // Submit form manually
                                                        this.submit();
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                @endforeach
                                @foreach ($arkes as $a)
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $a->id_arkes }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $a->id_arkes }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $a->id_arkes }}">Edit Arsip</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('masyarakat.arkes-update', ['id_arkes' => $a->id_arkes]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                                                <option @if ($a->kategori == 'BPJS') selected @endif value="BPJS">BPJS</option>
                                                                <option @if ($a->kategori == 'Rekam Medis') selected @endif value="Rekam Medis">Rekam Medis</option>
                                                                <option @if ($a->kategori == 'Lain - Lain') selected @endif value="Lain Lain">Lain Lain</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi:</label>
                                                            <textarea name="deskripsi_arkes" placeholder="Isi Deskripsi (Optional)" class="form-control">{{ $a->deskripsi_arkes }}</textarea>
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
    @include('validasi.validasi-edit')
    @include('validasi.notifikasi-berhasil')
@endsection