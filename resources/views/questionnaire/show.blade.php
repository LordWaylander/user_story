<?php $id=0; ?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between text-light">
            Accueil > Questionnaires
        </h2>
    </x-slot>
    <div class="my-6">
      <div class="mx-6">
            <div class="">
                <div class="">
                    <div class="mt-4 font-extrabold text-2xl">
                        {{ $questionnaire->nom_questionnaire }}
                    </div>
                    <div class="mt-4">
                        {{ $questionnaire->description }}
                    </div>
                </div>
                <form id="form" class="" action="{{ URL::route('reponse.store', Auth::user()->id) }}" method="post">
                    @csrf
                    @foreach ($questionnaire->questions as $question)
                        @if($question->status==1)
                            <div class="mt-4">
                                <p class="font-extrabold">{{ $question->question }} </p>
                                @if($question->typereponse=="radio")
                                    @foreach($reponses as $reponse)
                                        @if(count($reponse)==0)
                                            @if($question->id_question != $id)
                                                <?php $id = $question->id_question ?>
                                                <div class="mt-1 w-full bg-gris d-flex align-items-center">
                                                    <div class="">
                                                        <span class="">Réponse : </span>
                                                        <input class="form-check-input" type="radio" id="ouireponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="oui" required/>
                                                        <label class="w-10" for="oui">oui</label>

                                                        <input class="form-check-input" type="radio" id="nonreponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="non" required/>
                                                        <label for="non">non</label>

                                                        <input class="form-check-input hidden" type="radio" id="{{$question->id_question}}" name="reponse{{$question->id_question}}" value="autre" required/>
                                                        <input class="target h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id="autrereponse{{$question->id_question}}" name="{{$question->id_question}}" :value="old('reponse{{$question->id_question}}')" placeholder="Autre..."/>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            @foreach($reponse as $value)
                                                @if($value->question_id == $question->id_question)
                                                    @if($value->reponse=='oui')
                                                        <input class="form-check-input" type="radio" id="ouireponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="oui" checked required/>
                                                        <label class="w-10" for="oui">oui</label>

                                                        <input class="form-check-input" type="radio" id="nonreponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="non" required/>
                                                        <label for="non">non</label>

                                                        <input class="form-check-input hidden" type="radio" id="{{$question->id_question}}" name="reponse{{$question->id_question}}" value="autre" required/>
                                                        <input class="target h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id="autrereponse{{$question->id_question}}" name="{{$question->id_question}}" placeholder="Autre..."/>
                                                    @elseif($value->reponse=='non')
                                                        <input class="form-check-input" type="radio" id="ouireponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="oui" required/>
                                                        <label class="w-10" for="oui">oui</label>

                                                        <input class="form-check-input" type="radio" id="nonreponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="non" checked required/>
                                                        <label for="non">non</label>

                                                        <input class="form-check-input hidden" type="radio" id="{{$question->id_question}}" name="reponse{{$question->id_question}}" value="autre" required/>
                                                        <input class="target h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id="autrereponse{{$question->id_question}}" name="{{$question->id_question}}" placeholder="Autre..."/>
                                                    @else
                                                        <input class="form-check-input" type="radio" id="ouireponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="oui" required/>
                                                        <label class="w-10" for="oui">oui</label>

                                                        <input class="form-check-input" type="radio" id="nonreponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="non" required/>
                                                        <label for="non">non</label>

                                                        <input class="form-check-input hidden" type="radio" id="{{$question->id_question}}" name="reponse{{$question->id_question}}" value="autre" checked required/>
                                                        <input class="target h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id="autrereponse{{$question->id_question}}" name="{{$question->id_question}}" value="{{$value->reponse}}" placeholder="Autre..."/>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($reponses as $reponse)
                                        @if(count($reponse)==0)
                                            @if($question->id_question != $id)
                                                <?php $id = $question->id_question ?>
                                                <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id="reponse{{$question->id_question}}" name="reponse{{$question->id_question}}" placeholder="Champs libre à remplir" required/>
                                            @endif
                                        @else
                                            @foreach($reponse as $value)
                                                @if($value->question_id == $question->id_question)
                                                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" id="reponse{{$question->id_question}}" name="reponse{{$question->id_question}}" value="{{$value->reponse}}" placeholder="Champs libre à remplir" required/>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                                <input type="hidden" name="idquestion{{ $question->id_question }}" value="{{ $question->id_question }}">
                            </div>
                        @endif
                    @endforeach
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
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $( ".target" ).focus(function() {
            var id=$(this).attr("name");
            document.getElementById(id).checked = true;
        });
    </script>
</x-app-layout>
