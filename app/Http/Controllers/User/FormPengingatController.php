<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FormPengingat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'kategori' => 'required|in:biasa,penting,kilat,rahasia,segera',
            'disposisi' => 'required|array',
            'tanggal' => 'required|date',
            'text' => 'nullable|string',
            'file' => 'nullable|file|max:10240' // max 10MB
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/files', $filename);
            $data['file'] = str_replace('public/', '', $path);
        }

        // Convert arrays to JSON
        $data['user_ids'] = json_encode($data['user_ids']);
        $data['disposisi'] = json_encode($data['disposisi']);

        FormPengingat::create($data);

        return redirect()->route('user.pengingat.index')
            ->with('success', 'Pengingat berhasil ditambahkan');
    }
} 