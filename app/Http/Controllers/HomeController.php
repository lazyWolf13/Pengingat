<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Profile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $fotos = Foto::latest()->get(); // BUKAN hanya satu foto
        $profiles = Profile::all();
        
        return view('welcome', compact('fotos', 'profiles'));
    }
}
