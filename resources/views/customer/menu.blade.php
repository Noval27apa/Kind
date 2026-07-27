<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Menu - Cafe Kind Comfy Pleasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f5f7;
            color: #212529;
        }
        /* Navbar Eksklusif */
        .cafe-navbar {
            background: linear-gradient(135deg, #18181b 0%, #27272a 100%);
            border-bottom: 3px solid #d4af37;
            padding-top: 12px;
            padding-bottom: 12px;
        }
        /* Banner Sambutan Mewah */
        .hero-banner {
            background: linear-gradient(135deg, #27272a 0%, #18181b 100%);
            color: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        .hero-banner::after {
            content: '☕';
            position: absolute;
            right: -10px;
            bottom: -20px;
            font-size: 100px;
            opacity: 0.1;
        }
        /* Kategori Heading */
        .category-title {
            font-weight: 800;
            letter-spacing: -0.3px;
            color: #18181b;
            position: relative;
            padding-left: 14px;
        }
        .category-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 22px;
            background-color: #d4af37;
            border-radius: 4px;
        }
        /* Kartu Menu Premium */
        .menu-card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }
        .menu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        /* Foto Menu */
        .menu-img {
            width: 95px;
            height: 95px;
            object-fit: cover;
            border-radius: 16px;
        }
        .no-image-box {
            width: 95px;
            height: 95px;
            background: #f1f3f5;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 11px;
            font-weight: 600;
        }
        /* Tombol Tambah Elegan */
        .btn-add {
            background: linear-gradient(135deg, #18181b 0%, #27272a 100%);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(24, 24, 27, 0.2);
            transition: all 0.2s;
        }
        .btn-add:hover {
            background: linear-gradient(135deg, #d4af37 0%, #aa8c2c 100%);
            color: #fff;
        }
        /* Footer Keranjang Melayang */
        .floating-cart {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.08);
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
        }
        .btn-checkout {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            border: none;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
            transition: all 0.2s;
        }
        .btn-checkout:hover {
            transform: translateY(-1px);
        }
        /* Modal Styling */
        .modal-content {
            border-radius: 24px;
            border: none;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-light pb-6" style="padding-bottom: 110px;">
    
    <!-- Navbar Premium dengan Logo Kustom -->
    <nav class="navbar navbar-dark cafe-navbar shadow-sm sticky-top">
        <div class="container d-flex align-items-center">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('logo-kafe.jpg') }}" alt="Logo Kafe" class="rounded-circle object-fit-cover shadow-sm bg-white" style="width: 42px; height: 42px;">
                <div>
                    <span class="d-block text-warning small fw-bold tracking-wider" style="font-size: 10px; letter-spacing: 1px;">DIGITAL E-MENU</span>
                    <span class="navbar-brand mb-0 h1 fs-6 fw-bold">Kind Comfy Pleasure</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        
        <!-- Header Banner / Sambutan -->
        <div class="hero-banner mb-3">
            <span class="badge bg-warning text-dark fw-bold mb-2 px-3 py-1.5 rounded-pill" style="font-size: 11px;">✨ Selamat Datang</span>
            <h4 class="fw-extrabold mb-1" style="font-weight: 800; font-size: 1.25rem;">Jelajahi Menu Favorit Anda</h4>
            <p class="text-white-50 small mb-0" style="font-size: 12px;">Pesan langsung dari meja Anda dengan mudah, cepat, dan nyaman.</p>
        </div>

        <!-- FITUR SEARCH BAR -->
        <div class="mb-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border bg-white">
                <span class="input-group-text bg-white border-0 ps-3 text-muted">🔍</span>
                <input type="text" id="searchMenu" class="form-control border-0 py-2.5 shadow-none" placeholder="Cari menu makanan atau minuman..." onkeyup="filterMenu()">
            </div>
        </div>

        <!-- Wadah Daftar Menu -->
        <div id="menu-container">
    @foreach($categories as $category)
        @if($category->menus->count() > 0)
            <div class="category-section mt-4 mb-3">
                
                <!-- HEADER KATEGORI DENGAN TOMBOL PANAH -->
                <div class="d-flex align-items-center justify-content-between mb-3 bg-white p-3 rounded-4 shadow-sm" 
                     data-bs-toggle="collapse" 
                     data-bs-target="#collapseCategory{{ $category->id }}" 
                     aria-expanded="true" 
                     style="cursor: pointer; transition: all 0.2s;">
                    
                    <h5 class="category-title m-0 fs-5">{{ $category->name }}</h5>
                    
                    <!-- Ikon Panah (Berputar Otomatis) -->
                    <span class="arrow-icon fw-bold text-muted transition-transform" id="arrow{{ $category->id }}" style="transform: rotate(0deg); transition: transform 0.3s;">
                        ▼
                    </span>
                </div>
                
                <!-- KONTROL MENU YANG BISA DITUTUP/BUKA -->
                <div class="collapse show" id="collapseCategory{{ $category->id }}">
                    <div class="row g-3">
                        @foreach($category->menus as $menu)
                        <div class="col-12 col-md-6 menu-item-wrapper" data-name="{{ strtolower($menu->name) }}">
                            <div class="card menu-card p-3 h-100">
                                <div class="d-flex align-items-center">
                                    
                                    <!-- FOTO MENU -->
                                    <div class="me-3 flex-shrink-0">
                                        @if($menu->image)
                                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Foto" class="menu-img shadow-sm">
                                        @else
                                            <div class="no-image-box shadow-sm">No Image</div>
                                        @endif
                                    </div>

                                    <!-- Detail Menu -->
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1 text-dark fs-6 menu-name" style="letter-spacing: -0.2px;">{{ $menu->name }}</h6>
                                        <p class="text-muted mb-2 text-truncate-2" style="font-size: 12px; line-height: 1.4; color: #6c757d; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $menu->description }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-success fw-bold" style="font-weight: 800; font-size: 15px;">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modalMenu{{ $menu->id }}">+ Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- MODAL POP-UP (KUSTOMISASI ELEGAN) -->
                            <div class="modal fade" id="modalMenu{{ $menu->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg">
                                        <div class="modal-header border-0 pb-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">✨ Sesuaikan Pesanan</h5>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-4">
                                                @if($menu->image)
                                                    <img src="{{ asset('storage/' . $menu->image) }}" class="rounded-3 object-fit-cover me-3 shadow-sm" style="width: 60px; height: 60px;">
                                                @endif
                                                <div>
                                                    <h6 class="fw-bold mb-1 text-dark">{{ $menu->name }}</h6>
                                                    <span class="text-success fw-bold small">Harga Dasar: Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Checkbox Addons -->
                                            @if($menu->addons)
                                                <p class="text-dark fw-bold small mb-2">Pilih Tambahan / Topping:</p>
                                                @php $addonList = explode(',', $menu->addons); @endphp
                                                
                                                <div class="mb-3 bg-white border rounded-4 p-3 shadow-sm">
                                                @foreach($addonList as $index => $addonRaw)
                                                    @php
                                                        $addonParts = explode(':', $addonRaw);
                                                        $addonName = trim($addonParts[0]);
                                                        $addonPrice = isset($addonParts[1]) ? (int) trim($addonParts[1]) : 0;
                                                        $addonDisplay = $addonPrice > 0 ? $addonName . ' (+Rp ' . number_format($addonPrice, 0, ',', '.') . ')' : $addonName;
                                                    @endphp
                                                    
                                                    <div class="form-check py-1 {{ !$loop->last ? 'border-bottom mb-2 pb-2' : '' }}">
                                                        <input class="form-check-input addon-checkbox-{{ $menu->id }}" 
                                                               type="checkbox" 
                                                               value="{{ $addonName }}" 
                                                               data-price="{{ $addonPrice }}" 
                                                               data-display="{{ $addonDisplay }}"
                                                               id="addon_{{ $menu->id }}_{{ $index }}"
                                                               onchange="hitungHargaLive({{ $menu->id }}, {{ $menu->price }})"> 
                                                        
                                                        <label class="form-check-label small d-flex justify-content-between w-100 fw-medium cursor-pointer" for="addon_{{ $menu->id }}_{{ $index }}">
                                                            <span>{{ $addonName }}</span>
                                                            @if($addonPrice > 0)
                                                                <span class="text-success fw-bold">+Rp {{ number_format($addonPrice, 0, ',', '.') }}</span>
                                                            @else
                                                                <span class="text-muted">Gratis</span>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                                </div>
                                            @endif

                                            <!-- Catatan -->
                                            <div class="mb-1">
                                                <label for="note_{{ $menu->id }}" class="form-label fw-bold small text-dark mb-1">Catatan untuk Dapur (Opsional):</label>
                                                <textarea id="note_{{ $menu->id }}" class="form-control rounded-3" rows="2" placeholder="Contoh: Jangan terlalu manis, es dipisah..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4 pt-0 flex-column">
                                            <div class="d-flex justify-content-between align-items-center w-100 mb-3 px-2 bg-light p-3 rounded-3">
                                                <span class="small fw-bold text-muted">Total Harga Menu:</span>
                                                <span class="fw-extrabold text-success fs-5" id="livePrice_{{ $menu->id }}">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                            </div>

                                            <button type="button" class="btn btn-primary w-100 fw-bold py-3 rounded-pill shadow" onclick="prosesPesanan({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})">Masukkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Modal -->

                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Tombol Keranjang Melayang Mewah -->
    <div class="fixed-bottom p-3 floating-cart">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="ps-2">
                <span class="text-muted d-block" style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Total Keranjang</span>
                <span id="cart-count" class="fw-extrabold text-dark fs-5">0 Item</span>
            </div>
            <a href="{{ route('customer.checkout') }}" class="btn btn-checkout text-white d-flex align-items-center gap-2 px-4 py-2">
                <span>🛒 Lihat Keranjang</span>
            </a>
        </div>
    </div>

    <!-- Script Pencarian & Pemrosesan -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (header) {
                let targetId = header.getAttribute("data-bs-target");
                let targetElement = document.querySelector(targetId);
                let arrow = header.querySelector(".arrow-icon");

                if (targetElement && arrow) {
                    targetElement.addEventListener("hide.bs.collapse", function () {
                        arrow.style.transform = "rotate(-90deg)";
                    });
                    targetElement.addEventListener("show.bs.collapse", function () {
                        arrow.style.transform = "rotate(0deg)";
                    });
                }
            });
        });
        // Fungsi Filter Search Real-time
        function filterMenu() {
            let input = document.getElementById('searchMenu').value.toLowerCase();
            let menuItems = document.querySelectorAll('.menu-item-wrapper');
            let categorySections = document.querySelectorAll('.category-section');

            menuItems.forEach(item => {
                let name = item.getAttribute('data-name');
                if (name.includes(input)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });

            categorySections.forEach(section => {
                let visibleItems = section.querySelectorAll('.menu-item-wrapper[style*="display: none"]');
                let totalItems = section.querySelectorAll('.menu-item-wrapper');
                if (visibleItems.length === totalItems.length) {
                    section.style.display = "none";
                } else {
                    section.style.display = "";
                }
            });
        }

        let cart = JSON.parse(localStorage.getItem('cafe_cart')) || [];
        updateCartCount();

        function hitungHargaLive(id, basePrice) {
            let totalAddonPrice = 0;
            let checkboxes = document.querySelectorAll('.addon-checkbox-' + id + ':checked');
            
            checkboxes.forEach(function(cb) {
                totalAddonPrice += parseInt(cb.getAttribute('data-price'));
            });
            
            let finalPrice = basePrice + totalAddonPrice;
            let formattedPrice = new Intl.NumberFormat('id-ID').format(finalPrice);
            document.getElementById('livePrice_' + id).innerText = 'Rp ' + formattedPrice.replace(/,/g, '.');
        }

        function prosesPesanan(id, name, basePrice) {
            let selectedAddons = [];
            let totalAddonPrice = 0;
            
            let checkboxes = document.querySelectorAll('.addon-checkbox-' + id + ':checked');
            checkboxes.forEach(function(checkbox) {
                selectedAddons.push(checkbox.getAttribute('data-display')); 
                totalAddonPrice += parseInt(checkbox.getAttribute('data-price')); 
            });

            let note = document.getElementById('note_' + id).value.trim();
            let finalPrice = basePrice + totalAddonPrice;

            if (totalAddonPrice > 0) {
                let infoTambahan = "(Harga telah disesuaikan karena penambahan item menu)";
                if (note === "") {
                    note = infoTambahan;
                } else {
                    note = note + " - " + infoTambahan;
                }
            }

            let itemIndex = cart.findIndex(item => 
                item.id === id && 
                JSON.stringify(item.addons) === JSON.stringify(selectedAddons) && 
                item.note === note
            );

            if (itemIndex > -1) {
                cart[itemIndex].qty += 1;
            } else {
                cart.push({ 
                    id: id, 
                    name: name, 
                    price: finalPrice, 
                    qty: 1, 
                    addons: selectedAddons, 
                    note: note 
                });
            }

            localStorage.setItem('cafe_cart', JSON.stringify(cart));
            updateCartCount();
            
            let modalElement = document.getElementById('modalMenu' + id);
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();

            document.querySelectorAll('.addon-checkbox-' + id).forEach(cb => cb.checked = false);
            document.getElementById('note_' + id).value = '';
            hitungHargaLive(id, basePrice);

            alert(name + ' berhasil ditambahkan ke keranjang!');
        }

        function updateCartCount() {
            let totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
            document.getElementById('cart-count').innerText = totalQty + ' Item';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>