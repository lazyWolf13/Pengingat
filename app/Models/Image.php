<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image';

    protected $fillable = [
        'gallery_id',
        'file',
        'judul'
    ];

    // Relationship with Gallery
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Accessor for file URL
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file);
    }
} 