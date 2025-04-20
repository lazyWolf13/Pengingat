<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPengingat extends Model
{
    protected $table = 'form_pengingat';

    protected $fillable = [
        'user_id',
        'kategori',
        'tanggal',
        'text',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}