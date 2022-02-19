<?php $id=0; ?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between text-light">
            Accueil > Questionnaire
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
                @foreach ($questionnaire->questions as $question)
                    @if($question->status==1)
                        <div class="mt-4">
                            <p class="font-extrabold underline bg-gris pl-6">{{ $question->question }} : </p>
                            @if($question->typereponse=="radio")
                                @foreach($reponses as $reponse)
                                        @foreach($reponse as $value)
                                            @if($value->question_id == $question->id_question)
                                                <div class="border-bottom border-2">
                                                    <p class="m-0">Réponse : {{$value->reponse}}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                @endforeach
                            @else
                                @foreach($reponses as $reponse)
                                    @foreach($reponse as $value)
                                        @if($value->question_id == $question->id_question)
                                            <div class="">
                                                <p class="m-0 border-bottom border-2">Réponse : {{$value->reponse}}</p>
                                            </div>
                                        @endif
                                    @endforeach
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
