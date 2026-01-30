<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Treasure International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        /* PANEL KIRI: Background Gambar Buku dengan Overlay */
        .left-panel {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(125, 162, 179, 0.8)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .left-content {
            z-index: 2;
            padding: 20px;
        }

        .left-content img {
            width: 180px; /* Ukuran logo disesuaikan */
            margin-bottom: 30px;
            filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.3));
        }

        .left-content h4 {
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .left-content h5 {
            font-weight: 400;
            letter-spacing: 1px;
            opacity: 0.9;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .footer-text {
            position: absolute;
            bottom: 30px;
            font-size: 13px;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        /* PANEL KANAN: Form Login */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        .login-box h2 {
            font-weight: 800;
            color: #333;
            margin-bottom: 10px;
        }

        .login-box p {
            color: #666;
            margin-bottom: 35px;
        }

        label {
            font-size: 12px;
            font-weight: 700;
            color: #555;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px 15px;
        }

        .form-control:focus {
            border-color: #7da2b3;
            box-shadow: 0 0 0 0.25rem rgba(125, 162, 179, 0.25);
        }

        .btn-login {
            background-color: #7da2b3;
            border: none;
            height: 50px;
            border-radius: 8px;
            font-weight: 700;
            color: #fff;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #6e8fa0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: #fff;
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            body { overflow: auto; }
            .row { height: auto !important; }
            .left-panel { height: 40vh; }
            .right-panel { height: 60vh; padding: 20px; }
            .footer-text { position: relative; bottom: 0; margin-top: 20px; }
        }
    </style>
</head>
<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <div class="col-md-6 left-panel">
            <div class="left-content">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo">

                <h4>PORTAL PEMINJAMAN BUKU</h4>
                <h5>TREASURE INTERNATIONAL SCHOOL</h5>

                <div class="footer-text">
                    PUSKOM © 2013-2026
                </div>
            </div>
        </div>

        <div class="col-md-6 right-panel">
            <div class="login-box">
                <h2>LOGIN</h2>
                <p>
                    Belum punya akun? 
                    <a href="/register" class="text-decoration-none fw-bold" style="color: #7da2b3;">Daftar di sini</a>
                </p>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <label for="email">Username / Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" required autofocus>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label text-capitalize" for="remember" style="font-weight: 400; font-size: 14px;">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        MASUK KE PORTAL
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>