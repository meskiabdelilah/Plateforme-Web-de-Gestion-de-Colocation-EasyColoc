<x-app-layout>
    <div class="fixed top-5 right-5 z-[100] space-y-3">
        @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            class="bg-emerald-500/10 border border-emerald-500 text-emerald-500 px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-md flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            class="bg-red-500/10 border border-[#7d2020] text-[#7d2020] px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-md flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            <span class="text-sm font-bold">{{ session('error') ?? 'Erreur' }}</span>
        </div>
        @endif
    </div>

    <div class="py-12 bg-[#1a1a1a] min-h-screen" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">

                <aside class="w-full md:w-1/4 order-2 md:order-1">
                    <div class="bg-[#262626] p-6 rounded-[2rem] border border-gray-800 shadow-xl">
                        <h3 class="font-bold text-white mb-6 flex items-center uppercase tracking-widest text-xs">
                            <i class="fas fa-history mr-2 text-[#7d2020]"></i>
                            Historique
                        </h3>
                        <ul class="space-y-4">
                            @forelse($historyColocations as $history)
                            <li class="group p-4 bg-[#2d2d2d] rounded-2xl border border-gray-800 hover:border-[#7d2020]/50 transition-all duration-300">
                                <span class="font-bold text-gray-200 block group-hover:text-white transition">{{ $history->name }}</span>
                                <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-tighter italic">Quitté le : {{ $history->pivot->left_at->format('d/m/Y') }}</p>
                            </li>
                            @empty
                            <div class="text-center py-6">
                                <p class="text-xs text-gray-600 italic font-light">Aucun historique disponible.</p>
                            </div>
                            @endforelse
                        </ul>
                    </div>
                </aside>

                <main class="w-full md:w-3/4 order-1 md:order-2">
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <h2 class="text-4xl font-black text-white tracking-tight italic uppercase">Mes <span class="text-[#7d2020]">Colocs</span></h2>
                            <p class="text-gray-500 text-sm mt-1 uppercase tracking-widest font-light">Gérez vos espaces partagés</p>
                        </div>

                        @if($activeColocations->isEmpty())
                        <button @click="open = true" class="inline-flex items-center px-6 py-3 bg-[#7d2020] hover:bg-[#922a2a] text-white text-xs font-bold rounded-full shadow-lg transition-all transform hover:scale-105 active:scale-95 uppercase tracking-widest">
                            <i class="fas fa-plus mr-2"></i> Nouvelle
                        </button>
                        @else
                        <span class="text-[10px] font-bold text-gray-500 bg-[#262626] border border-gray-800 px-4 py-2 rounded-full uppercase tracking-widest">
                            Limite atteinte (1/1)
                        </span>
                        @endif
                    </div>

                    @if($activeColocations->isEmpty())
                    <div @click="open = true" class="group relative overflow-hidden cursor-pointer flex flex-col items-center justify-center p-20 bg-[#262626] border-2 border-dashed border-gray-800 rounded-[3rem] hover:border-[#7d2020]/40 transition-all duration-500">
                        <div class="absolute inset-0 bg-[#7d2020]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="bg-[#2d2d2d] p-6 rounded-full group-hover:rotate-12 transition-transform duration-500 shadow-2xl border border-gray-800">
                            <i class="fas fa-house-user text-4xl text-[#7d2020]"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-white tracking-tight">Ajouter votre première colocation</h3>
                        <p class="text-gray-500 text-sm mt-2 font-light">Commencez l'aventure EasyColoc maintenant.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($activeColocations as $col)
                        <div class="bg-[#262626] p-8 rounded-[2.5rem] border border-gray-800 shadow-2xl group hover:border-[#7d2020]/30 transition-all duration-500">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex items-center gap-6">
                                    <div class="w-20 h-20 bg-[#2d2d2d] rounded-[1.5rem] flex items-center justify-center border border-gray-700 shadow-inner group-hover:scale-110 transition-transform">
                                        <i class="fas fa-home text-3xl text-[#7d2020]"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-black text-white tracking-tighter uppercase group-hover:text-[#7d2020] transition-colors">{{ $col->name }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-white bg-[#7d2020] px-3 py-1 rounded-full">
                                                {{ $col->pivot->role }}
                                            </span>
                                            <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest ml-2">
                                                <i class="fas fa-users mr-1"></i> {{ $col->members->count() }} Membres
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('colocation.show', $col->id) }}" class="w-full md:w-auto flex items-center justify-center gap-3 px-8 py-4 bg-[#2d2d2d] border border-gray-700 text-white rounded-2xl hover:bg-white hover:text-black transition-all font-bold uppercase text-xs tracking-[0.2em]">
                                    Ouvrir l'Espace
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-800 flex items-center justify-between">
                                <div class="flex -space-x-3">
                                    @foreach($col->members->take(5) as $member)
                                    <div class="w-10 h-10 rounded-full bg-[#333] border-2 border-[#262626] flex items-center justify-center text-xs font-bold text-white shadow-lg" title="{{ $member->name }}">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                    @endforeach
                                    @if($col->members->count() > 5)
                                    <div class="w-10 h-10 rounded-full bg-gray-800 border-2 border-[#262626] flex items-center justify-center text-[10px] font-bold text-gray-400">
                                        +{{ $col->members->count() - 5 }}
                                    </div>
                                    @endif
                                </div>
                                <span class="text-[10px] text-gray-600 uppercase tracking-widest font-bold">Mis à jour récemment</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </main>
            </div>
        </div>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/90 backdrop-blur-sm transition-opacity" @click="open = false"></div>
                <div class="bg-[#2d2d2d] rounded-[2.5rem] shadow-2xl border border-gray-800 transform transition-all sm:max-w-md sm:w-full z-50 overflow-hidden">
                    <form action="{{ route('colocation.store') }}" method="POST" class="p-10">
                        @csrf
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-[#7d2020]/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-plus text-[#7d2020] text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Nouvelle Maison</h3>
                            <p class="text-gray-500 text-xs mt-1 uppercase tracking-widest">Créez votre espace de partage</p>
                        </div>

                        <div class="space-y-6">
                            <div class="group">
                                <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest mb-2 block group-focus-within:text-[#7d2020]">Nom de l'appartement</label>
                                <input type="text" name="name" required placeholder="Ex: Loft Guéliz..." 
                                    class="w-full bg-[#1a1a1a] border-gray-800 rounded-xl py-4 px-4 text-white focus:ring-[#7d2020] focus:border-[#7d2020] placeholder-gray-700 transition-all">
                            </div>
                        </div>

                        <div class="mt-10 flex flex-col gap-3">
                            <button type="submit" class="w-full bg-[#7d2020] hover:bg-[#922a2a] text-white font-bold py-4 rounded-xl shadow-xl transition-all uppercase text-xs tracking-widest">
                                Créer maintenant
                            </button>
                            <button type="button" @click="open = false" class="w-full py-3 text-gray-500 hover:text-white text-[10px] uppercase font-bold tracking-[0.2em] transition-colors">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>