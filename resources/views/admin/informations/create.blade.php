@extends('admin.layouts.app')

@section('content')
<div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddinformationModal: false }" x-cloak>

    {{-- Alert Gagal --}}
    <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }"
         x-show="show"
         x-init="setTimeout(() => show = false, 6000)"
         x-transition
         x-cloak>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    </div>

    {{-- Alert Berhasil --}}
    <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }"
         x-show="show"
         x-init="setTimeout(() => show = false, 6000)"
         x-transition
         x-cloak>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>

    {{-- Header --}}
    <div class="title p-4 flex flex-row items-center justify-between">
        <h3 class="text-xl text-neutral-700 font-bold">Tambah Informasi</h3>
    </div>

    {{-- Form Tambah Informasi --}}
    <form action="{{ route('informations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 px-4 pb-10">
        @csrf

        <div class="grid grid-cols-2 gap-6">

            {{-- Judul --}}
            <div class="col-span-2">
                <label for="title" class="block font-medium text-sm mb-1">Judul</label>
                <input type="text" name="title" id="title"
                       class="w-full p-2 border border-neutral-300 rounded-md focus:outline-none focus:ring focus:ring-sky-300"
                       required>
            </div>

            {{-- Gambar --}}
            <div class="col-span-2">
                <label for="images" class="block font-medium text-sm mb-1">Gambar</label>
                <input type="file" name="images" id="images"
                       accept=".jpg,.jpeg,.png"
                       class="w-full p-2 border border-neutral-200 rounded-md file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-neutral-300 hover:file:bg-neutral-200">
            </div>

            {{-- Deskripsi --}}
            <div class="col-span-2">
                <label for="description" class="block font-medium text-sm mb-1">Deskripsi</label>
                <div id="quillEditor" class="bg-white border border-neutral-300 rounded-md" style="height: 150px;"></div>
                <input type="hidden" name="description" id="hiddenDescription">
            </div>
        </div>

        {{-- Penulis (Otomatis dari Auth) --}}
        @php use Illuminate\Support\Facades\Auth; @endphp
        <input type="hidden" name="author" value="{{ Auth::user()->name }}">

        {{-- Tombol Submit --}}
        <div class="mt-4">
            <button type="submit"
                    class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-md shadow-sm transition">
                Simpan
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

        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('hiddenDescription').value = quill.root.innerHTML;
        });
    </script>

</div>
@endsection
