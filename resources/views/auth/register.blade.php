<x-guest-layout>
    <div class="min-h-screen bg-[#1a1a1a] flex items-center justify-center p-4 font-sans">
        <div class="bg-[#2d2d2d] rounded-[2rem] shadow-2xl flex flex-col md:flex-row w-full max-w-5xl overflow-hidden min-h-[700px] border border-gray-800">
            
            <div class="hidden md:flex md:w-1/2 bg-[#333333] p-12 flex-col items-center justify-center relative border-r border-gray-800">
                <div class="absolute top-12 left-12">
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        Easy<span class="text-[#7d2020]">Coloc</span>
                    </h2>
                </div>
                
                <div class="relative">
                    <img src="{{ asset('images/illustration.png') }}" alt="Illustration" class="w-full h-auto opacity-80">
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black/80 text-white text-[10px] font-bold px-3 py-1 rounded uppercase tracking-[0.2em] backdrop-blur-sm">
                        Upgrade Plan
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-14 flex flex-col justify-center bg-[#262626]">
                <div class="text-center mb-10">
                    <h1 class="text-white text-4xl font-bold mb-2 tracking-tight">Sign up</h1>
                    <p class="text-gray-400 text-sm italic">Join us to manage expenses easily</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <div class="group">
                        <label for="name" class="text-gray-500 text-xs mb-1 block group-focus-within:text-[#7d2020] transition-colors">Your full name</label>
                        <div class="relative border-b border-gray-700 group-focus-within:border-[#7d2020] transition-colors">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="First Last" required autofocus 
                                class="w-full bg-transparent border-none py-2 px-0 text-white focus:ring-0 placeholder-gray-600">
                            <i class="absolute right-0 top-2 text-gray-600 fas fa-id-card text-sm"></i>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="group">
                        <label for="email" class="text-gray-500 text-xs mb-1 block group-focus-within:text-[#7d2020] transition-colors">Email</label>
                        <div class="relative border-b border-gray-700 group-focus-within:border-[#7d2020] transition-colors">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Your email address" required 
                                class="w-full bg-transparent border-none py-2 px-0 text-white focus:ring-0 placeholder-gray-600">
                            <i class="absolute right-0 top-2 text-gray-600 fas fa-envelope text-sm"></i>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="group">
                        <label for="password" class="text-gray-500 text-xs mb-1 block group-focus-within:text-[#7d2020]">Set your password</label>
                        <div class="relative border-b border-gray-700 group-focus-within:border-[#7d2020]">
                            <input id="password" type="password" name="password" placeholder="••••••••••••••••" required 
                                class="w-full bg-transparent border-none py-2 px-0 text-white focus:ring-0 placeholder-gray-600 text-xs tracking-widest">
                            <i class="absolute right-0 top-2 text-gray-600 fas fa-key text-sm"></i>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="group">
                        <label for="password_confirmation" class="text-gray-500 text-xs mb-1 block group-focus-within:text-[#7d2020]">Re-enter</label>
                        <div class="relative border-b border-gray-700 group-focus-within:border-[#7d2020]">
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••••••••••" required 
                                class="w-full bg-transparent border-none py-2 px-0 text-white focus:ring-0 placeholder-gray-600 text-xs tracking-widest">
                            <i class="absolute right-0 top-2 text-gray-600 fas fa-lock text-sm"></i>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 pt-2">
                        <input type="checkbox" id="terms" required class="w-4 h-4 rounded border-gray-700 bg-transparent text-[#7d2020] focus:ring-[#7d2020] focus:ring-offset-[#262626]">
                        <label for="terms" class="text-gray-500 text-[11px]">I accept <span class="text-gray-300 hover:underline cursor-pointer">Terms and Privacy</span>.</label>
                    </div>

                    <button type="submit" class="w-full bg-[#7d2020] hover:bg-[#922a2a] text-white font-bold py-4 rounded-full mt-4 transition-all duration-300 shadow-xl shadow-black/20 uppercase text-xs tracking-widest">
                        Register
                    </button>
                </form>

                <div class="text-center mt-8">
                    <a href="{{ route('login') }}" class="text-gray-500 text-xs hover:text-white transition-colors">
                        Already have an account? <span class="underline underline-offset-4 decoration-gray-700">Log in</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>