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
        'file',
        'file_name',
        'file_path',
        'file_mime_type',
        'is_encrypted'
    ];

    protected $casts = [
        'user_ids' => 'array',
        'disposisi' => 'array',
        'tanggal' => 'date',
        'is_encrypted' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canAccessFile($userId)
    {
        // Ambil nilai user_ids dan pastikan dalam bentuk array
        $userIds = $this->user_ids;

        // Jika user_ids adalah string (belum dicast otomatis), ubah jadi array
        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }

        // Jika setelah decode masih bukan array, jadikan array kosong
        if (!is_array($userIds)) {
            $userIds = [];
        }

        return in_array($userId, $userIds);
    }

    public function getFileUrl()
    {
        if (!$this->file_path) {
            return null;
        }

        return route('user.pengingat.download', ['id' => $this->id]);
    }
}