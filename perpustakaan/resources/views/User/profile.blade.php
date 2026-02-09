<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | Treasure Library</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --brand-primary: #2563eb;
            --brand-dark: #0f172a;
            --bg-body: #f1f5f9;
            --text-main: #334155;
            --text-muted: #64748b;
        }

        body { 
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif; 
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        /* Layout Professional */
        .settings-container {
            max-width: 900px;
            margin: 40px auto;
        }

        .main-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Sidebar-like Header */
        .profile-section-header {
            padding: 32px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .avatar-edit-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: var(--brand-primary);
        }

        .btn-camera-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }

        .btn-camera-overlay:hover {
            background: #f8fafc;
            color: var(--brand-primary);
        }

        /* Form Styling */
        .form-section {
            padding: 32px;
        }

        .section-title {
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--brand-dark);
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Security Box */
        .security-container {
            background: #f8fafc;
            border-radius: 8px;
            padding: 24px;
            border: 1px solid #e2e8f0;
        }

        /* Button Professional */
        .btn-submit {
            background: var(--brand-dark);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        .btn-cancel {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .btn-cancel:hover { color: var(--brand-dark); }

        .validation-msg {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 4px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="settings-container">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">Pengaturan Profil</h4>
                    <p class="text-muted small mb-0">Kelola informasi publik dan keamanan akun Anda.</p>
                </div>
                <a href="{{ url('user/dashboard') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
            
            <div class="main-card">
                <form id="profileForm" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="profile-section-header">
                        <div class="avatar-edit-wrapper">
                            <div class="avatar-preview" id="preview-container">
                                @if($user->avatar)
                                    <img src="{{ asset('img/avatars/'.$user->avatar) }}" id="preview-img" class="w-100 h-100 rounded-circle">
                                @else
                                    <span id="initial-placeholder">{{ substr($user->name, 0, 1) }}</span>
                                    <img src="" id="preview-img" class="w-100 h-100 rounded-circle d-none">
                                @endif
                            </div>
                            <label for="avatar-input" class="btn-camera-overlay">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" name="avatar" id="avatar-input" hidden accept="image/*">
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
                            <p class="text-muted small mb-0">Terdaftar sejak {{ $user->created_at->format('M Y') }}</p>
                            <button type="button" class="btn btn-link p-0 text-decoration-none small mt-1" onclick="document.getElementById('avatar-input').click()">Ganti foto profil</button>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">Informasi Umum</div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="validation-msg">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="validation-msg">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-5" style="border-top: 1px solid #f1f5f9;">

                        <div class="section-title">Keamanan Akun</div>
                        <div class="security-container">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Kata Sandi Baru</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                                    <div id="password-error" class="validation-msg"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Konfirmasi Kata Sandi</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••">
                                    <div id="confirm-error" class="validation-msg"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-muted" style="font-size: 0.8rem;">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Biarkan kosong jika Anda tidak ingin mengganti kata sandi.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end gap-3 border-top pt-4">
                            <button type="submit" class="btn btn-submit">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image Preview Handler
        document.getElementById("avatar-input").onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                const img = document.getElementById("preview-img");
                const initial = document.getElementById("initial-placeholder");
                
                img.src = URL.createObjectURL(file);
                img.classList.remove("d-none");
                if(initial) initial.classList.add("d-none");
            }
        };

        // Form Validation Logic
        document.getElementById("profileForm").onsubmit = function(e) {
            let isValid = true;
            const password = document.getElementById("password");
            const confirm = document.getElementById("password_confirmation");
            
            document.getElementById("password-error").innerText = "";
            document.getElementById("confirm-error").innerText = "";

            if (password.value.length > 0) {
                if (password.value.length < 8) {
                    document.getElementById("password-error").innerText = "Kata sandi minimal 8 karakter.";
                    isValid = false;
                }
                if (password.value !== confirm.value) {
                    document.getElementById("confirm-error").innerText = "Konfirmasi kata sandi tidak cocok.";
                    isValid = false;
                }
            }

            if (!isValid) e.preventDefault();
        };

        // Professional Notification
        @if (session('status') === 'profile-updated')
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Profil berhasil diperbarui',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        @endif
    </script>
</body>
</html>