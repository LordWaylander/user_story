
<nav class="min-h-full relative" x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
        <div>
            <div class="d-flex justify-content-center ">
                <img class="w-full" src="{{ URL::asset('images/itmunity.png') }}" alt="Bird-Itsense">
            </div>
            <div class="d-flex justify-content-center">
                <div class="text-light">
                    Bonjour {{ Auth::user()->name }}
                </div>
            </div>
        </div>
        @if(Auth::user()->role==1)
            <div class="mt-4 ml-5 flex flex-col menu">
                <div class="">
                    <img class="w-10" src="{{ URL::asset('images/dashboard.png') }}" alt="dashboard">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-light text-decoration-none">
                        {{ __('Accueil') }}
                    </x-jet-nav-link>
                </div>
                <div>
                    <img class="w-10" src="{{ URL::asset('images/client.png') }}" alt="client">
                    <x-jet-nav-link href="{{ route('client.index') }}" :active="request()->routeIs('dashboard')" class="text-light text-decoration-none">
                        {{ __('Clients') }}
                    </x-jet-nav-link>
                </div>
                <div>
                    <img class="w-10" src="{{ URL::asset('images/questionnaire.png') }}" alt="questionnaire" >
                    <x-jet-nav-link href="{{ route('questionnaire.listing') }}" :active="request()->routeIs('dashboard')" class="text-light text-decoration-none">
                        {{ __('Questionnaires') }}
                    </x-jet-nav-link>
                </div>
            </div>
            <div class="flex flex-col fixed bottom-0 ml-5">
                <form method="GET" action="{{ route('logout.perform') }}">
                    @csrf
                    <x-jet-nav-link href="{{ route('logout.perform') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-light text-decoration-none p-0">
                        {{ __('Se déconnecter') }}
                    </x-jet-nav-link>
                </form>
                <x-jet-nav-link href="{{ route('profile.show') }}" class="text-light text-decoration-none px-0">
                    {{ __('Profil') }}
                </x-jet-nav-link>
                <x-jet-nav-link href="{{ route('cgu') }}" class="text-light text-decoration-none">
                    CGU
                </x-jet-nav-link>
                <x-jet-nav-link href="{{ route('mentionsLegales') }}" class="text-light text-decoration-none">
                    Mentions légales
                </x-jet-nav-link>
            </div>
        @elseif(Auth::user()->role==0)
        <div class="mt-4 ml-5 flex flex-col">
            <div>
                <img class="w-10" src="{{ URL::asset('images/questionnaire.png') }}" alt="questionnaire" >
                <x-jet-nav-link href="{{ route('questionnaire.listing') }}" :active="request()->routeIs('dashboard')" class="text-light text-decoration-none">
                    {{ __('Questionnaires') }}
                </x-jet-nav-link>
            </div>
        </div>
        <div class="mt-4 ml-5 flex flex-col">
            <div>
                <img class="w-10 text-white" src="{{ URL::asset('images/entreprise.png') }}" alt="questionnaire" >
                <x-jet-nav-link href="{{ route('entreprise.showClient', Auth::user()->relationClientCompteUsers->client->entreprise_id) }}" class="text-light text-decoration-none">
                    {{ __('Entreprise') }}
                </x-jet-nav-link>
            </div>
        </div>
        <div class="flex flex-col fixed bottom-0 ml-5">
            <form method="GET" action="{{ route('logout.perform') }}">
                @csrf
                <x-jet-nav-link href="{{ route('logout.perform') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-light text-decoration-none p-0">
                    {{ __('Se déconnecter') }}
                </x-jet-nav-link>
            </form>
            <x-jet-nav-link href="{{ route('profile.show') }}" class="text-light text-decoration-none px-0">
                {{ __('Profil') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('cgu') }}" class="text-light text-decoration-none">
                CGU
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('mentionsLegales') }}" class="text-light text-decoration-none">
                Mentions légales
            </x-jet-nav-link>
        </div>
        @endif
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout.perform') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout.perform') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Se déconnecter') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
