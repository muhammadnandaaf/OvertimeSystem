<x-app-layout>
    <x-slot name="header">Create Overtime Order Letter</x-slot>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[40px] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="p-10 border-b border-slate-50 bg-slate-50/50">
                <h3 class="font-serif-classic text-2xl text-slate-900">Overtime Request Form</h3>
                <p class="text-xs text-slate-500 mt-1">Please select employees and specify the overtime schedule.</p>
            </div>

            <form action="{{ route('spl.store') }}" method="POST" class="p-2 space-y-2">
                @csrf

                <div class="relative">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Overtime Date</label>
                    <input type="date" name="tanggal" required 
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all">
                </div>

                <div class="relative">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Select Employees (Multiple selections allowed)</label>
                    <select id="select-karyawan" name="karyawan_ids[]" multiple placeholder="Type employee name..." autocomplete="off" required
                        class="block w-full rounded-2xl border-none ring-1 ring-slate-200 shadow-sm">
                        @foreach($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}">{{ $karyawan->name }} ({{ $karyawan->section }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="relative">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Start Time</label>
                        <input type="time" name="jam_mulai" required 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                    <div class="relative">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">End Time</label>
                        <input type="time" name="jam_selesai" required 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" 
                        class="w-full py-5 bg-slate-900 hover:bg-black text-white text-[11px] font-black uppercase tracking-[0.3em] rounded-2xl shadow-xl transition-all transform hover:-translate-y-1 active:scale-95">
                        Submit Overtime Letter to Manager
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect("#select-karyawan", {
            plugins: ['remove_button'],
            maxOptions: 100, // Display up to 100 options during search
            create: false,
            render: {
                option: function(data, escape) {
                    return `<div class="py-2 px-3 border-b border-slate-50">
                                <div class="font-bold text-slate-800">${escape(data.text)}</div>
                            </div>`;
                },
                item: function(data, escape) {
                    return `<div class="bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-lg border border-indigo-100">${escape(data.text)}</div>`;
                }
            }
        });
    </script>
</x-app-layout>