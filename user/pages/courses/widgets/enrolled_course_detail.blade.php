@extends('user.layouts.app')

@section('name')
    {{ $currentSubModule->title }} - {{ $course->title }} - EduSmart
@endsection

@section('style')
    <style>
        /* CSS Tambahan untuk scrollbar agar cantik */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection

@section('content')
    <div class="flex h-[calc(100vh-80px)] mt-20 bg-slate-50 overflow-hidden relative">

        <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden lg:hidden transition-opacity"
            onclick="toggleSidebar()"></div>

        {{-- sidebar --}}
        @include('user.pages.courses.widgets.sidebar')

        <main class="flex-1 flex flex-col h-full relative overflow-hidden bg-white w-full">
            {{-- mobile sidebar --}}
            @include('user.pages.courses.widgets.mobile-sidebar')

            {{-- lesson content --}}
            @include('user.pages.courses.widgets.panes.lesson-content')

            {{-- action buttons --}}
            @include('user.pages.courses.widgets.action-button')

        </main>
    </div>
@endsection

@section('script')
    <script>
        // 1. Logic untuk Mobile Sidebar (Hamburger Menu)
        function toggleSidebar() {
            const sidebar = document.getElementById('course-sidebar');
            const overlay = document.getElementById('mobile-overlay');

            // Cek apakah sidebar sedang memiliki class translate-x-full (hidden state untuk mobile)
            if (sidebar.classList.contains('-translate-x-full')) {
                // BUKA SIDEBAR
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                // TUTUP SIDEBAR
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // 2. Logic untuk Accordion (Expand/Collapse Modul)
        function toggleModule(button) {
            // Ambil elemen konten (sibling setelah button)
            const content = button.nextElementSibling;
            // Ambil icon panah di dalam button
            const icon = button.querySelector('.ph-caret-down');

            // Toggle Visibility
            if (content.classList.contains('hidden')) {
                // Buka
                content.classList.remove('hidden');
                // Putar panah ke atas (180 derajat)
                icon.classList.add('rotate-180');
            } else {
                // Tutup
                content.classList.add('hidden');
                // Kembalikan panah ke posisi semula
                icon.classList.remove('rotate-180');
            }
        }

        // 3. Logic Mark as Complete (AJAX)
        const toggle = document.getElementById('mark-complete');
        if (toggle) {
            toggle.addEventListener('change', function() {
                const subModuleId = this.dataset.submoduleId;
                const isChecked = this.checked;
                const url = isChecked ?
                    '{{ route('learn.complete', ':id') }}'.replace(':id', subModuleId) :
                    '{{ route('learn.incomplete', ':id') }}'.replace(':id', subModuleId);

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update progress bar
                            const progressBar = document.getElementById('progress-bar');
                            const progressText = document.getElementById('progress-text');
                            const progressCount = document.getElementById('progress-count');

                            if (progressBar) {
                                progressBar.style.width = data.progress + '%';
                            }
                            if (progressText) {
                                progressText.textContent = data.progress + '% Selesai';
                            }
                            if (progressCount) {
                                progressCount.textContent = data.completed_count + '/' + data.total + ' Item';
                            }

                            // Update sidebar item styling
                            const sidebarItem = document.querySelector(`[data-submodule-id="${subModuleId}"]`);
                            if (sidebarItem) {
                                if (isChecked) {
                                    sidebarItem.classList.add('completed');
                                } else {
                                    sidebarItem.classList.remove('completed');
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert checkbox state on error
                        toggle.checked = !isChecked;
                    });
            });
        }
    </script>
@endsection
