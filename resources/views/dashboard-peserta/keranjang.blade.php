@extends('layouts.dashboard-peserta')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl text-gray-700 font-semibold mb-6 border-b-2 border-gray-300 pb-2">Keranjang Saya</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-500 text-white p-3 mb-4 rounded-lg shadow-md">
                {{ session('warning') }}
            </div>
        @endif

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

                    document.getElementById("countdown-timer").innerHTML = `⏳ Berakhir dalam: ${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
                }, 1000);
            }

            let discountEnd = document.getElementById("discount-end")?.textContent;
            if (discountEnd) startCountdown(discountEnd);
        </script>
<<<<<<< HEAD

        @if ($carts->count() > 0)
            <div class="">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-3 text-center">Nama Kursus</th>
                            <th class="px-4 py-3 text-center">Harga</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($carts as $cart)
                            @php
                                $total += $cart->course->price;
                            @endphp
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ asset('storage/' . $cart->course->image_path) }}" alt="Course Image"
                                            class="w-16 h-16 rounded-lg object-cover mr-4">
                                        <span class="font-semibold text-gray-800 capitalize">{{ $cart->course->title }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center text-red-500">Rp
                                    {{ number_format($cart->course->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-center items-center justify-center">
                                    <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="flex text-center items-center justify-center space-x-2 bg-red-400 hover:bg-red-500 p-1 rounded-md text-white" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-center w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            <!-- <span class="hidden lg:block text-sm">Hapus</span> -->
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Input Kupon -->
                <div class="mt-6">
                    <input type="text" id="coupon-code"
                        class="border border-gray-300 rounded-lg p-2 w-full sm:w-3/4 md:w-1/2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 "
                        placeholder="Masukkan Kode Kupon" value="{{ $couponCode ?? '' }}">
                    <button id="apply-coupon"
                        class="bg-sky-400 text-white px-4 py-2 rounded-lg mt-2 hover:bg-sky-300">Gunakan Kupon</button>
                </div>

                <!-- Total Harga -->
                <div class="flex justify-end space-x-3 items-center mt-6 flex-wrap">
                    <h3 class="font-semibold text-gray-700">
                        Total: <span id="total-price" class="text-red-500">Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}</span>
                    </h3>
                    <button class="bg-green-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-300" 
                        id="pay-now" 
                        data-total-price="{{ $totalPriceAfterDiscount }}">
                        Beli
                    </button>
                </div>

                <script>
                    document.getElementById('pay-now').addEventListener('click', function(e) {
                        e.preventDefault();

                        // Ambil harga normal dari atribut data-total-price
                        const totalPrice = this.getAttribute('data-total-price');
                        if (!totalPrice || isNaN(totalPrice)) {
                            alert('Harga tidak valid');
                            return;
                        }

                        // Ambil kode kupon dari input (nilai akan otomatis terisi jika pengguna sudah menerapkan kupon)
                        const couponInput = document.getElementById('coupon-code');
                        let couponCode = '';
                        if (couponInput && couponInput.value.trim() !== '') {
                            couponCode = couponInput.value.trim();
                        }

                        // Kirim data amount dan coupon_code ke server
                        fetch('/create-payment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ 
                                amount: totalPrice, // Harga normal, server akan menghitung diskon jika ada coupon_code
                                coupon_code: couponCode 
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Periksa data yang diterima
                            if (data.snapToken) {
                                // Simpan order_id dari response
                                const orderId = data.order_id;
                                snap.pay(data.snapToken, {
                                    onSuccess: function(result) {
                                        alert('Pembayaran berhasil');
                                        fetch('/payment-success', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            },
                                            body: JSON.stringify({
                                                order_id: orderId,
                                                transaction_status: 'success',
                                            }),
                                        })
                                        .then(res => res.json())
                                        .then(response => {
                                            alert(response.message);
                                            location.reload();
                                        })
                                        .catch(error => console.error('Error updating payment status:', error));
                                    },
                                    onPending: function(result) {
                                        alert('Pembayaran sedang diproses');
                                    },
                                    onError: function(result) {
                                        alert('Pembayaran gagal');
                                    }
                                });
                            } else {
                                alert('Gagal mendapatkan token pembayaran');
                            }
                        })
                        .catch(error => alert('Terjadi kesalahan saat memproses pembayaran.'));
                    });
                </script>

                

                <!-- Tambahkan JavaScript -->
                <script>
                    document.getElementById('apply-coupon').addEventListener('click', function() {
                        let couponCode = document.getElementById('coupon-code').value;
                        if (couponCode) {
                            window.location.href = "{{ route('cart.index') }}?coupon=" + couponCode;
                        } else {
                            alert("Masukkan kode kupon terlebih dahulu!");
                        }
                    });
                </script>
            </div>
        @else
=======
        @if ($carts->isEmpty())
            <!-- Jika keranjang kosong -->
>>>>>>> b7d151266b3392073166da3c657c8a24dc620dc3
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
            <div class="flex items-center space-x-4 mb-3 pb-2 border-b border-gray-200">
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
                    Total: <span id="total-price" class="text-red-500">Rp {{ number_format($totalPriceAfterDiscount, 0, ',', '.') }}</span>
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
    document.getElementById('pay-now').addEventListener('click', function(e) {
    e.preventDefault();

    const totalPrice = this.getAttribute('data-total-price');
    if (!totalPrice || isNaN(totalPrice)) {
        alert('Harga tidak valid');
        return;
    }

    fetch('/create-payment', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({ amount: totalPrice })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Periksa data yang diterima
        if (data.snapToken) {
            snap.pay(data.snapToken, {
            onSuccess: function(result) {
            alert('Pembayaran berhasil');
            fetch('/payment-success', {
            method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                body: JSON.stringify({
                    order_id: result.order_id,
                    transaction_status: 'success',
                    }),
                })
                .then(res => res.json())
                .then(response => {
                    alert(response.message);
                        location.reload();
                    })
                .catch(error => console.error('Error updating payment status:', error));
                },
                    onPending: function(result) {
                    alert('Pembayaran sedang diproses');
                },
                onError: function(result) {
                    alert('Pembayaran gagal');
                }
                });
                } else {
                        alert('Gagal mendapatkan token pembayaran');
                }
                })
                .catch(error => alert('Terjadi kesalahan saat memproses pembayaran.'));
                });
    
    document.getElementById('apply-coupon').addEventListener('click', function() {
        let couponCode = document.getElementById('coupon-code').value;
        if (couponCode) {
            window.location.href = "{{ route('cart.index') }}?coupon=" + couponCode;
        } else {
            alert("Masukkan kode kupon terlebih dahulu!");
        }
    });
</script> 
@endsection


