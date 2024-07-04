
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>AISYA - Arsip Masyarakat</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('landing/css/bootstrap-icons.css') }}" rel="stylesheet">

        <link href="{{ asset('landing/css/templatemo-topic-listing.css') }}" rel="stylesheet">
        <style>
            .fixed-size-image {
            width: 100%;
            height: 200px; /* Atur tinggi sesuai kebutuhan Anda */
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .image-wrapper {
            overflow: hidden;
        }

        .image-wrapper:hover .fixed-size-image {
            transform: scale(1.1);
        }

        /* Fullscreen container styles */
        .fullscreen-container {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .fullscreen-image {
            max-width: 90%;
            max-height: 90%;
        }

        /* detail arpres */
        .arpres-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .arpres-details h5 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #343a40;
        }

        .arpres-details p {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #495057;
        }

        .arpres-details strong {
            color: #212529;
        }

        </style>
<!--

TemplateMo 590 topic listing

https://templatemo.com/tm-590-topic-listing

-->
    </head>
    
    <body id="top">

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="http://aisya.cilacapkab.go.id/">
                        <img src="{{ asset('landing/images/aisya_new.2.3.1.png') }}" class="" height="70" width="120" alt="">
                        {{-- <img src="{{ asset('landing/images/aisya_new.2.3.png') }}" class="" height="70" width="70" alt=""> --}}
                        
                    </a>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav d-flex ms-lg-5">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_1">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/#section_2">Kemudahan</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/#section_3">Fitur</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/#section_4">Arip Prestasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/#section_6">Arsip Koran</a>
                            </li>

                            {{-- <li class="nav-item">
                                <a class="nav-link click-scroll" href="/#section_4">FAQs</a>
                            </li> --}}
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="/#section_5">Kontak</a>
                            </li>

                        </ul>
                        <span class="navbar-text ms-auto">
                            <ul class="navbar-nav d-flex ms-lg-5">
                                <a class="nav-link" href="{{ route('login') }}">LOGIN</a>
                                <a class="nav-link" href="{{ route('register') }}">REGISTER</a>
                            </ul>
                        </span>

                        {{-- <div class="d-none d-lg-block">
                            <a class="nav-link click-scroll" href="">Login</a>
                        </div> --}}
                    </div>
                </div>
            </nav>
            

            {{-- <header class="site-header d-flex flex-column justify-content-center align-items-center">
                <div class="container">
                    <div class="row justify-content-center align-items-center">

                        <div class="col-lg-5 col-12 mb-5">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Homepage</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">Web Design</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Introduction to <br> Web Design 101</h2>

                            <div class="d-flex align-items-center mt-5">
                                <a href="#topics-detail" class="btn custom-btn custom-border-btn smoothscroll me-4">Read More</a>

                                <a href="#top" class="custom-icon bi-bookmark smoothscroll"></a>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12">
                            <div class="topics-detail-block bg-white shadow-lg">
                                <img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="topics-detail-block-image img-fluid">
                            </div>
                        </div>

                    </div>
                </div>
            </header> --}}


            <section class="topics-detail-section section-padding" id="topics-detail">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 m-auto">
                            {{-- <h3 class="mb-4">Introduction to Web Design</h3>

                            <p>So how can you stand out, do something unique and interesting, build an online business, and get paid enough to change life. Please visit TemplateMo website to download free website templates.</p>

                            <p><strong>There are so many ways to make money online</strong>. Below are several platforms you can use to find success. Keep in mind that there is no one path everyone can take. If that were the case, everyone would have a million dollars.</p> --}}

                            
                                <blockquote>
                                    {{ $koran->penerbit }}
                                </blockquote>
                                <div class="row my-4">
                                    @foreach ($koran->detailKoran as $dt)    
                                        <div class="col-lg-6 col-md-6 col-6 mb-12">
                                            <div class="image-wrapper">
                                                <img src="{{ asset($dt->path) }}" class="topics-detail-block-image img-fluid fixed-size-image" onclick="openFullscreen(this)">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Fullscreen container -->
                                <div id="fullscreenContainer" class="fullscreen-container" onclick="closeFullscreen()">
                                    <img id="fullscreenImage" class="fullscreen-image">
                                </div>
                            

                                <div class="arpres-details">
                                    <h5>Detail Arsip</h5>
                                    <p><strong>Penerbit:</strong> {{ $koran->penerbit }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $koran->deskripsi }}</p>
                                </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>
		
        <footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <img src="{{ asset('landing/images/aisya_new.2.3.1.png') }}" class="" height="70" width="120" alt="">
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Resources</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#section_1" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_2" class="site-footer-link">Kemudahan</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_3" class="site-footer-link">Fitur</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_5" class="site-footer-link">Kontak</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Information</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: 028-252-0861" class="site-footer-link">
                                028-252-0861
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:arpus@cilacap.co.id" class="site-footer-link">
                                arpus@cilacap.co.id
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                        <div class="dropdown">
                            
                        </div>

                        <p class="copyright-text mt-lg-5 mt-4">
                        
                    </div>

                </div>
            </div>
        </footer>

        {{-- JAVASCRIPT --}}
        <SCRipt>
            function openFullscreen(imgElement) {
            var fullscreenContainer = document.getElementById("fullscreenContainer");
            var fullscreenImage = document.getElementById("fullscreenImage");
            
            fullscreenImage.src = imgElement.src;
            fullscreenContainer.style.display = "flex";
        }

        function closeFullscreen() {
            var fullscreenContainer = document.getElementById("fullscreenContainer");
            fullscreenContainer.style.display = "none";
        }
        </SCRipt>
        <!-- JAVASCRIPT FILES -->
        <script src="{{ asset('landing/js/jquery.min.js') }}"></script>
        <script src="{{ asset('landing/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('landing/js/jquery.sticky.js') }}"></script>
        <script src="{{ asset('landing/js/click-scroll.js') }}"></script>
        <script src="{{ asset('landing/js/custom.js') }}"></script>

    </body>
</html>