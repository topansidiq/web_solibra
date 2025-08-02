<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
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
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
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

        $event = Event::create($validated);
        return response()->json($event, 201);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'start_at' => 'sometimes|required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'poster' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:51200'
        ]);

        $event->update($validated);
        return response()->json($event);
    }
}