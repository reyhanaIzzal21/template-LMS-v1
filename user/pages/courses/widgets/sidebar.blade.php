<aside id="course-sidebar"
    class="fixed inset-y-0 left-0 z-40 w-80 bg-white border-r border-slate-200 flex flex-col h-full transform -translate-x-full lg:translate-x-0 lg:static lg:w-96 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">

    <div class="lg:hidden p-4 flex justify-end border-b border-slate-100">
        <button onclick="toggleSidebar()" class="p-2 text-slate-500 hover:text-red-500">
            <i class="ph-bold ph-x text-xl"></i>
        </button>
    </div>

    {{-- Progress Bar --}}
    <div class="p-5 border-b border-slate-100 bg-white">
        <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Progress Belajar</h2>
        <div class="w-full bg-slate-100 rounded-full h-2.5 mb-2">
            <div id="progress-bar" class="bg-green-500 h-2.5 rounded-full transition-all duration-300"
                style="width: {{ $progressPercentage }}%"></div>
        </div>
        <div class="flex justify-between text-xs font-bold">
            <span id="progress-text" class="text-slate-900">{{ $progressPercentage }}% Selesai</span>
            <span id="progress-count" class="text-slate-400">{{ $completedCount }}/{{ $totalSubModules }} Item</span>
        </div>
    </div>

    {{-- Modules List --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-2">
        @foreach ($course->modules as $module)
            @php
                $isCurrentModule = $currentModule && $currentModule->id === $module->id;
                $moduleHasCurrentSubModule = $module->subModules->contains('id', $currentSubModule->id);
            @endphp

            <div
                class="module-item {{ $isCurrentModule ? 'bg-slate-50' : 'bg-white' }} rounded-xl border border-slate-200 overflow-hidden">
                <button
                    class="w-full flex items-center justify-between p-4 {{ $isCurrentModule ? 'bg-slate-100' : 'bg-white' }} text-left hover:bg-slate-50 transition focus:outline-none"
                    onclick="toggleModule(this)">
                    <span class="font-bold text-slate-900 text-sm">Modul {{ $module->step }}:
                        {{ $module->title }}</span>
                    <i
                        class="ph-bold ph-caret-down text-slate-500 transform transition-transform duration-300 {{ $moduleHasCurrentSubModule ? 'rotate-180' : '' }}"></i>
                </button>

                <div
                    class="module-content divide-y divide-slate-200/50 {{ $moduleHasCurrentSubModule ? '' : 'hidden' }}">
                    @foreach ($module->subModules as $subModule)
                        @php
                            $isCompleted = in_array($subModule->id, $completedSubModuleIds);
                            $isCurrent = $currentSubModule && $currentSubModule->id === $subModule->id;
                        @endphp

                        @if ($isCurrent)
                            {{-- Materi yang sedang diikuti --}}
                            <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $subModule->slug]) }}"
                                class="flex items-start gap-3 p-3 bg-blue-50 border-l-4 border-primary-600 transition"
                                data-submodule-id="{{ $subModule->id }}">
                                <div class="mt-0.5 text-primary-600">
                                    <i class="ph-fill ph-play-circle text-lg animate-pulse"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-primary-700">{{ $subModule->title }}</p>
                                    <div class="flex items-center gap-1 text-[10px] text-primary-500 mt-1">
                                        <i class="ph-fill ph-play-circle"></i> Sub-modul {{ $subModule->step }}
                                    </div>
                                </div>
                            </a>
                        @elseif($isCompleted)
                            {{-- Materi yang sudah selesai --}}
                            <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $subModule->slug]) }}"
                                class="flex items-start gap-3 p-3 hover:bg-white transition opacity-60 completed"
                                data-submodule-id="{{ $subModule->id }}">
                                <div class="mt-0.5 text-green-600">
                                    <i class="ph-fill ph-check-circle text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 line-through decoration-slate-400">
                                        {{ $subModule->title }}</p>
                                    <div class="flex items-center gap-1 text-[10px] text-slate-400 mt-1">
                                        <i class="ph-fill ph-check"></i> Selesai
                                    </div>
                                </div>
                            </a>
                        @else
                            {{-- Materi yang belum selesai --}}
                            <a href="{{ route('learn.show', ['courseSlug' => $course->slug, 'subModuleSlug' => $subModule->slug]) }}"
                                class="flex items-start gap-3 p-3 hover:bg-white transition group"
                                data-submodule-id="{{ $subModule->id }}">
                                <div class="mt-0.5 text-slate-300 group-hover:text-purple-500">
                                    <i class="ph-fill ph-circle text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 group-hover:text-slate-900">
                                        {{ $subModule->title }}</p>
                                    <div class="flex items-center gap-1 text-[10px] text-slate-400 mt-1">
                                        <i class="ph-fill ph-play-circle"></i> Sub-modul {{ $subModule->step }}
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</aside>
