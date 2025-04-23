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

        $validatedData = $request->validate([
            'user_ids' => 'required|array',
            'kategori' => 'required|string',
            'disposisi' => 'required|array',
            'tanggal' => 'required|date',
            'text' => 'nullable|string',
            'file' => 'nullable|file',
        ]);
    
        $formPengingat = new FormPengingat();
        $formPengingat->user_ids = json_encode($validatedData['user_ids']);
        $formPengingat->kategori = $validatedData['kategori'];
        $formPengingat->disposisi = json_encode($validatedData['disposisi']);
        $formPengingat->tanggal = $validatedData['tanggal'];
        $formPengingat->text = $validatedData['text'];
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/files', $filename);
            $formPengingat->file = $filename;
        }
    
        $formPengingat->save();
    
        return redirect()->route('user.pengingat')->with('success', 'Data berhasil disimpan.');
    }

    public function index()
    {
        $query = FormPengingat::query();

        // Filter berdasarkan pencarian
        if (request('search')) {
            $query->where('text', 'like', '%' . request('search') . '%');
        }

        // Filter berdasarkan kategori
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        // Filter berdasarkan tanggal
        if (request('tanggal')) {
            $query->whereDate('tanggal', request('tanggal'));
        }

        // Ambil data dengan pagination
        $formPengingat = $query->orderBy('created_at', 'desc')->paginate(10);

        // Jika tidak ada parameter pencarian, tampilkan semua data
        if (!request('search') && !request('kategori') && !request('tanggal')) {
            $formPengingat = FormPengingat::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('user.pengingat', compact('formPengingat'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        if ($user) {
            $formPengingat = FormPengingat::where('user_id', $user->id)->get();
        } else {
            $formPengingat = FormPengingat::all();
        }
        return view('user.pengingat', compact('formPengingat'));
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