<?php
if(Session::get('client') != null){
    $client = Session::get('client');
}
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between m-0" style="color:#19293d">
            Accueil > Entreprise
        </h2>
    </x-slot>
    <div class="m-4">
        <div class="font-bold uppercase bluejob mx-12">
            Société {{ $entreprise->nom_entreprise }}
        </div>

        @if($client)
        <div class="mx-12 mb-2 flex">
            <form id="auditEntreprise" class="mr-2" action="{{URL::to("entreprise/show/$entreprise->id_entreprise")}}" method="GET">
                <input id="idClient" type="hidden" name="IDClient" value="{{$client->id_client}}">
                <button type="submit" class="btn"><p class="bluejob underline font-bold mt-3 w-auto bg-white text-sm m-0 p-0">Audit de la société</p></button>
            </form>
            <form class="ml-2" action="{{URL::to("questionnaire/listingclient/$client->id_client")}}" method="get">
                <input id="idEntreprise" type="hidden" name="idEntreprise" value="{{$entreprise->id_entreprise}}">
                <button type="submit" class="btn"><p class="bluejob mt-3 w-auto bg-white text-sm m-0 p-0">Questionnaire</p></button>
            </form>
        </div>
        @endif

        @if (session()->has('message'))
          <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md">
            {{ session('message') }}
          </div>
        @endif
        <div class="mx-12">
        <div class="w-full inputcreateclient h-10 d-flex align-items-center justify-between">
            <div class="font-bold mx-2">
                IDENTIFICATION DE L’ENTREPRISE
            </div>

            <div class="mx-2">
                @if($client)
                <form class="" action="{{URL::to("entreprise/edit/$entreprise->id_entreprise")}}" method="get">
                    <input type="hidden" name="IDClient" value="{{$client->id_client}}">
                    <button type="submit" class="inputcreateclient"><img src="{{ URL::asset('images/edit_white.png') }}" alt="edit"></button>
                </form>
                @else
                <a href="{{URL::to("entreprise/edit/$entreprise->id_entreprise")}}"><img src="{{ URL::asset('images/edit_white.png') }}" alt="edit"></a>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Raison Sociale :</label>
            </div>
            <div class="w-3/4">
                <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->nom_entreprise }}" disabled>
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Dénomination commerciale :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->denomination_commerciale)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->denomination_commerciale }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4 d-flex align-items-center">
                <label for="">Siège social :</label>
            </div>
            <div class="w-3/4">
                <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->adresse_entreprise }}" disabled>
                <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full bg-gris" type="text" name="" value="{{ $entreprise->code_postal }} {{ $entreprise->ville }}" disabled>
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Forme juridique :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->forme_juridique)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->forme_juridique }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Autre site(s) d’exploitation :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->site_exploitation)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->site_exploitation }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Nombre de sites :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->nb_sites)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->nb_sites }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4 d-flex align-items-center">
                <label for="">Immatriculation commerciale :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->siret)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="Siret : {{ $entreprise->siret }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="Siret à renseigner" disabled>
                @endif
                @if($entreprise->rc)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full bg-gris" type="text" name="" value="RC : {{ $entreprise->rc }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full bg-gris" type="text" name="" value="RC à renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Activité :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->activite)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->activite }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Code APE :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->code_ape)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->code_ape }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Représentant légal :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->representant_legal)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->representant_legal }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">DPO :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->dpo)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->dpo }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Directeur des établissements :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->directeur_etablissement)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->directeur_etablissement }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Téléphone</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->telephone)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->telephone }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Responsable traitement :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->responsable_traitement)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->responsable_traitement }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Sous-traitant :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->sous_traitant)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->sous_traitant }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Si oui Liste intégrale :</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->liste_sous_traitant)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->liste_sous_traitant }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Groupe utilisateurs (Habilitations 1)</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->groupe_user_habilitation_1)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->groupe_user_habilitation_1 }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>

        <div class="flex align-start mt-4">
            <div class="w-1/4">
                <label for="">Groupe utilisateurs (Habilitations 2)</label>
            </div>
            <div class="w-3/4">
                @if($entreprise->groupe_user_habilitation_2)
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="{{ $entreprise->groupe_user_habilitation_2 }}" disabled>
                @else
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="" value="A renseigner" disabled>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
