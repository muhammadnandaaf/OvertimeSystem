<x-app-layout>
    <x-slot name="header">Overtime Order Preview</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 flex justify-between items-center print:hidden">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-500 uppercase tracking-widest hover:text-slate-900 transition">
                ← Dashboard
            </a>
            <div class="flex gap-4">
                <button onclick="window.print()" class="px-6 py-2 bg-white border border-slate-300 rounded-xl text-[10px] font-black uppercase tracking-widest">
                    🖨️ Print Document
                </button>
                <a href="{{ route('spl.download', $spl->id) }}" class="px-6 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-slate-200">
                    📥 Download PDF
                </a>
            </div>
        </div>

        <div class="printable-content bg-white p-16 shadow-2xl border border-slate-100 min-h-[1000px] rounded-sm print:p-0 print:shadow-none print:border-none">
            @include('spl.pdf_template')
        </div>
    </div>
</x-app-layout>