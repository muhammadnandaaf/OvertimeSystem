<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem SPL - Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-serif-classic { font-family: 'Playfair Display', serif; }
            .glass-effect {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="antialiased bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-slate-200 via-slate-100 to-indigo-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="mb-8 transition-transform hover:scale-110 duration-500">
                <div class="h-20 w-20 bg-slate-900 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(0,0,0,0.1)] border-4 border-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 glass-effect shadow-[0_20px_50px_rgba(0,0,0,0.1)] sm:rounded-[40px]">
                {{ $slot }}
            </div>

            <footer class="mt-12 text-center">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-[0.3em] opacity-80">
                    &mdash; Est. 2026 HR Management &mdash;
                </p>
            </footer>
        </div>
    </body>
</html>