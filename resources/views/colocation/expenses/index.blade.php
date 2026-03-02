<x-app-layout>
    <div class="min-h-screen bg-[#1a1a1a] py-12 px-4 font-sans text-white">
        <div class="max-w-5xl mx-auto">
            
            {{-- ================= HEADER SECTION ================= --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 text-center md:text-left">
                <div>
                    <nav class="flex mb-4 text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold justify-center md:justify-start">
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('colocation.show', $colocation) }}" class="hover:text-white transition">{{ $colocation->name }}</a>
                        <span class="mx-2 text-[#7d2020]">/</span>
                        <span class="text-[#7d2020]">Dépenses</span>
                    </nav>
                    <h1 class="text-5xl font-black uppercase italic tracking-tighter">
                        Journal des <span class="text-[#7d2020]">Dépenses</span>
                    </h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('colocation.show', $colocation) }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white transition">
                        <i class="fas fa-arrow-left mr-2"></i> Retour
                    </a>
                    <a href="{{ route('expenses.create', $colocation) }}" 
                       class="px-8 py-4 bg-[#7d2020] hover:bg-[#922a2a] text-white rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-xl shadow-[#7d2020]/20 transition-all transform hover:-translate-y-1">
                        + Nouvelle Dépense
                    </a>
                </div>
            </div>

            {{-- ================= ALERTS ================= --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                 class="mb-8 p-5 bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 rounded-2xl flex items-center gap-4 backdrop-blur-md">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="text-sm font-bold uppercase tracking-wide">{{ session('success') }}</span>
            </div>
            @endif

            {{-- ================= LIST SECTION ================= --}}
            @if($expenses->count() > 0)
            <div class="space-y-4">
                @foreach($expenses->sortByDesc('date') as $expense)
                <div class="group bg-[#262626] border border-gray-800 p-6 rounded-[2rem] hover:border-[#7d2020]/50 transition-all duration-300 shadow-xl relative overflow-hidden">
                    
                    {{-- Hover Effect Background --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-[#7d2020]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                        
                        {{-- Left: Icon & Info --}}
                        <div class="flex items-center gap-6 flex-1 w-full">
                            <div class="w-16 h-16 bg-[#1a1a1a] border border-gray-700 rounded-[1.5rem] flex flex-col items-center justify-center group-hover:bg-[#7d2020] group-hover:border-[#7d2020] transition-colors duration-500 shadow-inner">
                                <span class="text-[10px] font-black uppercase text-gray-500 group-hover:text-white/80">{{ $expense->date->format('M') }}</span>
                                <span class="text-xl font-black group-hover:text-white">{{ $expense->date->format('d') }}</span>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="text-lg font-black tracking-tight text-white group-hover:text-[#7d2020] transition-colors uppercase">
                                        {{ $expense->description }}
                                    </h3>
                                    <span class="px-3 py-1 bg-[#1a1a1a] border border-gray-800 text-gray-500 text-[9px] font-black rounded-full uppercase tracking-widest">
                                        {{ $expense->category->name }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest flex items-center gap-2">
                                    <i class="fas fa-user-circle text-[#7d2020]"></i> Payé par <span class="text-gray-300">{{ $expense->user->name }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Center: Amount --}}
                        <div class="text-center md:text-right px-6 border-x border-gray-800/50 md:min-w-[150px]">
                            <p class="text-2xl font-black tracking-tighter text-white">
                                {{ number_format($expense->amount, 2, '.', ' ') }} <span class="text-[#7d2020] text-sm italic">MAD</span>
                            </p>
                        </div>

                        {{-- Right: Quick Actions --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('expenses.show', [$colocation, $expense]) }}" 
                               class="p-4 bg-[#1a1a1a] hover:bg-white hover:text-black rounded-2xl border border-gray-800 transition-all shadow-lg" title="Détails">
                                <i class="fas fa-eye text-xs"></i>
                            </a>

                            @if(auth()->id() === $expense->user_id)
                            <a href="{{ route('expenses.edit', [$colocation, $expense]) }}" 
                               class="p-4 bg-[#1a1a1a] hover:bg-emerald-600 hover:text-white rounded-2xl border border-gray-800 transition-all shadow-lg" title="Modifier">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            @endif

                            @if(auth()->id() === $expense->user_id || auth()->id() === $colocation->owner_id)
                            <form action="{{ route('expenses.destroy', [$colocation, $expense]) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette dépense ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-4 bg-[#1a1a1a] hover:bg-[#7d2020] hover:text-white rounded-2xl border border-gray-800 transition-all shadow-lg" title="Supprimer">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- ================= EMPTY STATE ================= --}}
            @else
            <div class="bg-[#262626] rounded-[3rem] border border-dashed border-gray-800 p-20 text-center">
                <div class="w-20 h-20 bg-[#1a1a1a] rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-receipt text-gray-700 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-black text-white uppercase italic tracking-tight">Rien à signaler</h2>
                <p class="text-gray-500 text-sm mt-2 max-w-xs mx-auto">Aucune dépense n'a été ajoutée pour le moment dans cette colocation.</p>
                <a href="{{ route('expenses.create', $colocation) }}" class="mt-8 inline-block px-10 py-4 bg-white text-black font-black rounded-2xl uppercase text-[10px] tracking-[0.2em] hover:bg-[#7d2020] hover:text-white transition-all">
                    Lancer la première
                </a>
            </div>
            @endif

            {{-- Footer info --}}
            <div class="mt-12 text-center">
                 <p class="text-[9px] text-gray-600 uppercase font-black tracking-[0.4em]">EasyColoc Ledger System v2.1</p>
            </div>
        </div>
    </div>
</x-app-layout>