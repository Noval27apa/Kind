<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Data Meja (Contoh 2 Meja)
        Table::create([
            'table_number' => 'Meja 01',
            'qr_code_token' => Str::random(15), // Membuat token acak untuk QR
            'status' => 'available'
        ]);
        
        Table::create([
            'table_number' => 'Meja 02',
            'qr_code_token' => Str::random(15),
            'status' => 'available'
        ]);

        // 2. Membuat Kategori Menu
        $kategoriMinuman = Category::create(['name' => 'Minuman']);
        $kategoriMakanan = Category::create(['name' => 'Makanan']);
        $kategoriSnack = Category::create(['name' => 'Cemilan']);

        // 3. Membuat Daftar Menu Kafe
        Menu::create([
            'category_id' => $kategoriMinuman->id,
            'name' => 'Kopi Robusta V60 (Tanpa Ampas)',
            'description' => 'Seduhan biji kopi Robusta pilihan dengan metode V60 sehingga menghasilkan kopi yang bersih tanpa endapan ampas.',
            'price' => 18000,
            'is_available' => true
        ]);

        Menu::create([
            'category_id' => $kategoriMinuman->id,
            'name' => 'Ice Lemon Tea',
            'description' => 'Teh segar dengan perasan lemon asli dan es batu.',
            'price' => 15000,
            'is_available' => true
        ]);

        Menu::create([
            'category_id' => $kategoriMakanan->id,
            'name' => 'Nasi Goreng Kind Comfy',
            'description' => 'Nasi goreng bumbu rempah spesial dengan telur mata sapi dan ayam suwir.',
            'price' => 25000,
            'is_available' => true
        ]);

        Menu::create([
            'category_id' => $kategoriSnack->id,
            'name' => 'Kentang Goreng (French Fries)',
            'description' => 'Kentang goreng renyah dengan taburan bumbu rahasia.',
            'price' => 15000,
            'is_available' => true
        ]);
    }
}