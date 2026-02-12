<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Panel | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-mini-width: 85px;
            --primary-blue: #4361ee;
            --sidebar-dark: #0f172a;
            --body-bg: #f4f7fe;
            --text-main: #1e293b;
            --text-soft: #64748b;
            --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR CORE --- */
        .sidebar {
            height: 100vh;
            background: var(--sidebar-dark);
            position: fixed;
            width: var(--sidebar-width);
            z-index: 1000;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Mencegah elemen bocor saat transisi */
        }

        body.sidebar-mini .sidebar {
            width: var(--sidebar-mini-width);
        }

        .sidebar-header { 
            padding: 20px;
            height: 90px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .sidebar-brand i { 
            color: var(--primary-blue); 
            font-size: 1.8rem; 
            min-width: 45px; /* Menjaga logo tetap di tengah saat mini */
            display: flex;
            justify-content: center;
        }

        .sidebar-menu { 
            padding: 20px 15px;
            flex-grow: 1;
        }

        .menu-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 1px;
            margin: 20px 0 10px 12px;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar a {
            color: #94a3b8;
            display: flex;
            align-items: center;
            padding: 12px;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
        }

        .sidebar a:hover { 
            color: white; 
            background: rgba(255,255,255,0.05); 
        }

        .sidebar a.active { 
            background: var(--primary-blue); 
            color: white; 
            box-shadow: 0 10px 20px -5px rgba(67, 97, 238, 0.4); 
        }

        .sidebar-icon { 
            min-width: 45px; /* Kunci agar ikon selalu center */
            display: flex;
            justify-content: center;
            font-size: 1.2rem;
        }

        .sidebar-footer { 
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .btn-logout {
            background: transparent; color: #94a3b8; border: none; border-radius: 10px;
            padding: 12px; width: 100%; display: flex; align-items: center;
            transition: 0.3s; font-weight: 600; font-size: 0.85rem;
        }

        .btn-logout:hover { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

        /* --- FIX UNTUK MODE MINI --- */
        body.sidebar-mini .sidebar-brand span, 
        body.sidebar-mini .menu-label, 
        body.sidebar-mini .sidebar a span:not(.sidebar-icon),
        body.sidebar-mini .btn-logout span {
            display: none; /* Hilangkan teks sepenuhnya agar tidak berantakan */
        }

        body.sidebar-mini .sidebar a, 
        body.sidebar-mini .btn-logout,
        body.sidebar-mini .sidebar-brand {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        /* --- CONTENT & TOP NAV --- */
        .top-nav {
            margin-left: var(--sidebar-width);
            height: 90px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid #eef2f6;
            transition: var(--transition);
        }

        body.sidebar-mini .top-nav { margin-left: var(--sidebar-mini-width); }

        .sidebar-toggle {
            background: #f8fafc; border: 1px solid #e2e8f0; width: 42px; height: 42px;
            border-radius: 10px; color: var(--text-main); cursor: pointer;
            display: flex; align-items: center; justify-content: center; margin-right: 20px;
        }

        .main-content { 
            margin-left: var(--sidebar-width); 
            padding: 40px; 
            transition: var(--transition);
        }

        body.sidebar-mini .main-content { margin-left: var(--sidebar-mini-width); }

        /* --- WIDGETS --- */
        .clock-wrapper {
            background: #fff; border: 1px solid #eef2f6; padding: 10px 20px;
            border-radius: 15px; display: flex; align-items: center; gap: 15px;
        }
        .time-display { font-weight: 800; font-size: 1.1rem; color: var(--primary-blue); }
        .date-display { font-size: 0.75rem; font-weight: 600; color: var(--text-soft); border-left: 2px solid #eef2f6; padding-left: 15px; }

        .stat-card {
            border: none; border-radius: 20px; background: white; padding: 25px;
            display: flex; align-items: center; box-shadow: var(--card-shadow);
        }
        .stat-icon { width: 55px; height: 55px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 18px; font-size: 1.2rem; }
    </style>
</head>
<body>

    <aside class="sidebar d-none d-md-flex">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="fa-solid fa-vault"></i>
                <span>TREASURE<span>LIB</span></span>
            </a>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-label">Analytics</div>
            <nav>
                <a href="/admin/dashboard" class="active">
                    <span class="sidebar-icon"><i class="fa-solid fa-chart-pie"></i></span>
                    <span>Dashboard</span>
                </a>
                <div class="menu-label">Management</div>
                <a href="/admin/user">
                    <span class="sidebar-icon"><i class="fa-solid fa-users"></i></span> 
                    <span>Members</span>
                </a>
                <a href="/admin/buku">
                    <span class="sidebar-icon"><i class="fa-solid fa-book"></i></span> 
                    <span>Collection</span>
                </a>
                <div class="menu-label">Operations</div>
                <a href="/admin/scan">
                    <span class="sidebar-icon"><i class="fa-solid fa-qrcode"></i></span> 
                    <span>QR Scanner</span>
                </a>
                <a href="/admin/peminjaman">
                    <span class="sidebar-icon"><i class="fa-solid fa-clock-rotate-left"></i></span> 
                    <span>Activity Logs</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-footer">
            <button type="button" class="btn-logout" onclick="confirmLogout()">
                <span class="sidebar-icon"><i class="fa-solid fa-power-off"></i></span>
                <span>Terminate Session</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <nav class="top-nav">
        <div class="d-flex align-items-center">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="breadcrumb mb-0 small fw-700 text-muted d-none d-sm-block">
                Admin <span class="mx-2">/</span> <span class="text-dark fw-800">Control Panel</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="clock-wrapper d-none d-lg-flex">
                <div class="time-display" id="realtime-clock">00:00:00</div>
                <div class="date-display" id="realtime-date">Loading...</div>
            </div>
            <div class="bg-primary rounded-circle" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon bg-soft-blue"><i class="fa-solid fa-users"></i></div>
                    <div><h6 class="text-muted small fw-bold mb-1">MEMBERS</h6><h4 class="fw-800 mb-0">1,240</h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon bg-soft-emerald"><i class="fa-solid fa-book"></i></div>
                    <div><h6 class="text-muted small fw-bold mb-1">BOOKS</h6><h4 class="fw-800 mb-0">3,502</h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon bg-soft-amber"><i class="fa-solid fa-rotate"></i></div>
                    <div><h6 class="text-muted small fw-bold mb-1">LOANS</h6><h4 class="fw-800 mb-0">452</h4></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h4 class="fw-800 mb-4">Recent Activity</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>MEMBER</th>
                            <th>TIMESTAMP</th>
                            <th class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="small fw-bold">Andi Wibowo</td>
                            <td class="small">Feb 11, 2026 - 09:00</td>
                            <td class="text-center"><span class="badge bg-success rounded-pill px-3">SUCCESS</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // 1. Toggle Sidebar Function
        function toggleSidebar() { 
            document.body.classList.toggle('sidebar-mini'); 
        }

        // 2. Real-time Clock Function
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const dateStr = now.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
            
            document.getElementById('realtime-clock').textContent = timeStr;
            document.getElementById('realtime-date').textContent = dateStr;
        }
        setInterval(updateClock, 1000); 
        updateClock();

        // 3. Logout Confirmation Function
        function confirmLogout() {
            Swal.fire({
                title: 'Terminate Session?',
                text: "Anda akan keluar dari panel administrasi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Logout',
                reverseButtons: true,
                customClass: { popup: 'rounded-4' }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('logout-form');
                    if(form) form.submit();
                }
            });
        }
    </script>
</body>
</html>