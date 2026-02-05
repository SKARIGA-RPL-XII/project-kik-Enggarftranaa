<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --dark-navy: #121826;
            --accent-blue: #3b82f6;
            --glass-white: rgba(255, 255, 255, 0.9);
        }

        body { 
            background: radial-gradient(circle at top right, #f8fafc, #e2e8f0);
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--dark-navy);
            min-height: 100vh;
        }

        .card { 
            border: none; 
            border-radius: 35px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: var(--glass-white);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .profile-header {
            background: linear-gradient(135deg, #121826 0%, #232d3f 100%);
            color: white;
            padding: 50px 20px;
            text-align: center;
            position: relative;
        }

        .avatar-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .avatar-wrapper {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-initial {
            font-size: 3rem;
            font-weight: 800;
            color: var(--dark-navy);
        }

        .upload-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--accent-blue);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 3px solid #121826;
            cursor: pointer;
            transition: 0.3s;
        }

        .upload-badge:hover { transform: scale(1.1); background: #2563eb; }

        .form-label { font-size: 0.8rem; letter-spacing: 0.5px; margin-bottom: 8px; }
        
        .form-control {
            border: 1.5px solid #e2e8f0;
            padding: 14px 20px;
            border-radius: 16px;
            font-size: 0.95rem;
            background: #f8fafc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus {
            background: white;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .password-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 25px;
            margin-top: 30px;
        }

        .btn-save { 
            background: linear-gradient(135deg, #121826 0%, #2d3748 100%);
            color: white; 
            border-radius: 18px; 
            padding: 16px; 
            font-weight: 700; 
            border: none;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .btn-save:hover { 
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.15);
            color: white;
        }

        .back-link {
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            color: var(--dark-navy) !important;
        }
        .back-link:hover { transform: translateX(-5px); }

        input[type="file"] { display: none; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                
                <a href="{{ url('user/dashboard') }}" class="text-decoration-none mb-4 d-inline-block fw-bold small back-link">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
                
                <div class="card">
                    <form id="profileForm" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="profile-header">
                            <div class="avatar-container">
                                <div class="avatar-wrapper" id="preview-box">
                                    {{-- PERBAIKAN JALUR GAMBAR --}}
                                    @if($user->avatar)
                                        <img src="{{ asset('img/avatars/'.$user->avatar) }}" id="preview-img">
                                    @else
                                        <div class="avatar-initial" id="preview-initial">{{ substr($user->name, 0, 1) }}</div>
                                        <img src="" id="preview-img" style="display:none;">
                                    @endif
                                </div>
                                <label for="avatar-input" class="upload-badge">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="avatar" id="avatar-input" accept="image/*">
                            </div>
                            <h3 style="font-family: 'Playfair Display', serif; font-weight: 900;" class="mb-1">{{ $user->name }}</h3>
                            <p class="text-white-50 small mb-0"><i class="fas fa-id-badge me-1"></i> Member Treasure Library</p>
                        </div>

                        <div class="p-4 p-lg-5 pt-4">
                            <div class="mb-4">
                                <label class="form-label text-uppercase fw-800 text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-uppercase fw-800 text-muted">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="password-section">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-primary">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold">Update Keamanan</h6>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted">Password Baru</label>
                                    <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diganti">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label text-muted">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted small">Anggota sejak {{ $user->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview Gambar Real-time
        document.getElementById("avatar-input").onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                const img = document.getElementById("preview-img");
                const initial = document.getElementById("preview-initial");
                
                img.src = URL.createObjectURL(file);
                img.style.display = "block";
                
                if(initial) {
                    initial.style.display = "none";
                }
                
                const box = document.getElementById("preview-box");
                box.style.transform = "scale(1.1)";
                box.style.transition = "0.3s";
                setTimeout(() => box.style.transform = "scale(1)", 300);
            }
        };

        @if (session('status') === 'profile-updated')
        Swal.fire({
            title: 'Berhasil!',
            text: 'Profil dan foto Anda telah diperbarui.',
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            background: '#ffffff',
            borderRadius: '25px',
            iconColor: '#3b82f6'
        });
        @endif
    </script>
</body>
</html>