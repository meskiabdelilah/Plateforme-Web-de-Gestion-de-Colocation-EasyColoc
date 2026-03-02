<x-app-layout>
    <div class="min-h-screen bg-[#1a1a1a] py-12 px-4 font-sans">
        <div class="max-w-xl mx-auto">
            
            {{-- Header Section --}}
            <div class="mb-10 text-center md:text-left">
                <nav class="flex mb-4 text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold justify-center md:justify-start">
                    <a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('colocation.show', $colocation) }}" class="hover:text-white transition">{{ $colocation->name }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#7d2020]">Modifier</span>
                </nav>
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <div class="w-12 h-12 bg-[#7d2020]/20 rounded-2xl flex items-center justify-center text-[#7d2020]">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                    <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter">
                        Modifier la <span class="text-[#7d2020]">Dépense</span>
                    </h1>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="bg-[#262626] rounded-[2.5rem] border border-gray-800 shadow-2xl p-8 md:p-10 relative overflow-hidden">
                {{-- Decorative Glow Background --}}
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-[#7d2020]/10 rounded-full blur-3xl"></div>

                <form action="{{ route('expenses.update', [$colocation, $expense]) }}" method="POST" class="space-y-8 relative z-10">
                    @csrf
                    @method('PUT')

                    {{-- Description --}}
                    <div class="group">
                        <label for="description" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 group-focus-within:text-[#7d2020] transition-colors">
                            Description de l'achat
                        </label>
                        <input type="text" id="description" name="description" 
                            class="w-full bg-[#1a1a1a] border-gray-800 rounded-2xl py-4 px-5 text-white focus:ring-[#7d2020] focus:border-[#7d2020] placeholder-gray-700 transition-all shadow-inner @error('description') border-red-500 @enderror"
                            value="{{ old('description', $expense->description) }}" required>
                        @error('description')
                            <p class="text-[#7d2020] text-[10px] font-bold mt-2 uppercase italic tracking-wide">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Category --}}
                        <div class="group">
                            <label for="category_id" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 group-focus-within:text-[#7d2020]">
                                Catégorie
                            </label>
                            <select id="category_id" name="category_id"
                                class="w-full bg-[#1a1a1a] border-gray-800 rounded-2xl py-4 px-5 text-white focus:ring-[#7d2020] focus:border-[#7d2020] transition-all cursor-pointer @error('category_id') border-red-500 @enderror"
                                required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }} class="bg-[#262626]">
                                        {{ $category->name }} {{ $category->colocation_id === null ? '(Standard)' : '(Perso)' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date --}}
                        <div class="group">
                            <label for="date" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 group-focus-within:text-[#7d2020]">
                                Date de paiement
                            </label>
                            <input type="date" id="date" name="date"
                                class="w-full bg-[#1a1a1a] border-gray-800 rounded-2xl py-4 px-5 text-white focus:ring-[#7d2020] focus:border-[#7d2020] transition-all"
                                value="{{ old('date', $expense->date->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div class="group">
                        <label for="amount" class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 group-focus-within:text-[#7d2020]">
                            Montant Total (MAD)
                        </label>
                        <div class="relative">
                            <input type="number" id="amount" name="amount" step="0.01" min="0"
                                class="w-full bg-[#1a1a1a] border-gray-800 rounded-2xl py-5 px-5 text-3xl font-black text-white focus:ring-[#7d2020] focus:border-[#7d2020] transition-all"
                                value="{{ old('amount', $expense->amount) }}" required>
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[#7d2020] font-black text-xl italic">
                                MAD
                            </div>
                        </div>
                        @error('amount')
                            <p class="text-[#7d2020] text-[10px] font-bold mt-2 uppercase italic tracking-wide">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-gray-800">
                        <button type="submit" class="flex-1 px-8 py-5 bg-[#7d2020] hover:bg-[#922a2a] text-white font-black rounded-2xl shadow-xl shadow-[#7d2020]/20 transition-all transform hover:-translate-y-1 uppercase text-xs tracking-[0.2em]">
                            Mettre à jour
                        </button>
                        <a href="{{ route('expenses.index', $colocation) }}" class="px-8 py-5 bg-[#2d2d2d] text-gray-500 hover:text-white font-black rounded-2xl border border-gray-700 hover:border-white transition-all text-center uppercase text-[10px] tracking-widest flex items-center justify-center">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
            
            <p class="mt-8 text-center text-[9px] text-gray-600 uppercase tracking-[0.4em] font-bold opacity-50">
                EasyColoc System v2.0
            </p>
        </div>
    </div>
</x-app-layout>