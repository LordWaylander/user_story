<?php
    $actif=0;
    $inactif=0;
    $nb_client=0;
    $envoieQuestionnaires=0;
    $repondu=0;


 ?>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="">
                <h2 class=" font-small text-xl leading-tight  text-light">
                    Tableau de bord
                </h2>
            </div>
            <div class="mr-12">
                <img src="{{ URL::asset('images/loupe.png') }}" alt="loupe">
                <input id="searchPageDashboard" type="text" name="searchPageDashboard" value="" placeholder="Rechercher une entreprise">
            </div>
        </div>
    </x-slot>

    <div id="dashboard" class="py-12">
        <div class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg mb-5 border-solid border-blue-500">
                <div class="flex justify-start m-2">
                    <img src="{{ URL::asset('images/log.png') }}" alt="">
                    <div class="ml-2 flex flex-wrap content-center">
                        <p class="m-0 font-bold">Dernières activités</p>
                    </div>
                </div>
                @foreach($activites as $activite)
                    <?php
                    $dateActivite=DateTime::createFromFormat('Y-m-d',$activite->date);
                    $interval=$dateActivite->diff($date);
                    ?>

                    @if($interval->d <= 7)
                        @if($activite->type_activite=='update')
                            <div class="ml-5">
                                @if($activite->type_entite=='entreprise')
                                    <p>> L'entreprise <span class="font-bold">{{ $activite->nom_entite }}</span> a été modifiée</p>
                                @elseif($activite->type_entite=='client')
                                    <p>> Le client <span class="font-bold">{{ $activite->nom_entite }}</span> a été modifié</p>
                                @endif
                            </div>
                        @elseif($activite->type_activite=='creation')
                            <div class="ml-5">
                                @if($activite->type_entite=='entreprise')
                                    <p>> L'entreprise <span class="font-bold">{{ $activite->nom_entite }}</span> a été créé</p>
                                @elseif($activite->type_entite=='client')
                                    <p>> Le client <span class="font-bold">{{ $activite->nom_entite }}</span> a été créé</p>
                                @endif
                            </div>
                        @elseif($activite->type_activite=='supression')
                            <div class="ml-5">
                                @if($activite->type_entite=='entreprise')
                                    <p>> L'entreprise <span class="font-bold">{{ $activite->nom_entite }}</span> a été suprimée</p>
                                @elseif($activite->type_entite=='client')
                                    <p>> Le client <span class="font-bold">{{ $activite->nom_entite }}</span> a été supprimé</p>
                                @endif
                            </div>
                        @elseif($activite->type_activite=='reponse')
                            <div class="ml-5">
                                @if($activite->type_entite=='entreprise')
                                    <p>> L'entreprise <span class="font-bold">{{ $activite->nom_entite }}</span> a répondu au questionnaire {<span class="font-bold">{{ $activite->name_questionnaire }}</span></p>
                                @elseif($activite->type_entite=='client')
                                    <p>> Le client <span class="font-bold">{{ $activite->nom_entite }}</span> a répondu au questionnaire <span class="font-bold">{{ $activite->name_questionnaire }}</span></p>
                                @endif
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
            <div class="bg-white overflow-hidden sm:rounded-lg border-solid border-blue-500">
                <div class="flex justify-start m-2">
                    <img src="{{ URL::asset('images/graph.png') }}" alt="">
                    <div class="flex flex-wrap content-center">
                        <p class="m-0 font-bold">Derniers Chiffres</p>
                    </div>
                </div>
                @foreach ($clients as $client)
                    <?php $nb_client++;  ?>
                    @if($client->status == 1)
                        <?php $actif++; ?>
                    @else
                        <?php $inactif++ ?>
                    @endif
                @endforeach
                @foreach($questionnairesEnvoyes as $QE)
                    <?php $envoieQuestionnaires++; ?>
                @endforeach
                @foreach($questionnaires as $questionnaire)
                    @foreach($questionnaire->relationQuestionnaireClients as $value)
                        @if($value->repondu=='oui')
                            <?php $repondu++ ?>
                        @endif
                    @endforeach
                @endforeach
                @if($nb_client>0)
                <p class="mt-3 ml-5">
                    > <?php echo $actif; ?> client actifs (<?php echo round($actif*(100/$nb_client), 2) ?> %)
                </p>
                @endif
                <p class="ml-5">
                    > <?php echo $inactif; ?> client en attente
                </p>
                <p class="ml-5">
                    > <?php echo $envoieQuestionnaires; ?> questionnaire envoyés
                </p>
                <p class="ml-5">
                    > <?php echo $repondu ?> questionnaires remplis
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
