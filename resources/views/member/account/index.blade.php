@extends('member.layouts.app')

@section('title', 'Accout | {{ $user->name }}')

@section('content')
    <div class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen p-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Left profile panel -->
            <section class="col-span-1 flex flex-col items-center md:items-start">
                <div class="relative rounded-full border-4 border-gray-300 w-48 h-48 overflow-hidden mb-4">

                    @if (empty($user->profile_picture))
                        @if ($user->gender == 'P')
                            <img src="{{ asset('img/female.png') }}" class="w-full h-full object-top" />
                        @elseif ($user->gender == 'L')
                            <img src="{{ asset('img/male.png') }}" class="w-full h-full object-cover" />
                        @else
                            <img src="{{ asset('img/male.png') }}" class="w-full h-full object-cover" />
                        @endif
                    @else
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-full h-full object-cover" />
                    @endif
                </div>

                <div class="text-center md:text-left">
                    <h1 class="text-xl font-semibold">{{ $user->name }}</h1>
                    <p class="text-gray-500 mb-2 text-sm">
                        <span class="font-bold">Status: </span>
                        <span class="cursor-pointer">
                            @if ($user->member_status == 'new')
                                <a href="{{ route('member.verification') }}">
                                    Baru <button
                                        class="text-xs border bg-neutral-500 text-neutral-50 rounded-lg px-2 hover:bg-neutral-700">Belum
                                        Terverifikasi</button>
                                </a>
                            @endif
                        </span>
                    </p>
                    <button
                        class="w-full mx-auto md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-md py-2 px-4 mb-6 transition">
                        Edit Profil
                    </button>

                    <ul class="space-y-3 text-sm text-gray-600 mb-6">
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 12.414m0 0L9.172 8.172m4.242 4.242l4.242 4.242m-8.484-8.484l4.242 4.242" />
                            </svg>
                            <span>2 followers • 2 following</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 11c0 4-3 7-3 7s-3-3-3-7a6 6 0 1112 0c0 4-3 7-3 7s-3-3-3-7z" />
                            </svg>
                            <span>Padang, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 3h-1a4 4 0 000 8h1a4 4 0 010 8h-1"></path>
                            </svg>
                            <a href="https://www.instagram.com/topanisme_" target="_blank" rel="noopener"
                                class="hover:text-blue-600">topanisme_</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M19 0h-14c-2.209 0-4 1.791-4 4v16c0 1.105.895 2 2 2h4v-8h-2v-2h2v-1c0-2.206 1.794-4 4-4h3v2h-3c-.551 0-1 .449-1 1v1h4l-1 2h-3v8h5c1.105 0 2-.895 2-2v-16c0-2.209-1.791-4-4-4z">
                                </path>
                            </svg>
                            <a href="https://linkedin.com/in/topanisme" target="_blank" rel="noopener"
                                class="hover:text-blue-600">in/topanisme</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 00-2 2v16l4-4h6a2 2 0 002-2V4a2 2 0 00-2-2z" />
                            </svg>
                            <span>@topanisme_</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 2a10 10 0 00-3.16 19.42c.5.09.68-.22.68-.48v-1.7c-2.8.61-3.38-1.35-3.38-1.35-.45-1.14-1.1-1.44-1.1-1.44-.9-.62.07-.61.07-.61 1 .07 1.53 1.02 1.53 1.02.89 1.53 2.34 1.1 2.9.84.09-.66.35-1.1.63-1.36-2.24-.26-4.6-1.12-4.6-4.97 0-1.1.38-2 .99-2.7a3.4 3.4 0 01.09-2.67s.81-.26 2.64 1a9.26 9.26 0 014.8 0c1.83-1.26 2.63-1 2.63-1a3.4 3.4 0 01.09 2.7c.61.7 1 1.6 1 2.7 0 3.86-2.37 4.7-4.63 4.96.36.32.68.95.68 1.92v2.85c0 .26.18.57.69.47A10 10 0 0012 2z" />
                            </svg>
                            <a href="https://youtube.com/@topanisme" target="_blank" rel="noopener"
                                class="hover:text-blue-600">@topanisme</a>
                        </li>
                    </ul>

                    <hr class="border-gray-300 w-full mb-6" />

                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Achievements</h2>
                    <div class="flex space-x-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/0d1d7e04-bb43-4226-a367-5a4a7e960d45.png"
                            alt="Achievement badge showing a stylized blue and white icon with intricate design"
                            class="rounded-full border border-gray-300"
                            onerror="this.src='https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/0bc936f5-1b1e-498d-b600-b4a7d587e2ed.png'" />
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/3a7ddbe4-1eb9-4bf4-8790-0dc923567c48.png"
                            alt="Achievement badge showing a circular colorful design with pastel pink and orange colors"
                            class="rounded-full border border-gray-300"
                            onerror="this.src='https://placehold.co/64x64/png?text=No+Image'" />
                    </div>
                </div>
            </section>

            <!-- Right main content panel -->
            <section class="col-span-3 flex flex-col space-y-8">
                <!-- Popular repositories -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Popular repositories</h2>
                    <button class="text-blue-600 text-sm hover:underline focus:outline-none"
                        aria-label="Customize your pins">
                        Customize your pins
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Repository card -->
                    <template
                        x-for="repo in [
          {name:'topan', desc:'abalabal', lang:'HTML', langColor:'bg-red-500'},
          {name:'topan-portfolio-website', desc:'', lang:'HTML', langColor:'bg-red-500'},
          {name:'basic-javascript-project', desc:'', lang:'CSS', langColor:'bg-purple-600'},
          {name:'portfolio-tailwind-css', desc:'Portfolio Topan Sidiq menggunakan TailwindCSS.', lang:'HTML', langColor:'bg-red-500'},
          {name:'ai-image-gen', desc:'', lang:'JavaScript', langColor:'bg-yellow-400'},
          {name:'world', desc:'Belajar Javascript - Sebuah Dunia Virtual', lang:'JavaScript', langColor:'bg-yellow-400'}
          ]"
                        :key="repo.name">
                        <div class="rounded-md border border-gray-300 p-4 hover:shadow-md transition bg-white">
                            <h3 class="font-semibold text-blue-600 hover:underline cursor-pointer" x-text="repo.name">
                            </h3>
                            <p class="text-gray-600 text-sm mt-1" x-text="repo.desc" x-show="repo.desc.length > 0"></p>
                            <div class="flex justify-between mt-3 items-center">
                                <div class="flex items-center space-x-2 text-sm text-gray-600" x-show="repo.lang">
                                    <span :class="repo.langColor + ' h-3 w-3 rounded-full block'"></span>
                                    <span x-text="repo.lang"></span>
                                </div>
                                <span
                                    class="px-2 py-0.5 border rounded-full border-gray-400 text-xs text-gray-700 select-none">Public</span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Contribution graph and years -->
                <div class="flex flex-col md:flex-row gap-6 text-sm">
                    <div class="flex-1">
                        <h3 class="mb-2 font-medium">88 contributions in the last year</h3>
                        <div class="overflow-auto border border-gray-300 rounded-md p-4 bg-white">
                            <div class="grid grid-cols-[repeat(53,14px)] grid-rows-7 gap-1">
                                <!-- Day Labels -->
                                <div class="col-span-1 row-start-2 row-end-3 text-xs text-gray-500"
                                    style="writing-mode: vertical-rl; transform: rotate(180deg)">Mon</div>
                                <div class="col-span-1 row-start-4 row-end-5 text-xs text-gray-500"
                                    style="writing-mode: vertical-rl; transform: rotate(180deg)">Wed</div>
                                <div class="col-span-1 row-start-6 row-end-7 text-xs text-gray-500"
                                    style="writing-mode: vertical-rl; transform: rotate(180deg)">Fri</div>

                                <!-- Contribution cells (mockup brightness random for demo) -->
                                <template x-for="i in 365" :key="i">
                                    <div class="contribution-cell bg-green-100 rounded-md"
                                        :class="{
                                            'bg-green-300': i % 15 === 0,
                                            'bg-green-200': i % 7 === 0 && i % 15 !== 0,
                                            'bg-green-400': i === 100,
                                        }"
                                        :title="`Day ${i} contributions: ${Math.floor(Math.random()*5)}`"></div>
                                </template>

                                <!-- Months Label -->
                                <div class="col-start-2 col-span-4 text-xs text-gray-500 font-semibold">Aug</div>
                                <div class="col-start-7 col-span-4 text-xs text-gray-500 font-semibold">Sep</div>
                                <div class="col-start-11 col-span-4 text-xs text-gray-500 font-semibold">Oct</div>
                                <div class="col-start-15 col-span-4 text-xs text-gray-500 font-semibold">Nov</div>
                                <div class="col-start-19 col-span-4 text-xs text-gray-500 font-semibold">Dec</div>
                                <div class="col-start-23 col-span-4 text-xs text-gray-500 font-semibold">Jan</div>
                                <div class="col-start-27 col-span-4 text-xs text-gray-500 font-semibold">Feb</div>
                                <div class="col-start-31 col-span-4 text-xs text-gray-500 font-semibold">Mar</div>
                                <div class="col-start-35 col-span-4 text-xs text-gray-500 font-semibold">Apr</div>
                                <div class="col-start-39 col-span-4 text-xs text-gray-500 font-semibold">May</div>
                                <div class="col-start-43 col-span-4 text-xs text-gray-500 font-semibold">Jun</div>
                                <div class="col-start-47 col-span-4 text-xs text-gray-500 font-semibold">Jul</div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 flex justify-between select-none">
                                <span>Less</span>
                                <div class="flex space-x-1">
                                    <div class="w-3 h-3 bg-green-100 rounded-sm"></div>
                                    <div class="w-3 h-3 bg-green-200 rounded-sm"></div>
                                    <div class="w-3 h-3 bg-green-300 rounded-sm"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-sm"></div>
                                </div>
                                <span>More</span>
                            </div>
                        </div>
                    </div>

                    <!-- Year selector -->
                    <div
                        class="w-32 flex flex-col items-center md:items-start justify-start text-gray-700 text-sm gap-1 select-none">
                        <div class="mb-2 font-semibold">Contribution settings <svg xmlns="http://www.w3.org/2000/svg"
                                class="inline-block h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg></div>
                        <template x-for="y in [2025, 2024, 2023, 2022, 2021]" :key="y">
                            <button @click="year = y" :class="year === y ? 'bg-blue-600 text-white' : 'hover:bg-gray-200'"
                                class="w-full text-center rounded-md px-3 py-1 transition focus:outline-none"
                                x-text="y"></button>
                        </template>
                    </div>
                </div>

                <!-- Contribution Activity -->
                <section>
                    <h3 class="text-lg font-semibold mb-4">Contribution activity</h3>
                    <div
                        class="border-t border-gray-300 pt-4 space-y-6 bg-white rounded-md p-4 shadow-sm max-h-[350px] overflow-y-auto">
                        <article>
                            <time class="block font-semibold text-gray-700 mb-1">July 2025</time>
                            <p class="flex items-center gap-1 text-gray-800 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
                                </svg>
                                Created 19 commits in 2 repositories
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-blue-600 text-sm">
                                <li>
                                    <a href="#" class="hover:underline">topansidiq/web_solibra</a>
                                    <span class="text-gray-500 ml-1">13 commits</span>
                                    <div class="h-2 mt-1 rounded-full bg-green-600 w-60"></div>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">topansidiq/ta</a>
                                    <span class="text-gray-500 ml-1">6 commits</span>
                                    <div class="h-2 mt-1 rounded-full bg-green-600 w-40"></div>
                                </li>
                            </ul>
                        </article>
                    </div>
                </section>
            </section>
        </div>
    </div>
@endsection
