@extends('admin.layouts.app')

@section('content')
    <div class="w-full">
        <div class="flex flex-row gap-2 p-4">
            {{-- Back to Book Menu --}}
            <div class="flex items-center w-fit">
                <a href="{{ route('books.index') }}" class="text-neutral-700 flex items-center">
                    <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                </a>
            </div>

            <div class="">
                <h3 class="text-xl text-neutral-700 font-bold">Tambah Buku Baru</h3>
                <p class="text-xs text-neutral-500">Ini adalah halaman untuk membuat data buku baru</p>
            </div>
        </div>
        <div class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50 relative">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-2 gap-7">
                @csrf

                <div class="col-span-2  pb-3">
                    <div>
                        <h3 class="text-md font-semibold"></h3>
                        <p class="text-xs text-neutral-500">
                            Informasi Dasar Buku
                        </p>
                    </div>
                    <div class="grid grid-cols-4 justify-between gap-4">
                        <div class="w-full">
                            <label for="title" class="block font-semibold text-sm pt-2 pb-1">Judul Buku</label>
                            <input type="text" name="title" id="title"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Pemrograman Web" required>
                        </div>
                        <div class="w-full">
                            <label for="author" class="block font-semibold text-sm pt-2 pb-1">Penulis</label>
                            <input type="text" name="author" id="author"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Sulistio, Bakayoko, Monorero" required>
                        </div>
                        <div class="w-full">
                            <label for="publisher" class="block font-semibold text-sm pt-2 pb-1">Penerbit</label>
                            <input type="text" name="publisher" id="publisher"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Gramedia" required>
                        </div>
                        <div class="w-full">
                            <label for="publication_place" class="block font-semibold text-sm pt-2 pb-1">Tempat
                                Terbit</label>
                            <input type="text" name="publication_place" id="publication_place"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Jakarta" required>
                        </div>
                        <div class="w-full">
                            <label for="year" class="block font-semibold text-sm pt-2 pb-1">Tahun Terbit</label>
                            <input type="text" name="year" id="year"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 2002" required min="1900" max="{{ date('Y') }}">
                        </div>
                        <div class="w-full">
                            <label for="isbn" class="block font-semibold text-sm pt-2 pb-1">ISBN</label>
                            <input type="text" name="isbn" id="isbn"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 9789834230190" required>
                        </div>
                        <div class="w-full">
                            <label for="edition" class="block font-semibold text-sm pt-2 pb-1">Edisi</label>
                            <input type="text" name="edition" id="edition"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Cetakan II, Edisi Revisi">
                        </div>
                        <div class="w-full">
                            <label for="language" class="block font-semibold text-sm pt-2 pb-1">Bahasa</label>
                            <input type="text" name="language" id="language"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Indonesia, Inggris, Minang">
                        </div>
                    </div>
                </div>

                <div class="col-span-2  pb-3">
                    <div>
                        <p class="text-xs text-neutral-500">
                            Informasi Fisik
                        </p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <div class="w-full">
                            <label for="material" class="block font-semibold text-sm pt-2 pb-1">Jenis Bahan</label>
                            <input type="material" name="material" id="material"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Monograf">
                        </div>
                        <div class="w-full">
                            <label for="physical_shape" class="block font-semibold text-sm pt-2 pb-1">Bentuk Fisik</label>
                            <input type="text" name="physical_shape" id="physical_shape"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Buku, Naskah, CD">
                        </div>
                        <div class="w-full">
                            <label for="physical_description" class="block font-semibold text-sm pt-2 pb-1">Deskripsi
                                Fisik</label>
                            <input type="text" name="physical_description" id="physical_description"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 101 halaman, Ilustrasi: bergambar;berwarna, 19 x 19 cm">
                        </div>
                        <div class="w-full">
                        </div>
                    </div>
                </div>

                <div class="col-span-2  pb-3">
                    <div>
                        <p class="text-xs text-neutral-500">
                            Informasi Sumber
                        </p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <div class="w-full">
                            <label for="supply_date" class="block font-semibold text-sm pt-2 pb-1">Tanggal
                                Pengadaan</label>
                            <input type="text" name="supply_date" id="supply_date"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 12-12-2012">
                        </div>
                        <div class="w-full">
                            <label for="identification_number" class="block font-semibold text-sm pt-2 pb-1">Nomor
                                Identifikasi</label>
                            <input type="text" name="identification_number" id="identification_number"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 136.4/Bp-2024">
                        </div>
                        <div class="w-full">
                            <label for="acquisition_source" class="block font-semibold text-sm pt-2 pb-1">Sumber
                                Perolehan</label>
                            <input type="text" name="acquisition_source" id="acquisition_source"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: Pembelian, Hibah">
                        </div>
                        <div class="w-full">
                            <label for="acquisition_name" class="block font-semibold text-sm pt-2 pb-1">Nama Sumber
                                Perolehan</label>
                            <input type="text" name="acquisition_name" id="acquisition_name"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: APBD 2022">
                        </div>
                    </div>
                </div>

                <div class="col-span-2  pb-3">
                    <div>
                        <p class="text-xs text-neutral-500">
                            Informasi Lainnya
                        </p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <div class="w-full">
                            <label for="price" class="block font-semibold text-sm pt-2 pb-1">Harga</label>
                            <input type="text" name="price" id="price"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 120.000, Rp320.000">
                        </div>
                        <div class="w-full">
                            <label for="stock" class="block font-semibold text-sm pt-2 pb-1">Stok/Eksemplar</label>
                            <input type="number" name="stock" id="stock"
                                class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs"
                                placeholder="Contoh: 23">
                        </div>
                        <div class="w-full">
                            <label for="categories" class="block font-semibold text-sm pt-2 pb-1">Kategori</label>
                            <div id="selectedCategories">
                                <div x-data="categorySearch({{ $categories->sortByDesc('books_count')->values()->toJson() }})" x-init="window.categorySearchInstance = $data" class="">
                                    <input type="text" x-model="search" @focus="show = true"
                                        @keydown.tab.prevent="selectFirst()" @keydown.enter.prevent="selectFirst()"
                                        @click.outside="show = false" id="categories" name="categories"
                                        class="form-input w-full border border-neutral-400 rounded-md focus: outline-0 p-2 placeholder: text-xs placeholder:text-blue-300"
                                        placeholder="Ketikkan kategori...">

                                    <!-- Dropdown kategori -->
                                    <div x-show="show"
                                        class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto max-w-60">
                                        <template x-for="(cat, index) in filtered" :key="cat.id">
                                            <div @click="select(cat)"
                                                class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer"
                                                :class="index === 0 ? 'bg-teal-50' :
                                                    ''">
                                                <span x-text="cat.name"></span>
                                                <span class="text-xs text-gray-400"
                                                    x-text="'(' + cat.books_count + ' buku)'"></span>
                                            </div>
                                        </template>

                                        <template x-if="filtered.length === 0">
                                            <div class="px-4 py-2 text-sm text-gray-400">Tidak ditemukan</div>
                                        </template>
                                    </div>

                                    <!-- Tampilkan kategori yang dipilih -->
                                    <div class="mt-2 flex flex-wrap gap-1" id="categories">
                                        <template x-for="(cat, i) in selected" :key="cat.id">
                                            <div
                                                class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-sm flex items-center">
                                                <span x-text="cat.name"></span>
                                                <button type="button" class="ml-2" @click="remove(cat.id)">
                                                    x
                                                </button>
                                                <input type="hidden" name="categories[]" :value="cat.id">
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-data="{ fileName: '' }" class="w-full">
                            <label for="cover-upload" class="block font-semibold text-sm pt-2 pb-1">Cover
                                Buku</label>

                            <!-- Label kustom sebagai pengganti input file -->
                            <label for="cover-upload"
                                class="flex items-center justify-between px-4 py-2 border border-dashed border-gray-400 rounded-md cursor-pointer bg-white hover:bg-gray-50 text-xs text-gray-500">
                                <span x-text="fileName || 'Pilih file cover (JPG/PNG)'" class="truncate"></span>
                                <i data-lucide="upload" class="w-4 h-4 text-gray-400"></i>
                            </label>

                            <!-- Input file tersembunyi -->
                            <input type="file" name="cover" id="cover-upload" class="hidden"
                                accept=".jpg,.jpeg,.png" @change="fileName = $event.target.files[0]?.name || ''">
                        </div>
                    </div>
                </div>


                <div class="col-span-2">
                    <label for="description" class="block pb-3 font-semibold text-sm">Deskripsi</label>
                    {{--
                    <textarea name="description" id="editor" rows="10"
                        placeholder="Bagian ini bisa di isi dengan sinopsis atau abstrak"
                        class="form-textarea text-sm w-full border-b border-slate-400 focus: outline-0 placeholder:text-xs placeholder:text-center resize-y"></textarea> --}}

                    <div id="quillEditor" class="bg-white" style="height: 130px;"></div>
                    <input type="hidden" name="description" id="hiddenDescription">
                </div>

                <div class="col-span-2 pt-4 flex flex-row content-end gap-4 justify-start">
                    <button type="reset" id="resetBtn"
                        class="block rounded-sm font-bold bg-yellow-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Reset</button>
                    <button type="button" @click="openAddBookModal=false"
                        class="block rounded-sm font-bold bg-red-700 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Batal</button>
                    <button type="submit"
                        class="bg-green-700 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
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
