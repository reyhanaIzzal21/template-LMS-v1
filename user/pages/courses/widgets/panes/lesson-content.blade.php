<div class="flex-1 overflow-y-auto p-4 md:p-8 lg:px-12 pb-24" id="lesson-content">
    <div class="max-w-4xl mx-auto">

        {{-- breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-4">
            <a href="{{ route('courses.detail', $course->slug) }}"
                class="hover:text-primary-600 transition">{{ $course->title }}</a>
            <i class="ph-bold ph-caret-right"></i>
            <span>Modul {{ $currentModule->step }}</span>
            <i class="ph-bold ph-caret-right"></i>
            <span class="text-primary-600 font-bold">Sub-modul {{ $currentSubModule->step }}</span>
        </div>

        {{-- lesson title --}}
        <div
            class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-8 border-b border-slate-100 pb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">{{ $currentSubModule->title }}</h1>
                @if ($currentSubModule->sub_title)
                    <p class="text-slate-600 mb-2">{{ $currentSubModule->sub_title }}</p>
                @endif
                <p class="text-slate-500 text-sm">
                    Modul {{ $currentModule->step }}: {{ $currentModule->title }}
                    • Oleh {{ $course->user->name ?? 'Instructor' }}
                </p>
            </div>
            <div class="flex gap-2">
                <button
                    class="p-2 rounded-full border border-slate-200 text-slate-400 hover:text-blue-500 hover:border-blue-200 hover:bg-blue-50 transition"
                    title="Diskusi / Komentar">
                    <i class="ph-bold ph-chat-text"></i>
                </button>
            </div>
        </div>

        {{-- Lesson Content --}}
        <div class="space-y-6 text-slate-700 leading-relaxed text-lg prose prose-slate max-w-none">
            @if ($currentSubModule->content)
                {!! $currentSubModule->content !!}
            @else
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 text-center">
                    <div
                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i class="ph-fill ph-file-text text-2xl"></i>
                    </div>
                    <p class="text-slate-500">Konten untuk sub-modul ini belum tersedia.</p>
                </div>
            @endif
        </div>

        {{-- Navigation Info --}}
        <div class="mt-12 mb-20 pt-8 border-t border-slate-100">
            <div class="flex items-center justify-between text-sm">
                <div>
                    @if ($prevSubModule)
                        <p class="text-slate-400 text-xs mb-1">Sebelumnya</p>
                        <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $prevSubModule->slug]) }}"
                            class="text-primary-600 font-bold hover:underline flex items-center gap-1">
                            <i class="ph-bold ph-arrow-left"></i>
                            {{ $prevSubModule->title }}
                        </a>
                    @endif
                </div>
                <div class="text-right">
                    @if ($nextSubModule)
                        <p class="text-slate-400 text-xs mb-1">Selanjutnya</p>
                        <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $nextSubModule->slug]) }}"
                            class="text-primary-600 font-bold hover:underline flex items-center gap-1">
                            {{ $nextSubModule->title }}
                            <i class="ph-bold ph-arrow-right"></i>
                        </a>
                    @else
                        <p class="text-slate-400 text-xs mb-1">Selamat!</p>
                        <span class="text-green-600 font-bold flex items-center gap-1">
                            <i class="ph-fill ph-check-circle"></i> Ini adalah materi terakhir
                        </span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
