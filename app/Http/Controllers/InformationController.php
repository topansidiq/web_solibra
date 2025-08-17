<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Information::paginate(20);
        $user = Auth::user();

        return view('admin.informations.index', compact('informations', 'user'));
    }

    public function create()
    {
        return view('admin.informations.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'author' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|image|max:4024',
        ]);

        $validated['author'] = $user->name;

        if ($request->hasFile('images')) {
            $imageBinary = file_get_contents($request->file('images')->getRealPath());
            $validated['images'] = $imageBinary;
        }

        if ($request->hasFile('images')) {
            $validated['images'] = $request->file('images')->store('images', 'public');
        }

        Information::create($validated);

        return redirect()->route('informations.index')->with('success', 'Berhasil membuat informasi baru.');
    }

    public function show(Information $information)
    {

        return view('admin.informations.show', compact('information'));
    }

    public function edit($id)
    {
        $information = Information::findOrFail($id);
        return view('admin.informations.update', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $information = Information::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $information->title = $request->title;
        $information->description = $request->description;
        $information->author = $request->author;

        if ($request->hasFile('images')) {
            if ($information->images && Storage::exists($information->images)) {
                Storage::delete($information->images);
            }
            $imagePath = $request->file('images')->store('informations', 'public');
            $information->images = $imagePath;
        }

        $information->save();

        return redirect()->route('informations.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(Information $information)
    {
        $information->delete();
        return redirect()->route('informations.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
