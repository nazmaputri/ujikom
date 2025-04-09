@extends('layouts.dashboard-peserta')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl text-gray-700 font-semibold mb-6 border-b-2 border-gray-300 pb-2 text-center">Keranjang Saya</h2>

        @if (session('success'))
            <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div id="flash-message" class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-2 mb-3 rounded" role="alert">
                {{ session('warning') }}
            </div>
        @endif

        <div id="flash-container"></div>

        <!-- Pemberitahuan Diskon (Tetap Ada di Atas Keranjang) -->
        @if ($activeDiscount)
        <div class="bg-yellow-100 text-yellow-700 p-4 mb-4 rounded-lg">
            <h3 class="font-bold text-lg">🎉 Kode kupon: <span class="">{{ $activeDiscount->coupon_code }}</span></h3>
            <p class="text-sm">Diskon sebesar <strong>{{ $activeDiscount->discount_percentage }}%</strong> berlaku hingga <span id="discount-end">{{ $activeDiscount->end_date }} {{ $activeDiscount->end_time }}</span>.</p>
            <div class="text-red-600 font-semibold text-sm mt-2" id="countdown-timer"></div>
        </div>
        @endif
        <!-- Tambahkan Countdown Timer -->
        <script>
            function startCountdown(endDate) {
                let countDownDate = new Date(endDate).getTime();

                let x = setInterval(function() {
                    let now = new Date().getTime();
                    let distance = countDownDate - now;

                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("countdown-timer").innerHTML = "⏳ Diskon telah berakhir.";
                        return;
                    }

                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("countdown-timer").innerHTML = ⏳ Berakhir dalam: ${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik;
                }, 1000);
            }

            let discountEnd = document.getElementById("discount-end")?.textContent;
            if (discountEnd) startCountdown(discountEnd);
        </script>
        @if ($carts->isEmpty())
            <!-- Jika keranjang kosong -->
            <div class="text-center py-3">
                <p class="text-gray-500">Keranjang Kamu masih kosong. Yuk, pilih kursus favoritmu!</p>
                <a href="{{ route('kategori-peserta') }}"
                    class="mt-4 font-semibold inline-block bg-sky-400 text-white py-1.5 px-5 rounded-lg hover:bg-sky-300 transition shadow-lg">
                    Jelajahi Kursus
                </a>
            </div>
        @else
        <div class="flex flex-col lg:flex-row gap-6">
        <!-- kontainer untuk kursus yang ada di keranjang -->
        <div class="flex flex-col bg-white p-3 rounded-lg shadow lg:w-2/3 md:min-h-40">
        @foreach ($carts as $cart)
            <div class="flex items-center space-x-4 mb-3 pb-2 @if(!$loop->last || $loop->first && !$loop->last) border-b border-gray-200 @endif">
                <img 
                    src="{{ asset('storage/' . $cart->course->image_path) }}" 
                    alt="Course Image" 
                    class="w-24 h-24 object-cover rounded-md"
                />
                
                <!-- Informasi Produk -->
                <div class="flex-1 space-y-1">
                    <h2 class="text-lg font-semibold text-gray-700">{{ $cart->course->title }}</h2>
                    <p class="text-sm font-semibold text-red-400">Rp. <span class="">{{ number_format($cart->course->price, 0, ',', '.') }}</span></p>
                    <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="flex text-center items-center justify-center rounded-md text-red text-xs" type="submit">
                            <span class="text-sm text-red-400">Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
         </div>

        <!-- kontainer untuk apply kupon, total harga dan beli -->
        <div class="bg-white p-3 rounded-lg shadow flex-1 max-h-40">
            <!-- Input Kupon -->
            <div class="flex space-x-2 items-center mt-6">
                <input type="text" id="coupon-code" class="border border-gray-300 rounded-lg p-1.5 w-full sm:w-3/4 md:w-2/3 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500" placeholder="Masukkan Kode Kupon" value="{{ $couponCode ?? '' }}">
                <button id="apply-coupon" class="bg-sky-400 flex text-white p-1.5 px-3 font-semibold rounded-lg hover:bg-sky-300">Gunakan</button>
            </div>

            <!-- Total Harga -->
            <div class="flex justify-end space-x-3 items-center mt-3 flex-wrap">
                <h3 class="font-semibold text-gray-700">
                    Total: 
                    @if ($couponCode) 
                        <span class="text-gray-500 line-through">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span> 
                    @endif
                    <span id="total-price" class="text-red-500">Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}</span>
                </h3>
                <button class="bg-sky-400 text-white font-semibold py-1.5 px-3 rounded-lg hover:bg-sky-300" 
                    id="pay-now" 
                    data-total-price="{{ $totalPriceAfterDiscount }}">
                    Beli
                </button>
            </div>
         </div>
        </div>
        @endif
    </div>

<script>
    //untuk mengatur flash message dari backend
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.remove();
                }, 3000); // Hapus pesan setelah 3 detik
            }
    });

    document.getElementById('pay-now').addEventListener('click', function(e) {
        e.preventDefault();

        const button = this;
        button.disabled = true; // Nonaktifkan tombol setelah diklik
        button.classList.add('opacity-50', 'cursor-not-allowed'); // Tambahkan efek visual tombol disable
        
        const totalPrice = this.getAttribute('data-total-price');
        if (!totalPrice || isNaN(totalPrice)) {
            showFlashMessage('Harga tidak valid', 'error');
            button.disabled = false; // Aktifkan kembali jika terjadi error
            button.classList.remove('opacity-50', 'cursor-not-allowed');
            return;
        }
        
        // Jika terdapat input kode kupon, ambil nilainya
        const couponInput = document.getElementById('coupon-code');
        const couponCode = couponInput ? couponInput.value : null;
        
        // Buat payload untuk payment creation
        const payload = { amount: totalPrice };
        if (couponCode) {
            payload.coupon_code = couponCode;
        }
        
        fetch('/create-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Cek data dari backend
                if (data.snapToken) {
                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            showFlashMessage('Pembayaran berhasil', 'success');

                            // Pastikan ambil order_id dari result Midtrans
                            const orderId = result.order_id || result.transaction_id;
                            if (!orderId) {
                                showFlashMessage('Order ID tidak ditemukan dari response pembayaran.', 'error');
                                return;
                            }

                            // Panggil endpoint update-payment-status untuk update ke database
                            fetch('/update-payment-status', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // pastikan ini di dalam blade
                                },
                                body: JSON.stringify({
                                    order_id: orderId,
                                    transaction_status: 'success'
                                }),
                            })
                            .then(res => res.json())
                            .then(response => {
                                showFlashMessage(response.message);
                                
                                 // Arahkan user ke daftar kursus setelah 2 detik
                                setTimeout(() => {
                                    window.location.href = "{{ route('daftar-kursus') }}";
                                }, 2000);
                            })
                            .catch(error => {
                                console.error('Error updating payment status:', error);
                                showFlashMessage('Gagal mengupdate status pembayaran.', 'error');
                            });
                        },

                        onPending: function(result) {
                            showFlashMessage('Pembayaran sedang diproses', 'info');
                        },

                        onError: function(result) {
                            console.error('Payment error:', result);
                            showFlashMessage('Pembayaran gagal', 'error');
                        }
                    });
                } else {
                    showFlashMessage('Gagal mendapatkan token pembayaran', 'error');
                    button.disabled = false; // Aktifkan kembali jika gagal
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Error creating payment:', error);
                showFlashMessage('Terjadi kesalahan saat memproses pembayaran.', 'error');
                button.disabled = false; // Aktifkan kembali jika terjadi error
                button.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        });
        
    document.getElementById('apply-coupon').addEventListener('click', function() {
        let couponCode = document.getElementById('coupon-code').value;
        if (couponCode) {
            window.location.href = "{{ route('cart.index') }}?coupon=" + couponCode;
        } else {
            alert("Masukkan kode kupon terlebih dahulu!");
        }
    });

    // Fungsi untuk menampilkan flash message di dalam kontainer
    function showFlashMessage(message, type = 'success') {
        const flashContainer = document.getElementById('flash-container');
        flashContainer.innerHTML = ''; // Hapus pesan lama sebelum menambahkan yang baru

        const flashMessage = document.createElement('div');
        flashMessage.id = 'flash-message';

        const colorClass = {
            'success': 'bg-green-100 border-green-400 text-green-700',
            'error': 'bg-red-100 border-red-400 text-red-700',
            'info': 'bg-blue-100 border-blue-400 text-blue-700'
        }[type] || 'bg-gray-100 border-gray-400 text-gray-700';

        flashMessage.className = `${colorClass} border p-2 rounded mb-3`;
        flashMessage.textContent = message;

        flashContainer.appendChild(flashMessage);

        setTimeout(() => {
            flashMessage.remove();
        }, 3000);
    }
</script>
@endsection