@extends('user.layouts.app')

@section('name')
    Daftar Kelas & Materi - EduSmart
@endsection

@section('content')
    <section class="relative bg-slate-900 pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(#60a5fa 1px, transparent 1px); background-size: 32px 32px;"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary-600 blur-[120px] opacity-20 rounded-full"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-6">Eksplorasi Kelas Favoritmu</h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto mb-10">Tingkatkan skill akademik dan soft skill dengan materi
                yang disusun oleh praktisi dan guru terbaik.</p>

            <div class="bg-white p-2 rounded-full max-w-2xl mx-auto shadow-2xl flex flex-col md:flex-row items-center gap-2">
                <div class="flex-1 w-full flex items-center px-4 md:border-r border-slate-100">
                    <i class="ph ph-magnifying-glass text-slate-400 text-xl"></i>
                    <input type="text" placeholder="Cari materi (mis: Matematika Diskrit)"
                        class="w-full py-3 px-3 outline-none text-slate-700 bg-transparent placeholder:text-slate-400">
                </div>
                <div class="w-full md:w-auto px-2">
                    <button
                        class="w-full md:w-auto px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-full transition shadow-lg shadow-primary-600/20">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-white sticky top-[72px] z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <p class="text-slate-500 text-sm font-medium"><span class="text-slate-900 font-bold">{{ $totalCourses }}</span>
                Course tersedia
            </p>

            <div class="flex items-center gap-3">
                <button
                    class="md:hidden flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg text-sm font-bold text-slate-700">
                    <i class="ph ph-faders"></i> Filter
                </button>

                <div class="hidden md:flex items-center gap-2">
                    <span class="text-sm text-slate-500">Urutkan:</span>
                    <select
                        class="form-select bg-slate-50 border-none text-sm font-bold text-slate-700 focus:ring-0 cursor-pointer py-2 pr-8 rounded-lg hover:bg-slate-100 transition">
                        <option>Terpopuler</option>
                        <option>Terbaru</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($courses->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <a href="{{ route('courses.detail', $course->slug) }}"
                            class="group relative bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                            <div class="relative h-48 overflow-hidden">
                                @if ($course->photo)
                                    <img src="{{ asset('storage/' . $course->photo) }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                                        <i class="ph ph-book-open text-white text-4xl"></i>
                                    </div>
                                @endif

                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span
                                        class="bg-white/90 backdrop-blur text-primary-600 text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wider">
                                        {{ $course->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-1">
                                <div class="mb-3">
                                    <h3
                                        class="text-lg font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-primary-600 transition-colors">
                                        {{ $course->title }}
                                    </h3>
                                    <p class="text-sm text-slate-500 line-clamp-2">
                                        {{ $course->sub_title }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between">
                                    @if (!$course->is_premium)
                                        {{-- Free Course --}}
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-green-600">GRATIS</span>
                                        </div>
                                        <button
                                            class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                                            <i class="ph-bold ph-play"></i>
                                        </button>
                                    @elseif($course->promotional_price && $course->promotional_price < $course->price)
                                        {{-- Promotional Price --}}
                                        <div class="flex flex-col">
                                            <span class="text-xs text-slate-400 line-through">Rp
                                                {{ number_format($course->price, 0, ',', '.') }}</span>
                                            <span class="text-lg font-bold text-primary-600">Rp
                                                {{ number_format($course->promotional_price, 0, ',', '.') }}</span>
                                        </div>
                                        <button
                                            class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition">
                                            <i class="ph-bold ph-shopping-cart"></i>
                                        </button>
                                    @else
                                        {{-- Normal Price --}}
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-slate-900">Rp
                                                {{ number_format($course->price, 0, ',', '.') }}</span>
                                        </div>
                                        <button
                                            class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition">
                                            <i class="ph-bold ph-shopping-cart"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-16 flex justify-center">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div
                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i class="ph-fill ph-book-open text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada course tersedia</h3>
                    <p class="text-slate-500">Course akan segera hadir. Nantikan update terbaru dari kami!</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Animasi simple saat page load
        document.addEventListener("DOMContentLoaded", function() {
            const cards = document.querySelectorAll('.group');
            cards.forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = "translateY(20px)";
                setTimeout(() => {
                    card.style.transition = "all 0.5s ease-out";
                    card.style.opacity = 1;
                    card.style.transform = "translateY(0)";
                }, index * 100); // Stagger effect
            });
        });
    </script>
@endsection
