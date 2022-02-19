<x-app-layout>

    @if(Auth::user()->role==1)
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="">
                <h2 class=" font-small text-xl leading-tight  text-light">
                    Accueil > Questionnaires
                </h2>
            </div>
            <div class="mr-12">
                <img src="{{ URL::asset('images/loupe.png') }}" alt="loupe">
                <input id="searchPageQuestionnaire" type="text" name="searchPageQuestionnaire" value="" placeholder="Rechercher une entreprise">
            </div>
        </div>
    </x-slot>
    <div id="PageQuestionnaire" class="pb-12">
        <div class="d-flex justify-content-end">
            <a href="{{ route('questionnaire.create') }}" role="button" class="mb-3 w-full inline-flex justify-center px-4 py-2 text-dark text-base font-medium sm:w-auto sm:text-sm no-underline"><img class="w-8 mr-3" src="{{ URL::asset('images/plus.png') }}" alt="plus">Créer questionnaire</a>
        </div>

        @if (session()->has('message'))
          <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md mx-12 my-6">
            {{ session('message') }}
          </div>
        @endif

        <div class="mx-12 overflow-auto">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($questionnaires as $questionnaire)
                  <div class="accordion-item w-screen md:w-full">
                      <div class="d-flex justify-content-between bg-gris">
                          <h2 class="accordion-header" id="flush-headingone{{$questionnaire->id_questionnaire}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$questionnaire->id_questionnaire}}" aria-expanded="false" aria-controls="flush-collapseOne{{$questionnaire->id_questionnaire}}">
                              {{$questionnaire->nom_questionnaire}}
                            </button>
                          </h2>
                          <div class="bg-gris flex">
                            @if($questionnaire->status=='enable')
                                Status du questionnaire : activé
                            @elseif($questionnaire->status=='unable')
                                Status du questionnaire : désactivé
                            @endif
                          </div>
                          <div class="bg-gris">
                            <a role="button" href="{{ route('questionnaire.show', $questionnaire->id_questionnaire) }}"><img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view"></a>
                            <a role="button" href="{{ route('questionnaire.edit', $questionnaire->id_questionnaire) }}"><img src="{{ URL::asset('images/edit.png') }}" alt="edit"></a>
                            @if($questionnaire->status=='enable')
                                <a role="button" href="{{ route('questionnaire.delete', $questionnaire->id_questionnaire) }}" class="btn">Désactivé</a>
                                <a role="button" href="{{ route('questionnaire.active', $questionnaire->id_questionnaire) }}" class="btn disabled">Activé</a>
                            @else
                                <a role="button" href="{{ route('questionnaire.delete', $questionnaire->id_questionnaire) }}" class="btn disabled">Désactivé</a>
                                <a role="button" href="{{ route('questionnaire.active', $questionnaire->id_questionnaire) }}" class="btn">Activé</a>
                            @endif
                          </div>
                      </div>
                      <div id="flush-collapseOne{{$questionnaire->id_questionnaire}}" class="accordion-collapse collapse" aria-labelledby="flush-headingone{{$questionnaire->id_questionnaire}}" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body bg-gris">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    {{ $questionnaire->description }}
                                </div>
                                <div class="">
                                    <p class="underline">Personnes qui ont répondu au questionnaire : </p>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Mail</th>
                                                <th>Téléphone</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($questionnaire->relationQuestionnaireClients as $value)
                                            @if($value->repondu=='oui')
                                                <tr>
                                                    <td>{{ $value->client->nom }}</td>
                                                    <td>{{ $value->client->mail }}</td>
                                                    <td>{{ $value->client->telephone }}</td>
                                                    <?php $count=1; ?>
                                                    @foreach($value->questionnaire->questions as $question)
                                                        @foreach($question->reponses as $reponse)
                                                            <?php if($count == 1){ ?>
                                                                <td>{{ $reponse->date_reponse }}</td>
                                                            <?php $count++; }?>
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="mt-4"></div>
              @endforeach
            </div>
        </div>
    @elseif(Auth::user()->role==0)
    <x-slot name="header">
        <h2 class=" font-small text-xl leading-tight  text-light">
            Accueil > Questionnaires
        </h2>
    </x-slot>
    <div class="mt-12">
        @if (session()->has('message'))
          <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md mx-12">
            {{ session('message') }}
          </div>
        @endif
        <div class="mx-12 overflow-auto">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($questionnaires as $questionnaire)
                    @if($questionnaire->status=='enable')
                        @foreach($questionnaire->relationQuestionnaireClients as $value)
                            @if($value->client_id==Auth::user()->relationClientCompteUsers->client_id)
                              <div class="accordion-item md:w-full">
                                  <div class="d-flex justify-content-between bg-gris">
                                      <h2 class="accordion-header" id="flush-headingone{{$questionnaire->id_questionnaire}}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$questionnaire->id_questionnaire}}" aria-expanded="false" aria-controls="flush-collapseOne{{$questionnaire->id_questionnaire}}">
                                          {{$questionnaire->nom_questionnaire}}
                                        </button>
                                      </h2>

                                      @if($value->repondu != 'oui')
                                      <div class="bg-gris flex items-center">
                                          <a role="button" href="{{ route('questionnaire.show', $questionnaire->id_questionnaire) }}"><img class="" src="{{ URL::asset('images/edit.png') }}" alt="view"></a>
                                      </div>
                                      @else
                                      <div class="bg-gris flex items-center">
                                          <a role="button" target="_blank" href="{{ route('questionnaire.showDisable', $questionnaire->id_questionnaire) }}"><img class="" src="{{ URL::asset('images/view.png') }}" alt="view"></a>
                                      </div>
                                      @endif


                                  </div>
                                  <div id="flush-collapseOne{{$questionnaire->id_questionnaire}}" class="accordion-collapse collapse" aria-labelledby="flush-headingone{{$questionnaire->id_questionnaire}}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body bg-gris w-full">
                                        {{ $questionnaire->description }}
                                    </div>
                                  </div>
                              </div>
                              <div class="mt-4"></div>
                          @endif
                      @endforeach
                  @endif
              @endforeach
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
