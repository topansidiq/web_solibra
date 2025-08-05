@extends('layouts.app')

@section('title', 'Tampilan Buku')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="max-w-6xl mx-auto bg-white rounded shadow-md">
            <div class="flex">
                <img src="{{ asset('storage/' . $event->poster) }}" alt="" class="h-[480px]">
                <div class="p-4">
                    <div>
                        <h1 class="text-xl font-bold">{{ $event->title }}</h1>
                        @if ($event->status == 'ongoing')
                            <p class="text-xs">Sedang Berlangsung</p>
                        @elseif ($event->status == 'upcoming')
                            <p class="text-xs">Akan Datang</p>
                        @elseif ($event->status == 'completed')
                            <p class="text-xs">Telah Berakhir</p>
                        @endif
                    </div>

                    <div class="detail grid gap-3 py-3">
                        <div class="grid grid-cols-4 text-sm">
                            <p class="col-span-1 font-semibold">Tanggal</p>
                            <p class="col-span-3">
                                {{ \Carbon\Carbon::parse($event->start_at)->translatedFormat('j F Y') }}
                                ({{ \Carbon\Carbon::parse($event->start_at)->diffForHumans() }})
                                s/d
                                {{ \Carbon\Carbon::parse($event->end_at)->translatedFormat('j F Y') }}
                                ({{ \Carbon\Carbon::parse($event->end_at)->diffForHumans() }})
                            </p>
                        </div>
                        <div class="grid grid-cols-4 text-sm">
                            <p class="col-span-1 font-semibold">Lokasi</p>
                            <p class="col-span-3">{{ $event->location }}</p>
                        </div>
                        <div class="grid grid-cols-4 text-sm">
                            <p class="col-span-1 font-semibold">Deskripsi</p>
                            <p class="col-span-3 font-semibold">{{ $event->description }}</p>
                        </div>
                        <div class="grid grid-cols-4 text-sm">
                            <p class="col-span-1 font-semibold">Link</p>
                            <p class="col-span-3 font-semibold">
                                <a class="bg-neutral-200 px-2 py-1 rounded-sm underline text-sky-500"
                                    href="http://localhost:8000/show/event/1">http://localhost:8000/show/event/1</a>
                            </p>
                        </div>
                        <div class="grid grid-cols-4 text-sm">
                            <div class="col-span-4">

                                <p class="py-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime rem velit
                                    iure
                                    blanditiis maiores, expedita, repudiandae tempora sunt molestiae excepturi eveniet.
                                    Recusandae et culpa distinctio totam, fuga quidem. Nemo soluta aut minima esse adipisci?
                                    Eum reiciendis earum at incidunt quaerat.</p>

                                <p class="py-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore quaerat
                                    nihil,
                                    deleniti sequi officia sed, impedit eaque, reiciendis repudiandae nisi illum quos
                                    ducimus quod ex facilis ut. Maiores architecto itaque sequi labore expedita accusamus
                                    perspiciatis ipsum, numquam incidunt eius.</p>

                                <p class="py-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga qui debitis
                                    dicta, deserunt
                                    eligendi officia eaque, eos temporibus accusantium quibusdam cupiditate saepe recusandae
                                    obcaecati ipsam ratione aut non delectus, aspernatur error eius! Harum nostrum error
                                    nemo? Repellendus cum, repellat quod atque libero praesentium voluptatibus et modi
                                    labore cumque. Itaque unde blanditiis aspernatur rerum ducimus, amet laudantium enim
                                    minus vero. Rem?</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ $event->link }}" target="_blank" class="text-blue-600 underline">
                                {{ $event->link }}
                            </a>

                            <a href="#" class="px-2 py-1 bg-sky-500 text-white rounded-sm shadow-md">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
