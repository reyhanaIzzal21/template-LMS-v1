@extends('user.layouts.app')

@section('name')
    {{ $course->title }} - EduSmart
@endsection

@section('content')
    <div class="bg-slate-900 pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <a href="{{ route('courses') }}" class="hover:text-white transition">Course</a>
                <i class="ph-bold ph-caret-right text-xs"></i>
                <span class="text-white font-medium">{{ $course->category->name ?? 'Course' }}</span>
            </nav>

            <div class="lg:w-2/3">
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4 leading-tight">
                    {{ $course->title }}
                </h1>
                <p class="text-slate-300 text-lg mb-6 leading-relaxed">
                    {{ $course->sub_title }}
                </p>

                <div class="flex flex-wrap items-center gap-6 text-sm text-slate-300">
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-books"></i> {{ $course->modules->count() }} Modul
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-clock"></i> Terakhir Diupdate: {{ $course->updated_at->format('M Y') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ph-fill ph-globe"></i> Bahasa Indonesia
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="relative py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12">

                <div class="lg:col-span-2 space-y-12">

                    {{-- Course Benefits --}}
                    @if ($course->benefits->count() > 0)
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 md:p-8">
                            <h2 class="text-xl font-bold text-slate-900 mb-6">Apa yang akan Anda pelajari?</h2>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach ($course->benefits as $benefit)
                                    <div class="flex gap-3">
                                        <i class="ph-bold ph-check text-green-600 mt-1"></i>
                                        <span class="text-slate-700 text-sm">{{ $benefit->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Course Curriculum --}}
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Kurikulum Kursus</h2>

                        @php
                            $totalSubModules = $course->modules->sum(function ($module) {
                                return $module->subModules->count();
                            });
                        @endphp

                        <div class="flex items-center justify-between text-sm text-slate-500 mb-4">
                            <span>{{ $course->modules->count() }} Modul • {{ $totalSubModules }} Materi</span>
                            <button onclick="expandAll()" class="text-primary-600 font-bold hover:underline">Expand
                                All</button>
                        </div>

                        @if ($course->modules->count() > 0)
                            <div
                                class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-200 bg-white">
                                @foreach ($course->modules as $module)
                                    <div class="accordion-item">
                                        <button
                                            class="w-full flex items-center justify-between p-5 bg-slate-50 hover:bg-slate-100 transition text-left focus:outline-none"
                                            onclick="toggleAccordion(this)">
                                            <div class="flex items-center gap-3">
                                                <i
                                                    class="ph-bold ph-caret-down transform -rotate-90 transition-transform duration-300"></i>
                                                <span class="font-bold text-slate-900">Modul {{ $module->step }}:
                                                    {{ $module->title }}</span>
                                            </div>
                                            <span
                                                class="text-xs text-slate-500 font-medium">{{ $module->subModules->count() }}
                                                Materi</span>
                                        </button>
                                        <div class="accordion-content hidden">
                                            <ul class="divide-y divide-slate-100">
                                                @foreach ($module->subModules as $subModule)
                                                    <li class="flex items-center justify-between p-4 hover:bg-slate-50">
                                                        <div class="flex items-center gap-3">
                                                            @if ($subModule->type === 'video')
                                                                <i
                                                                    class="ph-fill ph-play-circle text-primary-600 text-lg"></i>
                                                            @elseif($subModule->type === 'quiz')
                                                                <i class="ph-fill ph-question text-orange-500 text-lg"></i>
                                                            @elseif($subModule->type === 'task')
                                                                <i class="ph-fill ph-file-text text-purple-600 text-lg"></i>
                                                            @else
                                                                <i class="ph-fill ph-file text-slate-500 text-lg"></i>
                                                            @endif
                                                            <span
                                                                class="text-sm text-slate-700">{{ $subModule->title }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-4">
                                                            <i class="ph-fill ph-lock-key text-slate-300"></i>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 border border-slate-200 rounded-2xl">
                                <p class="text-slate-500">Kurikulum akan segera ditambahkan</p>
                            </div>
                        @endif
                    </div>

                    {{-- Course Description --}}
                    <div class="prose prose-slate max-w-none">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4 no-underline">Deskripsi Kursus</h2>
                        <div class="text-slate-600 leading-relaxed">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    {{-- Instructor --}}
                    @if ($course->user)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Instructor</h3>
                            <div class="flex gap-4">
                                @if ($course->user->photo)
                                    <img src="{{ asset('storage/' . $course->user->photo) }}"
                                        class="w-16 h-16 rounded-full object-cover border border-slate-200"
                                        alt="{{ $course->user->name }}">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xl border border-primary-200">
                                        {{ strtoupper(substr($course->user->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 hover:text-primary-600 cursor-pointer">
                                        {{ $course->user->name }}</h4>
                                    <p class="text-primary-600 text-sm font-medium mb-2">Instructor</p>
                                    @if ($course->user->bio)
                                        <p class="text-slate-600 text-sm leading-relaxed">
                                            {{ $course->user->bio }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden relative">

                            <div class="relative h-48 group cursor-pointer">
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
                                <div class="mb-6">
                                    @if (!$course->is_premium)
                                        <div class="flex items-end gap-2 mb-1">
                                            <span class="text-3xl font-extrabold text-green-600">GRATIS</span>
                                        </div>
                                    @elseif($course->promotional_price && $course->promotional_price < $course->price)
                                        <div class="flex items-end gap-2 mb-1">
                                            <span class="text-3xl font-extrabold text-slate-900">Rp
                                                {{ number_format($course->promotional_price, 0, ',', '.') }}</span>
                                            <span class="text-sm text-slate-400 line-through mb-1">Rp
                                                {{ number_format($course->price, 0, ',', '.') }}</span>
                                        </div>
                                        @php
                                            $discount = round(
                                                (($course->price - $course->promotional_price) / $course->price) * 100,
                                            );
                                        @endphp
                                        <div
                                            class="flex items-center gap-2 text-red-500 text-xs font-bold bg-red-50 px-2 py-1 rounded inline-block">
                                            <i class="ph-fill ph-tag"></i> Diskon {{ $discount }}%
                                        </div>
                                    @else
                                        <div class="flex items-end gap-2 mb-1">
                                            <span class="text-3xl font-extrabold text-slate-900">Rp
                                                {{ number_format($course->price, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-3 mb-6">
                                    @if ($course->is_premium)
                                        {{-- Premium Course --}}
                                        @auth
                                            @if ($isEnrolled)
                                                {{-- Already Enrolled (grandfathered or paid) - Continue Learning --}}
                                                <a href="{{ route('learn.index', $course->slug) }}"
                                                    class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                                                    <i class="ph-fill ph-play"></i>
                                                    Lanjutkan Belajar
                                                </a>
                                            @else
                                                {{-- Not Enrolled - Buy Now --}}
                                                <form action="{{ route('courses.checkout', $course->slug) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition shadow-lg shadow-primary-600/30 flex items-center justify-center gap-2">
                                                        <i class="ph-fill ph-shopping-cart"></i>
                                                        Beli Sekarang
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            {{-- Not Logged In - Redirect to Login --}}
                                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}"
                                                class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition shadow-lg shadow-primary-600/30 flex items-center justify-center gap-2">
                                                <i class="ph-fill ph-sign-in"></i>
                                                Login untuk Membeli
                                            </a>
                                        @endauth
                                    @else
                                        {{-- Free Course --}}
                                        @auth
                                            @if ($isEnrolled)
                                                {{-- Already Enrolled - Continue Learning --}}
                                                <a href="{{ route('learn.index', $course->slug) }}"
                                                    class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                                                    <i class="ph-fill ph-play"></i>
                                                    Lanjutkan Belajar
                                                </a>
                                            @else
                                                {{-- Not Enrolled - Enroll Now --}}
                                                <form action="{{ route('courses.enroll-free', $course->slug) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                                                        <i class="ph-fill ph-play"></i>
                                                        Mulai Belajar Gratis
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            {{-- Not Logged In - Redirect to Login --}}
                                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}"
                                                class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                                                <i class="ph-fill ph-sign-in"></i>
                                                Login untuk Mulai Belajar
                                            </a>
                                        @endauth
                                    @endif
                                </div>

                                <div class="space-y-3 mb-6">
                                    <p class="text-xs font-bold text-slate-900 uppercase tracking-wider">Yang kamu
                                        dapatkan:</p>
                                    <ul class="text-sm text-slate-600 space-y-2">
                                        <li class="flex items-center gap-2"><i
                                                class="ph-fill ph-books text-slate-400"></i>
                                            {{ $course->modules->count() }} Modul Pembelajaran
                                        </li>
                                        <li class="flex items-center gap-2"><i
                                                class="ph-fill ph-device-mobile text-slate-400"></i> Akses di HP dan Laptop
                                        </li>
                                        <li class="flex items-center gap-2"><i
                                                class="ph-fill ph-infinity text-slate-400"></i> Akses Seumur Hidup</li>
                                        <li class="flex items-center gap-2"><i
                                                class="ph-fill ph-certificate text-yellow-500"></i> Sertifikat Kelulusan
                                        </li>
                                    </ul>
                                </div>

                                <div class="pt-4 border-t border-slate-100 text-center">
                                    <p class="text-[10px] text-slate-400 font-semibold mb-2">PEMBAYARAN AMAN DENGAN</p>
                                    <div
                                        class="flex justify-center items-center gap-3 opacity-60 grayscale hover:grayscale-0 transition duration-300">
                                        <i class="ph-fill ph-bank text-2xl" title="Bank Transfer"></i>
                                        <i class="ph-fill ph-qr-code text-2xl" title="QRIS"></i>
                                        <i class="ph-fill ph-credit-card text-2xl" title="Credit Card"></i>
                                        <i class="ph-fill ph-wallet text-2xl" title="E-Wallet"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center gap-4 text-slate-500">
                            <a href="#" class="flex items-center gap-2 text-sm hover:text-primary-600 transition">
                                <i class="ph-bold ph-share-network"></i> Bagikan
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm hover:text-primary-600 transition">
                                <i class="ph-bold ph-gift"></i> Gift Course
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Simple Accordion Logic without AlpineJS
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.ph-caret-down');

            // Toggle Hidden
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.remove('-rotate-90');
                icon.classList.add('-rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('-rotate-180');
                icon.classList.add('-rotate-90');
            }
        }

        function expandAll() {
            const contents = document.querySelectorAll('.accordion-content');
            const icons = document.querySelectorAll('.ph-caret-down');

            contents.forEach(c => c.classList.remove('hidden'));
            icons.forEach(i => {
                i.classList.remove('-rotate-90');
                i.classList.add('-rotate-180');
            });
        }
    </script>
@endsection
