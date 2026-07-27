<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Category;

class OrderController extends Controller
{
    // Fungsi untuk memproses scan QR Code meja
    public function scanMeja($token)
    {
        // Cari data meja di database berdasarkan token
        $table = \App\Models\Table::where('qr_code_token', $token)->first();

        // Jika token tidak ditemukan (QR Code tidak valid)
        if (!$table) {
            abort(404, 'QR Code Meja Tidak Valid atau Tidak Ditemukan.');
        }

        // Simpan data meja ke dalam Session agar sistem ingat pelanggan duduk di mana
        session([
            'table_id' => $table->id, 
            'table_number' => $table->table_number
        ]);

        // Setelah berhasil scan, arahkan pelanggan ke halaman E-Menu
        return redirect()->route('customer.menu');
    }

    // Fungsi untuk menampilkan halaman menu digital
    public function tampilMenu()
    {
        // Cek apakah pelanggan sudah scan QR. Jika belum, tolak aksesnya.
        if (!session()->has('table_id')) {
            return "Akses Ditolak: Silakan scan QR Code di meja Anda terlebih dahulu.";
        }

        // Ambil semua data kategori beserta menu-menunya dari database
        $categories = Category::with('menus')->get();
        $table_number = session('table_number');

        // Tampilkan halaman antarmuka (UI) menu 
        return view('customer.menu', compact('categories', 'table_number'));
    }

    public function checkout()
    {
        if (!session()->has('table_id')) {
            return redirect('/');
        }
        $table_number = session('table_number');
        return view('customer.checkout', compact('table_number'));
    }

    public function storeOrder(Request $request)
    {
        $cart = json_decode($request->cart_data, true);
        $order_code = 'ORD-' . strtoupper(uniqid()); // Generate kode acak
        
        $total_price = 0;
        foreach($cart as $item) {
            $total_price += ($item['price'] * $item['qty']);
        }

        // 1. Simpan ke tabel orders
        $order = \App\Models\Order::create([
            'order_code' => $order_code,
            'table_id' => session('table_id'),
            'customer_name' => $request->customer_name,
            'total_price' => $total_price,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        // 2. Simpan ke tabel order_items
        foreach($cart as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // Ambil data pesanan beserta relasi mejanya untuk ditampilkan di struk
        $order = \App\Models\Order::with('table')->find($order->id);

        // Arahkan ke halaman struk digital
        return redirect()->route('customer.success', ['order_code' => $order->order_code]);
    }

    // Fungsi baru untuk menampilkan halaman struk digital
    public function halamanSukses($order_code)
    {
        // Cari pesanan berdasarkan kode pesanan
        $order = \App\Models\Order::with('table')->where('order_code', $order_code)->firstOrFail();
        
        // Tampilkan halaman struk
        return view('customer.success', compact('order'));
    }

    // Fungsi untuk menampilkan pesanan di layar Kasir
    public function halamanKasir()
    {
        // Ambil semua pesanan dari yang paling baru
        $orders = \App\Models\Order::with('table')->orderBy('created_at', 'desc')->get();
        return view('admin.kasir', compact('orders'));
    }

    // Fungsi untuk mengubah status menjadi lunas di database
    public function tandaiLunas($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->update(['payment_status' => 'paid']);
        
        return redirect()->back(); // Kembali ke halaman kasir (refresh otomatis)
    }
}