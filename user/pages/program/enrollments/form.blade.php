@extends('user.layouts.app')

@section('name')
    Formulir Pendaftaran - {{ $program->title }} - EduSmart
@endsection

@section('content')
    <div class="bg-slate-50 border-b border-slate-200 pt-28 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Formulir Pendaftaran</h1>
                    <p class="text-slate-500 text-sm">Lengkapi data diri kamu untuk memulai akses belajar.</p>
                </div>
            </div>
        </div>
    </div>

    <section class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                    <i class="ph-bold ph-warning-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <div id="form-errors" class="hidden mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                <p class="font-bold mb-2"><i class="ph-bold ph-warning-circle mr-2"></i>Terdapat kesalahan:</p>
                <ul id="error-list" class="list-disc list-inside text-sm"></ul>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                    <p class="font-bold mb-2"><i class="ph-bold ph-warning-circle mr-2"></i>Terdapat kesalahan pada
                        formulir:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="enrollment-form" action="{{ route('program.enroll.store', $program->slug) }}" method="POST">
                @csrf
                <div class="grid lg:grid-cols-3 gap-10">

                    <div class="lg:col-span-2 space-y-8">

                        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 text-primary-600 flex items-center justify-center text-xl">
                                    <i class="ph-bold ph-user"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">Informasi Siswa</h2>
                                    <p class="text-xs text-slate-500">Data ini akan digunakan untuk sertifikat dan akun.</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="full_name"
                                        value="{{ old('full_name', $enrollment->full_name ?? ($user->name ?? '')) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: Aditya Pratama" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email <span
                                            class="text-red-500">*</span></label>
                                    <input type="email" name="email"
                                        value="{{ old('email', $enrollment->email ?? ($user->email ?? '')) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="email@contoh.com" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nomor WhatsApp <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold text-sm">+62</span>
                                        <input type="text" name="phone_number"
                                            value="{{ old('phone_number', $enrollment->phone_number ?? '') }}"
                                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                            placeholder="81234567890" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                                <div
                                    class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                                    <i class="ph-bold ph-graduation-cap"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">Asal Sekolah</h2>
                                    <p class="text-xs text-slate-500">Untuk menyesuaikan materi pembelajaran.</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Sekolah <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="school_name"
                                        value="{{ old('school_name', $enrollment->school_name ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: SMAN 1 Surabaya" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenjang / Kelas <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="grade"
                                        value="{{ old('grade', $enrollment->grade ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: SMA / 10" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Kelulusan <span
                                            class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <input type="number" name="graduation_year"
                                        value="{{ old('graduation_year', $enrollment->graduation_year ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: 2025">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                                <div
                                    class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                                    <i class="ph-bold ph-users-three"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">Data Orang Tua / Wali</h2>
                                    <p class="text-xs text-slate-500">Untuk laporan perkembangan belajar (Report Card).</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Orang Tua <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="parent_name"
                                        value="{{ old('parent_name', $enrollment->parent_name ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Nama Ayah/Ibu" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">No. WhatsApp Ortu <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold text-sm">+62</span>
                                        <input type="text" name="parent_phone"
                                            value="{{ old('parent_phone', $enrollment->parent_phone ?? '') }}"
                                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                            placeholder="81234567890" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xl">
                                    <i class="ph-bold ph-map-pin"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">Alamat Domisili</h2>
                                    <p class="text-xs text-slate-500">Untuk pengiriman modul fisik (jika ada).</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap <span
                                            class="text-red-500">*</span></label>
                                    <textarea name="address" rows="3"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Nama Jalan, No. Rumah, RT/RW" required>{{ old('address', $enrollment->address ?? '') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Provinsi <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="province"
                                        value="{{ old('province', $enrollment->province ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: Jawa Timur" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Kota/Kabupaten <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="city"
                                        value="{{ old('city', $enrollment->city ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: Surabaya" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Kecamatan <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="district"
                                        value="{{ old('district', $enrollment->district ?? '') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                        placeholder="Contoh: Sukolilo" required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Desa/Kelurahan</label>
                                        <input type="text" name="village"
                                            value="{{ old('village', $enrollment->village ?? '') }}"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                            placeholder="Contoh: Gebang">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Pos</label>
                                        <input type="text" name="postal_code"
                                            value="{{ old('postal_code', $enrollment->postal_code ?? '') }}"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition"
                                            placeholder="60111">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1">
                        <div class="sticky top-28 space-y-6">

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden">
                                <div class="bg-slate-50 p-4 border-b border-slate-200">
                                    <h3 class="font-bold text-slate-900">Ringkasan Pesanan</h3>
                                </div>
                                <div class="p-6">
                                    <div class="flex gap-4 mb-6">
                                        @if ($program->thumbnail)
                                            <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                                class="w-20 h-20 rounded-lg object-cover border border-slate-100"
                                                alt="{{ $program->title }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop"
                                                class="w-20 h-20 rounded-lg object-cover border border-slate-100"
                                                alt="{{ $program->title }}">
                                        @endif
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900 line-clamp-2">
                                                {{ $program->title }}</h4>
                                            @if ($program->category)
                                                <p class="text-xs text-slate-500 mt-1">{{ $program->category->name }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if (!$program->isFree())
                                        <div class="space-y-3 mb-6 border-t border-slate-100 pt-4">
                                            @if ($program->promotional_price && $program->promotional_price > 0 && $program->promotional_price < $program->price)
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-slate-600">Harga Normal</span>
                                                    <span class="text-slate-400 line-through">Rp
                                                        {{ number_format($program->price, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-green-600 font-medium">Diskon Promo</span>
                                                    <span class="text-green-600 font-bold">- Rp
                                                        {{ number_format($program->price - $program->promotional_price, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex justify-between items-center border-t border-slate-100 pt-4 mb-6">
                                            <span class="font-bold text-slate-900">Total Bayar</span>
                                            <span class="text-2xl font-extrabold text-primary-600">Rp
                                                {{ number_format($program->getEffectivePrice(), 0, ',', '.') }}</span>
                                        </div>

                                        <button type="submit" id="submit-btn"
                                            class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition shadow-lg shadow-primary-600/30 flex items-center justify-center gap-2 group">
                                            <span id="btn-text">Lanjut Pembayaran</span>
                                            <i id="btn-icon"
                                                class="ph-bold ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                            <svg id="btn-loading" class="hidden animate-spin h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="flex justify-between items-center border-t border-slate-100 pt-4 mb-6">
                                            <span class="font-bold text-slate-900">Total Bayar</span>
                                            <span class="text-2xl font-extrabold text-green-600">GRATIS</span>
                                        </div>

                                        <button type="submit" id="submit-btn"
                                            class="w-full py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2 group">
                                            <span id="btn-text">Daftar Sekarang</span>
                                            <i id="btn-icon"
                                                class="ph-bold ph-check-circle group-hover:scale-110 transition-transform"></i>
                                            <svg id="btn-loading" class="hidden animate-spin h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif

                                    <p class="text-center text-xs text-slate-400 mt-4">
                                        <i class="ph-fill ph-lock-key"></i> Data Anda terenkripsi dengan aman.
                                    </p>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3 items-start">
                                <i class="ph-fill ph-info text-primary-600 text-xl mt-0.5"></i>
                                <div>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        Pastikan nomor WhatsApp aktif. Kami akan mengirimkan invoice dan akses akun melalui
                                        WA.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection

@if (!$program->isFree())
    @section('script')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
        @include('user.pages.program.scripts.form')
    @endsection
@endif
