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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Arsip Pendidikan</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Arsip Koran</h4>
                    <!-- Button tambah modal --> 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambahkan Foto</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Nama Gambar</th>
                                    <th>Gambar</th>
                                    <th>Tanggal Upload</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dtKoran as $item)
                                    <tr>
                                        <td>{{ $item->image }}</td>
                                        <td>
                                            <img src="{{ $item->path }}" alt="Foto Koran" class="img-fluid img-3x4 rounded" style="max-width: 50px;">
                                        </td>
                                        <td>{{ $item->created_at->format('l, d-m-Y') }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ $item->path }}" target="_blank" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Lihat</a>
                                            <form style="margin-right: 2%" id="deleteForm{{ $item->id }}" action="{{ route('masyarakat.koran-detail-pengajuan-destroy', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- VALIDASI DELETE --}}
                                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        $(document).ready(function(){
                                            $('#deleteForm{{ $item->id }}').submit(function(e){
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
                            </tbody>
                        </table>
                        <a href="{{ route('admin.koran') }}" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('masyarakat.koran-pengajuan-image-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajukan Arsip Koran</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form text-dark">
                            <div class="form-group">
                                <label class="text-danger">Upload file | jpeg,png,jpg,pdf | max:2MB</label>
                                <input type="file" name="image" class="form-control @error('images') is-invalid @enderror" placeholder="Pilih File" multiple>
                                <div id="extra-file-inputs"></div>
                                {{-- <button type="button" id="add-file-input" class="btn btn-sm mt-3 ms-auto btn-secondary">Tambah File</button> --}}
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('images.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('validasi.validasi-edit')
    @include('validasi.notifikasi-berhasil')
@endsection

@section('scripts')
    <script>
        document.getElementById('add-file-input').addEventListener('click', function() {
            var extraInputsDiv = document.getElementById('extra-file-inputs');
            var newFileInput = document.createElement('input');
            newFileInput.type = 'file';
            newFileInput.name = 'images[]';
            newFileInput.className = 'form-control mt-2';
            extraInputsDiv.appendChild(newFileInput);
        });
    </script>
    @endsection