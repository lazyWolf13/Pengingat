<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function index()
    {
        $fotos = Foto::all();
        return view('admin.foto', compact('fotos'));
    }

    public function create()
    {
        return view('admin.fotocreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the public disk under photos directory
            $path = $file->storeAs('photos', $filename, 'public');
            
            // Create the photo record
            Foto::create([
                'file' => $path,
                'judul' => $request->judul,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('admin.foto.index')
                            ->with('success', 'Foto berhasil diupload.');
        }

        return back()->with('error', 'Gagal mengupload foto.');
    }

    public function show(Foto $foto)
    {
        return view('admin.foto.show', compact('foto'));
    }

    public function edit(Foto $foto)
    {
        return view('admin.fotoedit', compact('foto'));
    }

    public function update(Request $request, Foto $foto)
    {
        $request->validate([
            'file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($foto->file);
            
            // Store new file
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');
            
            $foto->file = $path;
        }

        $foto->judul = $request->judul;
        $foto->catatan = $request->catatan;
        $foto->save();

        return redirect()->route('admin.foto.index')
                        ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Foto $foto)
    {
        // Delete the file from storage
        Storage::disk('public')->delete($foto->file);
        
        // Delete the record
        $foto->delete();

        return redirect()->route('admin.foto.index')
                        ->with('success', 'Foto berhasil dihapus.');
    }
} 