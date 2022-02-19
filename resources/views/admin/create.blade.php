<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Création d'un client
        </h2>
    </x-slot>

    <div class="py-12">
      <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
        <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

          <form method="POST" action="{{ route('client.store') }}">
              @csrf
              <div class="mt-4">
                  <x-jet-label value="Nom du client" />
                  <x-jet-input class="block mt-1 w-full" type="text" id=name name="name" :value="old('name')" placeholder="Nom du client" required autofocus />
              </div>
              <div class="mt-4">
                <x-jet-label class="text-center" value="Contact principal" />
                <div class="mt-4">
                    <select class="w-full h-8" name="contact_principal">
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id_contact_principal }}">{{ $contact->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label value="Mail du client" />
                <x-jet-input class="block mt-1 w-full" type="text" id=mail name="mail" :value="old('mail')" placeholder="Mail du client" required  />
            </div>
              <div class="mt-4">
                  <x-jet-label value="Téléphone du client" />
                  <x-jet-input class="block mt-1 w-full" type="text" id=telephone name="telephone" :value="old('telephone')" placeholder="Téléphone du client" required  />
              </div>
              <div class="mt-4">
                  <x-jet-label value="Raison Sociale du client" />
                  <x-jet-input class="block mt-1 w-full" type="text" id=raison_sociale name="raison_sociale" :value="old('raison_sociale')" placeholder="Raison Sociale du client" required  />
              </div>

              <div class="flex items-center justify-between mt-4">
                  <a class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold
                   text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                     transition" href="{{ route('client.index') }}">{{ __('Retour à la liste') }}</a>
                  <x-jet-button class="ml-4">
                      Envoyer
                  </x-jet-button>
              </div>
          </form>
        </div>
      </div>
    </div>



</x-app-layout>
