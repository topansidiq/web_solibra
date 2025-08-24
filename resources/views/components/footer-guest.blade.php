<footer class="bg-white mt-10 static bottom-0 w-full">
    <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-2 gap-10">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3974.2159786061274!2d100.6668065!3d-0.7978297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2a597d90519999%3A0x2b92f34027ee9e69!2sPerpustakaan%20Umum%20Kota%20Solok!5e0!3m2!1sid!2sid!4v1720778893269!5m2!1sid!2sid"
            width="100%" height="300" style="border:0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <div class="pl-2 md:justify-self-end max-w-md">

            <h3 class="text-md font-bold mb-3 border-b-2 inline-block border-gray-400">
                {{ __('main.footer.address_heading') }}</h3>
            <p class="text-gray-700 mb-2">{{ __('main.footer.address_content') }}</p>

            <div class="mb-4 text-gray-700 text-sm space-y-1">
                <p>{!! __('main.footer.telephone') !!}</p>
                <p>{!! __('main.footer.whatsapp') !!}</p>
                <p>{!! __('main.footer.email') !!}</p>
            </div>
            <h3 class="text-md font-bold mb-3 border-b-2 inline-block border-gray-400">{{ __('main.footer.social') }}
            </h3>
            <div class="flex items-center mt-1 space-x-3">
                <a href="/"
                    class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                        <path
                            d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z">
                        </path>
                    </svg>
                </a>
                <a href="/"
                    class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
                    <svg viewBox="0 0 30 30" fill="currentColor" class="h-6">
                        <circle cx="15" cy="15" r="4"></circle>
                        <path
                            d="M19.999,3h-10C6.14,3,3,6.141,3,10.001v10C3,23.86,6.141,27,10.001,27h10C23.86,27,27,23.859,27,19.999v-10   C27,6.14,23.859,3,19.999,3z M15,21c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S18.309,21,15,21z M22,9c-0.552,0-1-0.448-1-1   c0-0.552,0.448-1,1-1s1,0.448,1,1C23,8.552,22.552,9,22,9z">
                        </path>
                    </svg>
                </a>
                <a href="/"
                    class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                        <path
                            d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="border-t text-center text-sm text-gray-600 py-4">
        Copyright © 2025. All Right Reserved By Perpustakaan Umum Kota Solok
    </div>
</footer>
