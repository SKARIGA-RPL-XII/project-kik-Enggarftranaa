<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Treasure International School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            background: #6e8fa0;
            color: #fff;
            padding: 20px;
        }
        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 30px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .card-box {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar">
            <h4>ADMIN PANEL</h4>
            <p>Hi, {{ auth()->user()->name }}</p>
            <hr>

            <a href="/admin/dashboard">Dashboard</a>
            <a href="#">Data User</a>
            <a href="#">Data Buku</a>
            <a href="#">Peminjaman</a>
            <a href="#">Laporan</a>

            <hr>

            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-light btn-sm w-100">
                    Logout
                </button>
            </form>
        </div>

        <!-- CONTENT -->
        <div class="col-md-10 p-4">
            <h2 class="mb-4">Dashboard Admin</h2>

            <div class="row">

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-3">
                        <h6>Total User</h6>
                        <h3>120</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-3">
                        <h6>Total Buku</h6>
                        <h3>350</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-3">
                        <h6>Sedang Dipinjam</h6>
                        <h3>45</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box shadow-sm p-3">
                        <h6>Terlambat</h6>
                        <h3>8</h3>
                    </div>
                </div>

            </div>

            <div class="mt-5">
                <h4>Aktivitas Terakhir</h4>
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Andi</td>
                            <td>Laravel Untuk Pemula</td>
                            <td>2026-01-20</td>
                            <td><span class="badge bg-success">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td>Sinta</td>
                            <td>Basis Data</td>
                            <td>2026-01-18</td>
                            <td><span class="badge bg-danger">Terlambat</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>
