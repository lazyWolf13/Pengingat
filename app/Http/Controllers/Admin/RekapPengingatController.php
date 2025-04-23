<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormPengingat;

class RekapPengingatController extends Controller
{
    public function index()
    {
        $rekap = FormPengingat::with('user')->get();
        return view('admin.rekap_pengingat', compact('rekap'));
    }

    public function show($id)
    {
        $item = FormPengingat::with('user')->findOrFail($id);
        return view('admin.rekap_pengingat_show', compact('item'));
    }
}