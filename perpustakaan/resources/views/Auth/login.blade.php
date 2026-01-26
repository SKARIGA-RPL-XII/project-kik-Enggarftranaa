<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Treasure International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            overflow: hidden;
        }

        .left-panel {
            background: linear-gradient(180deg, #a9cfe0 0%, #6e8fa0 100%);
        }

        .left-content {
            max-width: 420px;
        }

        .left-content img {
            width: 400px;
            margin: 0 auto;
        }

        .right-panel {
            display: flex;
            align-items: center;
            padding-left: 80px;
        }

        .login-box {
            width: 360px;
        }

        .login-box h2 {
            font-weight: 700;
            margin-bottom: 40px;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
        }

        input {
            height: 44px;
            border-radius: 0 !important;
            margin-bottom: 25px;
        }

        .btn-login {
            background-color: #7da2b3 !important;
            border: none;
            height: 46px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
        }

        .btn-login:hover {
            background-color: #7da2b3 !important;
            color: #fff;
        }

        .btn-login:active,
        .btn-login:focus {
            background-color: #7da2b3 !important;
            color: #fff;
            box-shadow: none !important;
        }

        .footer-text {
            position: absolute;
            bottom: 30px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- KIRI -->
        <div class="col-md-6 d-flex justify-content-center align-items-center left-panel position-relative">
            <div class="left-content text-center">

                <img src="{{ asset('storage/logo.png') }}" class="mb-4" alt="Logo">

                <h4 class="fw-bold">PORTAL PEMINJAMAN BUKU</h4>
                <h5 class="fw-bold mb-5">TREASURE INTERNATIONAL SCHOOL</h5>

                <div class="footer-text">
                    PUSKOM © 2013-2026
                </div>
            </div>
        </div>

        <!-- KANAN -->
        <div class="col-md-6 right-panel">
            <div class="login-box">

                <h2>LOGIN</h2>
                <p class="mb-4">
    Belum punya akun?
    <a href="/register" class="fw-bold text-decoration-none">
        Daftar di sini
    </a>
</p>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <label>USERNAME</label>
                    <input type="email" name="email" class="form-control" required>

                    <label>PASSWORD</label>
                    <input type="password" name="password" class="form-control" required>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        LOGIN
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>
