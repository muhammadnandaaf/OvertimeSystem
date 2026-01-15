<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('HR Final Verification & Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="mb-4 font-bold text-gray-700">List of SPLs Awaiting HR Verification</h3>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-indigo-600 text-white uppercase text-sm leading-normal">
                                <th class="py-3 px-6 border">SPL iD</th>
                                <th class="py-3 px-6 border">Employee Details</th>
                                <th class="py-3 px-6 border">Overtime Schedule</th>
                                <th class="py-3 px-6 border text-center">Final Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($spls as $spl)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 border font-bold">{{ $spl->no_spl }}</td>
                                    <td class="py-3 px-6 border">
                                        <ul class="list-disc ml-4">
                                            @foreach($spl->details as $detail)
                                                <li>{{ $detail->user->name }} ({{ $detail->user->section }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="py-3 px-6 border">
                                        {{ $spl->tanggal }} <br>
                                        <span class="text-xs text-gray-500">
                                            ({{ $spl->details->first()->jam_mulai }} - {{ $spl->details->first()->jam_selesai }})
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 border text-center">
                                        <div class="flex justify-center">
                                            <form action="{{ route('sdm.approve', $spl->id) }}" method="POST" class="w-full max-w-[200px] space-y-3">
                                                @csrf
                                                
                                                <div class="text-left">
                                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Overtime Category</label>
                                                    <select name="jenis_lembur" required class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                                        <option value="">-- Select --</option>
                                                        <option value="Reguler">Work Day (Regular)</option>
                                                        <option value="Off">Holiday/Day Off</option>
                                                    </select>
                                                </div>

                                                <button type="submit" 
                                                    style="height: 25px; font-size: 14px; width: 100%; margin-top: 15px;"
                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold uppercase tracking-widest rounded-lg shadow-md transition-all active:scale-95 flex items-center justify-center">
                                                    FINAL APPROVE
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-500 italic">
                                        No Overtime Letter awaiting HR verification.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>