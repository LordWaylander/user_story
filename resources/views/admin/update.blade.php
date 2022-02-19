<x-app-layout>
    <x-slot name="header">
        <h2 class="px-6 font-semibold text-xl text-light leading-tight">
            Modification d'un client
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="text-center">
            <div class="text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="py-12">
      <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
        <div class="w-full sm:max-w-lg mt-6 px-6 py-4 overflow-hidden inputcreateclient">

          <form method="POST" action="{{ URL::route('client.update', $client->id_client) }}" enctype="multipart/form-data">
              @csrf
              <div class="text-center text-light">
                  MODIFICATION DU CLIENT
              </div>

              <div class="mt-4">
                  <x-jet-label class="text-light text-center" value="Logo entreprise" />
                  <x-jet-input class="block mt-1 w-full" type="file" id="avatar" name="avatar"/>
              </div>
              <div class="mt-4">
                  <x-jet-label class="text-light text-center" value="Raison Sociale" />
                  <select class="w-full py-0" name="entreprise" id="entreprise">
                      <option class="text-light" value="default">Sélectionnez une entreprise</option>
                      @foreach($entreprises as $entreprise)
                      @if($entreprise->id_entreprise == $client->entreprise_id)
                          <option value="{{ $entreprise->id_entreprise }}" selected>{{ $entreprise->nom_entreprise }}</option>
                      @else
                          <option value="{{ $entreprise->id_entreprise }}">{{ $entreprise->nom_entreprise }}</option>
                      @endif
                      @endforeach
                  </select>
              </div>
              <div id="createEntreprise" class="mt-4 hidden">
                  <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="nom_entreprise" name="nom_entreprise" :value="old('nom_entreprise')" placeholder="Raison sociale"/>
                  <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="adresse_entreprise" name="adresse_entreprise" :value="old('adresse_entreprise')" placeholder="Adresse entreprise"/>
                  <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="code_postal_entreprise" name="code_postal_entreprise" :value="old('code_postal_entreprise')" placeholder="Code postal"/>
                  <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="ville_entreprise" name="ville_entreprise" :value="old('ville_entreprise')" placeholder="Ville"/>
              </div>

              <div class="mt-4">
                  <x-jet-label class="text-light text-center" value="Nom du client" />
                  <x-jet-input class="block mt-1 w-full" type="text" id=name name="name" value="{{ $client->nom }}" placeholder="Nom du client" required autofocus />
              </div>

            <div class="mt-4">
                <x-jet-label class="text-light text-center" value="Mail du client" />
                <x-jet-input class="block mt-1 w-full" type="text" id=mail name="mail" value="{{ $client->mail }}" placeholder="Mail du client" disabled  />
            </div>
              <div class="mt-4">
                  <x-jet-label class="text-light text-center" value="Téléphone du client" />
                  <x-jet-input class="block mt-1 w-full" type="text" id=telephone name="telephone" value="{{ $client->telephone }}" placeholder="Téléphone du client" required  />
              </div>

              <div class="flex inline-block mt-2">
                @foreach($questionnaires as $questionnaire)
                    @if($questionnaire->status=='enable')
                        <div class="form-check">
                          <input class="form-check-input" name="questionnaire{{$questionnaire->id_questionnaire}}" type="checkbox" value="{{$questionnaire->id_questionnaire}}" id="flexCheckDefault">
                          <label class="form-check-label mr-2" for="flexCheckDefault">
                            {{ $questionnaire->nom_questionnaire }}
                          </label>
                        </div>
                    @endif
                @endforeach
              </div>
              <div class="flex items-center justify-between mt-4">
                  <a class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold
                   text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                     transition no-underline bg-white text-secondary" href="{{ route('client.index') }}">Retour à la liste</a>
                     <x-jet-button class="ml-4 bg-white text-blue-700">
                       <div class="text-secondary">
                         Envoyer
                       </div>
                     </x-jet-button>
              </div>
          </form>
        </div>
      </div>
    </div>
    </div>
</x-app-layout>
