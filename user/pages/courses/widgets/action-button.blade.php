<div
    class="absolute bottom-0 left-0 w-full bg-white border-t border-slate-200 p-4 md:px-12 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-20">
    <div class="max-w-4xl mx-auto flex items-center justify-between">
        {{-- Previous Button --}}
        @if ($prevSubModule)
            <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $prevSubModule->slug]) }}"
                class="flex items-center gap-2 text-slate-500 font-bold hover:text-slate-900 transition px-4 py-2 rounded-lg hover:bg-slate-100">
                <i class="ph-bold ph-arrow-left"></i> <span class="hidden md:inline">Sebelumnya</span>
            </a>
        @else
            <span class="flex items-center gap-2 text-slate-300 font-bold px-4 py-2 cursor-not-allowed">
                <i class="ph-bold ph-arrow-left"></i> <span class="hidden md:inline">Sebelumnya</span>
            </span>
        @endif

        {{-- Mark Complete Toggle --}}
        <form action="#" method="POST" class="flex-1 flex justify-center">
            <label class="flex items-center gap-3 cursor-pointer group">
                <div class="relative">
                    <input type="checkbox" class="sr-only peer" id="mark-complete"
                        data-submodule-id="{{ $currentSubModule->id }}" {{ $isCurrentCompleted ? 'checked' : '' }}>
                    <div
                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                    </div>
                </div>
                <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900 select-none">Tandai
                    Selesai</span>
            </label>
        </form>

        {{-- Next Button --}}
        @if ($nextSubModule)
            <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $nextSubModule->slug]) }}"
                class="flex items-center gap-2 bg-slate-900 text-white font-bold px-6 py-3 rounded-full hover:bg-slate-700 transition shadow-lg">
                <span class="hidden md:inline">Selanjutnya</span> <i class="ph-bold ph-arrow-right"></i>
            </a>
        @else
            <span
                class="flex items-center gap-2 bg-green-600 text-white font-bold px-6 py-3 rounded-full shadow-lg cursor-default">
                <i class="ph-fill ph-check-circle"></i> <span class="hidden md:inline">Selesai!</span>
            </span>
        @endif
    </div>
</div>
