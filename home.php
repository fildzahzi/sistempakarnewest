<!-- About Section -->
<section class="home">
    <div>
        <div class="welcome">
            <h1>
                Selamat datang
            </h1>
            <h1>
                di Sistem Pakar Penyakit Tebu
            </h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti deleniti libero magni ex animi aspernatur doloremque mollitia! Eveniet ullam accusantium, sunt maxime iure velit vitae aspernatur accusamus id pariatur inventore?</p>
            <a href="?m=konsultasi">Konsultasi</a>
        </div>
        <div class="slider-container">
            <div class="slider">
                <div class="card">
                    <img src="assets/images/tanaman1.png" alt="Tanaman 1" height="500">
                </div>
                <div class="card">
                    <img src="assets/images/tanaman2.png" alt="Tanaman 2" height="500">
                </div>
                <div class="card">
                    <img src="assets/images/tanaman3.png" alt="Tanaman 3" height="500">
                </div>
                <div class="card">
                    <img src="assets/images/tanaman4.png" alt="Tanaman 4" height="500">
                </div>
            </div>
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>

        <script>
            let currentSlide = 0;

            function showSlide(index) {
                const slides = document.querySelectorAll('.slider .card');
                const totalSlides = slides.length;

                if (index >= totalSlides) {
                    currentSlide = 0; // Kembali ke slide pertama
                } else if (index < 0) {
                    currentSlide = totalSlides - 1; // Kembali ke slide terakhir
                } else {
                    currentSlide = index;
                }

                const offset = -currentSlide * 100; // Menghitung offset dalam persentase
                document.querySelector('.slider').style.transform = `translateX(${offset}%)`;
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            // Tampilkan slide pertama saat halaman dimuat
            showSlide(currentSlide);
        </script>
    </div>
</section>