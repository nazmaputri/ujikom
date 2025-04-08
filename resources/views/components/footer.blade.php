<footer class="bg-sky-500 text-white py-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center justify-center place-items-center sm:text-left">
            <!-- Logo & Deskripsi -->
            <div class="flex flex-col items-center sm:items-start">
                <a href="#" class="flex items-center space-x-3">
                    <div class="bg-white rounded-full w-14 h-14 flex items-center justify-center">
                        <img src="{{ asset('storage/eduflix-1.png') }}" alt="EduFlix Logo" class="rounded-full object-cover w-full h-full">
                    </div>
                    <span class="text-2xl font-semibold text-white">EduFlix</span>
                </a>
                <p class="mt-4 text-sm">
                    EduFlix adalah platform kursus online dengan berbagai topik menarik yang disampaikan melalui video. Tersedia juga fitur konsultasi via chat untuk membantu siswa memahami materi dengan lebih baik.
                </p>
            </div>

            <!-- Menu Navigasi -->
            <div class="flex flex-col items-center sm:items-start">
                <h4 class="font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#home" class="hover:text-sky-200 transition">Beranda</a></li>
                    <li><a href="#about" class="hover:text-sky-200 transition">Tentang</a></li>
                    <li><a href="#category" class="hover:text-sky-200 transition">Kategori</a></li>
                    <li><a href="#price" class="hover:text-sky-200 transition">Harga</a></li>
                    <li><a href="#rating" class="hover:text-sky-200 transition">Rating</a></li>
                    <li><a href="/login" class="hover:text-sky-200 transition">Masuk</a></li>
                </ul>
            </div>

            <!-- Kontak & Sosial Media -->
            <div class="flex flex-col items-center sm:items-start">
                <h4 class="font-semibold mb-4">Kontak Kami</h4>
                <p class="text-sm">Email : eduflix00@gmail.com</p>
                <p class="text-sm">Telp : +62 813 1234 5678</p>
            </div>
        </div>

        <!-- Footer Bawah -->
        <div class="mt-8 border-t border-white pt-4 text-center text-sm">
            <p>&copy; 2024 EduFlix. All rights reserved.</p>
        </div>
    </div>
</footer>
