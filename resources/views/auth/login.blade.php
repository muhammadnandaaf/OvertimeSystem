<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="font-serif-classic text-3xl text-slate-900 leading-tight">Welcome</h2>
        <p class="text-sm text-slate-500 mt-3 italic">Please sign in to manage overtime orders</p>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-8" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5"> <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
                Corporate Email Address
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all duration-300 shadow-sm" 
                placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5"> <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
                Password
            </label>
            <input id="password" type="password" name="password" required 
                class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 transition-all duration-300 shadow-sm" 
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between px-1 mb-12"> <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded-full border-slate-300 text-slate-900 shadow-sm focus:ring-slate-900 transition cursor-pointer" name="remember">
                <span class="ms-3 text-xs font-semibold text-slate-500 group-hover:text-slate-900 transition tracking-wide">Remember me</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-slate-900 hover:text-indigo-600 transition decoration-2 underline-offset-4" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" 
                class="w-full py-5 bg-slate-900 hover:bg-black text-white text-[11px] font-black uppercase tracking-[0.3em] rounded-2xl shadow-[0_15px_30px_rgba(0,0,0,0.2)] transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                Sign In to System
            </button>
        </div>
    </form>
</x-guest-layout>
