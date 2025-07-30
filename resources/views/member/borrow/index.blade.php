@extends('member.layouts.app')

@section('content')
    <div class="border-x border-neutral-200 mx-52 p-4 px-5">
        <div>
            <div class="gap-4 items-center justify-between">
                <div>
                    <h1 class="font-bold text-lg text-neutral-700">Peminjaman Terbaru</h1>
                </div>
                <div class="py-2 gap-2">
                    @if ($user->borrows->isEmpty())
                        <p
                            class="p-2 bg-yellow-100 border border-neutral-300 rounded-md text-neutral-700 text-sm shadow-md w-fit">
                            {{ $user->name }} anda
                            belum melakukan
                            peminjaman</p>
                        <button class="p-2 bg-sky-700 text-neutral-50 text-sm rounded-md flex items-center gap-1">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                            <span>Buat Peminjaman</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
