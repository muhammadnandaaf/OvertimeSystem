<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Letter Approval - Manager Level') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="mb-4 font-bold text-gray-700">List of SPLs Awaiting Your Approval</h3>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 border">SPL ID</th>
                            <th class="py-3 px-6 border">Date</th>
                            <th class="py-3 px-6 border">Created By</th>
                            <th class="py-3 px-6 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($spls as $spl)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 border">{{ $spl->no_spl }}</td>
                                <td class="py-3 px-6 border">{{ $spl->tanggal }}</td>
                                <td class="py-3 px-6 border text-indigo-600 font-bold">
                                    {{ $spl->creator->name }} ({{ $spl->creator->section }})
                                </td>
                                <td class="py-3 px-6 border text-center">
                                    <form action="{{ route('manager.approve', $spl->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                                            ✔ Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('manager.reject', $spl->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="mt-3 px-4 py-2 bg-white border border-rose-200 text-rose-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-50 transition">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-500 italic">
                                    No Overtime Letter submissions require approval at this time.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>