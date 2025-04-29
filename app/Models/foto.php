<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'file',
        'judul',
        'catatan'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Accessor untuk mendapatkan URL lengkap dari file gambar
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file);
    }

    // Accessor untuk mendapatkan path file gambar
    public function getFilePathAttribute()
    {
        return storage_path('app/public/' . $this->file);
    }

    // Scope untuk mencari foto berdasarkan judul
    public function scopeSearch($query, $search)
    {
        return $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%');
    }

    // Scope untuk mengurutkan foto berdasarkan tanggal terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}