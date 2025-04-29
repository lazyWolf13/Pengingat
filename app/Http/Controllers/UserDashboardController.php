<?php

namespace App\Http\Controllers;

use App\Models\FormPengingat;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalTugas = FormPengingat::where('user_id', $user->id)
            ->where('status', '!=', 'selesai')
            ->count();

        $totalDokumen = FormPengingat::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        $totalProgress = FormPengingat::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        return view('user.dashboard', compact('totalTugas', 'totalDokumen', 'totalProgress'));
    }
} 