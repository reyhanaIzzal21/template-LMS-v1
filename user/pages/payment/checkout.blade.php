@extends('user.layouts.app')

@section('name')
    Checkout - {{ $course->title }}
@endsection

@section('content')
    <div class="bg-slate-900 pt-32 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <a href="{{ route('courses') }}" class="hover:text-white transition">Course</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <a href="{{ route('courses.detail', $course->slug) }}"
                    class="hover:text-white transition">{{ $course->title }}</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <span class="text-white font-medium">Checkout</span>
            </nav>

            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4 leading-tight">
                Checkout Pembayaran
            </h1>
            <p class="text-slate-300 text-lg">
                Selesaikan pembayaran untuk mulai belajar
            </p>
        </div>
    </div>

    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8">

                {{-- Order Summary --}}
                <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                    <div class="relative h-48">
                        @if ($course->photo)
                            <img src="{{ asset('storage/' . $course->photo) }}" class="w-full h-full object-cover"
                                alt="{{ $course->title }}">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                                <i class="ph ph-book-open text-white text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2 py-1 rounded">
                            {{ $course->category->name ?? 'Course' }}
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 mt-3 mb-2">{{ $course->title }}</h3>
                        <p class="text-slate-500 text-sm mb-4">{{ $course->sub_title }}</p>

                        <div class="border-t border-slate-200 pt-4">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="text-slate-500">Harga Kursus</span>
                                @if ($course->promotional_price && $course->promotional_price < $course->price)
                                    <span class="text-slate-400 line-through">Rp
                                        {{ number_format($course->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-900 font-bold">Rp
                                        {{ number_format($course->price, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            @if ($course->promotional_price && $course->promotional_price < $course->price)
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-green-600 font-medium">
                                        <i class="ph-fill ph-tag"></i> Diskon Promo
                                    </span>
                                    <span class="text-green-600 font-medium">
                                        - Rp {{ number_format($course->price - $course->promotional_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif

                            <div
                                class="flex items-center justify-between text-lg font-bold border-t border-slate-200 pt-3 mt-3">
                                <span class="text-slate-900">Total Pembayaran</span>
                                <span class="text-primary-600">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Section --}}
                <div class="space-y-6">
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">
                            <i class="ph-fill ph-shield-check text-green-500"></i> Pembayaran Aman
                        </h3>
                        <p class="text-slate-600 text-sm mb-6">
                            Pembayaran Anda diproses secara aman melalui Midtrans. Kami mendukung berbagai metode
                            pembayaran termasuk:
                        </p>
                        <div class="grid grid-cols-4 gap-3 text-center text-xs text-slate-500">
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <i class="ph-fill ph-credit-card text-2xl text-slate-400 mb-1"></i>
                                <p>Kartu Kredit</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <i class="ph-fill ph-bank text-2xl text-slate-400 mb-1"></i>
                                <p>Bank Transfer</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <i class="ph-fill ph-qr-code text-2xl text-slate-400 mb-1"></i>
                                <p>QRIS</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-slate-200">
                                <i class="ph-fill ph-wallet text-2xl text-slate-400 mb-1"></i>
                                <p>E-Wallet</p>
                            </div>
                        </div>
                    </div>

                    <button id="pay-button"
                        class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition shadow-lg shadow-primary-600/30 flex items-center justify-center gap-2 text-lg">
                        <i class="ph-fill ph-lock"></i>
                        Bayar Sekarang
                    </button>

                    <p class="text-xs text-slate-400 text-center">
                        Dengan melanjutkan pembayaran, Anda menyetujui
                        <a href="#" class="text-primary-600 hover:underline">Syarat & Ketentuan</a> kami.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href =
                        '{{ route('payment.finish') }}?order_id={{ $transaction->order_id }}&status=success';
                },
                onPending: function(result) {
                    window.location.href =
                        '{{ route('payment.finish') }}?order_id={{ $transaction->order_id }}&status=pending';
                },
                onError: function(result) {
                    window.location.href =
                        '{{ route('payment.finish') }}?order_id={{ $transaction->order_id }}&status=error';
                },
                onClose: function() {
                    alert('Anda menutup popup pembayaran tanpa menyelesaikan transaksi.');
                }
            });
        });
    </script>
@endsection
