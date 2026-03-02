<x-app-layout>
    {{-- ================= ALERTS (Glassmorphism style) ================= --}}
    <div class="fixed top-5 right-5 z-[100] space-y-3">
        @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="bg-emerald-500/10 border border-emerald-500 text-emerald-500 px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-md flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
            class="bg-red-500/10 border border-[#7d2020] text-[#7d2020] px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-md flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        @endif
    </div>

    {{-- ================= HEADER SECTION ================= --}}
    <div class="bg-[#1a1a1a] border-b border-gray-800 pt-10 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <nav class="flex mb-4 text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-[#7d2020]">Détails Coloc</span>
                    </nav>
                    <h2 class="text-5xl font-black text-white tracking-tighter uppercase italic">
                        {{ $colocation->name }}
                    </h2>
                    <div class="flex items-center gap-3 mt-3">
                        <span class="px-3 py-1 bg-[#2d2d2d] border border-gray-700 text-gray-400 text-[10px] font-bold rounded-full uppercase tracking-widest">
                            Status: <span class="text-emerald-500">{{ $colocation->status }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('expenses.index', $colocation) }}" 
                       class="px-8 py-4 bg-[#7d2020] text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-[#7d2020]/20 hover:bg-[#922a2a] transition-all transform hover:-translate-y-1">
                        <i class="fas fa-plus-circle mr-2"></i> Nouvelle Dépense
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ openInvite: false }" class="bg-[#1a1a1a] min-h-screen -mt-10 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ================= LEFT COLUMN ================= --}}
            <div class="space-y-8">
                {{-- MEMBERS CARD --}}
                <div class="bg-[#262626] p-8 rounded-[2.5rem] border border-gray-800 shadow-2xl">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="font-black text-white uppercase text-xs tracking-[0.2em]">
                            <i class="fas fa-users text-[#7d2020] mr-2"></i> Membres
                        </h3>
                        @if(auth()->id() === $colocation->owner_id)
                        <button @click="openInvite = true" class="text-[9px] bg-white text-black px-3 py-1.5 rounded-full font-black uppercase tracking-tighter hover:bg-[#7d2020] hover:text-white transition-colors">
                            + Inviter
                        </button>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @foreach($colocation->members as $member)
                        <div class="flex items-center justify-between p-4 bg-[#1a1a1a] rounded-2xl border border-gray-800 group hover:border-gray-600 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#7d2020] rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $member->name }}</p>
                                    <p class="text-[9px] text-gray-500 uppercase font-black tracking-widest">{{ $member->pivot->role }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-800 group-hover:text-gray-400 transition"></i>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- CATEGORIES CARD --}}
                <div class="bg-[#262626] p-8 rounded-[2.5rem] border border-gray-800 shadow-2xl">
                    <h3 class="font-black text-white uppercase text-xs tracking-[0.2em] mb-8">
                        <i class="fas fa-tags text-[#7d2020] mr-2"></i> Catégories
                    </h3>
                    @include('colocation.categories.index', [
                        'globalCategories' => $globalCategories,
                        'colocationCategories' => $colocationCategories,
                        'colocation' => $colocation,
                    ])
                </div>
            </div>

            {{-- ================= RIGHT COLUMN (Main Stats & History) ================= --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- QUICK STATS (Optional extra) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-[#7d2020] p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group">
                        <i class="fas fa-wallet absolute -right-4 -bottom-4 text-8xl opacity-10 group-hover:scale-110 transition-transform"></i>
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Total Dépenses</p>
                        <h4 class="text-4xl font-black mt-2 tracking-tighter">{{ $colocation->expenses->sum('amount') }} MAD</h4>
                    </div>
                    <div class="bg-[#2d2d2d] p-8 rounded-[2.5rem] text-white border border-gray-700 shadow-2xl group">
                         <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Membres Actifs</p>
                         <h4 class="text-4xl font-black mt-2 tracking-tighter">{{ $colocation->members->count() }}</h4>
                    </div>
                </div>

                {{-- ACTIVITY/HISTORY CARD --}}
                <div class="bg-[#262626] p-8 rounded-[3rem] border border-gray-800 shadow-2xl">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="font-black text-white uppercase text-xs tracking-[0.2em]">
                            <i class="fas fa-stream text-[#7d2020] mr-2"></i> Dernières Activités
                        </h3>
                        <a href="{{ route('expenses.index', $colocation) }}" class="text-[10px] text-gray-500 hover:text-white uppercase font-bold tracking-widest transition">Voir tout <i class="fas fa-external-link-alt ml-1"></i></a>
                    </div>

                    <div class="space-y-4">
                        @if($colocation->expenses->count())
                            @foreach($colocation->expenses->sortByDesc('created_at')->take(5) as $expense)
                            <div class="flex items-center justify-between p-6 bg-[#1a1a1a] rounded-[2rem] border border-gray-800 hover:bg-[#2d2d2d] transition-all group">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-[#2d2d2d] group-hover:bg-[#7d2020] rounded-2xl flex items-center justify-center text-white transition-colors shadow-inner">
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-white tracking-tight">{{ $expense->description }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mt-1">
                                            {{ $expense->category->name }} • {{ $expense->created_at->format('d M') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-black text-[#7d2020] tracking-tighter">{{ $expense->amount }} MAD</p>
                                    <p class="text-[9px] text-gray-600 font-bold uppercase italic">Validé</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-20 bg-[#1a1a1a] rounded-[2rem] border border-dashed border-gray-800">
                                <i class="fas fa-ghost text-4xl text-gray-800 mb-4"></i>
                                <p class="text-gray-600 text-sm font-light italic">Aucune dépense enregistrée.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- INVITE MODAL (Redesigned) --}}
        <div x-show="openInvite" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-[110] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="openInvite = false"></div>
            
            <div class="bg-[#2d2d2d] rounded-[2.5rem] border border-gray-800 shadow-2xl w-full max-w-md relative z-10 overflow-hidden">
                <form action="{{ route('colocation.invite', $colocation->id) }}" method="POST" class="p-10">
                    @csrf
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-[#7d2020]/20 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-paper-plane text-[#7d2020] text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Nouveau Coloc</h3>
                        <p class="text-gray-500 text-[10px] uppercase font-bold tracking-widest mt-2">Envoyez une invitation par email</p>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-gray-500 mb-2 block group-focus-within:text-[#7d2020] transition-colors">Adresse Email</label>
                        <input type="email" name="email" required placeholder="coloc@example.com"
                            class="w-full bg-[#1a1a1a] border-gray-800 rounded-2xl py-4 px-5 text-white focus:ring-[#7d2020] focus:border-[#7d2020] transition-all">
                    </div>

                    <div class="mt-10 flex flex-col gap-3">
                        <button type="submit" class="w-full bg-[#7d2020] text-white font-black py-4 rounded-2xl uppercase text-xs tracking-[0.2em] shadow-xl hover:bg-[#922a2a] transition-all">
                            Envoyer l'invitation
                        </button>
                        <button type="button" @click="openInvite = false" class="text-gray-600 hover:text-white text-[10px] font-bold uppercase tracking-widest py-2 transition">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>