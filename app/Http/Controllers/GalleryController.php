<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $galleries = Gallery::all();
            return view('admin.galleries.index', compact('galleries', 'user'));
        } catch (\Throwable $th) {
            Log::error($th);
            return back()->with('message', 'Gagal memuat halaman galeri')->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|string|in:image,video',
                'description' => 'nullable|string'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $type = $request->input('type');
            $fileRules = $type === 'image'
                ? 'required|image|mimes:jpg,jpeg,png|max:51200'
                : 'required|mimetypes:video/mp4,video/quicktime,video/webm|max:51200';
            $validator = Validator::make($request->all(), [
                'file' => $fileRules,
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $path = $request->file('file')->store('galleries', 'public');
            Gallery::create([
                'type' => $type,
                'file' => $path
            ]);
            return back()->with('success', "Berhasil menambahkan {$type} baru.");
        } catch (\Throwable $th) {
            Log::error($th);
            return back()
                ->with('message', 'Gagal menambahkan media baru.')
                ->with('error', $th->getMessage());
        }
    }
}
