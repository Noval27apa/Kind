<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola QR Code - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya khusus untuk mode cetak semua QR Code */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .card { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-light pb-5">
    
    <!-- NAVBAR KELOLA QR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow no-print">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/kasir">
                <img src="{{ url('logo-kafe.jpg') }}" alt="Logo Kafe" class="rounded-circle bg-white object-fit-cover shadow-sm" style="width: 38px; height: 38px;" onerror="this.style.display='none'">
                <span>Kind Comfy Staff</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kasir') ? 'active text-warning fw-bold' : '' }}" href="/kasir">💻 Dashboard Kasir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/menu') ? 'active text-warning fw-bold' : '' }}" href="/admin/menu">🍔 Kelola Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/qr') ? 'active text-warning fw-bold' : '' }}" href="/admin/qr">🖨️ Kelola QR</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex m-0">
                    @csrf
                    <button class="btn btn-danger btn-sm fw-bold px-3 rounded-pill" type="submit">🚪 Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-2">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h4 class="fw-bold m-0 text-dark">Daftar QR Code Meja</h4>
            <div class="d-flex gap-2">
                <button class="btn btn-secondary fw-bold px-4 rounded-pill shadow-sm" onclick="window.print()">🖨️ Cetak Semua QR</button>
                <button class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahMejaModal">+ Tambah Meja Baru</button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 no-print" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($tables as $table)
                <div class="col">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-3">
                        
                        <div class="card-body">
                            <h4 class="fw-extrabold text-dark text-uppercase mb-3" style="font-weight: 800;">{{ $table->table_number }}</h4>
                            
                            <div class="mb-3 p-2 bg-white d-inline-block rounded-3 border shadow-sm">
                                {!! QrCode::size(160)->generate(url('/scan/' . $table->qr_code_token)) !!}
                            </div>
                            
                            <p class="small text-muted mb-1 fw-bold">Cafe Kind Comfy Pleasure</p>
                            <p class="text-muted mb-0" style="font-size: 11px;">Scan QR Code ini untuk memesan menu dari meja Anda</p>
                        </div>

                        <!-- Tombol Aksi (Edit Nama & Hapus Meja) -->
                        <div class="card-footer bg-white border-0 pt-0 pb-2 no-print">
                            <div class="d-flex justify-content-center gap-2 mt-2">
                                <button class="btn btn-sm btn-warning fw-bold text-dark px-3 rounded-pill shadow-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#editMejaModal{{ $table->id }}">✏️ Edit Nama</button>
                                
                                <form action="{{ route('admin.qr.destroy', $table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus {{ $table->table_number }}? Pelanggan tidak akan bisa scan QR meja ini lagi.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold px-3 rounded-pill shadow-sm">🗑️ Hapus</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- MODAL EDIT NAMA MEJA -->
                <div class="modal fade text-start no-print" id="editMejaModal{{ $table->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('admin.qr.update', $table->id) }}" method="POST" class="modal-content shadow-lg border-0 p-3">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">✏️ Edit Nama / Nomor Meja</h5>
                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-secondary">Nama / Nomor Meja</label>
                                    <input type="text" name="table_number" class="form-control" value="{{ $table->table_number }}" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- MODAL TAMBAH MEJA -->
    <div class="modal fade no-print" id="tambahMejaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.qr.tambah') }}" method="POST" class="modal-content shadow-lg border-0 p-3">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">➕ Tambah Meja Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Nomor / Nama Meja</label>
                        <input type="text" name="table_number" class="form-control" placeholder="Contoh: Meja 01, VIP A, Outdoor" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">Simpan Meja</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>