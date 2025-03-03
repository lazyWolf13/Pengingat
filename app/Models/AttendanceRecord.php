<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'tanggal',
        'waktu_check_in',
        'waktu_check_out',
        'lokasi_absen',
        'ketepatan_waktu',
        'durasi_lembur',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
