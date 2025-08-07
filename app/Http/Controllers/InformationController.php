<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informations = Information::paginate(20);
        $user = Auth::user();

        return view('admin.informations.index', compact('informations', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.informations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'author'=> 'required|string',
            'title'=>'required|string',
            'description'=>'required|string',
            'images'=>'required|image|max:4024',
        ]);

        $validated['author'] = $user->name;

         if ($request->hasFile('images')) {
        // Ambil binary dari file gambar
        $imageBinary = file_get_contents($request->file('images')->getRealPath());
        $validated['images'] = $imageBinary;
    }

        if($request->hasFile('images')){
            $validated['images'] = $request->file('images')->store('images', 'public');
        }

        $informations = Information::create($validated);

        return redirect()->route('informations.index')->with('success', 'Berhasil membuat informasi baru');

    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information)
    {

        return view('admin.informations.show', compact('information'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        //
    }
}
