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
                    <h4 class="card-title">Seluruh Arsip Koran</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Aktor</th>
                                    <th>Penerbit</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koran as $item)
                                    <tr>
                                        <td>
                                            @if(isset($item->users->petugasarpus->name))
                                                {{ $item->users->petugasarpus->name }}
                                            @elseif(isset($item->users->masyarakat->name))
                                                {{ $item->users->masyarakat->name }}
                                            @else
                                                Tidak diketahui
                                            @endif
                                        </td>
                                        <td>{{ $item->penerbit }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->created_at->format('l, d-m-Y') }}</td>
                                        <td>
                                            @if ($item->status == 'Tertunda')
                                                <a href="javascript:void(0)" class="badge badge-rounded badge-outline-warning">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Ditolak')
                                                <a href="javascript:void(0)" class="badge badge-rounded badge-outline-danger">{{ $item->status }}</a>
                                            @elseif ($item->status == 'Diterima')
                                                <a href="javascript:void(0)" class="badge badge-rounded badge-outline-success">{{ $item->status }}</a>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id }}">Lihat</button>
                                            <div class="btn-group me-3">
                                                <button class="btn btn-rounded btn-info btn-xs dropdown-toggle me-3" style="margin-right: 2%" type="button" data-toggle="dropdown">
                                                    Status
                                                </button>
                                                <div class="dropdown-menu">
                                                    <form action="{{ route('admin.status-koran', ['id' => $item->id]) }}" method="POST">
                                                        @csrf
                                                        <input name="status" value="Diterima" type="hidden">
                                                        <button type="submit" class="dropdown-item">Terima</button>
                                                    </form>
                                                    <form action="{{ route('admin.status-koran', ['id' => $item->id]) }}" method="POST">
                                                        @csrf
                                                        <input name="status" value="Ditolak" type="hidden">
                                                        <button type="submit" class="dropdown-item">Tolak</button>
                                                    </form>
                                                    <form action="{{ route('admin.status-koran', ['id' => $item->id]) }}" method="POST">
                                                        @csrf
                                                        <input name="status" value="Tertunda" type="hidden">
                                                        <button type="submit" class="dropdown-item">Tunda</button>
                                                    </form>
                                                </div>
                                                <form style="margin-right: 2%" id="deleteForm{{ $item->id }}" action="{{ route('admin.koran-destroy', ['id' => $item->id]) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" style="width: 61px; margin-right: 2%" class="btn btn-rounded btn-danger btn-xs show_delete">Hapus</button>
                                                </form>
                                            </div>
                                            <a href="{{ route('admin.koran-detail', ['id' => $item->id]) }}" style="width: 61px; margin-left: 2%" class="btn btn-rounded btn-success btn-xs">Detail</a>
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
        
                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="next">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Arsip Koran dari Petugas</h4>
                    <!-- Button tambah modal --> 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">Ajukan Arsip Koran</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example2" style="min-width: 845px">
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
                                @foreach ($koranAdmin as $item)
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
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id }}">Lihat</button>
                                            <a href="{{ route('admin.koran-detail', ['id' => $item->id]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                            <form style="margin-right: 2%" id="deleteeForm{{ $item->id }}" action="{{ route('admin.koran-destroy', ['id' => $item->id]) }}" method="POST">
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
                                            $('#deleteeForm{{ $item->id }}').submit(function(e){
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

                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="next">
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
                                    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Arsip Koran Tertunda</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example5" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Aktor</th>
                                    <th>penerbit</th>
                                    <th>deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koranTertunda as $item)
                                    <tr>
                                        <td>
                                            @if(isset($item->users->petugasarpus->name))
                                                {{ $item->users->petugasarpus->name }}
                                            @elseif(isset($item->users->masyarakat->name))
                                                {{ $item->users->masyarakat->name }}
                                            @else
                                                Tidak diketahui
                                            @endif
                                        </td>
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
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id }}">Lihat</button>
                                            <a href="{{ route('admin.koran-detail', ['id' => $item->id]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                        </td>
                                    </tr>
                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="next">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Arsip Koran Diterima</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example3" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Aktor</th>
                                    <th>penerbit</th>
                                    <th>deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koranDiterima as $item)
                                    <tr>
                                        <td>
                                            @if(isset($item->users->petugasarpus->name))
                                                {{ $item->users->petugasarpus->name }}
                                            @elseif(isset($item->users->masyarakat->name))
                                                {{ $item->users->masyarakat->name }}
                                            @else
                                                Tidak diketahui
                                            @endif
                                        </td>
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
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id }}">Lihat</button>
                                            <a href="{{ route('admin.koran-detail', ['id' => $item->id]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                        </td>
                                    </tr>
                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="next">
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
                    <h4 class="card-title">Arsip Koran Ditolak</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-dark table-responsive-sm display nowrap" id="example4" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Aktor</th>
                                    <th>penerbit</th>
                                    <th>deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($koranDitolak as $item)
                                    <tr>
                                        <td>
                                            @if(isset($item->users->petugasarpus->name))
                                                {{ $item->users->petugasarpus->name }}
                                            @elseif(isset($item->users->masyarakat->name))
                                                {{ $item->users->masyarakat->name }}
                                            @else
                                                Tidak diketahui
                                            @endif
                                        </td>
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
                                            <button type="button" class="btn btn-primary btn-rounded btn-xs" style="margin-right: 2%" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $item->id }}">Lihat</button>
                                            <a href="{{ route('admin.koran-detail', ['id' => $item->id]) }}" style="width: 61px" class="btn btn-rounded btn-success btn-xs">Detail</a>
                                        </td>
                                    </tr>
                                    {{-- Modal Carousel --}}
                                    <div class="modal fade bd-example-modal-lg-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body p-4">
                                                            <div id="carouselExampleIndicators-{{ $item->id }}" class="carousel slide" data-ride="carousel">
                                                                <ol class="carousel-indicators">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <li data-target="#carouselExampleIndicators-{{ $item->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                                                    @endforeach
                                                                </ol>
                                                                <div class="carousel-inner">
                                                                    @foreach ($item->detailKoran as $index => $dt)
                                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                            <img class="d-block w-100" src="{{ $dt->path }}" alt="Slide {{ $index + 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carouselExampleIndicators-{{ $item->id }}" data-slide="next">
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
                <form action="{{ route('admin.koran-store') }}" method="POST" enctype="multipart/form-data">
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
    <script>
        new DataTable('#koranAdmin', {
            scrollX: true
        });
    </script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    @endsection