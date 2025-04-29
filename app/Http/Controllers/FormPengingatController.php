<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FormPengingat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

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
        $formPengingat->user_id = auth()->id();
        $formPengingat->user_ids = json_encode($validatedData['user_ids']);
        $formPengingat->kategori = $validatedData['kategori'];
        $formPengingat->disposisi = json_encode($validatedData['disposisi']);
        $formPengingat->tanggal = $validatedData['tanggal'];
        $formPengingat->text = $validatedData['text'];
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('file', $originalName, 'public');
            $formPengingat->file = $path;
        }
    
        $formPengingat->save();
    
        return redirect()->route('user.pengingat')->with('success', 'Data berhasil disimpan.');
    }

    public function index()
    {
        $query = FormPengingat::with(['user' => function($query) {
            $query->select('id', 'full_name');
        }])->where('status', '!=', 'selesai');

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

        return view('user.pengingat', compact('formPengingat'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        if ($user) {
            $formPengingat = FormPengingat::with('user')
                ->where('user_id', $user->id)
                ->where('status', '!=', 'selesai')
                ->paginate(10);
        } else {
            $formPengingat = FormPengingat::with('user')
                ->where('status', '!=', 'selesai')
                ->paginate(10);
        }
        return view('user.pengingat', compact('formPengingat'));
    }

    public function show($id)
    {
        $pengingat = FormPengingat::with('user')->findOrFail($id);
        return view('user.pengingat_detail', compact('pengingat'));
    }

    public function selesai(Request $request)
    {
        try {
            $pengingat = FormPengingat::findOrFail($request->pengingat_id);
            $pengingat->status = 'selesai';
            $pengingat->save();

            // Ambil semua pengingat yang sudah selesai
            $selesaiPengingat = FormPengingat::with('user')
                ->where('status', 'selesai')
                ->where('user_id', auth()->id())
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

            return redirect()->route('user.progress')
                ->with('success', 'Pengingat telah diselesaikan.')
                ->with('selesaiPengingat', $selesaiPengingat);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function progress(Request $request)
    {
        $user = auth()->user();
        $pengingat = null;
        
        // Ambil semua pengingat yang sudah selesai
        $selesaiPengingat = session('selesaiPengingat') ?? FormPengingat::with('user')
            ->where('status', 'selesai')
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('user.progress', compact('pengingat', 'selesaiPengingat'));
    }

    public function download($id)
    {
        $pengingat = FormPengingat::findOrFail($id);

        // Cek apakah user yang login adalah penerima file
        if (!$pengingat->canAccessFile(Auth::id())) {
            abort(403, 'Anda tidak memiliki akses ke file ini');
        }

        // Cek apakah file ada
        if (!$pengingat->file) {
            abort(404, 'File tidak ditemukan');
        }

        // Jika file terenkripsi dan ada path, gunakan ini:
        if ($pengingat->file_path && $pengingat->is_encrypted) {
            $encryptedContent = Storage::get($pengingat->file_path);
            $decryptedContent = Crypt::decrypt($encryptedContent);

            return response($decryptedContent)
                ->header('Content-Type', $pengingat->file_mime_type)
                ->header('Content-Disposition', 'attachment; filename="' . $pengingat->file_name . '"');
        }

        // Jika file biasa (tidak terenkripsi)
        $filePath = 'public/files/' . $pengingat->file;
        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }
        return Storage::download($filePath, $pengingat->file);
    }

    public function viewFile($id)
    {
        $pengingat = FormPengingat::findOrFail($id);

        // Cek apakah user yang login adalah penerima file
        if (!$pengingat->canAccessFile(Auth::id())) {
            abort(403, 'Anda tidak memiliki akses ke file ini');
        }

        // Cek apakah file ada
        if (!$pengingat->file) {
            abort(404, 'File tidak ditemukan');
        }

        // Jika file terenkripsi dan ada path, gunakan ini:
        if ($pengingat->file_path && $pengingat->is_encrypted) {
            $encryptedContent = Storage::get($pengingat->file_path);
            $decryptedContent = Crypt::decrypt($encryptedContent);

            return response($decryptedContent)
                ->header('Content-Type', $pengingat->file_mime_type)
                ->header('Content-Disposition', 'inline; filename="' . $pengingat->file_name . '"');
        }

        // Jika file biasa (tidak terenkripsi)
        $filePath = 'public/' . $pengingat->file;
        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(storage_path('app/' . $filePath));
    }
}