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
                    <h4 class="card-title">Arsip Koran </h4>
                    <!-- Button tambah modal --> 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Ajukan Arsip Koran</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>penerbit</th>
                                    <th>deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koran as $item)
                                    <tr>
                                        <td>{{ $item->penerbit }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->created_at->format('l, d-m-Y') }}</td>
                                        <td>
                                            @if ($item->status == 'Tertunda')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-warning">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Ditolak')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-danger">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Diterima')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-success">{{ $item->status }}</a>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <button type="button" style="width: 61px; margin-right: 2%" data-toggle="modal" data-target="#editModal{{ $item->id }}" class="btn btn-rounded btn-info btn-xs">Edit</button>
                                            <form style="margin-right: 2%" id="deleteForm{{ $item->id }}" action="{{ route('masyarakat.koran-pengajuan-destroy', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                            </form>
                                            <a href="{{ route('masyarakat.koran-pengajuan-detail', ['id' => $item->id]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
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

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Arsip</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('masyarakat.koran-pengajuan-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label>Penerbit</label>
                                                            <input type="text" class="form-control @error('penerbit') is-invalid @enderror" name="penerbit" id="penerbit" value="{{ $item->penerbit }}">
                                                            @error('penerbit')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi:</label>
                                                            <textarea name="deskripsi" placeholder="Isi Deskripsi" class="form-control">{{ $item->deskripsi }}</textarea>
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

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('masyarakat.koran-pengajuan-store') }}" method="POST" enctype="multipart/form-data">
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
                                <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" placeholder="Pilih File" multiple>
                                <div id="extra-file-inputs"></div>
                                <button type="button" id="add-file-input" class="btn btn-sm mt-3 ms-auto btn-secondary">Tambah File</button>
                                @error('images')
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
                            <div class="form-group">
                                <label>Penerbit</label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror" name="penerbit" id="penerbit" placeholder="Isi Penerbit">
                                @error('penerbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="text-dark">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Isi Deskripsi" rows="4" id="comment"></textarea>
                                @error('deskripsi')
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