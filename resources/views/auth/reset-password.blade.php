<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Mot de passe') }}" />
                <div class="flex">
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view" onclick="Afficher()">
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmer mot de passe') }}" />
                <div class="flex">
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view" onclick="AfficherPwd()">
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Reset Password') }}
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
        function AfficherPwd() {
            var input = document.getElementById("password_confirmation");
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
