<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img class="w-96" src="{{ URL::asset('images/itmunity.png') }}" alt="Bird-Itsense">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-light underline">
                {{ session('status') }}
            </div>
        @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="d-flex justify-content-center">
                    <div class="fs-2 text-light">
                        CONNEXION
                    </div>
                </div>

                <div class="mt-4">
                    <x-jet-input id="email" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus placeholder="Adresse Email"/>

                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <div class="mt-4 flex">
                    <x-jet-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" placeholder="Mot de passe"/>
                    <img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view" onclick="Afficher()">
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-light">{{ __('Se souvenir de moi') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-light hover:text-gray-900" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif

                    <x-jet-button class="ml-4 bg-light" >
                        <div class="text-secondary">
                            Je me connecte
                        </div>

                    </x-jet-button>
                </div>
            </form>
            <script type="text/javascript">
            function Afficher() {
                var input = document.getElementById("password");
                if (input.type === "password") {
                    input.type = "text";
                }
                else {
                    input.type = "password";
                }
            }
            </script>


    </x-jet-authentication-card>
</x-guest-layout>
