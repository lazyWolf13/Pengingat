<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Post;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('post')->orderBy('created_at', 'asc')->get();
        return view('admin.gallery', compact('galleries'));
    }

    public function create()
    {
        $posts = Post::all();
        return view('admin.gallerycreate', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'position' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        Gallery::create($request->all());

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil dibuat');
    }

    public function edit(Gallery $gallery)
    {
        $posts = Post::all();
        return view('admin.galleryedit', compact('gallery', 'posts'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'position' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $gallery->update($request->all());

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil dihapus');
    }
} 