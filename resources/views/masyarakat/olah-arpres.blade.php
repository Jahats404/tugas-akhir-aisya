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
                    <h4 class="card-title">Arsip Prestasi </h4>
                    <!-- Button tambah modal --> 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Wilayah</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arpres as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->wilayah }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->created_at->format('l, d-m-Y') }}</td>
                                        <td>
                                            @if ($item->status == 'Tertunda')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-warning">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Ditolak')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-danger">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Diterima')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-success">{{ $item->status }}</a>
                                            @else
                                            -
                                            @endif

                                        </td>
                                        <td class="d-flex justify-content-center">
                                            {{-- <a href="{{ $item->detailArpres->path }}" download="{{ $item->detailArpres->image }}" style="margin-right: 2%" class="btn btn-rounded btn-success btn-xs">Download</a> --}}
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id_arpres }}">Lihat</button>
                                            <button type="button" style="width: 61px; margin-right: 2%" data-toggle="modal" data-target="#editModal{{ $item->id_arpres }}" class="btn btn-rounded btn-info btn-xs">Edit</button>
                                            <form style="margin-right: 2%" id="deleteForm{{ $item->id_arpres }}" action="{{ route('masyarakat.arpres-pengajuan-destroy', ['id' => $item->id_arpres]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                            </form>
                                            <a href="{{ route('masyarakat.arpres-pengajuan-detail', ['id' => $item->id_arpres]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                            @if ($item->status == '-')
                                                <form style="margin-left: 2%" action="{{ route('masyarakat.arpres-pengajuan-ajukan', ['id' => $item->id_arpres]) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Ajukan</button>
                                                </form>
                                            @else
                                            <div class="" style="width: 40%"></div>
                                            {{-- <button style=" margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Telah  Diajukan</button> --}}
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id_arpres }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id_arpres }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailArpres as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailArpres as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide="next">
                                                                    <span class="carousel-control-next-icon"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- VALIDASI DELETE --}}
                                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        $(document).ready(function(){
                                            $('#deleteForm{{ $item->id_arpres }}').submit(function(e){
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
                                    <div class="modal fade" id="editModal{{ $item->id_arpres }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id_arpres }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id_arpres }}">Edit Arpres</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('masyarakat.arpres-pengajuan-update', ['id' => $item->id_arpres]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ $item->nama }}">
                                                            @error('nama')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Wilayah</label>
                                                            <input type="text" class="form-control @error('wilayah') is-invalid @enderror" name="wilayah" id="wilayah" value="{{ $item->wilayah }}">
                                                            @error('wilayah')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                                                <option value="">-- Pilih Kategori --</option>
                                                                <option value="Olahraga">Olahraga</option>
                                                                <option value="Akademik">Akademik</option>
                                                                <option value="Kesenian">Kesenian</option>
                                                                <option value="Pengabdian">Pengabdian</option>
                                                                <option value="Lain - Lain">Lain - Lain</option>
                                                            </select>
                                                            @error('kategori')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" value="{{ $item->deskripsi }}">
                                                            @error('deskripsi')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
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

        <div class="col-xl-6 col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Arsip Prestasi Diterima</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example3" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Wilayah</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arpresDiterima as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->wilayah }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->created_at->format('l, d-m-Y') }}</td>
                                        <td>
                                            @if ($item->status == 'Tertunda')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-warning">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Ditolak')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-danger">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Diterima')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-success">{{ $item->status }}</a>
                                            @else
                                            -
                                            @endif

                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id_arpres }}">Lihat</button>
                                            <button type="button" style="width: 61px; margin-right: 2%" data-toggle="modal" data-target="#editModal{{ $item->id_arpres }}" class="btn btn-rounded btn-info btn-xs">Edit</button>
                                            <form style="margin-right: 2%" id="deleteForm{{ $item->id_arpres }}" action="{{ route('masyarakat.arpres-pengajuan-destroy', ['id' => $item->id_arpres]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                            </form>
                                            <a href="{{ route('masyarakat.arpres-pengajuan-detail', ['id' => $item->id_arpres]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                            @if ($item->status == '-')
                                                <form style="margin-left: 2%" action="{{ route('masyarakat.arpres-pengajuan-ajukan', ['id' => $item->id_arpres]) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Ajukan</button>
                                                </form>
                                            @else
                                            <div class="" style="width: 40%"></div>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id_arpres }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Arpres</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id_arpres }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailArpres as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailArpres as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide="next">
                                                                    <span class="carousel-control-next-icon"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- VALIDASI DELETE --}}
                                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        $(document).ready(function(){
                                            $('#deleteForm{{ $item->id_arpres }}').submit(function(e){
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
                                    <div class="modal fade" id="editModal{{ $item->id_arpres }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id_arpres }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id_arpres }}">Edit Arpres</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('masyarakat.arpres-pengajuan-update', ['id' => $item->id_arpres]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ $item->nama }}">
                                                            @error('nama')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Wilayah</label>
                                                            <input type="text" class="form-control @error('wilayah') is-invalid @enderror" name="wilayah" id="wilayah" value="{{ $item->wilayah }}">
                                                            @error('wilayah')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                                                <option value="">-- Pilih Kategori --</option>
                                                                <option value="Olahraga">Olahraga</option>
                                                                <option value="Akademik">Akademik</option>
                                                                <option value="Kesenian">Kesenian</option>
                                                                <option value="Pengabdian">Pengabdian</option>
                                                                <option value="Lain - Lain">Lain - Lain</option>
                                                            </select>
                                                            @error('kategori')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" value="{{ $item->deskripsi }}">
                                                            @error('deskripsi')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
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

        <div class="col-xl-6 col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Arsip Prestasi Ditolak</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example2" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Wilayah</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arpresDitolak as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->wilayah }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->created_at->format('l, d-m-Y') }}</td>
                                        <td>
                                            @if ($item->status == 'Tertunda')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-warning">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Ditolak')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-danger">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Diterima')
                                            <a href="javascript:void()" class="badge badge-rounded badge-outline-success">{{ $item->status }}</a>
                                            @else
                                            -
                                            @endif

                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id_arpres }}">Lihat</button>
                                            <button type="button" style="width: 61px; margin-right: 2%" data-toggle="modal" data-target="#editModal{{ $item->id_arpres }}" class="btn btn-rounded btn-info btn-xs">Edit</button>
                                            <form style="margin-right: 2%" id="deleteForm{{ $item->id_arpres }}" action="{{ route('masyarakat.arpres-pengajuan-destroy', ['id' => $item->id_arpres]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                            </form>
                                            <a href="{{ route('masyarakat.arpres-pengajuan-detail', ['id' => $item->id_arpres]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                            @if ($item->status == '-')
                                                <form style="margin-left: 2%" action="{{ route('masyarakat.arpres-pengajuan-ajukan', ['id' => $item->id_arpres]) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Ajukan</button>
                                                </form>
                                            @else
                                            <div class="" style="width: 40%"></div>
                                            {{-- <button style=" margin-right: 2%" class="btn btn-rounded btn-primary btn-xs">Telah  Diajukan</button> --}}
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id_arpres }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Arpres</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id_arpres }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailArpres as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailArpres as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id_arpres }}" data-slide="next">
                                                                    <span class="carousel-control-next-icon"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- VALIDASI DELETE --}}
                                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        $(document).ready(function(){
                                            $('#deleteForm{{ $item->id_arpres }}').submit(function(e){
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
                                    <div class="modal fade" id="editModal{{ $item->id_arpres }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id_arpres }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id_arpres }}">Edit Arpres</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('masyarakat.arpres-pengajuan-update', ['id' => $item->id_arpres]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ $item->nama }}">
                                                            @error('nama')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Wilayah</label>
                                                            <input type="text" class="form-control @error('wilayah') is-invalid @enderror" name="wilayah" id="wilayah" value="{{ $item->wilayah }}">
                                                            @error('wilayah')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" value="{{ $item->kategori }}">
                                                            @error('kategori')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" value="{{ $item->deskripsi }}">
                                                            @error('deskripsi')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
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
                <form action="{{ route('masyarakat.arpres-pengajuan-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajukan Arip Prestasi</h5>
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
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Wilayah</label>
                                <input type="text" class="form-control @error('wilayah') is-invalid @enderror" name="wilayah" id="wilayah">
                                @error('wilayah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Kesenian">Kesenian</option>
                                    <option value="Pengabdian">Pengabdian</option>
                                    <option value="Lain - Lain">Lain - Lain</option>
                                </select>
                                @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi">
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