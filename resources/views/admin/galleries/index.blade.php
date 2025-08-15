@extends('admin.layouts.app')

@section('content')
    <div class="content flex flex-col flex-auto bg-gray-50 w-full" x-data="{ openAddborrowModal: false }" x-cloak>
        <div x-data="{ show: {{ session('error') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
            x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        <div x-data="{ show: {{ session('success') ? 'true' : 'false' }} }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="transition-all ease-in-out" x-transition
            x-cloak>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        <div class="title p-4 flex flex-row items-center justify-between">
            {{-- Header/Page Title/Page Description --}}
            <div class="flex flex-row gap-2">
                {{-- Go to Dashboard --}}
                <div class="flex items-center w-fit">
                    <a href="{{ route('dashboard.index') }}" class="text-teal-950 font-bold">
                        <i data-lucide="home" class="w-8 h-8 inline"></i>
                        <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                    </a>
                </div>

                <div class="">
                    <h3 class="text-xl text-neutral-700 font-bold">Galeri</h3>
                    <p class="text-xs text-neutral-500">Menu ini menampilkan media yang tersedia berdasarkan setiap media
                        yang ditambahkan ke aplikasi</p>
                </div>
            </div>
        </div>

        <div class="mx-4" x-data="{ addMedia: false }">
            <div class="font-sans w-full">
                {{-- Tombol Tambah Media --}}
                <button class="px-2 py-1 text-sm bg-sky-700 rounded-md text-neutral-50 flex items-center"
                    @click="addMedia=true">
                    <i class="inline w-6 h-6" data-lucide="plus"></i>
                    <span>Gambar/Video Baru</span>
                </button>

                {{-- Form Tambah Media --}}
                <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data" x-show="addMedia"
                    class="grid grid-cols-2 gap-3 items-center p-4 border rounded-xl border-neutral-200 w-fit mt-4">
                    @csrf
                    <div class="w-full col-span-2 flex justify-end-safe">
                        <button type="reset" @click="addMedia=false"><i data-lucide="x"
                                class="w-6 h-6 text-red-500"></i></button>
                    </div>
                    <div class="grid w-md items-end gap-2 col-span-1">
                        <label class="text-sm font-bold text-neutral-700" for="type">Tipe</label>
                        <select name="type" id="type" required
                            class="px-2 py-1 text-sm rounded-md text-neutral-700 border border-neutral-300 focus:outline">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div class="grid w-md gap-2 col-span-1">
                        <label class="text-sm font-bold text-neutral-700" for="file">File</label>
                        <input type="file" name="file" id="file" accept=".jpg,.jpeg,.png,.mp4,.mov,.webm"
                            required
                            class="px-2 py-1 text-sm rounded-md text-neutral-700 border border-neutral-300 focus:outline"
                            placeholder="Gambat, Video, Iklan">
                    </div>
                    <div class="grid gap-2 col-span-2">
                        <label class="text-sm font-bold text-neutral-700" for="description">Deskripsi</label>
                        <div>
                            <div id="quillEditor" class="bg-white" style="height: 130px;"></div>
                            <input type="hidden" name="description" id="hiddenDescription">
                        </div>
                    </div>
                    <div class="w-full col-span-2 flex justify-end-safe">
                        <button type="submit"
                            class="px-2 py-1 rounded-md text-sm bg-sky-700 text-neutral-50 flex items-center gap-2">
                            <i data-lucide="save" class="w-6 h-6 inline"></i>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-4">
            <div class="grid grid-cols-5 gap-3">
                @foreach ($galleries as $media)
                    <div class="shadow-md border border-neutral-200 rounded-xl">
                        <div class="h-[150px] overflow-hidden">
                            <img src="{{ asset('storage/' . $media->file) }}" class="h-full w-full object-contain">
                        </div>
                        <div class="p-4 h-[50]">
                            {{ $media->description }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script>
            const quill = new Quill('#quillEditor', {
                theme: 'snow'
            });

            // Saat submit form
            document.querySelector('form').addEventListener('submit', function() {
                document.getElementById('hiddenDescription').value = quill.root.innerHTML;
            });
        </script>
    </div>
@endsection
