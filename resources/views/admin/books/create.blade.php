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
                class="grid grid-cols-2 gap-6">
                @csrf

                <input type="hidden" name="_method" id="formMethod" value="POST">


                <div>
                    <label for="supply_date" class="block pb-3 font-semibold">Tanggal Pengadaan</label>
                    <input type="text" name="supply_date" id="supply_date"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Pemrograman Web" required>
                </div>
                <div>
                    <label for="identification_number" class="block pb-3 font-semibold">Nomor Identitas</label>
                    <input type="text" name="identification_number" id="identification_number"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Pemrograman Web" required>
                </div>
                <div>
                    <label for="material" class="block pb-3 font-semibold"> Bahan</label>
                    <input type="text" name="material" id="material"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Pemrograman Web" required>
                </div>
                <div>
                    <label for="physical_shape" class="block pb-3 font-semibold">Bentuk Fisik</label>
                    <input type="text" name="physical_shape" id="physical_shape"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Pemrograman Web" required>
                </div>
                <div>
                    <label for="title" class="block pb-3 font-semibold">Judul Buku</label>
                    <input type="text" name="title" id="title"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Pemrograman Web" required>
                </div>

                <div>
                    <label for="author" class="block pb-3 font-semibold">Penulis</label>
                    <input type="text" name="author" id="author"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        required placeholder="Contoh: Rio, Andi, Rahmat">
                </div>
                <div>
                    <label for="edition" class="block pb-3 font-semibold">Edisi</label>
                    <input type="text" name="edition" id="edition"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        required placeholder="Contoh: Rio, Andi, Rahmat">
                </div>
                <div>
                    <label for="publication_place" class="block pb-3 font-semibold">Tempat Terbit</label>
                    <input type="text" name="publication_place" id="publication_place"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        required placeholder="Contoh: Rio, Andi, Rahmat">
                </div>

                <div>
                    <label for="publisher" class="block pb-3 font-semibold">Penerbit</label>
                    <input type="text" name="publisher" id="publisher"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Solok Publisher">
                </div>
                <div>
                    <label for="year" class="block pb-3 font-semibold">Tahun</label>
                    <input type="number" name="year" id="year"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        min="1900" max="{{ date('Y') }}" placeholder="Contoh: 1998">
                </div>
                <div>
                    <label for="acquisition_source" class="block pb-3 font-semibold">Deskipsi Fisik</label>
                    <input type="text" name="acquisition_source" id="acquisition_source"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Indonesia">
                </div>
                <div>
                    <label for="physical_description" class="block pb-3 font-semibold">Jenis Sumber
                        Perolehan</label>
                    <input type="text" name="physical_description" id="physical_description"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Indonesia">
                </div>
                <div>
                    <label for="acquisition_source" class="block pb-3 font-semibold">Nama Sumber
                        Perolehan</label>
                    <input type="text" name="acquisition_source" id="acquisition_source"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Indonesia">
                </div>
                <div>
                    <label for="isbn" class="block pb-3 font-semibold">ISBN</label>
                    <input type="text" name="isbn" id="isbn"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: 987654321">
                </div>

                <div>
                    <label for="price" class="block pb-3 font-semibold">Harga</label>
                    <input type="text" name="price" id="price"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Indonesia">
                </div>
                <div>
                    <label for="language" class="block pb-3 font-semibold">Bahasa</label>
                    <input type="text" name="language" id="language"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        placeholder="Contoh: Indonesia">
                </div>

                <div id="selectedCategories">
                    <div x-data="categorySearch({{ $categories->sortByDesc('books_count')->values()->toJson() }})" x-init="window.categorySearchInstance = $data" class="relative">
                        <label for="keyword" class="block pb-3 font-semibold">Kategori</label>
                        <input type="text" x-model="search" @focus="show = true" @keydown.tab.prevent="selectFirst()"
                            @keydown.enter.prevent="selectFirst()" @click.outside="show = false" id="keyword"
                            name="keyword"
                            class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                            placeholder="Ketikkan kategori...">

                        <!-- Dropdown kategori -->
                        <div x-show="show"
                            class="absolute w-full bg-white shadow border mt-1 rounded z-50 max-h-60 overflow-y-auto">
                            <template x-for="(cat, index) in filtered" :key="cat.id">
                                <div @click="select(cat)" class="px-4 py-2 text-sm hover:bg-teal-100 cursor-pointer"
                                    :class="index === 0 ? 'bg-teal-50' :
                                        ''">
                                    <span x-text="cat.name"></span>
                                    <span class="text-xs text-gray-400" x-text="'(' + cat.books_count + ' buku)'"></span>
                                </div>
                            </template>

                            <template x-if="filtered.length === 0">
                                <div class="px-4 py-2 text-sm text-gray-400">Tidak ditemukan</div>
                            </template>
                        </div>

                        <!-- Tampilkan kategori yang dipilih -->
                        <div class="mt-2 flex flex-wrap gap-1" id="categories">
                            <template x-for="(cat, i) in selected" :key="cat.id">
                                <div class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-sm flex items-center">
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

                <div>
                    <label for="stock" class="block pb-3 font-semibold">Stok</label>
                    <input type="number" name="stock" id="stock"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm"
                        min="0" placeholder="Contoh: 23">
                </div>

                <div class="col-span-2">
                    <label for="description" class="block pb-3 font-semibold">Deskripsi</label>
                    <textarea name="description" id="description" rows="5"
                        placeholder="Bagian ini bisa di isi dengan sinopsis atau abstrak"
                        class="form-textarea text-sm w-full border-b border-slate-400 focus: outline-0 placeholder:text-sm placeholder:text-center resize-y"></textarea>
                </div>

                <div>
                    <label for="cover" class="block pb-3 font-semibold">Cover Buku</label>
                    <input type="file" name="cover" id="cover"
                        class="form-input w-full border-b border-slate-400 focus: outline-0 p-2 placeholder: text-sm">
                </div>

                <div class="col-span-2 pt-4 flex flex-row content-end gap-4 justify-end-safe">
                    <button type="reset" id="resetBtn"
                        class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Reset</button>
                    <button type="button" @click="openAddBookModal=false"
                        class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Batal</button>
                    <button type="submit"
                        class="bg-emerald-700 px-3 py-1 rounded-sm font-bold text-white block w-28 hover:scale-105 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
