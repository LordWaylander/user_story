<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img class="w-96" src="{{ URL::asset('images/itmunity.png') }}" alt="Bird-Itsense">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mt-4">
            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nom et Prénom"/>
        </div>



        <div class="mt-4">
            <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="Email"/>
        </div>

        <div class="mt-4 flex">
            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Mot de passe"/>
            <img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view" onclick="Afficher()">
        </div>

        <div class="mt-4 flex">
            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le mot de passe"/>
            <img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view" onclick="AfficherPwd()">
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms"/>

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>
        @endif

        <div class="flex items-center justify-between mt-4">


            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Déjà enregistrer ?') }}
            </a>

            <x-jet-button class="ml-4 bg-light">
                <div class="text-secondary">
                    {{ __('s\'enregistrer') }}
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
