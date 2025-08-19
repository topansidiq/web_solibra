@extends('member.layouts.app')

@section('title', 'Peminjaman | Perpustakaan Umum Kota Solok')

@section('content')
    <main class="bg-white py-6" x-data="borrowModal()">
        <div class="max-w-7xl mx-auto px-4">
            <div class="gap-4 items-center justify-between">
                <div>
                    <h1 class="font-bold text-lg text-neutral-700">{{ __('borrow.latest_borrow') }}</h1>
                </div>
                <div class="py-2 grid gap-2">
                    @if ($collections->isEmpty())
                        <div class="px-4 py-8 bg-slate-50 rounded-lg text-center text-gray-500 text-sm">
                            {{ __('borrow.no_borrow') }}
                        </div>
                        <button @click="showBorrowModal=true"
                            class="p-2 w-fit bg-sky-700 hover:bg-sky-800 transition text-white text-sm rounded-md flex items-center gap-1 shadow">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                            <span>{{ __('borrow.create_borrow') }}</span>
                        </button>
                    @else
                        <div>
                            <button @click="showBorrowModal=true"
                                class="p-2 w-fit bg-sky-700 hover:bg-sky-800 transition text-white text-sm rounded-md flex items-center gap-1 shadow">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                                <span>{{ __('borrow.add_borrow') }}</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-5">
                            @foreach ($collections as $book)
                                <a href="{{ route('member.collection.show', $book->id) }}" class="block bg-white rounded-xl shadow hover:shadow-lg border border-slate-200
                                    hover:scale-105 transition transform overflow-hidden">

                                    {{-- Cover Buku --}}
                                    @if (!empty($book->cover) && Storage::disk('public')->exists($book->cover))
                                        <div class="h-72 bg-cover bg-center"
                                            style="background-image: url('{{ asset('storage/' . $book->cover) }}')"></div>
                                    @else
                                        <div class="h-72 bg-sky-800 flex items-center justify-center text-white text-center p-4">
                                            <h1 class="text-lg font-semibold drop-shadow-lg">{{ $book->clean_title }}</h1>
                                        </div>
                                    @endif

                                    {{-- Info Buku --}}
                                    <div class="p-3">
                                        <h2 class="font-bold text-sm line-clamp-2 text-slate-800">
                                            {{ $book->title }} ({{ $book->year }})
                                        </h2>
                                        <div class="text-xs text-gray-500 mb-1">
                                            @foreach ($book->categories as $category)
                                                <span>{{ $category->name }}</span>@if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                        <p class="text-xs font-medium text-sky-700">{{ __('borrow.author') }} {{ $book->author }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Pencarian -->
        <div x-show="showBorrowModal" class="fixed inset-0 z-50 flex items-start justify-center bg-black/50 overflow-auto">
            <div class="bg-white rounded-2xl w-full max-w-6xl mt-10 p-6 relative">
                <button @click="showBorrowModal=false"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">&times;</button>
                <h2 class="text-xl font-bold text-sky-800 mb-4">{{ __('borrow.search_book') }}</h2>

                <!-- Input search -->
                <input type="text" x-model="query" @input.debounce.100ms="searchBooks" placeholder="{{ __('borrow.search_book') }}..."
                    class="w-full p-2 border rounded-md mb-4">

                <!-- Hasil buku -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
                    <template x-for="book in books" :key="book.id">
                        <a :href="`{{ route('member.collection.show', ['book' => 'BOOK_ID']) }}`.replace('BOOK_ID', book.id)"
                            class="block bg-white rounded-xl shadow hover:shadow-lg border border-slate-200 hover:scale-105 transition transform overflow-hidden">

                            <div x-show="book.cover" class="h-72 bg-cover bg-center"
                                :style="`background-image: url(${book.cover})`"></div>
                            <div x-show="!book.cover"
                                class="h-72 bg-sky-800 flex items-center justify-center text-white text-center p-4">
                                <h1 class="text-lg font-semibold drop-shadow-lg" x-text="book.title"></h1>
                            </div>
                            <div class="p-3">
                                <h2 class="font-bold text-sm line-clamp-2 text-slate-800" x-text="book.title"></h2>
                                <div class="text-xs text-gray-500 mb-1" x-text="book.categories.join(', ')"></div>
                                <p class="text-xs font-medium text-sky-700"x-text="'{{ __('borrow.author') }} ' + book.author"></p>
                            </div>
                        </a>
                    </template>

                    <template x-if="books.length === 0 && query.length >= 2">
                        <div class="col-span-full text-center text-gray-500">{{ __('borrow.no_book_found') }}</div>
                    </template>
                </div>
            </div>
        </div>
    </main>

    <script>
        function borrowModal() {
            return {
                showBorrowModal: false,
                query: '',
                books: [],
                searchBooks() {
                    if (this.query.length < 2) {
                        this.books = [];
                        return;
                    }
                    fetch(`/member/borrow/search?q=${this.query}`)
                        .then(res => res.json())
                        .then(data => {
                            this.books = data.map(book => ({
                                id: book.id,
                                title: book.title,
                                author: book.author,
                                cover: book.cover ? `/storage/${book.cover}` : null,
                                categories: book.categories.map(c => c.name)
                            }));
                        });
                }
            }
        }
    </script>
@endsection
