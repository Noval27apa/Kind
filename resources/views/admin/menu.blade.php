<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Mempercantik tampilan Modal dan Input */
        .modal-content { border-radius: 16px; border: none; }
        .form-control:focus, .form-select:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }
    </style>
</head>
<body class="bg-light pb-5">
    
    <!-- NAVBAR DENGAN LOGO KUSTOM -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/kasir">
                <img src="{{ asset('logo-kafe.jpg') }}" alt="Logo Kafe" class="rounded-circle bg-white object-fit-cover shadow-sm" style="width: 38px; height: 38px;">
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0 text-dark">Daftar Menu Kafe</h4>
            <button class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">+ Tambah Menu</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <strong>Gagal Menyimpan!</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 text-secondary">Foto</th>
                                <th class="text-secondary">Nama Menu</th>
                                <th class="text-secondary">Kategori</th>
                                <th class="text-secondary">Harga</th>
                                <th class="text-secondary">Tambahan / Topping</th>
                                <th class="text-center text-secondary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr class="border-bottom">
                                <td class="px-4 py-3">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="Foto" class="rounded-3 shadow-sm object-fit-cover" style="width: 65px; height: 65px;">
                                    @else
                                        <div class="bg-secondary bg-opacity-10 border rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 65px; height: 65px; font-size: 11px;">No Image</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold d-block text-dark">{{ $menu->name }}</span>
                                    <small class="text-muted d-block mt-1" style="max-width: 250px; white-space: normal; line-height: 1.3;">{{ $menu->description }}</small>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-25 text-dark border">{{ $menu->category->name ?? 'Tanpa Kategori' }}</span></td>
                                <td class="text-success fw-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                <td class="text-muted small">
                                    @if($menu->addons)
                                        <span class="badge bg-info bg-opacity-25 text-dark border">{{ $menu->addons }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- TOMBOL AKSI -->
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-warning fw-bold text-dark px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $menu->id }}">✏️ Edit</button>
                                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold px-3 rounded-pill shadow-sm">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- AREA MODAL (DIPISAH DARI DALAM TABEL)      -->
    <!-- ========================================== -->

    <!-- 1. Modal Pop-up Tambah Menu -->
    <div class="modal fade" id="tambahMenuModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow-lg">
                @csrf
                <div class="modal-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="modal-title fw-bold text-dark">✨ Tambah Menu Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Foto Menu</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-danger" style="font-size: 11px;">* Maksimal 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Kategori Menu <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Cth: Kopi Robusta" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Harga Dasar (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" placeholder="Cth: 15000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Tambahan / Topping (Opsional)</label>
                        <input type="text" name="addons" class="form-control" placeholder="Cth: Ekstra Telur:3000, Level Pedas">
                        <small class="text-muted d-block mt-1" style="font-size: 11px; line-height: 1.2;">Gunakan <b>koma (,)</b> antar opsi. Gunakan <b>titik dua (:)</b> untuk menambah harga topping.</small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold text-secondary small mb-1">Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan sedikit tentang menu ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Perulangan Modal Edit Menu (Diletakkan di Luar Tabel agar Tidak Error) -->
    @foreach($menus as $menu)
    <div class="modal fade text-start" id="editMenuModal{{ $menu->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="modal-content shadow-lg">
                @csrf
                @method('PUT')
                <div class="modal-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="modal-title fw-bold text-dark">✏️ Edit Menu: {{ $menu->name }}</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
                    <!-- Preview Foto & Input -->
                    <div class="mb-4 text-center">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" class="rounded-4 shadow-sm mb-3 object-fit-cover border" style="width: 120px; height: 120px;">
                        @else
                            <div class="bg-light border rounded-4 d-flex align-items-center justify-content-center mx-auto mb-3 text-muted" style="width: 120px; height: 120px; font-size: 12px;">
                                No Image
                            </div>
                        @endif
                        
                        <div class="text-start">
                            <label class="form-label fw-bold text-secondary small mb-1">Ganti Foto Menu</label>
                            <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted" style="font-size: 11px;">Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Kategori Menu <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $menu->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $menu->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Harga Dasar (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ $menu->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small mb-1">Tambahan / Topping (Opsional)</label>
                        <input type="text" name="addons" class="form-control" value="{{ $menu->addons }}" placeholder="Contoh: Ekstra Telur:3000, Level Pedas">
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold text-secondary small mb-1">Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3">{{ $menu->description }}</textarea>
                    </div>
                </div>

                <div class="modal-footer bg-white border-top-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>