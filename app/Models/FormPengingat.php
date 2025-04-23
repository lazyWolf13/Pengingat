<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPengingat extends Model
{
    use HasFactory;

    protected $table = 'form_pengingat';

    protected $fillable = [
        'user_id',
        'user_ids',
        'kategori',
        'disposisi',
        'tanggal',
        'text',
        'file'
    ];

    protected $casts = [
        'user_ids' => 'array',
        'disposisi' => 'array',
        'tanggal' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}