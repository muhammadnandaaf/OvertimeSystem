<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Overtime Letter System') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif-classic { font-family: 'Playfair Display', serif; }
        .sidebar-active { background: rgba(15, 23, 42, 0.05); border-right: 4px solid #0f172a; }

        @media print {
            /* 1. Sembunyikan semua elemen UI kecuali konten cetak */
            aside, header, footer, .print\:hidden, button, nav {
                display: none !important;
            }

            /* 2. Reset paksa semua pembungkus agar tidak ada sisa tinggi */
            html, body {
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            /* 3. Hilangkan padding pada pembungkus layout Laravel */
            main, .p-12, .p-16, .max-w-4xl, .space-y-6 {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }

            /* 4. Pastikan kartu surat tidak memiliki bayangan atau tinggi minimal yang berlebih */
            .printable-content {
                box-shadow: none !important;
                border: none !important;
                min-height: 0 !important; /* Hilangkan min-h-[1000px] saat print */
                padding: 0 !important;
            }

            /* 5. Cegah page break di tengah tabel */
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
        }
    </style>
</head>
<body class="bg-[#f8fafc]">
    <div class="flex min-h-screen">
        <aside class="w-72 bg-white border-r border-slate-200 flex flex-col shadow-sm sticky top-0 h-screen overflow-y-auto">
            <div class="p-8">
                <div class="flex items-center gap-3 mb-10">
                    <div class="h-10 w-10 bg-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-serif-classic text-2xl tracking-tight text-slate-900">Overtime System</span>
                </div>

                <nav class="space-y-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    @if(Auth::user()->role == 'Supervisor')
                        <a href="{{ route('spl.create') }}" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Create New Overtime Letter
                        </a>
                    @endif

                    @if(Auth::user()->role == 'Manager')
                        <a href="{{ route('manager.index') }}" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Manager Approval
                        </a>
                    @endif

                    @if(Auth::user()->role == 'Admin SDM')
                        <a href="{{ route('sdm.index') }}" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            HR Verification
                        </a>
                    @endif

                    @if(Auth::user()->role == 'Admin SDM')
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Structural Management (Manager/SPV)
                        </a>
                    @endif

                    @if(Auth::user()->role == 'Supervisor')
                        <a href="{{ route('spv.users.index') }}" class="flex items-center gap-3 p-4 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Register Team Members (Employees)
                        </a>
                    @endif
                </nav>
            </div>

            <div class="mt-auto p-8 border-t border-slate-100">
                <div class="mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Active User</p>
                    <p class="text-sm font-bold text-slate-900 mt-1">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500 italic">{{ Auth::user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs font-bold text-red-500 uppercase tracking-widest hover:text-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1">
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center px-12 sticky top-0 z-10">
                <h2 class="font-serif-classic text-xl text-slate-900">{{ $header ?? 'Dashboard' }}</h2>
            </header>

            <div class="p-12">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>