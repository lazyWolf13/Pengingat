<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('admin.profile', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profilecreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Profile::create($request->all());
        return redirect()->route('admin.profiles.index')->with('success', 'Profile created successfully.');
    }

    public function edit(Profile $profile)
    {
        return view('admin.profileedit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $profile->update($request->all());
        return redirect()->route('admin.profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return redirect()->route('admin.profiles.index')->with('success', 'Profile deleted successfully.');
    }
}
