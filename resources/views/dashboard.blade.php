<x-app-layout>
    <div class="fixed top-5 right-5 z-[100] space-y-3">

        @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-end="opacity-0 scale-90"
            class="bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            class="bg-red-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="text-sm font-bold">
                {{ session('error') ?? 'Erreur de validation' }}
            </span>
        </div>
        @endif
    </div>
    <div class="py-12" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">

                <aside class="w-full md:w-1/4 order-2 md:order-1">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Historique
                        </h3>
                        <ul class="space-y-3">
                            @forelse($historyColocations as $history)
                            <li class="text-sm p-3 bg-gray-50 rounded-lg text-gray-600 border border-transparent hover:border-indigo-200 transition">
                                <span class="font-medium">{{ $history->name }}</span>
                                <p class="text-xs text-gray-400">Quitté le : {{ $history->pivot->left_at->format('d/m/Y') }}</p>
                            </li>
                            @empty
                            <p class="text-xs text-gray-400 italic">Aucun historique disponible.</p>
                            @endforelse
                        </ul>
                    </div>
                </aside>

                <main class="w-full md:w-3/4 order-1 md:order-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Mes Colocations</h2>

                        @if($activeColocations->isEmpty())
                        <button @click="open = true" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-0.5">
                            + Nouvelle
                        </button>
                        @else
                        <span class="text-xs font-medium text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                            1 Colocation Active (Limite atteinte)
                        </span>
                        @endif
                    </div>

                    @if($activeColocations->isEmpty())
                    <div @click="open = true" class="cursor-pointer group flex flex-col items-center justify-center p-12 bg-white border-2 border-dashed border-gray-300 rounded-2xl hover:border-indigo-400 hover:bg-indigo-50 transition duration-300">
                        <div class="bg-indigo-100 p-4 rounded-full group-hover:scale-110 transition duration-300">
                            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-700">Ajouter votre première colocation</h3>
                        <p class="text-gray-400 text-sm mt-1">Cliquez ici pour commencer à gérer vos dépenses.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($activeColocations as $col)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $col->name }}</h3>
                                    <span class="text-xs font-medium uppercase tracking-wider text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded">
                                        {{ $col->pivot->role }}
                                    </span>
                                </div>
                                <a href="{{ route('colocation.show', $col->id) }}" class="p-2 bg-gray-50 rounded-full hover:bg-indigo-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center text-sm text-gray-500">
                                <div class="flex -space-x-2">
                                    @foreach($col->members->take(3) as $member)
                                    <div class="w-7 h-7 rounded-full bg-indigo-200 border-2 border-white flex items-center justify-center text-[10px] font-bold">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                    @endforeach
                                </div>
                                <span class="ml-3">{{ $col->members->count() }} membres</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </main>

            </div>
        </div>

        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="open = false"></div>
                <div class="bg-white rounded-2xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full z-50 overflow-hidden">
                    <form action="{{ route('colocation.store') }}" method="POST" class="p-8">
                        @csrf
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Nouvelle Colocation</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" :value="__('Nom de la maison / Appartement')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500" placeholder="Ex: Appartement 5, Guéliz" required />
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end gap-3">
                            <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:underline">Annuler</button>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Créer l'espace</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>