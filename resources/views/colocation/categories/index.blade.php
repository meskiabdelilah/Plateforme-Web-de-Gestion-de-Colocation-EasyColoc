<div x-data="{ editModal: false, currentCategory: {id: '', name: ''} }" class="text-white">

    {{-- ================= HEADER & ADD CATEGORY ================= --}}
    <div class="mb-8">
        <div class="flex flex-col gap-4">
            <h3 class="font-black text-white uppercase text-xs tracking-[0.2em] flex items-center">
                <i class="fas fa-folder-open text-[#7d2020] mr-2"></i> 
                Gestion des Catégories
            </h3>

            @if(isset($colocation) && auth()->id() === $colocation->owner_id)
            <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                <input type="text" name="name" placeholder="Nouvelle catégorie (ex: Internet, Gaz...)" 
                    class="flex-1 bg-[#1a1a1a] border-gray-800 rounded-xl py-3 px-4 text-sm text-white focus:ring-[#7d2020] focus:border-[#7d2020] placeholder-gray-600 transition-all" required>
                <button type="submit" class="bg-[#7d2020] hover:bg-[#922a2a] text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                    Ajouter
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- ================= CATEGORIES LIST ================= --}}
    <div class="space-y-6">
        
        {{-- Section: Global --}}
        @if(isset($globalCategories) && $globalCategories->count())
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 mb-3 ml-2">Standards (Global)</p>
            <div class="grid grid-cols-1 gap-2">
                @foreach($globalCategories as $category)
                <div class="flex justify-between items-center p-4 bg-[#1a1a1a]/50 rounded-2xl border border-gray-800 group transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-gray-700"></div>
                        <span class="text-sm font-bold text-gray-400">{{ $category->name }}</span>
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-tighter text-gray-600 italic">Lecture seule</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Section: Spécifiques --}}
        @if(isset($colocationCategories) && $colocationCategories->count())
        <div class="pt-4 border-t border-gray-800">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#7d2020] mb-3 ml-2">Personnalisées (Spécifiques)</p>
            <div class="grid grid-cols-1 gap-3">
                @foreach($colocationCategories as $category)
                <div class="flex justify-between items-center p-4 bg-[#1a1a1a] rounded-2xl border border-gray-800 hover:border-[#7d2020]/30 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#7d2020] shadow-[0_0_8px_#7d2020]"></div>
                        <span class="text-sm font-bold text-white uppercase tracking-tight">{{ $category->name }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if(isset($colocation) && auth()->id() === $colocation->owner_id)
                        <button @click="currentCategory.id='{{ $category->id }}'; currentCategory.name='{{ $category->name }}'; editModal = true;"
                            class="p-2 text-gray-500 hover:text-white transition-colors">
                            <i class="fas fa-edit text-xs"></i>
                        </button>

                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-500 hover:text-[#7d2020] transition-colors" onclick="return confirm('Supprimer cette catégorie ?')">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-[9px] font-black uppercase tracking-tighter text-gray-600">Privé</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Empty State --}}
        @if(!(isset($globalCategories) && $globalCategories->count()) && !(isset($colocationCategories) && $colocationCategories->count()))
        <div class="text-center py-10 bg-[#1a1a1a] rounded-2xl border border-dashed border-gray-800">
            <p class="text-gray-600 text-xs italic font-light">Aucune catégorie disponible.</p>
        </div>
        @endif
    </div>

    {{-- ================= EDIT MODAL (Redesigned) ================= --}}
    <div x-show="editModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm" x-cloak>
        
        <div class="bg-[#2d2d2d] p-8 rounded-[2rem] w-full max-w-md border border-gray-800 shadow-2xl" @click.away="editModal = false">
            <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-6 italic">Modifier <span class="text-[#7d2020]">Catégorie</span></h3>
            
            <form :action="'/categories/' + currentCategory.id" method="POST">
                @csrf
                @method('PUT')
                <div class="group mb-8">
                    <label class="text-[10px] font-black uppercase text-gray-500 mb-2 block group-focus-within:text-[#7d2020]">Nom de la catégorie</label>
                    <input type="text" name="name" x-model="currentCategory.name" 
                        class="w-full bg-[#1a1a1a] border-gray-800 rounded-xl py-4 px-4 text-white focus:ring-[#7d2020] focus:border-[#7d2020] transition-all" required>
                </div>

                <div class="flex flex-col gap-2">
                    <button type="submit" class="w-full bg-[#7d2020] text-white font-black py-4 rounded-xl uppercase text-xs tracking-widest hover:bg-[#922a2a] transition-all">
                        Sauvegarder
                    </button>
                    <button type="button" @click="editModal = false" class="py-2 text-gray-500 hover:text-white text-[10px] font-bold uppercase tracking-widest transition-colors">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>