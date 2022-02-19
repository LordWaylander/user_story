<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img class="h-96" src="{{ URL::asset('images/bird_itsense.png') }}" alt="Bird-Itsense">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mt-4">
                    <x-jet-label for="floatingName" value="{{ __('Email ou nom dutilisateur') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />

                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Mot de passe') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-items-center mt-4">
                    <x-jet-button class="mr-4">
                      <a href="{{ route('register') }}">Pas de compte ?</a>
                    </x-jet-button>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif

                    <x-jet-button class="ml-4">
                        {{ __('Je me connecte') }}
                    </x-jet-button>
                </div>
            </form>

    </x-jet-authentication-card>
</x-guest-layout>
