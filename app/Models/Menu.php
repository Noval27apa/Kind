<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Tambahkan koma di akhir setiap baris kecuali yang paling bawah
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'image',
        'addons'
    ];

    // Relasi ke tabel kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}