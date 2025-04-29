<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $fillable = [
        'post_id',
        'position',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getGambarUrlAttribute()
    {
        return asset('storage/' . $this->gambar);
    }
} 