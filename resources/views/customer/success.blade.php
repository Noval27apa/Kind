<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FITUR AUTO-REFRESH: Halaman akan reload setiap 5 detik jika status masih unpaid -->
    @if($order->payment_status == 'unpaid')
        <meta http-equiv="refresh" content="5">
    @endif
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container p-3" style="max-width: 500px;">
        <div class="card border-0 shadow-lg rounded-4 p-4 text-center">
            
            <!-- Ubah ikon centang berdasarkan status -->
            <div class="mb-3">
                @if($order->payment_status == 'paid')
                    <span style="font-size: 4rem;">🎉</span>
                @else
                    <span style="font-size: 4rem;">✅</span>
                @endif
            </div>

            <h2 class="fw-bold text-success mb-3">
                @if($order->payment_status == 'paid')
                    Pembayaran Lunas!
                @else
                    Pesanan Diterima!
                @endif
            </h2>
            
            <p class="text-muted mb-4">
                @if($order->payment_status == 'paid')
                    Terima kasih <strong>{{ $order->customer_name }}</strong>. Pesanan Anda sedang kami siapkan!
                @else
                    Halo <strong>{{ $order->customer_name }}</strong>, pesanan Anda sudah masuk ke sistem dapur.
                @endif
            </p>

            <ul class="list-group list-group-flush text-start mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span class="text-muted">No. Pesanan:</span>
                    <strong class="text-dark">{{ $order->order_code }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span class="text-muted">Nomor Meja:</span>
                    <strong class="text-dark">{{ $order->table->table_number }}</strong>
                </li>
                
                <!-- STATUS PEMBAYARAN DINAMIS -->
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span class="text-muted">Status Pembayaran:</span>
                    @if($order->payment_status == 'paid')
                        <span class="badge bg-success px-3 py-2 fs-6">Sudah Lunas</span>
                    @else
                        <span class="badge bg-danger px-3 py-2 fs-6">Belum Dibayar</span>
                    @endif
                </li>
                
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-0 mt-3">
                    <span class="fw-bold fs-5">Total Tagihan:</span>
                    <span class="fw-bold fs-5 text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </li>
            </ul>

            @if($order->payment_status == 'unpaid')
                <p class="text-muted small mb-4">
                    <span class="spinner-border spinner-border-sm text-primary me-1" role="status"></span>
                    Menunggu pembayaran di Kasir...
                </p>
            @endif

            <a href="{{ route('customer.menu') }}" class="btn btn-secondary w-100 fw-bold py-3 text-uppercase rounded-3">Kembali ke Menu</a>
        </div>
    </div>
</body>
</html>