<x-app-layout>
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
    <div x-data="{ open: false}" class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900">{{ $colocation->name }}</h2>
                    <p class="text-slate-500 mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Espace de colocation actif
                    </p>
                </div>

                <div class="flex gap-3">
                    <form action="#" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?')">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition">
                            Quitter la maison
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-800 mb-4">Membres de la colocation</h3>
                        <div class="space-y-4">
                            @foreach($colocation->members as $member)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">{{ $member->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $member->pivot->role }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center min-h-[300px]">
                        <div class="bg-slate-50 p-4 rounded-full mb-4">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-700">Aucune member pour l'instant</h3>
                        <p class="text-slate-400 text-sm max-w-xs mt-2">Commencez à ajouter vos member.</p>
                        <button @click="open = true" class="mt-6 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                            + Ajouter un member
                        </button>
                    </div>
                </div>
                <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="open = false"></div>
                        <div class="bg-white rounded-2xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full z-50 overflow-hidden">
                            <form action="{{ route('colocation.invite', $colocation->id) }}" method="POST" class="p-8">
                                @csrf
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Nouvelle Member</h3>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="email" :value="__('Ajouter email du member')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500" placeholder="Example@gmail.com" required />
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-end gap-3">
                                    <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:underline">Annuler</button>
                                    <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Créer un Member</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>