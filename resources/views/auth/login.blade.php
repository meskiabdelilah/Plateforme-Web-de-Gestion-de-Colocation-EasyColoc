<x-guest-layout>
    <div class="min-h-screen bg-[#1a1a1a] flex items-center justify-center py-12 px-4 font-sans">
        <div class="bg-[#2d2d2d] rounded-[2rem] shadow-2xl flex flex-col md:flex-row w-full max-w-5xl overflow-hidden min-h-[600px] border border-gray-800">
            
            <div class="hidden md:flex md:w-1/2 bg-[#333333] p-12 flex-col justify-between relative border-r border-gray-800">
                <div class="">
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        Easy<span class="text-[#7d2020]">Coloc</span>
                    </h2>
                </div>
                
                <div class="relative py-10 text-center">
                    <img src="{{ asset('images/illustration.png') }}" alt="Login Illustration" class="w-full h-auto opacity-70 grayscale hover:grayscale-0 transition-all duration-700">
                    <h3 class="text-white text-xl font-light mt-6">Welcome Back!</h3>
                    <p class="text-gray-500 text-sm mt-2">Manage your shared expenses effortlessly.</p>
                </div>

                <div class="text-gray-600 text-[10px] uppercase tracking-[0.3em]">
                    Secure Access Panel
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center bg-[#262626]">
                <div class="text-center mb-12">
                    <h1 class="text-white text-5xl font-bold mb-3 tracking-tight">Log in</h1>
                    <p class="text-gray-500 text-sm italic">Enter your credentials to continue</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf
                    
                    <div class="group">
                        <label for="email" class="text-gray-500 text-xs mb-1 block group-focus-within:text-[#7d2020] transition-colors font-bold uppercase tracking-wider">Email Address</label>
                        <div class="relative border-b border-gray-700 group-focus-within:border-[#7d2020] transition-colors">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="mail@example.com" required autofocus autocomplete="username"
                                class="w-full bg-transparent border-none py-3 px-0 text-white focus:ring-0 placeholder-gray-700">
                            <i class="absolute right-0 top-3 text-gray-700 fas fa-at text-sm"></i>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="group">
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="text-gray-500 text-xs block group-focus-within:text-[#7d2020] font-bold uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[10px] text-gray-600 hover:text-[#7d2020] transition-colors uppercase">Forgot?</a>
                            @endif
                        </div>
                        <div class="relative border-b border-gray-700 group-focus-within:border-[#7d2020]">
                            <input id="password" type="password" name="password" placeholder="••••••••••••" required autocomplete="current-password"
                                class="w-full bg-transparent border-none py-3 px-0 text-white focus:ring-0 placeholder-gray-700 tracking-[0.3em] text-xs">
                            <i class="absolute right-0 top-3 text-gray-700 fas fa-lock text-sm"></i>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-700 bg-transparent text-[#7d2020] focus:ring-[#7d2020] focus:ring-offset-[#262626]">
                        <span class="ml-2 text-xs text-gray-500 uppercase tracking-widest">Keep me logged in</span>
                    </div>

                    <button type="submit" class="w-full bg-[#7d2020] hover:bg-[#9c2929] text-white font-bold py-4 rounded-full mt-6 transition-all duration-300 shadow-2xl shadow-black/40 uppercase text-xs tracking-[0.2em]">
                        Sign In
                    </button>
                </form>

                <div class="text-center mt-12">
                    <p class="text-gray-600 text-xs uppercase tracking-widest">
                        New here? 
                        <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors underline underline-offset-8 decoration-[#7d2020]">
                            Create Account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>