<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->get();
        $categories = Category::all();
        return view('admin.menu', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'addons' => 'nullable|string'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }

        Menu::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'addons' => $request->addons,
            'image' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Menu dan foto berhasil ditambahkan!');
    }

    // --- FUNGSI BARU: UPDATE MENU ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'addons' => 'nullable|string'
        ]);

        $menu = Menu::findOrFail($id);

        // Jika Admin mengunggah foto baru
        if ($request->hasFile('image')) {
            // Hapus foto yang lama (jika ada) agar memori tidak penuh
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            
            // Simpan foto yang baru
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $menu->image = $imagePath;
        }

        // Update data lainnya
        $menu->category_id = $request->category_id;
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->description = $request->description;
        $menu->addons = $request->addons;
        
        $menu->save();

        return redirect()->back()->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Hapus file gambar fisik dari folder jika ada
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }
        
        // Mengabaikan constraint riwayat pesanan dan menghapus data menu secara langsung
        // *Catatan: Pastikan relasi database Anda mengizinkan onDelete('cascade') atau set null jika ingin benar-benar bersih
        try {
            $menu->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika masih terikat database secara ketat, kita paksa putus relasinya di riwayat (opsional)
            // Atau Anda bisa menghapus baris riwayat yang terkait terlebih dahulu
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $menu->delete();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function qrIndex()
    {
        $tables = Table::all();
        return view('admin.qr', compact('tables'));
    }

    public function tambahMeja(Request $request)
    {
        Table::create([
            'table_number' => $request->table_number,
            'qr_code_token' => Str::random(15)
        ]);
        return redirect()->back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    public function updateMeja(Request $request, $id)
    {
        $request->validate([
            'table_number' => 'required|string|max:255'
        ]);

        $table = \App\Models\Table::findOrFail($id);
        $table->table_number = $request->table_number;
        $table->save();

        return redirect()->back()->with('success', 'Nama meja berhasil diperbarui!');
    }

    public function hapusMeja($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->back()->with('success', 'QR Code / Meja berhasil dihapus!');
    }
}