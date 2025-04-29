<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with(['kategori', 'adminUser'])->orderBy('created_at', 'asc')->get();
        return view('admin.posts', compact('posts'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.postscreate', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'isi' => 'required|string',
            'status' => 'required|in:draft,published'
        ]);

        $post = Post::create([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'isi' => $request->isi,
            'admin_users_id' => Auth::id(),
            'status' => $request->status
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dibuat');
    }

    public function show(Post $post)
    {
        $post->load(['kategori', 'adminUser']);
        return view('admin.postsshow', compact('post'));
    }

    public function edit(Post $post)
    {
        $kategoris = Kategori::all();
        return view('admin.postsedit', compact('post', 'kategoris'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'isi' => 'required|string',
            'status' => 'required|in:draft,published'
        ]);

        $post->update([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'isi' => $request->isi,
            'status' => $request->status
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil diperbarui');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dihapus');
    }

    public function publish(Post $post)
    {
        $post->update(['status' => 'published']);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dipublish');
    }

    public function unpublish(Post $post)
    {
        $post->update(['status' => 'draft']);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil diunpublish');
    }
} 