<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        // Mengambil gambar dengan urutan dari yang terlama
        $images = Image::with('gallery')->oldest()->get();
        return view('admin.image', compact('images'));
    }    

    public function toggleStatus(Image $image)
    {
        $image->status = $image->status === 'active' ? 'inactive' : 'active';
        $image->save();

        return redirect()->route('admin.image')->with('success', 'Status gambar berhasil diubah.');
    }

    public function create()
    {
        $galleries = Gallery::all();
        return view('admin.imagecreate', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:gallery,id',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the public disk under photos directory
            $path = $file->storeAs('images', $filename, 'public');
            
            // Create the photo record
            Image::create([
                'gallery_id' => $request->gallery_id,
                'file' => $path,
                'judul' => $request->judul
            ]);

            return redirect()->route('admin.image.index')
            ->with('success', 'Gambar berhasil diunggah');
        }

        return back()->with('error', 'Gagal mengupload foto.');
    }

    public function edit(Image $image)
    {
        $galleries = Gallery::all();
        return view('admin.imageedit', compact('image', 'galleries'));
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'gallery_id' => 'required|exists:gallery,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255'
        ]);

        $data = [
            'gallery_id' => $request->gallery_id,
            'judul' => $request->judul
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::delete('public/' . $image->file);

            // Upload file baru
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/images', $filename);
            $data['file'] = 'images/' . $filename;
        }

        $image->update($data);

        return redirect()->route('admin.image.index')
            ->with('success', 'Gambar berhasil diperbarui');
    }

    public function destroy(Image $image)
    {
        // Hapus file dari storage
        Storage::delete('public/' . $image->file);
        
        // Hapus record dari database
        $image->delete();

        return redirect()->route('admin.image.index')
            ->with('success', 'Gambar berhasil dihapus');
    }
} 