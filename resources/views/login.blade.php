<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Staf - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-pills .nav-link { color: #6c757d; font-weight: bold; border-radius: 10px; }
        .nav-pills .nav-link.active { background-color: #212529; color: white; }
    </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container p-3" style="max-width: 450px;">
        
        <!-- Notifikasi Pesan Sukses / Error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-lg rounded-4 p-4">
            <h3 class="fw-bold text-center mb-4">☕ Portal Staf</h3>

            <!-- Menu Tab Navigasi -->
            <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab">Masuk</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab">Daftar Akun</button>
                </li>
                <li class="nav-item d-none" role="presentation">
                    <!-- Tab Lupa Password disembunyikan dari menu atas, diakses via link di dalam form login -->
                    <button class="nav-link" id="pills-forgot-tab" data-bs-toggle="pill" data-bs-target="#pills-forgot" type="button" role="tab">Lupa Password</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                
                <!-- ================= TAB 1: FORM LOGIN ================= -->
                <div class="tab-pane fade show active" id="pills-login" role="tabpanel">
                    <form action="{{ route('authenticate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="admin@cafe.com" required>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-bold">Password</label>
                                <!-- Tombol pemicu pindah ke Tab Lupa Password -->
                                <a href="#" class="text-decoration-none small text-primary" onclick="document.getElementById('pills-forgot-tab').click(); return false;">Lupa Password?</a>
                            </div>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="********" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 fw-bold py-3 mt-2 rounded-3">Masuk ke Sistem</button>
                    </form>
                </div>

                <!-- ================= TAB 2: FORM DAFTAR ADMIN ================= -->
                <div class="tab-pane fade" id="pills-register" role="tabpanel">
                    <form action="{{ route('register.admin.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="admin@cafe.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Buat Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3">Buat Akun</button>
                    </form>
                </div>

                <!-- ================= TAB 3: FORM LUPA PASSWORD ================= -->
                <div class="tab-pane fade" id="pills-forgot" role="tabpanel">
                    <div class="text-center mb-3">
                        <span style="font-size: 3rem;">🔒</span>
                        <p class="text-muted small mt-2">Masukkan email Anda. Kami akan mengirimkan tautan untuk mereset password Anda.</p>
                    </div>
                    <form action="{{ route('password.reset') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="email" name="email" class="form-control" placeholder="Email terdaftar..." required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 rounded-3">Kirim Link Reset</button>
                        <div class="text-center mt-3">
                            <a href="#" class="text-decoration-none small text-muted" onclick="document.getElementById('pills-login-tab').click(); return false;">⬅️ Kembali ke Halaman Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="small text-muted">&copy; 2026 Cafe Kind Comfy Pleasure</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>