@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="profile">
                <div class="profile-head">
                    {{-- <div class="photo-content">
                        <div class="cover-photo">
                            <img src="{{ asset('images/profile/8.jpg') }}" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-photo">
                            <img src="{{ asset('images/profile/6.jpg') }}" class="img-fluid rounded" alt="">
                        </div>
                    </div> --}}
                    {{-- <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset('images/profile/6.jpg') }}" alt="user-avatar" class="d-block rounded mr-3 mb-3" height="100" width="100" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Foto</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="foto_profile" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                </form>
                            </label>
                            <p class="text-muted mb-0">JPG, GIF or PNG. Ukuran Max 2MB</p>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="profile-personal-info">
                        <br>
                        <h4 class="text-primary mb-4">Informasi Pribadi</h4>
                        <div class="row mb-4">
                            <div class="col-5">
                                @if (Auth()->user()->url)
                                    <img src="{{ Auth()->user()->url }}" alt="user-avatar" class="d-block mr-3 rounded-circle mb-3" height="150" width="150" id="uploadedAvatar" />
                                @else
                                <img src="{{ asset('images/svg/profile.svg') }}" alt="user-avatar" class="d-block mr-3 rounded-circle mb-3" height="150" width="150" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-5">
                                <h5 class="f-w-500">Nama <span class="pull-right">:</span>
                                </h5>
                            </div>
                            <div class="col-7"><span>{{ Auth()->user()->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-5">
                                <h5 class="f-w-500">Tanggal Lahir <span class="pull-right">:</span></h5>
                            </div>
                            <div class="col-7"><span>{{ $user->tanggal_lahir }}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-5">
                                <h5 class="f-w-500">NO HP <span class="pull-right">:</span></h5>
                            </div>
                            <div class="col-7"><span>{{ $user->no_hp }}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-5">
                                <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                </h5>
                            </div>
                            <div class="col-7"><span>{{ Auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-5">
                                <h5 class="f-w-500">No KK <span class="pull-right">:</span></h5>
                            </div>
                            <div class="col-7"><span>{{ Auth()->user()->kk }}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-5">
                                <h5 class="f-w-500">No NIK <span class="pull-right">:</span>
                                </h5>
                            </div>
                            <div class="col-7 "><span>{{ Auth()->user()->nik }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <h4 class="text-primary mt-4">Pengaturan Akun</h4>
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link active show">Akun</a>
                                </li>
                                <li class="nav-item"><a href="#change-pw" data-toggle="tab" class="nav-link">Password</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="profile-settings" class="tab-pane fade active show">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <h4 class="text-primary">Upload foto Profile</h4>
                                            <form action="{{ route('masyarakat.update-fotodir') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="file" name="image" class="form-control" placeholder="Pilih File">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <button type="submit" class="btn btn-sm btn-rounded btn-primary"><span
                                                            class="btn-icon-left text-primary"><i class="fa fa-upload color-success"></i>
                                                        </span>Unggah</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <hr>
                                            <h4 class="text-primary">Edit Data</h4>
                                            <form id="updateProfile" action="{{ route('masyarakat.update-profile') }}" method="POST">
                                                @csrf
                                                @method('put')
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Nama</label>
                                                        <input type="text" name="name" placeholder="Nama" class="form-control" value="{{ $user->name }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Email</label>
                                                        <input type="email" name="email" placeholder="Email" class="form-control" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>NIK</label>
                                                        <input type="number" name="nik" disabled placeholder="NIK" class="form-control" value="{{ $user->nik }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>KK</label>
                                                        <input type="number" name="kk" disabled placeholder="KK" class="form-control" value="{{ $user->kk }}">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" class="form-control" value="{{ $user->tanggal_lahir }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>No HP</label>
                                                        <input type="number" name="no_hp" placeholder="NO Hp" class="form-control" value="{{ $user->no_hp }}">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary edit_confirm" type="submit">Ubah Data</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="change-pw" class="tab-pane fade">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <h4 class="text-primary">Ganti Password</h4>
                                            <form id="updatePassword" action="{{ route('masyarakat.update-password') }}" method="POST">
                                                @csrf
                                                @method('put')
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Password Lama</label>
                                                            <input type="password" name="current_password" id="password" placeholder="Password" class="form-control">
                                                            <input type="checkbox" id="showPassword" onchange="togglePasswordVisibility()">
                                                            <label for="showPassword">Lihat Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Password Baru</label>
                                                            <input type="password" name="new_password" id="password2" placeholder="Password Baru" class="form-control">
                                                            <input type="checkbox" id="showPassword2" onchange="togglePasswordVisibility2()">
                                                            <label for="showPassword2">Lihat Password</label>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Konfimasi Password</label>
                                                            <input type="password" name="konfirmasi_password" id="password3" placeholder="Konfimasi Password" class="form-control">
                                                            <input type="checkbox" id="showPassword3" onchange="togglePasswordVisibility3()">
                                                            <label for="showPassword3">Lihat Password</label>
                                                        </div>
                                                    </div>
                                                <button class="btn btn-primary show_confirm" type="submit">Ubah Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('#updateProfile').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda ingin mengubah Data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form manually
                        this.submit();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#updatePassword').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda ingin mengubah Password?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form manually
                        this.submit();
                    }
                });
            });
        });
    </script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var showPasswordCheckbox = document.getElementById('showPassword');
    
            if (showPasswordCheckbox.checked) {
                passwordInput.setAttribute("type", "text");
            } else {
                passwordInput.setAttribute("type", "password");
            }
        }
    </script>
    <script>
        function togglePasswordVisibility2() {
            var passwordInput = document.getElementById('password2');
            var showPasswordCheckbox = document.getElementById('showPassword2');
    
            if (showPasswordCheckbox.checked) {
                passwordInput.setAttribute("type", "text");
            } else {
                passwordInput.setAttribute("type", "password");
            }
        }
    </script>
    <script>
        function togglePasswordVisibility3() {
            var passwordInput = document.getElementById('password3');
            var showPasswordCheckbox = document.getElementById('showPassword3');
    
            if (showPasswordCheckbox.checked) {
                passwordInput.setAttribute("type", "text");
            } else {
                passwordInput.setAttribute("type", "password");
            }
        }
    </script>
    @include('validasi.validasi-edit')
    @include('validasi.notifikasi-berhasil')
@endsection