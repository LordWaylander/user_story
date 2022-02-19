<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="">
                <h2 class=" font-small text-xl leading-tight  text-light">
                    Accueil > clients
                </h2>
            </div>
            <div class="mr-12">
                <img src="{{ URL::asset('images/loupe.png') }}" alt="loupe">
                <input id="searchPageClient" type="text" name="searchPageClient" value="" placeholder="Rechercher une entreprise">
            </div>
        </div>
    </x-slot>
    <div id="pageClient" class="py-6">
        <div class="row m-0">
            <div class="col-6">
                <div class="d-flex justify-content-start bluejob text-3xl font-bold">
                    Liste des clients
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end">

                    <a id="modalOpenCreate" role="button" class="bluejob font-medium py-1 px-1 text-decoration-none"><img class="w-8" src="{{ URL::asset('images/plus.png') }}" alt="plus"> Nouveau client</a>
                </div>
            </div>
        </div>

        <div class="row mx-0 mt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              @if (session()->has('message'))
                <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md mb-2">
                  {{ session('message') }}
                </div>
              @endif
              @if (session()->has('error'))
                <div class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3 rounded-md mb-2">
                  {{ session('error') }}
                </div>
              @endif
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

                <div class="d-flex flex-row">

                    <label class="form-check-label mr-2" id="clientWaiting" for="flexSwitchCheckDefault">{{ __('translations.client waiting') }}</label>
                    <div class="form-check form-switch">
                      <input class="form-check-input" id="filtre" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                    </div>
                    <label class="form-check-label" id="clientActive" for="flexSwitchCheckDefault">{{ __('translations.client active') }}</label>
                    <div class="ml-4">
                        <button id="displayAll" class="btn hover:bg-blue-700 hover:text-white">{{ __('translations.see all') }}</button>
                    </div>
                </div>

                <div class="bg-white-700 p-1 overflow-auto">
                  <table class="table table-striped table-borderless">
                  <thead>
                      <tr>
                          <th class="px-2 py-2">Statut</th>
                          <th class="px-2 py-2">Raison sociale</th>
                          <th class="px-2 py-2">Email</th>
                          <th class="px-2 py-2">Contact principal</th>
                          <th class="px-2 py-2">Téléphone</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody id="bodyclient">
                    @foreach ($clients as $client)
                        @if ($client->status)
                        <tr class="active">
                          <td>Actif</td>
                        @else
                        <tr class="wait">
                          <td>En attente</td>
                        @endif
                      <td>{{ $client->entreprise->nom_entreprise }}</td>
                      <td>{{ $client->mail }}</td>
                      <td>{{ $client->nom }}</td>
                      <td>{{ $client->telephone }}</td>
                      <td>
                          <a value="{{ $client->id_client }}" type="button" class="modalVue openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                              <img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view">
                          </a>
                      </td>
                      <td>
                          <a href="{{ URL::route('client.edit',$client->id_client) }}" role="button"><img src="{{ URL::asset('images/edit.png') }}" alt="edit"></a>
                      </td>
                      <td>
                          @if($client->status==0)
                            <a role="button" class="modalSupress openModal" value="{{ $client->id_client }}"><img src="{{ URL::asset('images/supprimer.png') }}" alt="suppr"></a>
                          @endif
                      </td>
                      <td>
                          <form class="" action="{{ route('mdp.client') }}" method="post">
                              @csrf
                              <input id="email" type="hidden" name="email" value="{{ $client->mail }}"/>
                              <x-jet-button class="ml-4 bg-white text-blue-700">
                                  <div class="text-secondary">
                                      Envoyer lien de création de mot de passe
                                  </div>
                              </x-jet-button>
                          </form>
                      </td>
                    </tr>
                    @if ($client->status)
                        <tr class="active" style="height:10px"></tr>
                    @else
                        <tr class="wait" style="height:10px"></tr>
                        <!-- un tr vide de 10px pour espacer corretement le lignes du tableau, avec la classe pour les afficher / cacher-->
                    @endif
                    @endforeach
                  </tbody>
                  </table>
              </div>

            </div>
        </div>
    </div>

<!------------------------------- MODAL DE SUPPRESSION ----------------------------------->
<div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modalSuppression">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"><!-- centre la modal --></span>
        <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full ">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg @click="toggleModal" class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                          Voulez-vous vraiment supprimer le client ?
                        </h3>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a id="btn_suppr" href="{{ URL::to("client/destroyclient") }}/" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm no-underline">
                    Supprimer
                </a>
                <button type="button" class="closeModalSuppression mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
<!----------------------------- FIN MODAL SUPPRESSION ---------------------------->
<!------------------------------- MODAL DE VIEW ----------------------------------->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content inputcreateclient">
      <div class="modal-header inputcreateclient">
          <div class="w-full">
              <h5 class="modal-title d-flex justify-content-center" id="staticBackdropLabel">Fiche client</h5>
          </div>

              <div class="flex justify-end">
                  <a type="button" class="closeModalView" data-bs-dismiss="modal">
                      <img class="h-10" src="{{ URL::asset('images/close.png') }}" alt="close"></button>
                  </a>
              </div>
      </div>
      <div class="d-flex justify-content-center inputcreateclient ">
          <img id="logoclient" class="w-1/2" src="{{ URL::asset('avatars')}}/">
      </div>
      <div id="modalBody" class="modal-body inputcreateclient">
      </div>
      <div class="flex justify-center inputcreateclient">
          <form id="auditEntreprise" class="" action="{{URL::to("entreprise/show")}}/" method="get">
              <input id="idClient" type="hidden" name="IDClient" value="">
              <input type="submit" value="Audit de la société" class="mt-3 w-1/2 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium bluejob hover:bg-white-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white-500 sm:ml-3 sm:w-auto sm:text-sm no-underline">
          </form>
      </div>
      <div class="flex justify-center inputcreateclient">
          <form id="questionnaireClient" class="" action="{{URL::to("questionnaire/listingclient")}}/" method="get">
              <input id="idEntreprise" type="hidden" name="idEntreprise" value="">
              <input type="submit" value="Questionnaire(s)" class="mt-3 w-1/2 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium bluejob hover:bg-white-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white-500 sm:ml-3 sm:w-auto sm:text-sm no-underline">
          </form>
      </div>
      <div class="modal-footer inputcreateclient">
      </div>
    </div>
  </div>
</div>
<!----------------------------- FIN MODAL VIEW ---------------------------->
<!----------------------------- MODAL CREATE ------------------------------>
<div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modalCreate">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"><!-- centre la modal --></span>
        <div class="inline-block text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full ">
            <div class="p-2" style="background-color:#18274c">
                <div class="flex justify-end">
                    <a type="button" class="closeModalCreate">
                        <img class="h-10" src="{{ URL::asset('images/close.png') }}" alt="close"></button>
                    </a>
                </div>

                <main class="p-3 text-center text-light">
                    <div class="">
                        CRÉER UN NOUVEAU COMPTE CLIENT

                    </div>
                      <form method="POST" action="{{ route('client.store') }}" enctype="multipart/form-data">
                          @csrf

                      <div class="mt-4">
                          <x-jet-label class="text-light text-center" value="Logo entreprise" />
                          <x-jet-input class="block mt-1 w-full" type="file" id="avatar" name="avatar"/>
                      </div>
                      <div class="mt-4">
                          <select class="w-full inputcreateclient py-0" name="entreprise" id="entreprise">
                              <option class="text-light" selected value="default">Sélectionnez une entreprise</option>
                              @foreach($entreprises as $entreprise)
                                  <option value="{{ $entreprise->id_entreprise }}">{{ $entreprise->nom_entreprise }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div id="createEntreprise" class="mt-4">
                          <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}" placeholder="Raison sociale"/>
                          <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="adresse_entreprise" name="adresse_entreprise" value="{{ old('adresse_entreprise') }}" placeholder="Adresse entreprise"/>
                          <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="code_postal_entreprise" name="code_postal_entreprise" value="{{ old('code_postal_entreprise') }}" placeholder="Code postal"/>
                          <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id="ville_entreprise" name="ville_entreprise" value="{{ old('ville_entreprise') }}" placeholder="Ville"/>
                      </div>

                        <div class="mt-4">
                          <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id=name name="name" value="{{ old('name') }}" placeholder="Nom" required autofocus/>

                        </div>
                        <div class="mt-4">
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="email" id=mail name="email" value="{{ old('email') }}" placeholder="Mail" required  />
                        </div>
                          <div class="mt-4">
                              <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block mt-1 w-full inputcreateclient border-bottom border-light rounded-none" type="text" id=telephone name="telephone" value="{{ old('telephone') }}" placeholder="Téléphone" required  />
                          </div>


                          <div class="flex inline-block mt-2">
                              @foreach($questionnaires as $questionnaire)
                                @if($questionnaire->status=='enable')
                                    <div class="form-check mr-2">
                                      <input class="form-check-input" name="questionnaire{{$questionnaire->id_questionnaire}}" type="checkbox" value="{{$questionnaire->id_questionnaire}}" id="flexCheckDefault">
                                      <label class="form-check-label" for="flexCheckDefault">
                                        {{ $questionnaire->nom_questionnaire }}
                                      </label>
                                    </div>
                                @endif
                                @endforeach
                          </div>


                          <div class="flex justify-center mt-4">
                              <x-jet-button class="ml-4 bg-white text-blue-700">
                                <div class="text-secondary">
                                  Envoyer
                                </div>
                              </x-jet-button>
                          </div>
                      </form>
                </main>
            </div>
        </div>
    </div>
</div>
<!----------------------------- FIN MODAL CREATE -------------------------->
<! ---------------------------- MODAL UPDATE ----------------------------->
<div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modalUpdate">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"><!-- centre la modal --></span>
        <div class="inline-block text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full ">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4" style="background-color:#18274c">
                <main class="p-3 text-center text-light">
                    <div id="modalUpdateBody">
                    </div>
                    <a class='closeModalUpdate px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'>Annuler</a>
                </main>
            </div>
        </div>
    </div>
</div>
<!-----------------------------------FIN MODAL UPDATE ----------------------->
</x-app-layout>
