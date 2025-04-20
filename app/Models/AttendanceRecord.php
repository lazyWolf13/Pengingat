<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'ketepatan_waktu',
        'durasi_lembur',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function summaries()
    {
        return $this->hasMany(AttendanceSummary::class);
    }
}
