<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Invitation reçue !</h2>
            <p class="text-gray-600 mb-6">
                Vous avez été invité à rejoindre la colocation 
                <span class="font-bold text-indigo-600">{{ $invitation->colocation->name }}</span>.
            </p>

            <div class="flex flex-col gap-3">
                <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                        Accepter l'invitation
                    </button>
                </form>

                <form action="{{ route('invitations.reject', $invitation->token) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                        Refuser
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>