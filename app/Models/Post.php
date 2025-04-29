<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'judul',
        'kategori_id',
        'isi',
        'admin_users_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_users_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
} 