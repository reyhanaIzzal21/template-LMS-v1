@extends('user.layouts.app')

@section('name')
    {{ $program->title }} - EduSmart
@endsection

@section('content')
    <header class="bg-slate-900 pt-32 pb-20 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-600 rounded-full blur-[150px] opacity-20 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600 rounded-full blur-[120px] opacity-10 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <a href="{{ route('program') }}" class="hover:text-white transition">Program</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <span class="text-white font-medium">{{ $program->category->name ?? 'Uncategorized' }}</span>
            </nav>

            <div class="max-w-3xl">
                {{-- category program --}}
                @if ($program->category)
                    <span
                        class="inline-block px-3 py-1 bg-accent-500 text-white text-xs font-bold rounded-full mb-4 uppercase tracking-wider shadow-lg shadow-accent-500/30">
                        {{ $program->category->name }}
                    </span>
                @endif

                {{-- title --}}
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                    {{ $program->title }}
                </h1>

                {{-- subtitle --}}
                <p class="text-slate-300 text-lg md:text-xl leading-relaxed mb-8">
                    {{ $program->sub_title }}
                </p>

                {{-- meta program --}}
                <div class="flex flex-wrap gap-6 text-sm font-medium text-slate-300 border-t border-slate-700 pt-6">
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-users text-primary-400 text-xl"></i>
                        @if ($program->student_quota === null)
                            <span>Kuota Tidak Terbatas</span>
                        @elseif ($program->student_quota > 0)
                            <span>Kuota: {{ $program->student_quota }} Siswa</span>
                        @else
                            <span class="text-red-400">Kuota Habis</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-star text-yellow-400 text-xl"></i>
                        <span>4.9 (86 Review)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-certificate text-green-400 text-xl"></i>
                        <span>Sertifikat Resmi</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12 relative">

                <div class="lg:col-span-2 space-y-10">

                    {{-- deskripsi program --}}
                    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Deskripsi Program</h2>
                        <div class="prose prose-slate prose-lg max-w-none text-slate-600">
                            {!! nl2br(e($program->description)) !!}
                        </div>
                    </div>

                    {{-- benefit program --}}
                    @if ($program->benefits->count() > 0)
                        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                            <h2 class="text-2xl font-bold text-slate-900 mb-6">Apa yang Akan Kamu Dapatkan?</h2>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach ($program->benefits as $benefit)
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <div
                                            class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="ph-bold ph-check"></i>
                                        </div>
                                        <span class="text-slate-700 font-medium">{{ $benefit->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- jadwal pelaksanaan --}}
                    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Jadwal Pelaksanaan</h2>
                        <div class="flex flex-col md:flex-row gap-6">
                            {{-- tanggal mulai - dinamis --}}
                            <div class="flex-1 bg-blue-50 rounded-xl p-5 border border-blue-100 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-white text-primary-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                                    <i class="ph-fill ph-calendar-plus"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-500 uppercase">Tanggal Mulai</p>
                                    <p class="text-lg font-bold text-slate-900">
                                        {{ $program->start_date ? $program->start_date->translatedFormat('d F Y') : 'Belum ditentukan' }}
                                    </p>
                                </div>
                            </div>
                            <div class="hidden md:flex items-center text-slate-300">
                                <i class="ph-bold ph-arrow-right text-2xl"></i>
                            </div>
                            {{-- fetch yang tanggal berakhir --}}
                            <div
                                class="flex-1 bg-orange-50 rounded-xl p-5 border border-orange-100 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-white text-orange-600 rounded-xl flex items-center justify-center text-2xl shadow-sm">
                                    <i class="ph-fill ph-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-500 uppercase">Tanggal Berakhir</p>
                                    <p class="text-lg font-bold text-slate-900">
                                        {{ $program->end_date ? $program->end_date->translatedFormat('d F Y') : 'Belum ditentukan' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-start gap-2 text-sm text-slate-500">
                            <i class="ph-fill ph-info mt-0.5 text-primary-500"></i>
                            <p>Jadwal bisa menyesuaikan dengan pengumuman resmi SNPMB terbaru. Rekaman kelas tersedia jika
                                Anda berhalangan hadir.</p>
                        </div>
                    </div>

                    {{-- faq (tidak usah di fetch, hanya perbaiki dropdown) --}}
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-slate-900">Pertanyaan Umum</h2>

                        {{-- FAQ Item 1 --}}
                        <div class="border border-slate-200 rounded-xl bg-white overflow-hidden" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full flex justify-between items-center p-5 text-left font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                                Apakah bisa dicicil?
                                <i class="ph-bold ph-caret-down transition-transform duration-300"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open" x-collapse x-cloak>
                                <div class="px-5 pb-5 text-slate-600">
                                    Ya, kami menyediakan opsi cicilan. Anda bisa mencicil pembayaran menjadi 2-3 kali
                                    pembayaran sesuai dengan kesepakatan. Silakan hubungi admin kami via WhatsApp untuk
                                    informasi lebih lanjut mengenai opsi cicilan yang tersedia.
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 2 --}}
                        <div class="border border-slate-200 rounded-xl bg-white overflow-hidden" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full flex justify-between items-center p-5 text-left font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                                Bagaimana jika tidak lulus PTN?
                                <i class="ph-bold ph-caret-down transition-transform duration-300"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open" x-collapse x-cloak>
                                <div class="px-5 pb-5 text-slate-600">
                                    Kami memberikan jaminan belajar sampai bisa. Jika Anda tidak lulus di gelombang pertama
                                    SNBT, Anda bisa mengikuti kelas remedial tambahan secara GRATIS untuk persiapan jalur
                                    mandiri atau SBMPTN gelombang berikutnya.
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 3 --}}
                        <div class="border border-slate-200 rounded-xl bg-white overflow-hidden" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full flex justify-between items-center p-5 text-left font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                                Apakah bisa mengikuti jika sudah lulus SMA?
                                <i class="ph-bold ph-caret-down transition-transform duration-300"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open" x-collapse x-cloak>
                                <div class="px-5 pb-5 text-slate-600">
                                    Tentu saja bisa! Program ini terbuka untuk siswa kelas 12 maupun alumni (gap year).
                                    Materi dan metode pembelajaran kami dirancang untuk semua yang ingin mempersiapkan diri
                                    menghadapi UTBK SNBT dengan serius.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden relative z-20">

                            {{-- thumbnail --}}
                            <div class="relative h-56 group overflow-hidden">
                                @if ($program->thumbnail)
                                    <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                                        alt="{{ $program->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                                    @if (!$program->is_active)
                                        <span class="bg-slate-600 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                                            <i class="ph-bold ph-x-circle"></i> Pendaftaran Ditutup
                                        </span>
                                    @elseif ($program->student_quota !== null && $program->student_quota <= 0)
                                        <span class="bg-slate-600 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                                            <i class="ph-bold ph-x-circle"></i> Kuota Habis
                                        </span>
                                    @elseif ($program->student_quota !== null && $program->student_quota <= 5)
                                        <span
                                            class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow-sm animate-pulse">
                                            <i class="ph-bold ph-alarm"></i> Sisa {{ $program->student_quota }} Kuota!
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="mb-6">
                                    @if ($program->isFree())
                                        {{-- FREE PROGRAM UI --}}
                                        <div class="text-center">
                                            <div
                                                class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full mb-3">
                                                <i class="ph-fill ph-gift text-xl"></i>
                                                <span class="text-2xl font-extrabold">GRATIS</span>
                                            </div>
                                            <p class="text-sm text-slate-500">Akses penuh tanpa biaya!</p>
                                        </div>
                                    @else
                                        {{-- PAID PROGRAM UI --}}
                                        <p class="text-sm text-slate-500 mb-1 font-medium">Investasi Belajar:</p>
                                        <div class="flex items-end gap-2 flex-wrap">
                                            @if ($program->promotional_price && $program->promotional_price > 0)
                                                <span class="text-3xl font-extrabold text-primary-600">Rp
                                                    {{ number_format($program->promotional_price, 0, ',', '.') }}</span>
                                                <span class="text-sm text-slate-400 line-through mb-1.5">Rp
                                                    {{ number_format($program->price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-3xl font-extrabold text-primary-600">Rp
                                                    {{ number_format($program->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        @if ($program->promotional_price && $program->promotional_price > 0)
                                            @php
                                                $discount = $program->price - $program->promotional_price;
                                                $discountPercent = ($discount / $program->price) * 100;
                                            @endphp
                                            <p class="text-xs text-green-600 font-bold mt-1">
                                                Hemat Rp {{ number_format($discount, 0, ',', '.') }} (Diskon
                                                {{ number_format($discountPercent, 0) }}%)
                                            </p>
                                        @endif
                                    @endif
                                </div>

                                @if (!$program->is_active)
                                    <button
                                        class="w-full py-4 bg-slate-400 text-white font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 mb-4"
                                        disabled>
                                        <i class="ph-bold ph-x-circle"></i>
                                        Pendaftaran Ditutup
                                    </button>
                                @elseif ($program->student_quota !== null && $program->student_quota <= 0)
                                    <button
                                        class="w-full py-4 bg-slate-400 text-white font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 mb-4"
                                        disabled>
                                        <i class="ph-bold ph-x-circle"></i>
                                        Kuota Habis
                                    </button>
                                @else
                                    <a href="{{ route('program.enroll.form', $program->slug) }}"
                                        class="w-full py-4 {{ $program->isFree() ? 'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-500/30' : 'bg-accent-500 hover:bg-accent-600 shadow-accent-500/30' }} text-white font-bold rounded-xl transition shadow-lg flex items-center justify-center gap-2 mb-4 transform hover:scale-[1.02]">
                                        @if ($program->isFree())
                                            <i class="ph-bold ph-check-circle"></i>
                                            Daftar Gratis Sekarang
                                        @else
                                            Daftar Program Sekarang
                                            <i class="ph-bold ph-arrow-right"></i>
                                        @endif
                                    </a>
                                @endif

                                @if (!$program->isFree())
                                    <p class="text-center text-xs text-slate-400 mb-6">Jaminan uang kembali 7 hari jika
                                        tidak
                                        puas</p>

                                    <div class="border-t border-slate-100 pt-4">
                                        <p
                                            class="text-[10px] text-slate-400 font-bold uppercase mb-3 text-center tracking-wider">
                                            Metode Pembayaran</p>
                                        <div
                                            class="grid grid-cols-4 gap-2 opacity-70 grayscale hover:grayscale-0 transition-all duration-300">
                                            <div class="h-8 bg-slate-100 rounded flex items-center justify-center border border-slate-200"
                                                title="QRIS"><i class="ph-fill ph-qr-code text-xl"></i></div>
                                            <div class="h-8 bg-slate-100 rounded flex items-center justify-center border border-slate-200"
                                                title="GoPay"><i class="ph-fill ph-wallet text-xl"></i></div>
                                            <div class="h-8 bg-slate-100 rounded flex items-center justify-center border border-slate-200"
                                                title="Bank Transfer"><i class="ph-fill ph-bank text-xl"></i></div>
                                            <div class="h-8 bg-slate-100 rounded flex items-center justify-center border border-slate-200"
                                                title="Credit Card"><i class="ph-fill ph-credit-card text-xl"></i></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 text-center">
                            <p class="text-sm font-bold text-slate-800 mb-1">Butuh bantuan mendaftar?</p>
                            <a href="#"
                                class="text-primary-600 text-sm font-bold hover:underline flex items-center justify-center gap-1">
                                <i class="ph-bold ph-whatsapp-logo"></i> Chat Admin via WA
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Mobile Button --}}
    <div
        class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 p-4 lg:hidden z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <div class="flex items-center justify-between gap-4">
            <div>
                @if ($program->isFree())
                    {{-- FREE PROGRAM - MOBILE --}}
                    <div class="flex items-center gap-2 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">
                        <i class="ph-fill ph-gift"></i>
                        <span class="text-lg font-bold">GRATIS</span>
                    </div>
                @elseif ($program->promotional_price && $program->promotional_price > 0)
                    {{-- PAID WITH PROMO - MOBILE --}}
                    <p class="text-xs text-slate-400 line-through">Rp {{ number_format($program->price, 0, ',', '.') }}
                    </p>
                    <p class="text-xl font-bold text-primary-600">Rp
                        {{ number_format($program->promotional_price, 0, ',', '.') }}</p>
                @else
                    {{-- PAID NORMAL - MOBILE --}}
                    <p class="text-xl font-bold text-primary-600">Rp {{ number_format($program->price, 0, ',', '.') }}</p>
                @endif
            </div>
            @if (!$program->is_active)
                <button class="flex-1 py-3 bg-slate-400 text-white font-bold rounded-lg cursor-not-allowed" disabled>
                    Pendaftaran Ditutup
                </button>
            @elseif ($program->student_quota !== null && $program->student_quota <= 0)
                <button class="flex-1 py-3 bg-slate-400 text-white font-bold rounded-lg cursor-not-allowed" disabled>
                    Kuota Habis
                </button>
            @else
                <a href="{{ route('program.enroll.form', $program->slug) }}"
                    class="flex-1 py-3 {{ $program->isFree() ? 'bg-emerald-500' : 'bg-accent-500' }} text-white font-bold rounded-lg shadow-lg text-center">
                    {{ $program->isFree() ? 'Daftar Gratis' : 'Daftar Sekarang' }}
                </a>
            @endif
        </div>
    </div>
@endsection
