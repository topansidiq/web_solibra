<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:upcoming,ongoing,completed,cancelled',
            'poster' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:51200'
        ]);

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $mimeType = $file->getMimeType(); // contoh: 'image/jpeg' atau 'video/mp4'
            $mediaType = null;
            if (str_starts_with($mimeType, 'image/')) {
                $mediaType = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $mediaType = 'video';
            } else {
                return response()->json(['error' => 'Tipe file tidak didukung'], 400);
            }

            $path = $file->store('posters', 'public');

            $validated['poster'] = $path;

            Gallery::create([
                'file' => $path,
                'type' => $mediaType
            ]);
        }

        Event::create($validated);
        return redirect()->route('events.index')->with('success', 'Berhasil menambahkan acara kegiatan baru');
    }

    // public function update(Request $request, Event $event)
    // {
    //     $validated = $request->validate([
    //         'title' => 'sometimes|required|string|max:255',
    //         'start_at' => 'sometimes|required|date',
    //         'end_at' => 'nullable|date|after_or_equal:start_at',
    //         'description' => 'nullable|string',
    //         'location' => 'nullable|string|max:255',
    //         'status' => 'required|in:upcoming,ongoing,completed,cancelled',
    //         'poster' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:51200'
    //     ]);

    //     $event->update($validated);
    //     return response()->json($event);
    // }

    public function edit($id)
    {
        $event = Event::findOrFail($id); // Ambil data event berdasarkan ID
        return view('admin.events.update', compact('event')); // Kirim data ke view
    }

    public function show($id)
    {
        // Bisa langsung redirect ke index atau halaman detail
        return redirect()->route('member.event');
    }


    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'start_at' => 'sometimes|required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'poster' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:51200'
        ]);

        $event->title = $request->title;
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->author = Auth::user()->name;

        // Jika ada file poster baru
        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada
            if ($event->poster && file_exists(public_path('posters/' . $event->poster))) {
                unlink(public_path('posters/' . $event->poster));
            }

            $posterName = time() . '_' . $request->poster->getClientOriginalName();
            $request->poster->move(public_path('posters'), $posterName);
            $event->poster = $posterName;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui.');
    }


    public function create()
    {
        try {
            return view('admin.events.create');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return back()->with('success', 'Berhasil menghapus acara');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
