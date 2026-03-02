<x-guest-layout>
    <div class="min-h-screen bg-[#1a1a1a] flex items-center justify-center p-4 font-sans">
        <div class="bg-[#2d2d2d] rounded-[3rem] shadow-2xl w-full max-w-md overflow-hidden border border-gray-800 relative">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-[#7d2020]"></div>

            <div class="p-10 md:p-14 text-center">
                <div class="w-24 h-24 bg-[#7d2020]/10 rounded-[2rem] flex items-center justify-center mx-auto mb-8 transform -rotate-6 group-hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-envelope-open-text text-[#7d2020] text-4xl"></i>
                </div>

                <h2 class="text-white text-3xl font-black mb-4 tracking-tighter uppercase italic">
                    Invitation <span class="text-[#7d2020]">reçue !</span>
                </h2>
                
                <p class="text-gray-400 text-sm leading-relaxed mb-10 font-light">
                    Vous avez été invité à rejoindre l'aventure de la colocation 
                    <span class="block text-white font-black text-lg mt-2 uppercase tracking-tight group">
                        "{{ $invitation->colocation->name }}"
                    </span>
                </p>

                <div class="flex flex-col gap-4">
                    <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-[#7d2020] hover:bg-[#922a2a] text-white font-black py-5 rounded-2xl shadow-xl shadow-[#7d2020]/20 transition-all duration-300 transform hover:-translate-y-1 uppercase text-xs tracking-[0.2em]">
                            Accepter l'invitation
                        </button>
                    </form>

                    <form action="{{ route('invitations.reject', $invitation->token) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-transparent border border-gray-700 text-gray-500 hover:text-white hover:border-white py-4 rounded-2xl font-bold transition-all duration-300 uppercase text-[10px] tracking-widest">
                            Refuser l'accès
                        </button>
                    </form>
                </div>

                <p class="mt-8 text-[10px] text-gray-600 uppercase tracking-widest font-bold">
                    Easy<span class="text-[#7d2020]">Coloc</span> Management System
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>