<x-app-layout>
    <x-slot name="header">Manajemen Otoritas Struktural</x-slot>

    <div class="max-w-4xl mx-auto space-y-5">
        <div class="bg-white rounded-[40px] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                <h3 class="font-serif-classic text-2xl text-slate-900">Registrasi Manager & Supervisor</h3>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-5 space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Email Kantor</label>
                        <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Kata Sandi (Password)</label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Role</label>
                        <select name="role" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200">
                            <option value="Manager">Manager</option>
                            <option value="Supervisor">Supervisor</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Departemen</label>
                        <input type="text" name="department" placeholder="Contoh: Produksi" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Section</label>
                        <input type="text" name="section" placeholder="Contoh: Finishing" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200">
                    </div>
                </div>

                <button type="submit" class="w-full py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.3em] rounded-2xl shadow-xl hover:bg-black transition">
                    Daftarkan Pejabat Struktural
                </button>
            </form>
        </div>

        <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden mt-12">
            <div class="p-8 border-b border-slate-100 flex justify-between items-center">
                <h4 class="font-serif-classic text-xl text-slate-900">Daftar Pejabat Struktural Aktif</h4>
            </div>
            
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="p-6">Nama Pejabat</th>
                        <th class="p-6">Email Kantor</th>
                        <th class="p-6">Role / Jabatan</th>
                        <th class="p-6 text-right">Departemen & Section</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition duration-300">
                        <td class="p-6">
                            <span class="font-bold text-slate-900 block">{{ $user->name }}</span>
                        </td>
                        <td class="p-6 text-sm text-slate-500 italic">{{ $user->email }}</td>
                        <td class="p-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest 
                                {{ $user->role == 'Manager' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <span class="text-xs font-semibold text-slate-900 block">{{ $user->department }}</span>
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $user->section }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center text-slate-400 italic">Belum ada pejabat struktural yang didaftarkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>