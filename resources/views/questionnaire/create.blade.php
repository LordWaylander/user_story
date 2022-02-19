<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between text-light">
            Accueil > Questionnaires
        </h2>
    </x-slot>
    <div class="my-6">
      <div class="mx-6">
            <div class="">
                <form class="" action="{{ route('questionnaire.store') }}" method="post">
                    @csrf
                    <div class="mt-4">
                        <x-jet-label class="font-extrabold" value="Nom du questionnaire" />
                        <x-jet-input class="block mt-1 w-full" type="text" id=name name="name" :value="old('name')" placeholder="Nom du questionnaire" required autofocus />
                    </div>
                    <div class="mt-4">
                        <x-jet-label class="font-extrabold" value="Description du questionnaire" />
                        <textarea id="description" name="description" :value="old('description')" class="w-full" required></textarea>
                    </div>
                    <div class="mt-4">
                        <x-jet-label class="font-extrabold" value="Status du questionnaire" />
                        <input class="form-check-input" type="radio" id="enable" name="status" value="enable" required>
                        <label for="enable">Activé</label>
                        <input class="form-check-input" type="radio" id="unable" name="status" value="unable" required>
                        <label for="unable">Désactivé</label>
                    </div>

                    <div class="mt-4" id="questionReponse1">
                        <div class="flex justify-between d-flex align-items-end mt-2">
                            <label class="block font-medium text-sm text-gray-700 font-extrabold">Question</label>
                                <a role="button" class="supressQuestion" value="1"><img class="w-1/2" src="{{ URL::asset('images/supprimer.png') }}" alt="suppr"></a>
                        </div>
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='question1' name="question1" :value="old('question1')" placeholder="Question" autofocus />

                        <label class="block font-medium text-sm text-gray-700 font-extrabold">Type de réponse attendue</label>
                        <div class="mt-2">
                            <div class="mt-4">
                                <input class="form-check-input input" type="radio" id="input" name="typereponse1" value="input">
                                <label for="input">
                                    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" placeholder="Réponse de type texte" disabled />
                                </label>
                            </div>

                            <div class="mt-2">
                                <input class="form-check-input radio" type="radio" id="radio" name="typereponse1" value="radio" checked>
                                <label for="radio">
                                    Réponse de type oui / non
                                </label>

                                <div id="typereponse1" class="">
                                    <div class="flex justify-between">
                                        <div class="mr-2">
                                            <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='oui1' name="oui1" :value="old('oui1')" placeholder="Note du oui" autofocus />
                                        </div>
                                        <div class="w-full">
                                            <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationoui1' name="preconisationoui1" :value="old('preconisationoui1')" placeholder="Préconisation" autofocus />
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="mr-2">
                                            <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='non1' name="non1" :value="old('non1')" placeholder="Note du non" autofocus />
                                        </div>
                                        <div class="w-full">
                                            <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationnon1' name="preconisationnon1" :value="old('preconisationnon1')" placeholder="Préconisation" autofocus />
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="mr-2">
                                            <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='autre1' name="autre1" :value="old('autre1')" placeholder="Note autre" autofocus />
                                        </div>
                                        <div class="w-full">
                                            <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationautre1' name="preconisationautre1" :value="old('preconisationautre1')" placeholder="Préconisation" autofocus />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="questionsuivante"> <!-- le JS ajoute les questions suivantes ici --> </div>
                    <div class="mt-4 flex flex-col sm:justify-center items-center">
                        <button id="btnAjoutQuestion" class="btn" type="button" name="button" value="2"><img class="w-8" src="{{ URL::asset('images/plus.png') }}" alt="plus"> Ajouter question</button>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <a class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold
                         text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                          focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                           transition no-underline" href="{{ route('questionnaire.listing') }}">{{ __('Retour à la liste') }}</a>
                        <x-jet-button class="ml-4">
                            Envoyer
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
