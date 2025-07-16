function carousel() {
    return {
        active: 0,
        slides: [
            { image: "/img/Perpustakaan_Umum_Kota_Solok.jpg" },
            { image: "/img/BI_Corner.jpg" },
            { image: "/img/Perpustakaan_Umum_Kota_Solok.jpg" },
            { image: "/img/BI_Corner.jpg" },
        ],
        start() {
            setInterval(() => {
                this.next();
            }, 7000);
        },
        next() {
            this.active = (this.active + 1) % this.slides.length;
        },
        prev() {
            this.active =
                (this.active - 1 + this.slides.length) % this.slides.length;
        },
    };
}
