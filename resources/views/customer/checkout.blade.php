<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h3 class="fw-bold text-center mb-4">Konfirmasi Pesanan</h3>
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold border-bottom pb-2">Daftar Pesanan ({{ $table_number }})</h5>
                <ul id="order-list" class="list-group list-group-flush mb-3">
                    <!-- Item dirender via JS -->
                </ul>
                <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                    <span>Total Bayar:</span>
                    <span id="total-price" class="text-success">Rp 0</span>
                </div>
            </div>
        </div>

        <!-- Form untuk dikirim ke Backend Laravel -->
        <!-- Perbaikan: Menambahkan id="checkout-form" dan nama rute yang benar -->
        <form id="checkout-form" action="{{ route('customer.order') }}" method="POST">
            @csrf
            <input type="hidden" name="cart_data" id="cart_data">
            
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary">Nama Pemesan</label>
                <input type="text" name="customer_name" class="form-control form-control-lg" placeholder="Masukkan nama Anda..." required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 fw-bold py-3 fs-5">Kirim Pesanan ke Dapur</button>
        </form>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cafe_cart')) || [];
        if(cart.length === 0) {
            alert('Keranjang kosong! Kembali ke menu.');
            window.location.href = '/menu';
        }

        let orderList = document.getElementById('order-list');
        let total = 0;
        
        cart.forEach(item => {
            let subtotal = item.price * item.qty;
            total += subtotal;

            // --- FITUR BARU: Menampilkan Opsi Tambahan (Addons) ---
            let addonsHtml = '';
            if (item.addons && item.addons.length > 0) {
                addonsHtml = '<div class="mt-1 d-flex flex-wrap gap-1">';
                item.addons.forEach(addon => {
                    addonsHtml += `<span class="badge bg-warning text-dark border fw-normal" style="font-size: 10px;">+ ${addon}</span>`;
                });
                addonsHtml += '</div>';
            }

            // --- FITUR BARU: Menampilkan Catatan (Note) ---
            let noteHtml = '';
            if (item.note && item.note.trim() !== '') {
                noteHtml = `<div class="text-muted mt-1" style="font-size: 11px; font-style: italic;">📝 Catatan: ${item.note}</div>`;
            }

            // Memasukkan HTML yang sudah digabung ke dalam daftar pesanan
            orderList.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-start px-0 py-3">
                    <div class="pe-2">
                        <h6 class="my-0 fw-bold">${item.name}</h6>
                        <small class="text-muted">${item.qty} x Rp ${item.price.toLocaleString('id-ID')}</small>
                        ${addonsHtml}
                        ${noteHtml}
                    </div>
                    <span class="text-dark fw-bold text-end">Rp ${subtotal.toLocaleString('id-ID')}</span>
                </li>`;
        });
        
        document.getElementById('total-price').innerHTML = `Rp ${total.toLocaleString('id-ID')}`;
        document.getElementById('cart_data').value = JSON.stringify(cart);

        // Menghapus data keranjang lokal setelah form berhasil dikirim
        document.getElementById('checkout-form').addEventListener('submit', function() {
            localStorage.removeItem('cafe_cart'); 
        });
    </script>
</body>
</html>