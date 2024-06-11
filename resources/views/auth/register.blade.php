
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Aisya - Arsip Masyarakat </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landing/images/aisya_new.2.3.4.png') }}">
    <link href="./css/style.css" rel="stylesheet">
    <!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    {{-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor2/select2/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor2/select2-bootstrap-theme/select2-bootstrap.min.css') }}" /> --}}

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                {{-- <img src="{{ asset('/images/aisya2.jpg') }}" alt="user-avatar" class="d-block mr-3 rounded-circle mb-3 justify-content-center" height="450" width="450" id="uploadedAvatar" /> --}}
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Daftarkan Akun Anda</h4>
                                    @if (session('sukses'))
                                        <div class="alert alert-success">{{ session('sukses') }}</div>
                                    @endif
                                    <form action="{{ route('store') }}" method="POST">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Nama Lengkap</label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Nomor Induk Kependudukan</label>
                                                <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" autocomplete="nik" placeholder="Nomor Induk Kependudukan">
                                                @error('nik')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" autocomplete="tanggal_lahir" name="tanggal_lahir">
                                                @error('tanggal_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Nomor Kartu Keluarga</label>
                                                <input type="number" class="form-control @error('kk') is-invalid @enderror" value="{{ old('kk') }}" autocomplete="kk" name="kk" placeholder="Nomor Kartu Keluarga">
                                                @error('kk')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>kecamatan</label>
                                                <select class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" required name="kecamatan" value="{{ old('kecamatan') }}" autocomplete="kecamatan" data-placeholder="Pilih Kecamatan">
                                                    <option value="" selected>Pilih Kecamatan</option>
                                                    @foreach ($kecamatan as $item)
                                                    @if ($item->nama == 'KAB. CILACAP')
                                                    @else
                                                    <option value="{{ $item->kode }}">{{ $item->nama }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('kecamatan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>desa</label>
                                                <select class="form-control @error('desa') is-invalid @enderror" id="desa" required name="desa" value="{{ old('desa') }}" autocomplete="desa" data-placeholder="Pilih Desa">
                                                </select>
                                                @error('desa')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Nomor Telepon</label>
                                                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" autocomplete="no_hp" placeholder="Nomor Telepon">
                                                @error('no_hp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <label class="text-danger">  *Minimal 6 Karakter</label>
                                                <input type="password" name="password"  id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                                <input type="checkbox" id="showPassword" onchange="togglePasswordVisibility()">
                                                <label for="showPassword">Lihat Password</label>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password Confirm</label>
                                                <input type="password" name="password_confirmation"  id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password">
                                                <input type="checkbox" id="password-confirm" onchange="togglePasswordConfirmationVisibility()">
                                                <label for="password-confirm">Lihat Password</label>
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 ms-3">
                                                <input class="form-check-input @error('setuju') is-invalid @enderror" type="checkbox" name="setuju" value="setuju" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Klik untuk menyetujui segala ketentuan 
                                                </label>
                                                @error('setuju')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn center justify-content-center btn-primary btn-block">{{ __('Register') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Sudah Memiliki Akun? <a class="text-primary" href="{{ route('login') }}"> Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <!--endRemoveIf(production)-->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!-- Scripts -->
    

</body>

{{-- jquery ajax --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-migrate-3.4.1.js" integrity="sha256-CfQXwuZDtzbBnpa5nhZmga8QAumxkrhOToWweU52T38=" crossorigin="anonymous"></script> --}}
<script>
    $(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $(function(){

            $('#kecamatan').on('change',function(){
                let idkecamatan = $('#kecamatan').val();
                
                console.log(idkecamatan);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('getkecamatan') }}",
                    data: {idkecamatan:idkecamatan},
                    cache: false,

                    success: function (msg) { 
                        $('#desa').html(msg);
                     },
                     error: function(data){
                        console.log('error', data);
                     },
                })
            });
        });
    });
</script>

{{-- Select2 --}}
<script>
    $( '#kecamatan' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
</script>
<script>
    $( '#desa' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
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
    function togglePasswordConfirmationVisibility() {
        var passwordInput = document.getElementById('password_confirmation');
        var showPasswordCheckbox = document.getElementById('password-confirm');

        if (showPasswordCheckbox.checked) {
            passwordInput.setAttribute("type", "text");
        } else {
            passwordInput.setAttribute("type", "password");
        }
    }
</script>

</html>