@extends('user.layouts.app')

@section('name')
    Status Pembayaran - {{ $course->title }}
@endsection

@section('content')
    <div class="min-h-screen bg-slate-100 pt-32 pb-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($transaction->isSuccessful())
                {{-- Success State --}}
                <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden text-center p-8 md:p-12">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph-fill ph-check-circle text-green-500 text-6xl"></i>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">
                        Pembayaran Berhasil! 🎉
                    </h1>
                    <p class="text-slate-500 mb-8">
                        Selamat! Anda sekarang memiliki akses penuh ke kursus ini.
                    </p>

                    <div class="bg-slate-50 rounded-2xl p-6 mb-8 text-left">
                        <div class="flex items-start gap-4">
                            @if ($course->photo)
                                <img src="{{ asset('storage/' . $course->photo) }}" class="w-20 h-20 rounded-xl object-cover"
                                    alt="{{ $course->title }}">
                            @else
                                <div
                                    class="w-20 h-20 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                                    <i class="ph ph-book-open text-white text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900">{{ $course->title }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ $course->sub_title }}</p>
                            </div>
                        </div>

                        <div class="border-t border-slate-200 mt-4 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Order ID</span>
                                <span class="text-slate-900 font-mono">{{ $transaction->order_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Pembayaran</span>
                                <span class="text-slate-900 font-bold">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Metode Pembayaran</span>
                                <span
                                    class="text-slate-900">{{ ucwords(str_replace('_', ' ', $transaction->payment_type ?? '-')) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Waktu Pembayaran</span>
                                <span
                                    class="text-slate-900">{{ $transaction->paid_at?->format('d M Y, H:i') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('learn.index', $course->slug) }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/30">
                        <i class="ph-fill ph-play"></i>
                        Mulai Belajar Sekarang
                    </a>
                </div>
            @elseif ($transaction->isPending())
                {{-- Pending State --}}
                <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden text-center p-8 md:p-12">
                    <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph-fill ph-hourglass-medium text-yellow-500 text-6xl animate-pulse"></i>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">
                        Menunggu Pembayaran
                    </h1>
                    <p class="text-slate-500 mb-8">
                        Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran sesuai instruksi.
                    </p>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8 text-left">
                        <div class="flex items-start gap-3">
                            <i class="ph-fill ph-info text-yellow-500 text-xl mt-0.5"></i>
                            <div>
                                <h4 class="font-bold text-yellow-800 mb-1">Instruksi Pembayaran</h4>
                                <p class="text-sm text-yellow-700">
                                    Setelah melakukan pembayaran, status akan diperbarui secara otomatis.
                                    Refresh halaman ini untuk melihat status terbaru.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 mb-8 text-left">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Order ID</span>
                                <span class="text-slate-900 font-mono">{{ $transaction->order_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Pembayaran</span>
                                <span class="text-slate-900 font-bold">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Status</span>
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                    <i class="ph-fill ph-clock"></i> Menunggu Pembayaran
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('courses.detail', $course->slug) }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition">
                            <i class="ph-bold ph-arrow-left"></i>
                            Kembali ke Kursus
                        </a>
                        <button onclick="location.reload()"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition">
                            <i class="ph-bold ph-arrows-clockwise"></i>
                            Refresh Status
                        </button>
                    </div>

                    {{-- Cancel Transaction Button --}}
                    <form action="{{ route('courses.cancel-transaction', $course->slug) }}" method="POST" class="mt-4"
                        onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-red-300 text-red-600 font-bold rounded-xl hover:bg-red-50 transition">
                            <i class="ph-bold ph-x-circle"></i>
                            Batalkan Transaksi
                        </button>
                    </form>
                </div>
            @else
                {{-- Failed/Expired/Cancelled State --}}
                <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden text-center p-8 md:p-12">
                    <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph-fill ph-x-circle text-red-500 text-6xl"></i>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-3">
                        Pembayaran
                        {{ $transaction->status === 'expired' ? 'Kedaluwarsa' : ($transaction->status === 'cancelled' ? 'Dibatalkan' : 'Gagal') }}
                    </h1>
                    <p class="text-slate-500 mb-8">
                        @if ($transaction->status === 'expired')
                            Waktu pembayaran telah habis. Silakan buat transaksi baru.
                        @elseif ($transaction->status === 'cancelled')
                            Transaksi telah dibatalkan. Silakan coba lagi jika ingin melanjutkan.
                        @else
                            Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.
                        @endif
                    </p>

                    <div class="bg-slate-50 rounded-2xl p-6 mb-8 text-left">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Order ID</span>
                                <span class="text-slate-900 font-mono">{{ $transaction->order_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Status</span>
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                    <i class="ph-fill ph-x"></i> {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('courses.detail', $course->slug) }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition">
                            <i class="ph-bold ph-arrow-left"></i>
                            Kembali ke Kursus
                        </a>
                        <form action="{{ route('courses.checkout', $course->slug) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition">
                                <i class="ph-fill ph-arrows-clockwise"></i>
                                Coba Lagi
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
