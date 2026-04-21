@extends('user.layouts.app')

@section('content')
    <section class="bg-slate-900 py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#4b5563 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-primary-900 text-primary-200 text-xs font-bold mb-4 border border-primary-700">Tahun
                Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</span>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Pilih Paket Belajar Terbaikmu</h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg">Investasi terbaik untuk masa depan. Pilih program yang
                sesuai dengan jenjang sekolah dan target akademismu.</p>
        </div>
    </section>

    {{-- Filter Categories --}}
    @php
        $categories = $programs->pluck('category')->filter()->unique('id');
    @endphp
    <section class="sticky top-[65px] z-40 bg-slate-50/95 backdrop-blur py-4 border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 overflow-x-auto">
            <div class="flex md:justify-center gap-2 min-w-max" id="filter-container">
                <button onclick="filterSelection('all')"
                    class="filter-btn active px-6 py-2 rounded-full text-sm font-bold transition-all bg-slate-800 text-white shadow-lg">Semua</button>
                @foreach ($categories as $category)
                    <button onclick="filterSelection('{{ strtolower($category->slug) }}')"
                        class="filter-btn px-6 py-2 rounded-full text-sm font-bold text-slate-600 hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-slate-200">{{ $category->name }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($programs->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="program-grid">
                    @foreach ($programs as $index => $program)
                        @php
                            $isPremium = $program->is_premium;
                            $hasPromo = $program->promotional_price && $program->promotional_price < $program->price;
                            $categorySlug = $program->category ? strtolower($program->category->slug) : 'other';
                            $isPopular = $index === 0; // First program as popular (you can change this logic)
                        @endphp

                        <div class="program-card {{ $isPopular ? 'relative border-2 border-primary-500 shadow-lg' : 'border border-slate-200' }} bg-white rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col"
                            data-category="{{ $categorySlug }}">

                            @if ($isPopular)
                                <div
                                    class="absolute top-0 right-0 bg-primary-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl">
                                    POPULER</div>
                            @endif

                            <div
                                class="p-1 bg-gradient-to-r {{ $isPopular ? 'from-primary-600 to-indigo-600' : 'from-blue-400 to-cyan-400' }}">
                            </div>

                            <div class="p-8 flex-1">
                                <div class="flex justify-between items-start mb-4">
                                    <span
                                        class="px-3 py-1 {{ $isPopular ? 'bg-indigo-50 text-indigo-600' : 'bg-blue-50 text-blue-600' }} rounded-lg text-xs font-bold uppercase tracking-wider">
                                        {{ $program->category->name ?? 'Program' }}
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $program->title }}</h3>
                                <p class="text-slate-500 text-sm mb-6">{{ $program->sub_title }}</p>

                                {{-- Program Benefits --}}
                                @if ($program->benefits->count() > 0)
                                    <div class="space-y-3 mb-8">
                                        @foreach ($program->benefits as $benefit)
                                            <div class="flex items-center gap-3 text-slate-700 text-sm">
                                                <i
                                                    class="ph-fill ph-check-circle {{ $isPopular ? 'text-primary-600' : 'text-green-500' }} text-lg"></i>
                                                <span>{{ $benefit->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="p-8 pt-0 border-t border-slate-100 mt-auto">
                                @if ($hasPromo)
                                    <p class="text-slate-400 text-xs line-through mb-1">Rp
                                        {{ number_format($program->price, 0, ',', '.') }}</p>
                                @endif

                                <div class="flex items-end gap-1 mb-4">
                                    @if (!$isPremium)
                                        <span class="text-3xl font-bold text-green-600">GRATIS</span>
                                    @else
                                        <span
                                            class="text-3xl font-bold {{ $isPopular ? 'text-primary-600' : 'text-slate-900' }}">
                                            Rp
                                            {{ number_format($hasPromo ? $program->promotional_price : $program->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-slate-500 text-sm mb-1">/bulan</span>
                                    @endif
                                </div>

                                @if ($isPopular)
                                    <a href="{{ route('program.show', $program->slug) }}"
                                        class="block w-full py-3 rounded-xl bg-primary-600 text-white font-bold hover:bg-primary-700 shadow-lg shadow-primary-600/20 transition text-center">Pilih
                                        Paket Ini</a>
                                @else
                                    <a href="{{ route('program.show', $program->slug) }}"
                                        class="block w-full py-3 rounded-xl border-2 border-slate-200 text-slate-700 font-bold hover:border-primary-600 hover:text-primary-600 transition text-center">Lihat
                                        Detail</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <div
                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i class="ph-fill ph-package text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada program tersedia</h3>
                    <p class="text-slate-500">Program akan segera hadir. Nantikan update terbaru dari kami!</p>
                </div>
            @endif

            <div id="empty-state" class="hidden text-center py-20">
                <div
                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i class="ph-fill ph-magnifying-glass text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Belum ada paket untuk kategori ini</h3>
                <p class="text-slate-500">Coba pilih kategori lain atau hubungi admin.</p>
            </div>
        </div>
    </section>

    <section class="py-10 px-4">
        <div
            class="max-w-4xl mx-auto bg-gradient-to-r from-accent-500 to-orange-500 rounded-2xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-white opacity-10" style="background-image: url('data:image/svg+xml,...');">
            </div>
            <div class="text-left relative z-10">
                <h3 class="text-2xl font-bold text-white mb-2">Bingung Pilih Paket yang Mana?</h3>
                <p class="text-orange-100">Konsultasikan kebutuhan belajarmu dengan Education Consultant kami. Gratis!
                </p>
            </div>
            <a href="#"
                class="relative z-10 bg-white text-orange-600 px-8 py-3 rounded-full font-bold hover:bg-orange-50 transition shadow-lg flex items-center gap-2">
                <i class="ph-bold ph-whatsapp-logo text-xl"></i>
                Chat Konsultan
            </a>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Filter Function Logic
        function filterSelection(category) {
            const cards = document.getElementsByClassName("program-card");
            const btns = document.getElementsByClassName("filter-btn");
            const emptyState = document.getElementById("empty-state");
            let visibleCount = 0;

            // 1. Update Button Styles
            for (let i = 0; i < btns.length; i++) {
                btns[i].className = btns[i].className.replace(" active bg-slate-800 text-white shadow-lg",
                    " text-slate-600 hover:bg-white hover:shadow-md border-transparent hover:border-slate-200");

                if (btns[i].getAttribute("onclick").includes(category)) {
                    btns[i].className =
                        "filter-btn active px-6 py-2 rounded-full text-sm font-bold transition-all bg-slate-800 text-white shadow-lg";
                }
            }

            // 2. Show/Hide Cards with Animation
            for (let i = 0; i < cards.length; i++) {
                cards[i].classList.remove("hidden");

                if (category === "all" || cards[i].getAttribute("data-category") === category) {
                    cards[i].style.display = "flex";
                    setTimeout(() => {
                        cards[i].style.opacity = "1";
                        cards[i].style.transform = "scale(1)";
                    }, 50);
                    visibleCount++;
                } else {
                    cards[i].style.display = "none";
                    cards[i].style.opacity = "0";
                    cards[i].style.transform = "scale(0.95)";
                }
            }

            // 3. Show Empty State if no cards match
            if (visibleCount === 0) {
                emptyState.classList.remove("hidden");
            } else {
                emptyState.classList.add("hidden");
            }
        }
    </script>
@endsection
