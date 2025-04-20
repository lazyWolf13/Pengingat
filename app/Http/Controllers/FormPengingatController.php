<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FormPengingat;

class FormPengingatController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('user.form_pengingat', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'nullable|date',
            'kategori' => 'required|string',
            'text' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('pengingat_files', 'public');
        }

        FormPengingat::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'text' => $request->text,
            'file' => $filename,
        ]);

        return redirect()->back()->with('success', 'Pengingat berhasil dikirim!');
    }
}