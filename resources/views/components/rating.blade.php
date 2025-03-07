<!-- Testimoni Section -->
<section id="rating" class="bg-sky-50 py-16">
    <div class="container mx-auto px-2">
        <div class="mb-6 text-center">
            <h3 class="md:text-3xl text-2xl font-bold text-sky-400" data-aos="fade-down">
                Testimoni Pengguna
            </h3>
            <p class="text-md text-gray-700 mt-2" data-aos="fade-down">
                Apa kata pengguna kami setelah mengikuti kursus di Eduflix?
            </p>
        </div>
        <div class="overflow-x-auto hide-scrollbar">
        @if ($ratings->isEmpty())
            <div class="text-center text-gray-500 text-md" data-aos="fade-down">
                Belum ada rating
            </div>
        @else
            <div class="flex space-x-6 m-7">
                @foreach ($ratings as $rating)
                    @if ($rating->display) 
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md w-full md:w-1/2 lg:w-1/3 p-6 mt-6 mx-2 hover:shadow-lg transition-shadow duration-300 ease-in-out" data-aos="zoom-in-up">
                            <div class="flex items-center mb-4">
                                <!-- Gambar avatar (ikon user) -->
                                <div class="w-14 h-14 rounded-full flex items-center justify-center">
                                    <img width="48" height="48" src="https://img.icons8.com/pulsar-color/48/user-male-circle.png" alt="user-male-circle"/>
                                </div>
        
                                <!-- Nama dan Rating -->
                                <div class="ml-4">
                                    <!-- Nama User -->
                                    <h4 class="text-xl font-semibold text-sky-400 capitalize">{{ $rating->nama }}</h4>
                                    <div class="flex items-center mt-1">
                                        <!-- Menampilkan bintang berdasarkan rating -->
                                        @for ($i = 0; $i < 5; $i++)
                                            <span class="{{ $i < $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 mt-2">"{{ $rating->comment }}"</p>
                        </div>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
        
    </div>

    <style>
        /* Animasi hover untuk card testimoni */
        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</section>

<!-- Rating Section -->
<section id="rating" class="bg-sky-50 py-16">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row lg:space-x-12 items-center">
            <!-- Image Section -->
            <div class="lg:w-1/3 order-1 lg:order-2 lg:mb-0 flex justify-center" data-aos="fade-left">
                <img src="{{ asset('storage/eduflix-1.png') }}" alt="Gambar" class="w-4/4 h-auto">
            </div>

            <!-- Text Content -->
            <div class="lg:w-7/12 space-y-6 order-2 lg:order-1" data-aos="fade-right">
                <!-- Title -->
                <div class="mb-6">
                    <h3 class="md:text-3xl text-2xl font-bold text-sky-400">
                        Berikan Penilaian Anda untuk Eduflix
                    </h3>
                </div>

                <!-- Rating Form -->
                <form class="space-y-4" method="POST" action="{{ route('rating.store') }}">
                    @csrf
                    <div>
                        <label for="nama" class="block text-md text-gray-700">Nama :</label>
                        <input type="nama" id="nama" name="nama" class="border border-gray-300 rounded-md p-2 w-full max-w-xs focus:outline-none focus:ring-1 focus:ring-sky-400 focus:border-sky-400" placeholder="Masukkan nama Anda" required/>
                    </div>

                    <div>
                        <label for="email" class="block text-md text-gray-700">Email :</label>
                        <input type="email" id="email" name="email" class="border border-gray-300 rounded-md p-2 w-full max-w-xs focus:outline-none  focus:ring-1 focus:ring-sky-400 focus:border-sky-400" placeholder="Masukkan email Anda" required/>
                    </div>

                    <div>
                        <label for="rating" class="block text-md text-gray-700">Rating :</label>
                        <select id="rating" name="rating" class="border border-gray-300 rounded-md p-2 w-full max-w-xs focus:ring-1 focus:ring-sky-400 focus:border-sky-400" required>
                            <option value="5">⭐️⭐️⭐️⭐️⭐️ (5/5)</option>
                            <option value="4">⭐️⭐️⭐️⭐️ (4/5)</option>
                            <option value="3">⭐️⭐️⭐️ (3/5)</option>
                            <option value="2">⭐️⭐️ (2/5)</option>
                            <option value="1">⭐️ (1/5)</option>
                        </select>
                    </div>

                    <div>
                        <label for="comment" class="block text-md text-gray-700">Komentar :</label>
                        <textarea id="comment" name="comment" rows="4" class="border border-gray-300 rounded-md p-2 w-full md:max-w-xs focus:outline-none  focus:ring-1 focus:ring-sky-400 focus:border-sky-400" placeholder="Tulis ulasan Anda di sini..."></textarea>
                    </div>

                    <button type="submit" class="bg-sky-400 text-white px-4 py-2 rounded-md hover:bg-sky-500 focus:outline-none flex items-center gap-2">
                        Kirim
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-5 h-5" viewBox="0 0 50 50" fill="currentColor">
                            <path d="M46.137,6.552c-0.75-0.636-1.928-0.727-3.146-0.238l-0.002,0C41.708,6.828,6.728,21.832,5.304,22.445c-0.259,0.09-2.521,0.934-2.288,2.814c0.208,1.695,2.026,2.397,2.248,2.478l8.893,3.045c0.59,1.964,2.765,9.21,3.246,10.758c0.3,0.965,0.789,2.233,1.646,2.494c0.752,0.29,1.5,0.025,1.984-0.355l5.437-5.043l8.777,6.845l0.209,0.125c0.596,0.264,1.167,0.396,1.712,0.396c0.421,0,0.825-0.079,1.211-0.237c1.315-0.54,1.841-1.793,1.896-1.935l6.556-34.077C47.231,7.933,46.675,7.007,46.137,6.552z M22,32l-3,8l-3-10l23-17L22,32z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Modal Pop-up Notifikasi -->
@if (session('success'))
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h3 class="text-xl font-semibold text-center text-green-400">{{ session('success') }}</h3>
            <div class="flex justify-center mt-4">
                <button id="closeModal" class="bg-green-400 text-white px-6 py-2 rounded-md hover:bg-green-500 focus:outline-none">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menampilkan modal pop-up jika ada pesan sukses
            const modal = document.getElementById('successModal');
            const closeModal = document.getElementById('closeModal');

            // Menutup modal ketika tombol OK diklik
            closeModal.addEventListener('click', function () {
                modal.style.display = 'none';
            });
        });
    </script>
@endif
