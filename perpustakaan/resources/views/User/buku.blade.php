<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Koleksi | Bibliotheca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #fdfbf7; /* Off-white / Cream agar mata nyaman */
            font-family: 'Inter', sans-serif;
            color: #2c2c2c;
        }

        .navbar {
            background-color: #1a2a6c !important;
            border-bottom: 3px solid #b8926a;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #1a2a6c;
            border-bottom: 2px solid #b8926a;
            display: inline-block;
            margin-bottom: 30px;
        }

        /* Search Bar Classic */
        .search-container {
            background: white;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin-bottom: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }

        /* Book Card Style */
        .book-card {
            background: white;
            border: none;
            border-radius: 0;
            transition: 0.3s;
            height: 100%;
            border: 1px solid #eee;
        }

        .book-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .book-cover {
            height: 250px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid #eee;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-status {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 5px 10px;
            border-radius: 0;
        }

        .btn-pinjam {
            background-color: #1a2a6c;
            color: white;
            border-radius: 0;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-pinjam:hover {
            background-color: #b8926a;
            color: white;
        }

        .text-author {
            color: #b8926a;
            font-style: italic;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark shadow-sm px-4">
    <a href="/user/dashboard" class="navbar-brand text-white text-decoration-none">BIBLIOTHECA</a>
    <a href="/user/dashboard" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="page-title">Katalog Koleksi Buku</h2>
        </div>
        <div class="col-md-4">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari judul atau penulis..." style="border-radius: 0;">
                <button class="btn btn-dark" type="button" style="border-radius: 0;">Cari</button>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card shadow-sm">
                <div class="book-cover">
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=500" alt="Cover Buku">
                </div>
                <div class="card-body">
                    <span class="badge bg-success badge-status mb-2">Tersedia</span>
                    <h5 class="card-title h6 fw-bold mb-1">Filosofi Teras</h5>
                    <p class="text-author mb-3">Henry Manampiring</p>
                    <div class="d-grid">
                        <button class="btn btn-pinjam">PINJAM BUKU</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card shadow-sm">
                <div class="book-cover">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=500" alt="Cover Buku">
                </div>
                <div class="card-body">
                    <span class="badge bg-danger badge-status mb-2">Dipinjam</span>
                    <h5 class="card-title h6 fw-bold mb-1">Bumi Manusia</h5>
                    <p class="text-author mb-3">Pramoedya Ananta Toer</p>
                    <div class="d-grid">
                        <button class="btn btn-secondary btn-sm" disabled>TIDAK TERSEDIA</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card shadow-sm">
                <div class="book-cover">
                    <img src="https://images.unsplash.com/photo-1589998059171-988d887df64e?q=80&w=500" alt="Cover Buku">
                </div>
                <div class="card-body">
                    <span class="badge bg-success badge-status mb-2">Tersedia</span>
                    <h5 class="card-title h6 fw-bold mb-1">Laskar Pelangi</h5>
                    <p class="text-author mb-3">Andrea Hirata</p>
                    <div class="d-grid">
                        <button class="btn btn-pinjam">PINJAM BUKU</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card shadow-sm">
                <div class="book-cover">
                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=500" alt="Cover Buku">
                </div>
                <div class="card-body">
                    <span class="badge bg-success badge-status mb-2">Tersedia</span>
                    <h5 class="card-title h6 fw-bold mb-1">Atomic Habits</h5>
                    <p class="text-author mb-3">James Clear</p>
                    <div class="d-grid">
                        <button class="btn btn-pinjam">PINJAM BUKU</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav aria-label="Page navigation" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#" style="border-radius: 0; color: #1a2a6c;">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#" style="background-color: #1a2a6c; border-color: #1a2a6c;">1</a></li>
            <li class="page-item"><a class="page-link" href="#" style="color: #1a2a6c;">2</a></li>
            <li class="page-item"><a class="page-link" href="#" style="border-radius: 0; color: #1a2a6c;">Next</a></li>
        </ul>
    </nav>
</div>

<footer class="mt-5 py-4 text-center text-muted">
    <small>© 2024 Bibliotheca Digital Archive</small>
</footer>

</body>
</html>