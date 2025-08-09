@extends('admin.layouts.app')

@section('content')
<div class="content flex flex-col flex-auto bg-gray-50 w-full">

    {{-- Alert --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="title p-4 flex flex-row items-center justify-between">
        <h3 class="text-xl text-neutral-700 font-bold">Edit Informasi</h3>
    </div>

    {{-- Form Edit Informasi --}}
    <form action="{{ route('informations.update', $information->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 px-4 pb-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">

            {{-- Judul --}}
            <div class="col-span-2">
                <label for="title" class="block font-medium text-sm mb-1">Judul</label>
                <input type="text" name="title" id="title"
                       class="w-full p-2 border border-neutral-300 rounded-md focus:outline-none focus:ring focus:ring-sky-300"
                       value="{{ old('title', $information->title) }}" required>
            </div>

            {{-- Gambar --}}
            <div class="col-span-2">
                <label for="images" class="block font-medium text-sm mb-1">Gambar</label>
                <input type="file" name="images" id="images"
                       accept=".jpg,.jpeg,.png"
                       class="w-full p-2 border border-neutral-200 rounded-md file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-neutral-300 hover:file:bg-neutral-200">
                @if ($information->images)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $information->images) }}" alt="Current Image" class="w-32 h-auto border rounded">
                    </div>
                @endif
            </div>

            {{-- Deskripsi --}}
            <div class="col-span-2">
                <label for="description" class="block font-medium text-sm mb-1">Deskripsi</label>
                <div id="quillEditor" class="bg-white border border-neutral-300 rounded-md" style="height: 150px;"></div>
                <input type="hidden" name="description" id="hiddenDescription" value="{{ old('description', $information->description) }}">
            </div>
        </div>

        {{-- Penulis --}}
        @php use Illuminate\Support\Facades\Auth; @endphp
        <input type="hidden" name="author" value="{{ Auth::user()->name }}">

        {{-- Tombol Submit --}}
        {{-- Tombol Submit dan Batal --}}
        <div class="mt-4 flex gap-2">
            <a href="{{ route('informations.index') }}"
            class="px-6 py-2 bg-red-500 hover:bg-gray-500 text-white font-semibold rounded-md shadow-sm transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-sky-800 hover:bg-sky-700 text-white font-semibold rounded-md shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>

    </form>

    {{-- Quill.js --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        const quill = new Quill('#quillEditor', {
            theme: 'snow'
        });

        // Set initial content
        const initialContent = `{!! old('description', $information->description) !!}`;
        quill.root.innerHTML = initialContent;

        // Copy editor content to hidden input on submit
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('hiddenDescription').value = quill.root.innerHTML;
        });
    </script>

</div>
@endsection
