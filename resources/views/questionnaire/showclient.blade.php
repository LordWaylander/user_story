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
                <div>
                    @foreach ($questionnaire->questions as $question)
                        @if($question->status==1)
                            <div class="mt-4">
                                <p class="font-extrabold bg-gris pl-6">{{ $question->question }} : </p>
                                @if($question->typereponse=="radio")
                                <div class="mt-1 w-full d-flex align-items-center border-bottom border-2 pb-2">
                                    <div class="w-full d-flex justify-content-between">
                                        @foreach($question->reponses as $reponse)
                                            @if($reponse->id_user_TEST==$client->relationClientCompteUsers->user_id)
                                                <div class="">
                                                    <p class="m-0">Réponse : {{$reponse->reponse}}</p>
                                                </div>
                                                @foreach($question->preconisation as $value)
                                                    @if($reponse->reponse=='oui')
                                                        @if($value->type_reponse=='oui')
                                                            <div class="">
                                                                <p class="m-0">Note : {{ $value->note_reponse }}</p>
                                                            </div>
                                                            <div class="">
                                                                <p class="m-0">Préconisation : {{$value->conseil}}</p>
                                                            </div>
                                                        @endif
                                                    @elseif($reponse->reponse=='non')
                                                        @if($value->type_reponse=='non')
                                                            <div class="">
                                                                <p class="m-0">Note : {{ $value->note_reponse }}</p>
                                                            </div>
                                                            <div class="">
                                                                <p class="m-0">Préconisation : {{$value->conseil}}</p>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if($value->type_reponse=='autre')
                                                            <div class="">
                                                                <p class="m-0">Note : {{ $value->note_reponse }}</p>
                                                            </div>
                                                            <div class="">
                                                                <p class="m-0">Préconisation : {{$value->conseil}}</p>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="mt-1 w-full d-flex align-items-center border-bottom border-2 pb-2">
                                    <div class="w-full d-flex justify-content-between ">
                                        @foreach($question->reponses as $reponse)
                                            @if($reponse->id_user_TEST==$client->relationClientCompteUsers->user_id)
                                                <div class="">
                                                    <p class="m-0">Réponse : {{$reponse->reponse}}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
