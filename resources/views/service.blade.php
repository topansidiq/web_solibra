@extends('layouts.app')

@section('title', __('main.navigation.service') . ' | Perpustakaan Umum Kota Solok')

@section('content')
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="text-3xl font-extrabold text-sky-800">{{ __('service.our_service') }}</h2>
                <p class="text-gray-500 mt-2">{{ __('service.our_service_message') }}</p>
                <div class="w-20 border-b-4 border-sky-600 mt-3"></div>
            </div>

            <!-- Grid Layanan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Circulation -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="iteration-cw" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.circulation') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.circulation_content') }}</p>
                </div>

                <!-- Member -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="square-user-round" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.member') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.member_content') }}</p>
                </div>

                <!-- Children Collection -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="blocks" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.children_collection') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.children_collection_content') }}</p>
                </div>

                <!-- General Collection -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="users" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.general_collection') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.general_collection_content') }}</p>
                </div>

                <!-- Chatbot -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="bot" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.chatbot') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.chatbot_content') }}</p>
                </div>

                <!-- Reference -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="bookmark-check" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.reference') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.reference_content') }}</p>
                </div>

                <!-- Tandon -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="book-copy" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.tandon') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.tandon_content') }}</p>
                </div>

                <!-- Special Needs -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="accessibility" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.special_needs') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.special_needs_content') }}</p>
                </div>

                <!-- Complaint -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="speech" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.complaint') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.complaint_content') }}</p>
                </div>

                <!-- Solok Corner -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="file-clock" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.solok_corner') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.solok_corner_content') }}</p>
                </div>

                <!-- Information Retrieval -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="search" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.information_retrieval') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.information_retrieval_content') }}</p>
                </div>

                <!-- Warintek -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="laptop-minimal" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.warintek') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.warintek_content') }}</p>
                </div>

                <!-- Mobile Library -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="bus" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.mobile_library') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.mobile_library_content') }}</p>
                </div>

                <!-- Book Rotation -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="refresh-ccw" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.book_rotation') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.book_rotation_content') }}</p>
                </div>

                <!-- Early Literacy -->
                <div
                    class="bg-white rounded-xl shadow p-6 text-center border border-gray-200 hover:scale-105 hover:shadow-md transition-all duration-300 ease-in-out">
                    <i data-lucide="baby" class="w-12 h-12 mx-auto text-sky-800 mb-4"></i>
                    <h3 class="text-lg font-semibold text-sky-800 mb-2">{{ __('service.early_literacy') }}</h3>
                    <p class="text-gray-700 text-sm">{{ __('service.early_literacy_content') }}</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Jadwal Layanan -->
    <section class="py-12 bg-white">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-sky-800 mb-6 text-center">
                {{ __('service.title') }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Weekdays -->
                <div class="bg-sky-800 text-white rounded-lg p-6 text-center shadow">
                    <h3 class="text-lg font-semibold">{{ __('service.weekdays') }}</h3>
                    <p class="mt-2 text-sm">{{ __('service.weekdays_hours') }}</p>
                </div>

                <!-- Weekend -->
                <div class="bg-sky-800 text-white rounded-lg p-6 text-center shadow">
                    <h3 class="text-lg font-semibold">{{ __('service.weekend') }}</h3>
                    <p class="mt-2 text-sm">{{ __('service.weekend_hours') }}</p>
                </div>
            </div>
        </div>
    </section>

@endsection
