<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            Mot de passe oublié ? Pas de problème. Renseigner votre adresse mail et nous enverrons un lien de réinitialisation.
        </div>
        @if (session()->has('error'))
          <div class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3 rounded-md mb-2">
            {{ session('error') }}
          </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-light underline">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-between mt-4">
                <x-jet-button>
                    <a class="text-white no-underline" href="{{ route('login') }}">
                        Retour
                    </a>
                </x-jet-button>
                <x-jet-button>
                    Envoyer lien
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
