@extends('admin.layouts.app')

@section('content')
    <div class="w-full">
        <script src="{{ asset('js/admin/dashboard.js') }}"></script>
        <div x-data="{ showError: {{ session('error') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => showError = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-red-300 px-2 py-1 rounded-sm">Gagal</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }} }" x-show="show"
            x-init="setTimeout(() => showSuccess = false, 6000)" class="transition-all ease-in-out" x-transition x-cloak>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold bg-green-300 px-2 py-1 rounded-sm">Berhasil</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        <div class="flex flex-row gap-2 p-4">
            {{-- Back to Book Menu --}}
            <div class="flex items-center w-fit">
                <a href="{{ route('books.index') }}" class="text-neutral-700 flex items-center">
                    <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                </a>
            </div>

            <div class="">
                <h3 class="text-xl text-neutral-700 font-bold">Edit Buku</h3>
                <p class="text-xs text-neutral-500">Halaman ini digunakan untuk memperbarui data buku</p>
            </div>
        </div>
        <div class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50 relative">
            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-2 gap-5">
                @csrf
                @method('PUT')

                <div class="col-span-2 pb-3">
                    <div>
                        <h3 class="text-md font-semibold"></h3>
                        <p class="text-xs text-neutral-500">
                            Informasi Dasar Buku
                        </p>
                    </div>
                    <div class="grid grid-cols-4 justify-between gap-4">
                        <div class="w-full">
                            <label for="title" class="block font-semibold text-sm pt-2 pb-1">
                                Judul Buku <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: Pemrograman Web" value="{{ old('title', $book->title) }}" required>
                        </div>
                        <div class="w-full">
                            <label for="author" class="block font-semibold text-sm pt-2 pb-1">
                                Penulis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="author" id="author"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: Sulistio, Bakayoko, Monorero"
                                value="{{ old('author', $book->author) }}">
                        </div>
                        <div class="w-full">
                            <label for="publisher" class="block font-semibold text-sm pt-2 pb-1">Penerbit</label>
                            <input type="text" name="publisher" id="publisher"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: Gramedia" value="{{ old('publisher', $book->publisher) }}">
                        </div>
                        <div class="w-full">
                            <label for="publication_place" class="block font-semibold text-sm pt-2 pb-1">Tempat
                                Terbit</label>
                            <input type="text" name="publication_place" id="publication_place"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: Jakarta"
                                value="{{ old('publication_place', $book->publication_place) }}">
                        </div>
                        <div class="w-full">
                            <label for="year" class="block font-semibold text-sm pt-2 pb-1">Tahun Terbit</label>
                            <input type="number" name="year" id="year"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: 2002" value="{{ old('year', $book->year) }}" min="1900"
                                max="{{ date('Y') }}">
                        </div>
                        <div class="w-full">
                            <label for="isbn" class="block font-semibold text-sm pt-2 pb-1">ISBN</label>
                            <input type="text" name="isbn" id="isbn"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: 9789834230190" value="{{ old('isbn', $book->isbn) }}">
                        </div>
                        <div class="w-full">
                            <label for="edition" class="block font-semibold text-sm pt-2 pb-1">Edisi</label>
                            <input type="text" name="edition" id="edition"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: Cetakan II, Edisi Revisi" value="{{ old('edition', $book->edition) }}">
                        </div>
                        <div class="w-full">
                            <label for="language" class="block font-semibold text-sm pt-2 pb-1">Bahasa</label>
                            <select name="language" id="language"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-sm">
                                <option value="">-- Pilih Bahasa --</option>
                                <option value="bahasa indonesia" {{ old('language', $book->language) == 'bahasa indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                <option value="bahasa inggris" {{ old('language', $book->language) == 'bahasa inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                <option value="bahasa minang" {{ old('language', $book->language) == 'bahasa minang' ? 'selected' : '' }}>Bahasa Minang</option>
                                <option value="bahasa" {{ old('language', $book->language) == 'bahasa' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 pb-3">
                    <div>
                        <p class="text-xs text-neutral-500">
                            Informasi Fisik
                        </p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <div class="w-full">
                            <label for="material" class="block font-semibold text-sm pt-2 pb-1">Jenis Bahan</label>
                            <select name="material" id="material"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-sm">
                                <option value="">-- Pilih Jenis Bahan --</option>
                                <option value="monograf" {{ old('material', $book->material) == 'monograf' ? 'selected' : '' }}>Monograf</option>
                                <option value="terbitan berseri" {{ old('material', $book->material) == 'terbitan berseri' ? 'selected' : '' }}>Terbitan Berseri</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="physical_shape" class="block font-semibold text-sm pt-2 pb-1">Bentuk Fisik</label>
                            <input type="text" name="physical_shape" id="physical_shape"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: Buku, Naskah, CD"
                                value="{{ old('physical_shape', $book->physical_shape) }}">
                        </div>
                        <div class="w-full">
                            <label for="physical_description" class="block font-semibold text-sm pt-2 pb-1">Deskripsi
                                Fisik</label>
                            <input type="text" name="physical_description" id="physical_description"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: 101 halaman, Ilustrasi: bergambar;berwarna, 19 x 19 cm"
                                value="{{ old('physical_description', $book->physical_description) }}">
                        </div>
                        <div class="w-full">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 pb-3">
                    <div>
                        <p class="text-xs text-neutral-500">
                            Informasi Sumber
                        </p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <div class="w-full">
                            <label for="supply_date" class="block font-semibold text-sm pt-2 pb-1">Tanggal Pengadaan</label>
                            <input type="text" name="supply_date" id="supply_date"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: 12-12-2012" value="{{ old('supply_date', $book->supply_date) }}">
                        </div>

                        <div class="w-full">
                            <label for="identification_number" class="block font-semibold text-sm pt-2 pb-1">Nomor
                                Identifikasi</label>
                            <input type="text" name="identification_number" id="identification_number"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: 136.4/Bp-2024"
                                value="{{ old('identification_number', $book->identification_number) }}">
                        </div>
                        <div class="w-full">
                            <label for="acquisition_source" class="block font-semibold text-sm pt-2 pb-1">Sumber
                                Perolehan</label>
                            <select name="acquisition_source" id="acquisition_source"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-sm required">
                                <option value="">-- Pilih Sumber Perolehan --</option>
                                <option value="pembelian" {{ old('acquisition_source', $book->acquisition_source) == 'pembelian' ? 'selected' : '' }}>Pembelian</option>
                                <option value="hadiah/hibah" {{ old('acquisition_source', $book->acquisition_source) == 'hadiah/hibah' ? 'selected' : '' }}>Hadiah/Hibah</option>
                                <option value="buku liam" {{ old('acquisition_source', $book->acquisition_source) == 'buku liam' ? 'selected' : '' }}>Buku Liam</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="acquisition_name" class="block font-semibold text-sm pt-2 pb-1">Nama Sumber
                                Perolehan</label>
                            <input type="text" name="acquisition_name" id="acquisition_name"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 text-xs"
                                placeholder="Contoh: APBD 2022"
                                value="{{ old('acquisition_name', $book->acquisition_name) }}">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 pb-3">
                    <p class="text-xs text-neutral-500 mb-2">Informasi Lainnya</p>

                    <div class="flex justify-between items-start gap-4">

                        <!-- Harga -->
                        <div class="w-full">
                            <label for="price" class="block font-semibold text-sm pt-2 pb-1">Harga</label>
                            <input type="text" name="price" id="price"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 placeholder:text-xs"
                                placeholder="Contoh: 120.000, Rp320.000" value="{{ old('price', $book->price ?? '') }}">
                        </div>

                        <!-- Stok -->
                        <div class="w-full">
                            <label for="stock" class="block font-semibold text-sm pt-2 pb-1">Stok/Eksemplar</label>
                            <input type="number" name="stock" id="stock"
                                class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 placeholder:text-xs"
                                placeholder="Contoh: 23" value="{{ old('stock', $book->stock ?? '') }}">
                        </div>

                        <!-- Kategori -->
                        <div class="w-full">
                            <label for="categories" class="block font-semibold text-sm pt-2 pb-1">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <div x-data="categorySearch({{ $categories->sortByDesc('books_count')->values()->toJson() }})"
                                x-init="window.categorySearchInstance = $data">
                                <input type="text" x-model="search" @focus="show = true"
                                    @keydown.tab.prevent="selectFirst()" @keydown.enter.prevent="selectFirst()"
                                    @click.outside="show = false" id="categories" name="categories"
                                    class="form-input w-full border border-neutral-400 rounded-md focus:outline-0 p-2 placeholder:text-xs placeholder:text-blue-300"
                                    placeholder="Ketikkan kategori...">

                                <!-- Wrapper Alpine.js -->
                                <div x-data="categorySelector({{ $categories->toJson() }}, {{ isset($book) ? $book->categories->toJson() : '[]' }})"
                                    class="relative">

                                    <!-- Dropdown kategori -->
                                    <div x-show="show"
                                        class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto max-w-60">
                                        <template x-for="(cat, index) in filtered" :key="cat.id">
                                            <div @click="select(cat)"
                                                class="px-4 py-2 text-sm hover:bg-sky-100 cursor-pointer"
                                                :class="index === 0 ? 'bg-sky-50' :
                                                    ''">
                                                <span x-text="cat.name"></span>
                                                <span class="text-xs text-neutral-400"
                                                    x-text="'(' + cat.books_count + ' buku)'"></span>
                                            </div>
                                        </template>

                                        <template x-if="filtered.length === 0">
                                            <div class="px-4 py-2 text-sm text-neutral-400">Tidak ditemukan</div>
                                        </template>
                                    </div>

                                    <!-- Tampilkan kategori yang dipilih -->
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        <template x-for="(cat, i) in selected" :key="cat.id">
                                            <div
                                                class="bg-sky-100 text-sky-800 px-2 py-1 rounded text-sm flex items-center">
                                                <span x-text="cat.name"></span>
                                                <button type="button" class="ml-2" @click="remove(cat.id)">x</button>
                                                <input type="hidden" name="categories[]" :value="cat.id">
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <script>
                                    function categorySelector(allCategories, selectedCategories) {
                                        return {
                                            show: false,
                                            search: '',
                                            filtered: allCategories,
                                            selected: selectedCategories, // di edit langsung isi kategori lama

                                            select(cat) {
                                                if (!this.selected.some(c => c.id === cat.id)) {
                                                    this.selected.push(cat);
                                                }
                                            },
                                            remove(id) {
                                                this.selected = this.selected.filter(c => c.id !== id);
                                            }
                                        }
                                    }
                                </script>
                            </div>
                            <a class="block text-xs rounded-sm px-2 py-1 bg-sky-700 text-neutral-50 w-fit mt-2"
                                href="{{ route('categories.index') }}">
                                Buat Kategori Baru
                            </a>
                        </div>

                        <!-- Cover Buku -->
                        <div x-data="{ fileName: '' }" class="w-full">
                            <label for="cover-upload" class="block font-semibold text-sm pt-2 pb-1">Cover Buku</label>
                            <label for="cover-upload"
                                class="flex items-center justify-between px-4 py-2 border border-dashed border-gray-400 rounded-md cursor-pointer bg-white hover:bg-gray-50 text-xs text-gray-500">
                                <span x-text="fileName || 'Pilih file cover (JPG/PNG)'" class="truncate"></span>
                                <i data-lucide="upload" class="w-4 h-4 text-gray-400"></i>
                            </label>
                            <input type="file" name="cover" id="cover-upload" class="hidden" accept=".jpg,.jpeg,.png"
                                @change="fileName = $event.target.files[0]?.name || ''">
                        </div>

                    </div>
                </div>

                <div class="col-span-2">
                    <label for="description" class="block pb-3 font-semibold text-sm">Deskripsi</label>
                    <div id="quillEditor" class="bg-white" style="height: 130px;">
                        {!! old('description', $book->description) !!}
                    </div>
                    <input type="hidden" name="description" id="hiddenDescription"
                        value="{{ old('description', $book->description) }}">
                </div>

                {{-- Tombol Simpan / Batal --}}
                <div class="flex justify-end gap-2 mt-4 col-span-2">
                    <a href="{{ route('books.index') }}"
                        class="text-xs bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="text-xs bg-sky-800 text-white px-6 py-2 rounded hover:bg-sky-900 transition">
                        Simpan Perubahan
                    </button>
                </div>

                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
                <script>
                    const quill = new Quill('#quillEditor', {
                        theme: 'snow'
                    });

                    // Saat submit form
                    document.querySelector('form').addEventListener('submit', function () {
                        document.getElementById('hiddenDescription').value = quill.root.innerHTML;
                    });
                </script>
            </form>

        </div>
    </div>
@endsection
