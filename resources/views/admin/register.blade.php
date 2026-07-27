<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container p-3" style="max-width: 400px;">
        <div class="card border-0 shadow-lg rounded-4 p-4">
            <h3 class="fw-bold text-center mb-4">☕ Buat Akun Admin</h3>
            
            <!-- Tampilkan pesan error jika validasi gagal (misal email sudah ada) -->
            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                </div>
                
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Daftar Sekarang</button>
            </form>
            
            <div class="text-center mt-3">
                <a href="/login" class="text-decoration-none small text-muted">Sudah punya akun? Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>
</html>