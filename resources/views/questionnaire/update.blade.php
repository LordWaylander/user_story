<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between text-light">
            Accueil > Questionnaires
        </h2>
    </x-slot>
    <div class="my-6">
      <div class="mx-6">
            <div class="">
                <form class="" action="{{ route('questionnaire.update', $questionnaire->id_questionnaire) }}" method="post">
                    @csrf
                    <div class="mt-4">
                        <x-jet-label class="font-extrabold" value="Nom du questionnaire" />
                        <x-jet-input class="block mt-1 w-full" type="text" id=name name="name" value="{{$questionnaire->nom_questionnaire}}" placeholder="Nom du questionnaire" required autofocus />
                    </div>
                    <div class="mt-4">
                        <x-jet-label class="font-extrabold" value="Description du questionnaire" />
                        <textarea id="description" name="description" value="{{$questionnaire->description}}" class="w-full" required>{{$questionnaire->description}}</textarea>
                    </div>
                    <div class="mt-4">
                        <x-jet-label class="font-extrabold" value="Status du questionnaire" />
                        @if($questionnaire->status=='enable')
                            <input class="form-check-input" type="radio" id="enable" name="status" value="enable" checked required>
                            <label for="enable">Activé</label>
                            <input class="form-check-input" type="radio" id="unable" name="status" value="unable" required>
                            <label for="unable">Désactivé</label>
                        @elseif($questionnaire->status=='unable')
                            <input class="form-check-input" type="radio" id="enable" name="status" value="enable" required>
                            <label for="enable">Activé</label>
                            <input class="form-check-input" type="radio" id="unable" name="status" value="unable" checked required>
                            <label for="unable">Désactivé</label>
                        @endif
                    </div>


                    @foreach ($questionnaire->questions as $question)
                        @if($question->status==1)
                            <div class="mt-4" id="questionReponse{{ $question->id_question}}">
                                <div class="flex justify-between d-flex align-items-end mt-2">
                                    <label class="block font-medium text-sm text-gray-700 font-extrabold" >Question</label>
                                        <a role="button" class="supressQuestion" value="{{ $question->id_question}}"><img class="w-1/2" src="{{ URL::asset('images/supprimer.png') }}" alt="suppr"></a>
                                </div>

                                <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='question{{ $question->id_question}}' name="question{{ $question->id_question}}" value="{{ $question->question }}" placeholder="Question" autofocus />

                                <label class="block font-medium text-sm text-gray-700">Type de réponse attendue</label>
                                @if($question->typereponse=='radio')
                                    <div class="mt-2">
                                        <div>
                                            <input class="form-check-input input" type="radio" id="input" name="typereponse{{ $question->id_question}}" value="input">
                                            <label for="input">
                                                <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" placeholder="Réponse de type texte" disabled />
                                            </label>
                                        </div>
                                        <div class="mt-4">
                                            <input class="form-check-input radio" type="radio" id="radio" name="typereponse{{ $question->id_question}}" value="radio" checked>
                                            <label for="radio">
                                                Réponse de type oui / non
                                            </label>
                                            <div id="typereponse{{ $question->id_question}}" class="">
                                                @foreach($question->preconisation as $value)
                                                    @if($value->type_reponse=='oui')
                                                <div class="flex justify-between">
                                                    <div class="mr-2">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='oui{{ $question->id_question}}' name="oui{{ $question->id_question}}" value="{{ $value->note_reponse }}" placeholder="Note du oui" autofocus />
                                                    </div>
                                                    <div class="w-full">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationoui{{ $question->id_question}}' name="preconisationoui{{ $question->id_question}}" value="{{ $value->conseil }}" placeholder="Préconisation" autofocus />
                                                    </div>
                                                </div>
                                                @elseif($value->type_reponse=='non')
                                                <div class="flex justify-between">
                                                    <div class="mr-2">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='non{{ $question->id_question}}' name="non{{ $question->id_question}}" value="{{ $value->note_reponse }}" placeholder="Note du non" autofocus />
                                                    </div>
                                                    <div class="w-full">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationnon{{ $question->id_question}}' name="preconisationnon{{ $question->id_question}}" value="{{ $value->conseil }}" placeholder="Préconisation" autofocus />
                                                    </div>
                                                </div>
                                                @elseif($value->type_reponse=='autre')
                                                <div class="flex justify-between">
                                                    <div class="mr-2">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='autre{{ $question->id_question}}' name="autre{{ $question->id_question}}" value="{{ $value->note_reponse }}" placeholder="Note autre" autofocus />
                                                    </div>
                                                    <div class="w-full">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationautre{{ $question->id_question}}' name="preconisationautre{{ $question->id_question}}" value="{{ $value->conseil }}" placeholder="Préconisation" autofocus />
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <div>
                                            <input class="form-check-input input" type="radio" id="input" name="typereponse{{ $question->id_question}}" value="input" checked>
                                            <label for="input">
                                                <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" placeholder="Réponse de type texte" disabled />
                                            </label>
                                        </div>
                                        <div>
                                            <input class="form-check-input radio" type="radio" id="radio" name="typereponse{{ $question->id_question}}" value="radio">
                                            <label for="radio">
                                                Réponse de type oui / non
                                            </label>
                                            <div id="typereponse{{ $question->id_question}}" class="hidden">
                                                <div class="flex justify-between">
                                                    <div class="mr-2">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='oui{{ $question->id_question}}' name="oui{{ $question->id_question}}" value="" placeholder="Note du oui" autofocus />
                                                    </div>
                                                    <div class="w-full">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationoui{{ $question->id_question}}' name="preconisationoui{{ $question->id_question}}" value="" placeholder="Préconisation" autofocus />
                                                    </div>
                                                </div>
                                                <div class="flex justify-between">
                                                    <div class="mr-2">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='non{{ $question->id_question}}' name="non{{ $question->id_question}}" value="" placeholder="Note du non" autofocus />
                                                    </div>
                                                    <div class="w-full">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationnon{{ $question->id_question}}' name="preconisationnon{{ $question->id_question}}" value="" placeholder="Préconisation" autofocus />
                                                    </div>
                                                </div>
                                                <div class="flex justify-between">
                                                    <div class="mr-2">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='autre{{ $question->id_question}}' name="autre{{ $question->id_question}}" value="" placeholder="Note autre" autofocus />
                                                    </div>
                                                    <div class="w-full">
                                                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='preconisationautre{{ $question->id_question}}' name="preconisationautre{{ $question->id_question}}" value="" placeholder="Préconisation" autofocus />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach


                    <div id="questionsuivante"> <!-- le JS ajoute les questions suivantes ici --> </div>
                    <div class="mt-4 flex flex-col sm:justify-center items-center">
                        <button id="btnAjoutQuestion" class="btn" type="button" name="button" value="{{ $question->id_question+1 }}"><img class="w-8" src="{{ URL::asset('images/plus.png') }}" alt="plus"> Ajouter question</button>
                    </div>
                    <div class="flex items-center justify-around mt-4">
                        <a class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold
                         text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                          focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                           transition no-underline" href="{{ route('questionnaire.listing') }}">{{ __('Retour à la liste') }}</a>
                        <x-jet-button class="ml-4">
                            Envoyer
                        </x-jet-button>
                    </div>
                </form>
                <label class="block mt-4 font-medium text-sm text-gray-700 font-extrabold uppercase" >Questions désactivées</label>
                @foreach ($questionnaire->questions as $question)
                    @if($question->status==0)

                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id='question{{ $question->id_question}}' name="question{{ $question->id_question}}" value="{{ $question->question }}" placeholder="Question" disabled />
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
