<x-app-layout>
    <x-slot name="header">Employee Overtime Summary </x-slot>

    <div class="space-y-10">
        <div class="bg-slate-900 rounded-[40px] p-10 text-white shadow-2xl border border-white/10">
            <h3 class="font-serif-classic text-3xl mb-2">Welcome, {{ Auth::user()->name }}</h3>
            <p class="text-slate-400 text-sm">Unit: {{ Auth::user()->department }} | Section: {{ Auth::user()->section }}</p>
        </div>

        @if(Auth::user()->role != 'Karyawan')
            <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h4 class="font-serif-classic text-xl text-slate-900">Overtime Activity Monitoring</h4>
                        <p class="text-xs text-slate-400 mt-1 italic">
                            @if(Auth::user()->role == 'Admin SDM') Showing comprehensive company records.
                            
                            @else Showing data within {{ Auth::user()->section ?? Auth::user()->department }} @endif
                        </p>
                    </div>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <tr>
                            <th class="p-6">Employee Name</th>
                            <th class="p-6">SPL ID</th>
                            <th class="p-6">Timeframe</th>
                            <th class="p-6">Status</th>
                            <th class="p-6 text-right">Total Conversion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($monitoringKaryawan as $item)
                        <tr class="hover:bg-slate-50/50 transition duration-300">
                            <td class="p-6">
                                <span class="font-bold text-slate-900 block">{{ $item->user->name }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $item->user->section }}</span>
                            </td>
                            <td class="p-6 text-xs font-mono text-slate-500">{{ $item->spl->no_spl }}</td>
                            <td class="p-6 text-xs">
                                {{ $item->spl->tanggal }}<br>
                                <span class="text-slate-400">({{ $item->jam_mulai }} - {{ $item->jam_selesai }})</span>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter 
                                    @if($item->spl->status_approval == 'Approved') bg-emerald-100 text-emerald-700 
                                    @elseif($item->spl->status_approval == 'Rejected') bg-rose-100 text-rose-700 
                                    @else bg-amber-100 text-amber-700 @endif">
                                    {{ $item->spl->status_approval }}
                                </span>
                            </td>
                            <td class="p-6 text-right font-serif-classic text-xl text-slate-900">
                                {{ $item->total_konversi ?? '0.00' }} <span class="text-sm font-sans font-medium text-slate-500">Hours</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center text-slate-400 italic">No overtime has been recorded.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        @if(Auth::user()->role == 'Karyawan')
            <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8 border-b border-slate-100">
                    <h4 class="font-serif-classic text-xl text-slate-900">My Overtime History</h4>
                    <p class="text-xs text-slate-400 mt-1 italic">Displaying a list of personal overtime requests that have been submitted.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-fixed">
                        <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <tr>
                                <th class="p-6 w-1/4">SPL ID</th>
                                <th class="p-6 w-1/6">Date</th>
                                <th class="p-6 w-1/4">Work Time</th>
                                <th class="p-6 w-1/6 text-center">Status</th>
                                <th class="p-6 w-1/4 text-right">Total Conversion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($riwayat as $item)
                            <tr class="hover:bg-slate-50/50 transition duration-300">
                                <td class="p-6 font-bold text-slate-900 truncate">{{ $item->spl->no_spl }}</td>
                                <td class="p-6 text-sm text-slate-600">{{ $item->spl->tanggal }}</td>
                                <td class="p-6 text-xs text-slate-500 italic">
                                    {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                </td>
                                <td class="p-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest 
                                        @if($item->spl->status_approval == 'Approved') bg-emerald-100 text-emerald-700 
                                        @elseif($item->spl->status_approval == 'Rejected') bg-rose-100 text-rose-700 
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ $item->spl->status_approval }}
                                    </span>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="font-serif-classic text-2xl text-slate-900 whitespace-nowrap">
                                        {{ $item->total_konversi ?? '0.00' }} <span class="text-sm font-sans font-medium text-slate-500">Hours</span>
                                    </div>
                                    
                                    @if($item->spl->status_approval == 'Approved')
                                        <a href="{{ route('spl.preview', $item->spl->id) }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-900 font-bold text-[10px] uppercase tracking-tighter">
                                            👁️ Preview
                                        </a>
                                    @else
                                        <span class="mt-2 block text-[10px] font-bold text-slate-300 uppercase italic">Preview Unavailable</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-20 text-center text-slate-400 italic">You do not have any overtime request history..</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>