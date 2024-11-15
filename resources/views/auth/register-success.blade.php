@extends('layouts.app')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600 py-12 px-6 sm:px-12">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="relative h-40 bg-indigo-500 flex justify-center items-center">
                <h1 class="text-4xl text-white font-bold">Registrasi Berhasil</h1>
            </div>

            <!-- Content -->
            <div class="px-8 py-6">
                <h2 class="text-2xl font-semibold text-center text-gray-900 mb-4">Terima kasih, {{ session('user') }}!</h2>
                <p class="text-lg text-gray-600 text-center mb-6">
                    Registrasi Anda telah berhasil. Kami sedang memproses verifikasi akun Anda. <br>
                    Anda akan diberitahu melalui WhatsApp setelah proses verifikasi selesai.
                </p>

                <!-- Image Centered and Resized -->
                <div class="flex justify-center mb-6" style="display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('done.gif') }}" alt="Success" width="230">
                </div>

                <!-- Timer Countdown -->
                <div class="text-center text-gray-700 mt-6">
                    <p class="text-lg">Halaman ini akan mengarahkan Anda kembali ke halaman login dalam <span
                            id="countdown">10</span> detik...</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-indigo-600 py-3 text-center text-white">
                <p class="text-sm">© 2024 Sistem Registrasi - Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Timer dan Redirect -->
    <script>
        let countdown = document.getElementById("countdown");
        let timeLeft = 10;

        function updateCountdown() {
            timeLeft--;
            countdown.textContent = timeLeft;
            if (timeLeft <= 0) {
                window.location.href = "{{ route('login') }}"; // Redirect ke halaman login
            }
        }

        setInterval(updateCountdown, 1000);
    </script>
@endsection
