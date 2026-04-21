@extends('user.layouts.app')

@section('name')
    @if ($transaction && $transaction->status === 'success')
        Pendaftaran Berhasil - {{ $program->title }} - EduSmart
    @elseif($transaction && $transaction->status === 'pending')
        Menunggu Pembayaran - {{ $program->title }} - EduSmart
    @else
        Status Pendaftaran - {{ $program->title }} - EduSmart
    @endif
@endsection

@section('content')
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen pt-28 pb-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Main Card --}}
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

                {{-- Status Header - Dynamic based on transaction status --}}
                @if (!$program->isFree() && $transaction)
                    @if ($transaction->status === 'success')
                        {{-- SUCCESS --}}
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-center">
                            <div
                                class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="ph-bold ph-check-circle text-5xl text-green-600"></i>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                                Pembayaran Berhasil! 🎉
                            </h1>
                            <p class="text-green-100 text-sm md:text-base">
                                Kamu resmi terdaftar sebagai peserta program ini.
                            </p>
                        </div>
                    @elseif($transaction->status === 'pending')
                        {{-- PENDING --}}
                        <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-8 text-center">
                            <div
                                class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="ph-bold ph-hourglass-medium text-5xl text-amber-600"></i>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                                Menunggu Pembayaran ⏳
                            </h1>
                            <p class="text-amber-100 text-sm md:text-base">
                                Silakan selesaikan pembayaran untuk mengaktifkan akses program.
                            </p>
                        </div>
                    @elseif(in_array($transaction->status, ['failed', 'expired', 'cancelled']))
                        {{-- FAILED --}}
                        <div class="bg-gradient-to-r from-red-500 to-rose-600 p-8 text-center">
                            <div
                                class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="ph-bold ph-x-circle text-5xl text-red-600"></i>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                                Pembayaran Gagal 😔
                            </h1>
                            <p class="text-red-100 text-sm md:text-base">
                                Terjadi masalah pada pembayaran Anda. Silakan coba lagi.
                            </p>
                        </div>
                    @else
                        {{-- DEFAULT --}}
                        <div class="bg-gradient-to-r from-slate-500 to-slate-600 p-8 text-center">
                            <div
                                class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="ph-bold ph-info text-5xl text-slate-600"></i>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                                Status Pendaftaran
                            </h1>
                            <p class="text-slate-100 text-sm md:text-base">
                                Informasi pendaftaran program Anda.
                            </p>
                        </div>
                    @endif
                @else
                    {{-- FREE PROGRAM SUCCESS --}}
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-center">
                        <div
                            class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="ph-bold ph-check-circle text-5xl text-green-600"></i>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                            Selamat! Pendaftaran Berhasil 🎉
                        </h1>
                        <p class="text-green-100 text-sm md:text-base">
                            Kamu resmi terdaftar sebagai peserta program ini.
                        </p>
                    </div>
                @endif

                {{-- Content --}}
                <div class="p-6 md:p-8">
                    {{-- Program Details --}}
                    <div class="flex gap-4 mb-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        @if ($program->thumbnail)
                            <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                class="w-20 h-20 rounded-lg object-cover border border-slate-200"
                                alt="{{ $program->title }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop"
                                class="w-20 h-20 rounded-lg object-cover border border-slate-200"
                                alt="{{ $program->title }}">
                        @endif
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg">{{ $program->title }}</h3>
                            @if ($program->category)
                                <span
                                    class="inline-block px-2 py-1 bg-primary-100 text-primary-700 text-xs font-medium rounded mt-1">
                                    {{ $program->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Payment Details for Paid Programs --}}
                    @if (!$program->isFree() && $transaction)
                        <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 mb-6">
                            <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="ph-bold ph-receipt text-primary-600"></i>
                                Rincian Pembayaran
                            </h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Order ID</span>
                                    <span class="font-mono text-slate-900">{{ $transaction->order_id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Status</span>
                                    @if ($transaction->status === 'success')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 font-bold rounded text-xs">
                                            <i class="ph-bold ph-check"></i> Berhasil
                                        </span>
                                    @elseif($transaction->status === 'pending')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 font-bold rounded text-xs">
                                            <i class="ph-bold ph-clock"></i> Menunggu
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 font-bold rounded text-xs">
                                            <i class="ph-bold ph-x"></i> {{ ucfirst($transaction->status) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Total Pembayaran</span>
                                    <span class="font-bold text-slate-900">Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                </div>
                                @if ($transaction->payment_type)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Metode Pembayaran</span>
                                        <span
                                            class="text-slate-900">{{ ucwords(str_replace('_', ' ', $transaction->payment_type)) }}</span>
                                    </div>
                                @endif
                                @if ($transaction->paid_at)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Waktu Pembayaran</span>
                                        <span
                                            class="text-slate-900">{{ $transaction->paid_at->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Info Cards --}}
                    @if ($program->isFree() || ($transaction && $transaction->status === 'success'))
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <div
                                    class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="ph-bold ph-user-circle text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Status Kamu</p>
                                    <p class="font-bold text-slate-900">Student ✓</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-purple-50 rounded-xl border border-purple-100">
                                <div
                                    class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="ph-bold ph-calendar-check text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Tanggal Pendaftaran</p>
                                    <p class="font-bold text-slate-900">{{ now()->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Schedule Info --}}
                        @if ($program->start_date || $program->end_date)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                                <div class="flex items-start gap-3">
                                    <i class="ph-fill ph-calendar text-amber-600 text-xl mt-0.5"></i>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Jadwal Program</p>
                                        <p class="text-slate-600 text-sm">
                                            @if ($program->start_date)
                                                Mulai: {{ $program->start_date->translatedFormat('d F Y') }}
                                            @endif
                                            @if ($program->start_date && $program->end_date)
                                                <span class="mx-1">—</span>
                                            @endif
                                            @if ($program->end_date)
                                                Berakhir: {{ $program->end_date->translatedFormat('d F Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Next Steps --}}
                        <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 mb-6">
                            <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="ph-bold ph-lightbulb text-yellow-500"></i>
                                Langkah Selanjutnya
                            </h4>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">1</span>
                                    <span class="text-slate-700 text-sm">Cek WhatsApp untuk informasi detail program dan
                                        grup belajar.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">2</span>
                                    <span class="text-slate-700 text-sm">Bergabung ke grup WhatsApp yang akan dikirimkan via
                                        pesan.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">3</span>
                                    <span class="text-slate-700 text-sm">Persiapkan diri untuk sesi pertama sesuai
                                        jadwal.</span>
                                </li>
                            </ul>
                        </div>
                    @elseif($transaction && $transaction->status === 'pending')
                        {{-- Pending Payment Instructions --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-6">
                            <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="ph-bold ph-warning text-amber-600"></i>
                                Instruksi Pembayaran
                            </h4>
                            <p class="text-slate-700 text-sm mb-4">
                                Silakan selesaikan pembayaran sesuai instruksi yang diberikan pada halaman checkout.
                                Pembayaran akan otomatis diverifikasi setelah Anda menyelesaikan transaksi.
                            </p>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li class="flex items-center gap-2">
                                    <i class="ph-bold ph-check-circle text-green-600"></i>
                                    Pastikan nominal transfer sesuai dengan total pembayaran.
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="ph-bold ph-check-circle text-green-600"></i>
                                    Simpan bukti pembayaran Anda.
                                </li>
                            </ul>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('program') }}"
                            class="flex-1 py-3 px-6 border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition flex items-center justify-center gap-2">
                            <i class="ph-bold ph-arrow-left"></i>
                            Lihat Program Lain
                        </a>
                        @if ($transaction && $transaction->status === 'pending')
                            <a href="{{ route('program.enroll.form', $program->slug) }}"
                                class="flex-1 py-3 px-6 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition shadow-lg shadow-amber-500/30 flex items-center justify-center gap-2">
                                <i class="ph-bold ph-arrow-clockwise"></i>
                                Lanjut Pembayaran
                            </a>
                        @else
                            <a href="{{ route('home') }}"
                                class="flex-1 py-3 px-6 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition shadow-lg shadow-primary-600/30 flex items-center justify-center gap-2">
                                <i class="ph-bold ph-house"></i>
                                Kembali ke Beranda
                            </a>
                        @endif
                    </div>

                    {{-- Cancel Transaction Button for Pending Payments --}}
                    @if ($transaction && $transaction->status === 'pending')
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <form action="{{ route('program.cancel-transaction', $program->slug) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3 px-6 border-2 border-red-300 text-red-600 font-bold rounded-xl hover:bg-red-50 transition flex items-center justify-center gap-2">
                                    <i class="ph-bold ph-x-circle"></i>
                                    Batalkan Transaksi
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Help Section --}}
            <div class="mt-6 text-center">
                <p class="text-slate-600 text-sm">
                    Butuh bantuan?
                    <a href="#" class="text-primary-600 font-bold hover:underline">
                        <i class="ph-bold ph-whatsapp-logo"></i> Hubungi Admin via WhatsApp
                    </a>
                </p>
            </div>

        </div>
    </div>
@endsection
