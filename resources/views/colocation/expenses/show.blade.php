<x-app-layout>
    <div class="min-h-screen bg-[#1a1a1a] py-12 px-4 font-sans text-white">
        <div class="max-w-2xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-10 flex justify-between items-center">
                <div>
                    <nav class="flex mb-2 text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">
                        <a href="{{ route('expenses.index', $colocation) }}" class="hover:text-white transition">Dépenses</a>
                        <span class="mx-2">/</span>
                        <span class="text-[#7d2020]">Détails</span>
                    </nav>
                    <h1 class="text-3xl font-black uppercase italic tracking-tighter">Récapitulatif</h1>
                </div>
                <a href="{{ route('expenses.index', $colocation) }}" class="p-3 bg-[#262626] rounded-xl text-gray-400 hover:text-white border border-gray-800 transition">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            {{-- Main Card --}}
            <div class="bg-[#262626] rounded-[2.5rem] border border-gray-800 shadow-2xl overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#7d2020]"></div>
                
                <div class="p-10 text-center">
                    {{-- Icon Category --}}
                    <div class="w-20 h-20 bg-[#1a1a1a] border border-gray-700 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <i class="fas fa-file-invoice-dollar text-[#7d2020] text-3xl"></i>
                    </div>

                    <h2 class="text-2xl font-black uppercase tracking-tight mb-2">{{ $expense->description }}</h2>
                    <span class="px-4 py-1 bg-[#7d2020]/10 border border-[#7d2020]/30 text-[#7d2020] text-[10px] font-black rounded-full uppercase tracking-widest">
                        {{ $expense->category->name }}
                    </span>

                    <div class="my-10 py-8 border-y border-gray-800/50">
                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-[0.2em] mb-2">Montant de la transaction</p>
                        <div class="text-5xl font-black tracking-tighter text-white">
                            {{ number_format($expense->amount, 2, '.', ' ') }} <span class="text-[#7d2020] italic text-xl">MAD</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 text-left">
                        <div class="bg-[#1a1a1a] p-5 rounded-2xl border border-gray-800">
                            <p class="text-[9px] text-gray-600 uppercase font-black mb-2 tracking-widest">Payé par</p>
                            <p class="text-sm font-bold text-gray-200 flex items-center gap-2">
                                <i class="fas fa-user-circle text-[#7d2020]"></i> {{ $expense->user->name }}
                            </p>
                        </div>
                        <div class="bg-[#1a1a1a] p-5 rounded-2xl border border-gray-800">
                            <p class="text-[9px] text-gray-600 uppercase font-black mb-2 tracking-widest">Date</p>
                            <p class="text-sm font-bold text-gray-200 flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-[#7d2020]"></i> {{ $expense->date->format('d F Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Bottom Actions --}}
                    <div class="mt-10 flex gap-4">
                        @if(auth()->id() === $expense->user_id || auth()->id() === $colocation->owner_id)
                            <a href="{{ route('expenses.edit', [$colocation, $expense]) }}" 
                               class="flex-1 bg-white text-black font-black py-4 rounded-2xl uppercase text-[10px] tracking-widest hover:bg-[#7d2020] hover:text-white transition-all shadow-xl shadow-white/5">
                                Modifier la dépense
                            </a>
                            
                            <form action="{{ route('expenses.destroy', [$colocation, $expense]) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer définitivement ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-4 bg-[#1a1a1a] text-gray-500 hover:text-[#7d2020] border border-gray-800 rounded-2xl transition-all">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <p class="mt-8 text-center text-[9px] text-gray-700 uppercase font-black tracking-[0.4em]">Transaction ID: #00{{ $expense->id }}</p>
        </div>
    </div>
</x-app-layout>