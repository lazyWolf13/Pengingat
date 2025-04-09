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
        'catatan',
    ];

    // Accessor to get the full URL of the photo
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file);
    }
}