<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// 1. JALUR PELANGGAN (BEBAS DIAKSES)
// ==========================================
Route::get('/scan/{token}', [App\Http\Controllers\OrderController::class, 'scanMeja'])->name('scan.meja');
Route::get('/menu', [App\Http\Controllers\OrderController::class, 'tampilMenu'])->name('customer.menu');
Route::get('/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('customer.checkout');
Route::post('/order', [App\Http\Controllers\OrderController::class, 'storeOrder'])->name('customer.order');
Route::get('/success/{order_code}', [App\Http\Controllers\OrderController::class, 'halamanSukses'])->name('customer.success');


// ==========================================
// 2. JALUR PORTAL ADMIN (1 HALAMAN)
// ==========================================
// Menampilkan Halaman Terpadu (Login, Daftar, Lupa Password)
Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');

// Proses Login
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Proses Daftar Admin Baru
Route::post('/register-admin', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
    ]);

    return redirect('/login')->with('success', 'Akun admin berhasil dibuat! Silakan masuk.');
})->name('register.admin.store');

// Proses Lupa Password (Prototipe)
Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    // Di aplikasi nyata, ini akan mengirimkan email. Untuk prototipe kampus, kita tampilkan notifikasi sukses saja.
    return redirect('/login')->with('success', 'Tautan reset password telah dikirim ke ' . $request->email);
})->name('password.reset');


// ==========================================
// 3. JALUR STAF & ADMIN (DIKUNCI / WAJIB LOGIN)
// ==========================================
Route::middleware('auth')->group(function () {
    // Halaman Kasir
    Route::get('/kasir', [App\Http\Controllers\OrderController::class, 'halamanKasir'])->name('kasir');
    Route::post('/kasir/lunas/{id}', [App\Http\Controllers\OrderController::class, 'tandaiLunas'])->name('kasir.lunas');

    // Halaman Admin
    Route::get('/admin/menu', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.menu');
    Route::post('/admin/menu', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.menu.store');
    
    // --> INI RUTE BARU UNTUK EDIT MENU <--
    Route::put('/admin/menu/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.menu.update');
    Route::put('/admin/qr/{id}', [App\Http\Controllers\AdminController::class, 'updateMeja'])->name('admin.qr.update');

    Route::delete('/admin/menu/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.menu.destroy');
    Route::get('/admin/qr', [App\Http\Controllers\AdminController::class, 'qrIndex'])->name('admin.qr');
    Route::post('/admin/qr', [App\Http\Controllers\AdminController::class, 'tambahMeja'])->name('admin.qr.tambah');
    Route::delete('/admin/qr/{id}', [App\Http\Controllers\AdminController::class, 'hapusMeja'])->name('admin.qr.destroy');
});