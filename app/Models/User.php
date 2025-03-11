<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Attendance;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'subdit',
        'lembaga',
    ];
    protected $hidden = [
        'password',
    ];
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    
}
