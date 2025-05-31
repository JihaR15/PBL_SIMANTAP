<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Selamat Datang di SIMANTAP</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/images/jti_polinema.ico') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="#" class="logo d-flex align-items-center me-auto">
                {{-- <img src="assets/img/logo.png" alt=""> --}}
                <h1 class="sitename">SIMANTAP</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#services">Alur</a></li>
                    {{-- <li><a href="#footer">Kontak</a></li> --}}
                    {{-- <li><a href="#pricing">Pricing</a></li> --}}
                    {{-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Dropdown 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown 2</a></li>
                            <li><a href="#">Dropdown 3</a></li>
                            <li><a href="#">Dropdown 4</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">Login</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="hero-bg">
                <img src="assets/images/polinema-bg2.png" alt="">
            </div>
            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h1 data-aos="fade-up">Laporkan Kerusakan di <span>SIMANTAP!</span></h1>
                    <p data-aos="fade-up" data-aos-delay="100">Kampus <strong>Hebat</strong> dimulai dari Fasilitas yang
                        <strong>Terawat</strong><br></p>
                    {{-- <h1 data-aos="fade-up">Kampus Hebat dimulai dari Fasilitas yang Terawat</h1>
                    <p data-aos="fade-up" data-aos-delay="100">Laporkan di <strong>SIMANTAP!</strong><br></p> --}}
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('login') }}" class="btn-get-started">Laporkan</a>
                        {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                            class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle"></i><span>Watch Video</span></a> --}}
                    </div>
                    <img src="assets/img/building-bro.svg" class="img-fluid hero-img" alt="" data-aos="zoom-out"
                        data-aos-delay="300">
                </div>
            </div>

        </section><!-- /Hero Section -->

        {{-- <!-- Featured Services Section -->
        <section id="featured-services" class="featured-services section light-background">

            <div class="container">

                <div class="row gy-4">

                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link">Lorem Ipsum</a></h4>
                                <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias
                                    excepturi</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Item -->

                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link">Dolor Sitema</a></h4>
                                <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                    aliquip exa</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item d-flex">
                            <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>
                            <div>
                                <h4 class="title"><a href="#" class="stretched-link">Sed ut perspiciatis</a></h4>
                                <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Featured Services Section --> --}}

        <!-- Clients Section -->
        {{-- <section id="clients" class="clients section">

            <div class="container" data-aos="fade-up">

                <div class="row gy-4">

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="assets/img/clients/logo_polinema.png" class="img-fluid" alt="">
                    </div><!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="assets/img/clients/Jti_polinema.png" class="img-fluid" alt="">
                    </div><!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="assets/img/clients/laravel.png" class="img-fluid" alt="">
                    </div><!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="assets/img/clients/Bootstrap.png" class="img-fluid" alt="">
                    </div><!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="assets/img/clients/php.png" class="img-fluid" alt="">
                    </div><!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="assets/img/clients/laragon.png" class="img-fluid" alt="">
                    </div><!-- End Client Item -->

                </div>

            </div>

        </section><!-- /Clients Section --> --}}

        <!-- About Section -->
        <section id="about" class="about section" style="padding-top: 40px;">

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 content d-flex flex-column  justify-content-center" data-aos="fade-up"
                        data-aos-delay="100" style="padding-right: 30px;">
                        <p class="who-we-are">Tentang Kami</p>
                        <h3 style="margin-bottom: 20px">Kampus Hebat Dimulai dari Fasilitas yang Terawat</h3>
                        <p class="fst-italic">
                            Kami percaya bahwa lingkungan belajar yang nyaman dimulai dari fasilitas yang bersih,
                            lengkap, dan terawat. Di kampus ini, setiap ruang, alat, dan sarana dikelola dengan baik
                            demi mendukung proses pembelajaran yang optimal. Komitmen kami adalah menciptakan suasana
                            kampus yang aman, inspiratif, dan mendukung prestasi mahasiswa. Karena kampus hebat lahir
                            dari perhatian terhadap hal-hal mendasar — termasuk fasilitas yang berkualitas.
                        </p>
                        {{-- <ul>
                            <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Duis aute irure dolor in reprehenderit in
                                    voluptate velit.</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</span></li>
                        </ul> --}}
                        {{-- <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                        --}}
                    </div>

                    <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
                        <img src="assets/img/college campus-rafiki.svg" class="img-fluid" alt=""
                            style="max-width: 70%; height: auto; display: block; margin: 0 auto;">
                        {{-- <div class="row gy-4">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <div class="row gy-4">
                                    <div class="col-lg-12">
                                        <img src="assets/img/about-company-2.jpg" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-lg-12">
                                        <img src="assets/img/about-company-3.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>

                </div>

            </div>
        </section><!-- /About Section -->

        <section id="featured-services" class="featured-services section light-background">

            <div class="container">

            <div class="row gy-4">

                <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item d-flex">
                    <div class="icon flex-shrink-0"><i class="bi bi-people"></i></div>
                    <div>
                    <h4 class="title">Total Pengguna</h4>
                    <p class="description">{{ $userCount ?? 0 }} pengguna terdaftar di SIMANTAP</p>
                    </div>
                </div>
                </div>
                <!-- End Service Item -->

                <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item d-flex">
                    <div class="icon flex-shrink-0"><i class="bi bi-file-earmark-text"></i></div>
                    <div>
                    <h4 class="title">Laporan Masuk</h4>
                    <p class="description">{{ $laporanCount ?? 0 }} laporan telah diterima</p>
                    </div>
                </div>
                </div><!-- End Service Item -->

                <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item d-flex">
                    <div class="icon flex-shrink-0"><i class="bi bi-tools"></i></div>
                    <div>
                    <h4 class="title">Perbaikan Selesai</h4>
                    <p class="description">{{ $perbaikanCount ?? 0 }} perbaikan telah dilakukan</p>
                    </div>
                </div>
                </div><!-- End Service Item -->

            </div>

            </div>

        </section><!-- /Featured Services Section -->

        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Alur Penggunaan</h2>
                <p>Ikuti langkah-langkah berikut untuk melaporkan kerusakan atau kebutuhan fasilitas kampus secara mudah, cepat, dan terintegrasi melalui SIMANTAP.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row g-3">

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item item-cyan position-relative d-flex flex-column align-items-center text-center">
                            <i class="bi bi-door-open icon mb-4 me-0"></i>
                            <div>
                                <h3>Daftar & Login</h3>
                                <p class="mt-3">Masuk ke platform dengan akun Anda untuk mulai menggunakan fitur SIMANTAP.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item item-orange position-relative d-flex flex-column align-items-center text-center">
                            <i class="bi bi-pencil-square icon mb-4 me-0"></i>
                            <div>
                                <h3>Input Laporan</h3>
                                <p class="mt-3">Isi laporan kerusakan atau kebutuhan fasilitas secara mudah dan cepat.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item item-teal position-relative d-flex flex-column align-items-center text-center">
                            <i class="bi bi-check2-circle icon mb-4 me-0"></i>
                            <div>
                                <h3>Validasi Laporan</h3>
                                <p class="mt-3">Laporan Anda akan diverifikasi oleh pihak terkait sebelum diproses.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item item-red position-relative d-flex flex-column align-items-center text-center">
                            <i class="bi bi-tools icon mb-4 me-0"></i>
                            <div>
                                <h3>Perbaikan Dilakukan</h3>
                                <p class="mt-3">Tim akan menindaklanjuti dan memperbaiki sesuai laporan yang telah divalidasi.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Services Section -->

    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">SIMANTAP</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Soekarno Hatta Street No.9 Malang 65141</p>
                        <p>Jatimulyo, Kec. Lowokwaru, Malang,</p>
                        <p>East Java - Indonesia</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>(0341) 404424 - 404425</span></p>
                        <p><strong>Email:</strong> <span>info@polinema.ac.id</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="https://www.polinema.ac.id/" target="_blank" rel="noopener"><i class="bi bi-globe"></i></a>
                        <a href="http://instagram.com/polinema_campus/" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-3 footer-links">
                    <h4>Kelompok 5 - TI-2A</h4>
                    <ul>
                        @php
                            $anggota = [
                                ['nama' => 'Jiha Ramdhan', 'nim' => '2341720043'],
                                ['nama' => 'Gilang Purnomo', 'nim' => '2341720042'],
                                ['nama' => 'Octrian Adiluhung Tito Putra', 'nim' => '2341720078'],
                                ['nama' => 'Sesy Tana Lina Rahmatin', 'nim' => '2341720029'],
                                ['nama' => 'Vincentius Leonanda Prabowo', 'nim' => '2341720149'],
                            ];
                        @endphp
                        @foreach($anggota as $i => $mhs)
                            <li><a>{{ $i + 1 }}. {{ $mhs['nama'] }} ({{ $mhs['nim'] }})</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div> --}}
                <div class="col-lg-4 col-md-12 footer-image d-flex justify-content-center align-items-center flex-column text-center">
                    <img src="{{ asset('assets/images/logo-polinema-l.png') }}" alt="Polinema" class="img-fluid mb-2" style="width: 320px;">
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">PBL</strong><span>Semester 4 2025 - Kelompok 5 TI-2A</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Politeknik Negeri Malang - <a href="https://github.com/JihaR15/PBL_SIMANTAP" target="_blank" rel="noopener">Link Github</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    {{-- <!-- Preloader -->
    <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>