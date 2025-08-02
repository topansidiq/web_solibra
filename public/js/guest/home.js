function carousel() {
    return {
        active: 0,
        images: [
            '{{ asset("img/weekend-sale-banner-template-promotion-vector.jpg") }}',
            '{{ asset("img/discount-promo-landscape-banner-template-design-b2d961494cf7721d73884d8a307ac771_screen.jpg") }}',
            '{{ asset("img/banner-tambahan.jpg") }}', // Tambahkan gambar lainnya jika ada
        ],
        next() {
            this.active = (this.active + 1) % this.images.length;
        },
        prev() {
            this.active =
                (this.active - 1 + this.images.length) % this.images.length;
        },
    };
}
