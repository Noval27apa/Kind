<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- ================= NAVBAR ADMIN & KASIR ================= -->
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
    <!-- ================= END NAVBAR ================= -->

    <div class="container py-4">
        <h4 class="mb-4 fw-bold">Daftar Pesanan Masuk</h4>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">Waktu</th>
                                <th>No. Pesanan</th>
                                <th>Meja</th>
                                <th>Nama Pelanggan</th>
                                <th>Total Harga</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="border-bottom">
                                <td class="px-4 text-muted">{{ $order->created_at->format('H:i') }} WIB</td>
                                <td class="fw-bold">{{ $order->order_code }}</td>
                                <td><span class="badge bg-secondary">{{ $order->table->table_number }}</span></td>
                                <td class="fw-bold text-primary">{{ $order->customer_name }}</td>
                                <td class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->payment_status == 'unpaid')
                                        <span class="badge bg-danger">Belum Dibayar</span>
                                    @else
                                        <span class="badge bg-success">Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->payment_status == 'unpaid')
                                        <form action="{{ route('kasir.lunas', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success fw-bold">Tandai Lunas</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>