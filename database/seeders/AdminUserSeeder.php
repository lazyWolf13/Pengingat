<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::create([
            'full_name' => 'AdminSAC1',
            'email' => 'thalialupinski@gmail.com',
            'password' => Hash::make('securepasswordSAC'),
        ]);
    }
}
