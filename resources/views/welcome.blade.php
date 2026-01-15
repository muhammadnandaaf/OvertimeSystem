<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Overtime System - HR Department</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans antialiased text-slate-900">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="bg-white p-10 rounded-3xl shadow-2xl max-w-lg w-full text-center border border-slate-200">
            <div class="mx-auto h-20 w-20 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Overtime Management System</h1>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Employee Overtime Management <br>
                <span class="font-semibold text-indigo-600 tracking-widest uppercase text-xs">Transparent & Accurate</span>
            </p>

            <div class="space-y-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-indigo-200">
                        Open Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-indigo-200 text-lg">
                        Log In to System
                    </a>
                @endauth
            </div>
            
            <p class="mt-8 text-[10px] text-slate-400 uppercase tracking-[0.2em]">
                &copy; 2026 IT System - HR Department
            </p>
        </div>

    </div>
</body>
</html>