    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\{
        AuthController, AdminController, UserController,
        BukuController, KategoriController, PeminjamanController,
        ProfileController, QRController
    };

    // --- PUBLIC ROUTES ---
    Route::get('/', function () { return view('welcome'); });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store');
        Route::post('/logout', 'logout')->name('logout');
    });

    //
    Route::middleware('auth')->group(function () {

        // 1. PROFILE
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile/update', 'update')->name('profile.update');
        });

        // 2. USER DASHBOARD
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/dashboard', [BukuController::class, 'indexUser'])->name('dashboard');
            Route::get('/buku', [BukuController::class, 'indexUser'])->name('buku');
            
            // Fitur Riwayat Peminjaman User (Halaman yang Anda minta)
            Route::get('/history', [PeminjamanController::class, 'userHistory'])->name('history');
            
            // Fitur Pinjam & QR
            Route::get('/pinjam/{id}', [PeminjamanController::class, 'pinjam'])->name('pinjam.buku');
            Route::get('/pinjam/tiket/{id}', [QRController::class, 'generateTicket'])->name('generate.qr');
        });

        // 3. ADMIN DASHBOARD
        Route::prefix('admin')->name('admin.')->group(function () {
            // Dashboard Admin
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            
            // CRUD Resources
            Route::resource('buku', BukuController::class);
            Route::resource('kategori', KategoriController::class);
            Route::resource('user', UserController::class);
            Route::put('user/{id}/reset', [UserController::class, 'resetPassword'])->name('user.reset');

            // Fitur Scanner 
            Route::get('/scan', [AdminController::class, 'showScanner'])->name('scan');
            Route::get('/get-peminjam/{user_id}/{buku_id}', [AdminController::class, 'getDataScan']);
            Route::post('/proses-pinjam', [AdminController::class, 'prosesPinjam'])->name('proses.pinjam');

            // Log Peminjaman Admin
            Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
            
            Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
            Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

            Route::get('/user/cek-status/{buku_id}', [App\Http\Controllers\UserController::class, 'cekStatusPinjam'])->name('user.cek.status');
        });Route::middleware(['auth'])->group(function () {
        
      
        Route::get('/user/cek-status/{buku_id}', [UserController::class, 'cekStatusPinjam'])->name('user.cek.status');

        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

      Route::prefix('admin')->name('admin.')->group(function () {

    // Log Peminjaman Admin
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    

    Route::get('/report/peminjaman/pdf', [PeminjamanController::class, 'exportPdf'])->name('report.pdf');


    Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

    });
    });
