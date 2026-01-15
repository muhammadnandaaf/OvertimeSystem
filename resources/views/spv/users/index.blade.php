<x-app-layout>
    <x-slot name="header">Team Member Management</x-slot>

    <div class="max-w-5xl mx-auto space-y-12">
        <div class="bg-white rounded-[40px] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="p-10 border-b border-slate-50 bg-slate-50/50">
                <h3 class="font-serif-classic text-2xl text-slate-900">Register New Employee</h3>
                <p class="text-xs text-slate-500 mt-1 italic tracking-wide text-indigo-600">
                    Employee will be automatically registered in Section: {{ Auth::user()->section }}
                </p>
            </div>

            <form action="{{ route('spv.users.store') }}" method="POST" class="p-10 space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Employee Name</label>
                        <input type="text" name="name" required placeholder="Full Name" 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Office Email</label>
                        <input type="email" name="email" required placeholder="email@company.com" 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Default Password</label>
                        <input type="password" name="password" required placeholder="Minimum 8 Characters" 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all shadow-sm">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-slate-900 hover:bg-black text-white text-[11px] font-black uppercase tracking-[0.3em] rounded-2xl shadow-xl transition-all transform hover:-translate-y-1">
                        Save Employee
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 border-b border-slate-100">
                <h4 class="font-serif-classic text-xl text-slate-900">Team Member List ({{ Auth::user()->section }})</h4>
            </div>
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="p-6">Name</th>
                        <th class="p-6">Email</th>
                        <th class="p-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition duration-300">
                        <td class="p-6 font-bold text-slate-900">{{ $user->name }}</td>
                        <td class="p-6 text-sm text-slate-500 italic">{{ $user->email }}</td>
                        <td class="p-6 text-right">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-100 text-emerald-700">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-20 text-center text-slate-400 italic">No employees registered in your section.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>