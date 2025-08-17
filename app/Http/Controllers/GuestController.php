<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Information;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home()
    {
        $latestBook = Book::latest()->take(6)->get();
        $latestMedia = Gallery::latest()->take(6)->get();
        $latestEvent = Event::latest()->take(6)->get();
        $newItem = [
            'book' => Book::latest()->first(),
            'event' => Event::latest()->first(),
            'information' => Information::latest()->first(),
        ];

        return view('home', compact('latestBook', 'latestMedia', 'latestEvent', 'newItem'));
    }

    public function collection(Request $request)
    {
        $latestBook = Book::latest()->take(6)->get();
        $books = Book::all();

        $categories = Category::whereHas('books')->take(5)->get();
        $selectedCategory = $request->query('category');
        $books = Book::when($selectedCategory, function ($query, $categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        })->latest()->take(6)->get();

        return view('collection', compact('latestBook', 'books', 'categories', 'selectedCategory'));
    }

    public function profile()
    {
        return view('profile');
    }
    public function service()
    {
        return view('service');
    }
    public function event()
    {
        $events = Event::all()->groupBy('status');
        return view('event', compact('events'));
    }

    public function information()
    {
        $informations = Information::orderBy('created_at', 'desc')->get();
        return view('information', compact('informations'));
    }

    public function gallery()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('gallery', compact('galleries'));
    }

    public function showInformation($id)
    {
        $information = Information::findOrFail($id);
        return view('show.information', compact('information'));
    }

    public function showEvent($id)
    {
        $event = Event::findOrFail($id);

        return view('show.event', compact('event'));
    }

    public function showBook(Book $book)
    {
        $book->load('categories');
        $categoryIds = $book->categories->pluck('id');
        $relatedBooks = Book::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
            ->where('id', '!=', $book)
            ->with('categories')
            ->latest()
            ->take(6)
            ->get();

        return view('show.book', compact('book', 'relatedBooks'));
    }

    public function showByCategory()
    {
        return redirect()->route('collection')->with('success', 'Yahh');
    }
}