<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Eksklusif | Treasure International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0f172a; /* Midnight Blue */
            --accent-blue: #3b82f6;  /* Royal Blue */
            --soft-blue: #dbeafe;
            --gold-accent: #fbbf24; 
        }

        * {
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        body, html {
            height: 100%;
            margin: 0;
            background-color: #f8fafc;
        }

        /* PANEL KIRI: Desain Sinematik */
        .left-panel {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 58, 138, 0.8)), 
                        url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 90% 100%, 0% 100%);
        }

        .left-content {
            z-index: 2;
            padding: 40px;
            text-align: left;
            max-width: 80%;
        }

        .left-content img {
            width: 120px;
            margin-bottom: 40px;
            filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.5));
        }

        .left-content h4 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .brand-divider {
            width: 60px;
            height: 4px;
            background: var(--accent-blue);
            margin-bottom: 20px;
            border-radius: 2px;
        }

        .left-content p {
            font-size: 1.1rem;
            color: var(--soft-blue);
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        /* PANEL KANAN: Card Modern */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box h2 {
            font-weight: 800;
            color: var(--primary-dark);
            font-size: 2rem;
            letter-spacing: -1px;
        }

        .login-box p.subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 40px;
        }

        /* Styling Form input */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control {
            height: 55px;
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 1rem;
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--accent-blue);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* Tombol */
        .btn-login {
            background: var(--primary-dark);
            color: white;
            height: 55px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: var(--accent-blue);
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.3);
            color: #fff;
        }

        .footer-text {
            margin-top: 50px;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }
            .right-panel {
                height: 100vh;
            }
            .login-box {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <div class="col-lg-7 col-md-6 left-panel">
            <div class="left-content">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo School">
                <h4>Empowering Knowledge,<br>Inspiring Futures.</h4>
                <div class="brand-divider"></div>
                <p>Selamat datang di Portal Perpustakaan Digital<br>Treasure International School.</p>
            </div>
        </div>

        <div class="col-lg-5 col-md-6 right-panel">
            <div class="login-box">
                <h2>Selamat Datang</h2>
                <p class="subtitle">Silahkan masuk ke akun Anda untuk mengakses layanan digital.</p>

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 10px;">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="input-group-custom">
                        <label class="form-label">USERNAME ATAU EMAIL</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="user@treasure.sch.id" required autofocus>
                    </div>

                    <div class="input-group-custom">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">KATA SANDI</label>
                        </div>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="font-size: 0.9rem; color: #475569;">
                            Tetap masuk di perangkat ini
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        MASUK KE PORTAL
                    </button>
                </form>

                <div class="footer-text">
                    &copy; 2026 Treasure International School. <br> Powered by Pusat Komputer & Teknologi Informasi.
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>