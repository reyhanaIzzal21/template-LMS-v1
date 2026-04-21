<div class="lg:hidden p-4 bg-white border-b border-slate-200 flex items-center justify-between sticky top-0 z-20">
    <span class="font-bold text-slate-900 truncate max-w-[70%]">Modul {{ $currentModule->step }}:
        {{ Str::limit($currentSubModule->title, 20) }}</span>
    <button onclick="toggleSidebar()"
        class="text-primary-600 font-bold text-sm flex items-center gap-2 px-3 py-1.5 bg-primary-50 rounded-lg hover:bg-primary-100 transition">
        <i class="ph-bold ph-list text-lg"></i> Daftar Materi
    </button>
</div>
