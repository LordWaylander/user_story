<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between text-light m-0">
            Accueil > Questionnaires du client
        </h2>
    </x-slot>
    <div class="m-4">
        <div class="font-bold uppercase bluejob mx-12">
            Société {{ $entreprise->nom_entreprise }}
        </div>
        @if (session()->has('message'))
          <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md mx-12">
            {{ session('message') }}
          </div>
        @endif
        <div class="mx-12 mb-2 flex">
            <form id="auditEntreprise" class="mr-2" action="{{URL::to("entreprise/show/$entreprise->id_entreprise")}}" method="GET">
                <input id="idClient" type="hidden" name="IDClient" value="{{$client->id_client}}">
                <button type="submit" class="btn"><p class="bluejob mt-3 w-auto bg-white text-sm m-0 p-0">Audit de la société</p></button>
            </form>
            <form class="ml-2" action="{{URL::to("questionnaire/listingclient/$client->id_client")}}" method="get">
                <input id="idEntreprise" type="hidden" name="idEntreprise" value="{{$entreprise->id_entreprise}}">
                <button type="submit" class="btn"><p class="bluejob underline font-bold mt-3 w-auto bg-white text-sm m-0 p-0">Questionnaire</p></button>
            </form>
        </div>

        <div class="mx-12">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($questionnaires as $questionnaire)
                    @if($questionnaire->status=='enable')
                        @foreach($questionnaire->relationQuestionnaireClients as $value)
                            @if($value->client_id==$client->id_client)

                            <?php
                                // C'est pour le score de mise en conformité
                                // j'ai préféré le faire ici car ds le controleur je retourne qu'une seule variable
                                // et si y'a plusieurs questionnaire, bah... ça coince.
                                $noteTotale=0;
                                $noteclient=0;
                                $notePourcentage=0;
                                $relationClientCompteUsers = $client->relationClientCompteUsers;
                                $idUser = $client->relationClientCompteUsers->user->id;
                                $tableReponse = array();

                                foreach ($client->relationQuestionnaireClients as $relation) {
                                    foreach ($relation->questionnaire->questions as $question) {
                                        foreach ($question->reponses as $reponse) {
                                            if($reponse->id_user_TEST === $idUser){
                                                array_push($tableReponse,$reponse);
                                            }
                                        }
                                    }
                                }
                                foreach ($tableReponse as $reponse) {
                                    $question = $reponse->question;
                                    if($question->id_questionnaire==$questionnaire->id_questionnaire){
                                        // si la réponse attendu est de type radio (donc avec notes prédéfinie)
                                        // on va chercher la note du oui (valeur la plus élevée)
                                        // sinon, la note vaut 1 pour une réponse de type input
                                        // on obtient donc la note maximale attendue
                                        // puis un récupère les réponses du client
                                        // on calcul sa note totale, puis simple calcul de pourcentage
                                        if($question->typereponse=="radio"){
                                            $idQuestion = $question->id_question;
                                            $preconisations = $question->preconisation;
                                            foreach ($preconisations as $preconisation) {
                                                if($preconisation->type_reponse=='oui' && $preconisation->question_id==$idQuestion){
                                                    $preconisationOui = $preconisation;
                                                    $noteTotale+=$preconisationOui->note_reponse;
                                                }elseif ($preconisation->type_reponse=='non' && $preconisation->question_id==$idQuestion) {
                                                    $preconisationNon = $preconisation;
                                                }else {
                                                    $preconisationAutre = $preconisation;
                                                }
                                            }
                                            if($reponse->reponse=='oui'){
                                                $noteclient+=$preconisationOui->note_reponse;
                                            }elseif ($reponse->reponse=='non') {
                                                $noteclient+=$preconisationNon->note_reponse;
                                            }else {
                                                $noteclient+=$preconisationAutre->note_reponse;
                                            }
                                        }else {
                                            $noteTotale+=1;
                                            $noteclient+=1;
                                        }
                                    }
                                }
                                if($noteTotale==0){
                                    //si pas de réponse $noteTotale reste à 0, donc si pas de réponse $noteTotale=1, pour avoir 0%
                                    $noteTotale=1;
                                }
                                $notePourcentage=round(($noteclient*100)/$noteTotale);
                            ?>

                              <div class="accordion-item">
                                  <div class="d-flex justify-content-between bg-gris">
                                      <h2 class="accordion-header" id="flush-headingone{{$questionnaire->id_questionnaire}}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$questionnaire->id_questionnaire}}" aria-expanded="false" aria-controls="flush-collapseOne{{$questionnaire->id_questionnaire}}">
                                          {{$questionnaire->nom_questionnaire}}
                                        </button>
                                      </h2>
                                      <div class="flex flex-nowrap">
                                          <div class="bg-gris flex items-center">
                                              <a role="button" href="{{ url('questionnaire/showclient/'.$questionnaire->id_questionnaire.'/'.$client->id_client)}}"><img class="h-10" src="{{ URL::asset('images/view.png') }}" alt="view"></a>
                                          </div>
                                          <div class="bg-gris flex items-center">
                                              <a class="download" questionnaire="{{$questionnaire->id_questionnaire}}" client="{{$client->id_client}}"><img class="h-10" src="{{ URL::asset('images/download.png') }}" alt="download"></a>
                                          </div>
                                          <div class="flex items-center">
                                              <form class="" action="{{ route('rappel.client') }}" method="post">
                                                  @csrf
                                                  <input id="idclient" type="hidden" name="idclient" value="{{ $client->id_client }}"/>
                                                  <input id="idquestionnaire" type="hidden" name="idquestionnaire" value="{{ $questionnaire->id_questionnaire }}"/>
                                                  @if($value->repondu=='oui')
                                                      <x-jet-button class="ml-4 bg-white text-blue-700 hidden">
                                                          <div class="text-secondary">
                                                              Envoyer rappel mail
                                                          </div>
                                                      </x-jet-button>
                                                  @else
                                                      <x-jet-button class="ml-4 bg-white text-blue-700">
                                                          <div class="text-secondary">
                                                              Envoyer rappel mail
                                                          </div>
                                                      </x-jet-button>
                                                  @endif
                                              </form>
                                          </div>
                                      </div>

                                  </div>
                                  <div id="flush-collapseOne{{$questionnaire->id_questionnaire}}" class="accordion-collapse collapse" aria-labelledby="flush-headingone{{$questionnaire->id_questionnaire}}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body bg-gris">
                                        {{ $questionnaire->description }}
                                        <div class="">
                                            Score MISE EN CONFORMITÉ obtenu <?php  echo $notePourcentage ?>%
                                        </div>
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
</x-app-layout>
