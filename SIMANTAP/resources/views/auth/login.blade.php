<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login SIMANTAP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/jti_polinema.ico">
    @vite([])
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style>
       .auth-body-bg {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 0.5rem;
            height: auto;
            margin-bottom: 0;
        }

        .login-container {
            height: 100vh;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* align-items: center; */
            height: 100vh;
            padding: 10%;
        }

        .form-card {
            background-color: #ffffff;
            padding: 8% 10% 0 10%;
            border-radius: 0.5rem;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        }

        .auth-body-bg {
            background: url('assets/images/polinema-bg2.png') no-repeat center center fixed;
            background-size: cover;
        }
        
        .bg-overlay1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 66, 102, 0.5); /* Warna overlay dengan transparansi */
        }

    </style>
</head>

<body class="auth-body-bg">
    <div class="bg-overlay1"></div>
    <div class="container-fluid login-container">
        <div class="row h-100">
            <!-- Left Side: Empty Space -->
            <div class="col-md-6 d-none d-md-block"></div>
            
            <!-- Right Side: Login Form -->
            <div class="col-md-6 d-flex align-items-center" style="padding-right: 0; padding-left: 0;">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="align-items-center justify-content-center" style="padding-right: 0; padding-left: 0;">
                            <a href="{{ url('/') }}" class="d-flex align-items-center text-secondary">
                                <i class="ri-arrow-left-s-line" style="font-size: 1.5rem"></i> Kembali
                            </a>
                        </div>
                        <div class="text-center mt-4">
                            <div class="mb-3">
                                <a href="{{ route('landing') }}" class="auth-logo text-center">
                                    {{-- <img src="assets/images/logo-dark.png" height="30" class="logo-dark mx-auto" alt=""> --}}
                                    <span class="logo-lg">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="ri-tools-line me-2 text-dark" style="font-size: 2rem;"></i>
                                            <span class="logo-text fw-bold text-dark" style="font-size: 1.5rem;">SIMANTAP</span>
                                        </div>
                                    </span>
                                </a>
                            </div>
                        </div>
                        
                        
                        <h1 class="text-center"><b>Welcome King!</b></h1>
                        <span class="text-muted text-center font-size-12"><b>Satu Laporanmu, Seribu Perbaikan Dimulai!</b></span>
                        
                        <div class="form-card">
                            <form id="form-login" class="form-horizontal mt-3" action="{{ url('login') }}" method="POST">
                                @csrf

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control" type="text" required="" id="username" name="username"
                                            placeholder="NIM/NIP/NIDN / Akun Polinema">
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control" type="password" id="password" name="password"
                                            required="" placeholder="Password">
                                        <button type="button" class="btn btn-link position-absolute end-0 top-0 mt-2 me-4 p-0" id="togglePassword" tabindex="-1" style="color: #6c757d;">
                                            <i class="ri-eye-off-line" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const passwordInput = document.getElementById('password');
                                        const togglePassword = document.getElementById('togglePassword');
                                        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
                                        if (passwordInput && togglePassword && togglePasswordIcon) {
                                            togglePassword.addEventListener('click', function () {
                                                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                                passwordInput.setAttribute('type', type);
                                                togglePasswordIcon.className = type === 'password' ? 'ri-eye-off-line' : 'ri-eye-line';
                                            });
                                        }
                                    });
                                </script>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        {{-- <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
                                            <label class="form-label ms-1" for="customCheck1">Remember me</label>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="form-group mb-3 text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-info btn-rounded w-100 waves-effect waves-light" type="submit">Masuk</button>
                                    </div>
                                </div>

                                <div class="form-group mb-0 row mt-2">
                                    <div class="col-12 text-center mt-3">
                                        <span class="text-muted">Belum punya akun? <a href="{{ url('register') }}" class="text-info">Klik disini</a></span>
                                    </div>
                                </div>
{{-- 
                                <div class="form-group mb-0 row mt-2">
                                    <div class="col-sm-7 mt-3">
                                        <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot
                                            your password?</a>
                                    </div>
                                    <div class="col-sm-5 mt-3">
                                        <a href="auth-register.html" class="text-muted"><i
                                                class="mdi mdi-account-circle"></i> Create an account</a>
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                        <!-- end -->
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('#form-login').validate({
                rules: {
                    username: { required: true, minlength: 4, maxlength: 20 },
                    password: { required: true, minlength: 5, maxlength: 20 }
                },
                messages: {
                    username: "NIM/NIP/NIDN wajib diisi",
                    password: "Password wajib diisi"
                },
                submitHandler: function (form) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            Swal.close();
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function () {
                                    window.location = response.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat login.'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.after(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });

        }); 
    </script>

</body>

</html>