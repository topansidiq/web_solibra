@extends('admin.layouts.app')

@section('content')
    <div class="w-full">
        <div class="flex flex-row gap-2 p-4">
            {{-- Back to Book Menu --}}
            <div class="flex items-center w-fit">
                <a href="{{ route('events.index') }}" class="text-neutral-700 flex items-center">
                    <i data-lucide="chevron-left" class="w-10 h-10 inline"></i>
                </a>
            </div>

            <div class="">
                <h3 class="text-xl text-neutral-700 font-bold">Tambah Kegiatan Baru</h3>
                <p class="text-xs text-neutral-500">Ini adalah halaman untuk membuat data kegiatan baru</p>
            </div>
        </div>
        <div class="mx-4 mb-4 p-4 rounded-sm bg-neutral-50 relative">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-2 gap-6">
                @csrf



                <div class="col-span-2 pt-4 flex flex-row content-end gap-4 justify-end-safe">
                    <button type="reset" id="resetBtn"
                        class="block rounded-sm font-bold bg-red-500 px-3 py-1 w-28 text-white hover:scale-105 transition-all">Reset</button>
                    <button type="button"
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
