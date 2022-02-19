<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-small text-xl leading-tight justify-between text-light">
            Accueil > clients
        </h2>
    </x-slot>
    <div class="m-4">
        <div class="font-bold uppercase bluejob">
            Société {{ $entreprise->nom_entreprise }}
        </div>

        <div class="w-full inputcreateclient h-10 d-flex align-items-center justify-between">
            <div class="font-bold mx-2">
                MODIFICATION DE L’ENTREPRISE
            </div>
        </div>
        <form class="" action="{{ route('entreprise.updateClient', $entreprise->id_entreprise) }}" method="post">
            @csrf
            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Raison Sociale :</label>
                </div>
                <div class="w-3/4">
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="nom_entreprise" value="{{ $entreprise->nom_entreprise }}">
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Dénomination commerciale :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->denomination_commerciale)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="denomination_commerciale" value="{{ $entreprise->denomination_commerciale }}">
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="denomination_commerciale" placeholder="A renseigner">
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4 d-flex align-items-center">
                    <label for="">Siège social :</label>
                </div>
                <div class="w-3/4">
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="adresse_entreprise" value="{{ $entreprise->adresse_entreprise }}">
                    <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full bg-gris" type="text" name="siege_social" value="{{ $entreprise->code_postal }} {{ $entreprise->ville }}">
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Forme juridique :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->forme_juridique)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="forme_juridique" value="{{ $entreprise->forme_juridique }}">
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="forme_juridique" placeholder="A renseigner">
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Autre site(s) d’exploitation :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->site_exploitation)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="site_exploitation" value="{{ $entreprise->site_exploitation }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="site_exploitation" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Nombre de sites :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->nb_sites)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="nb_sites" value="{{ $entreprise->nb_sites }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="nb_sites" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4 d-flex align-items-center">
                    <label for="">Immatriculation commerciale :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->siret)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="siret" value="{{ $entreprise->siret }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="siret" placeholder="Siret à renseigner" >
                    @endif
                    @if($entreprise->rc)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full bg-gris" type="text" name="rc" value="{{ $entreprise->rc }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full bg-gris" type="text" name="rc" placeholder="RC à renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Activité :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->activite)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="activite" value="{{ $entreprise->activite }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="activite" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Code APE :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->code_ape)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="code_ape" value="{{ $entreprise->code_ape }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="code_ape" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Représentant légal :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->representant_legal)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="representant_legal" value="{{ $entreprise->representant_legal }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="representant_legal" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">DPO :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->dpo)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="dpo" value="{{ $entreprise->dpo }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="dpo" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Directeur des établissements :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->directeur_etablissement)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="directeur_etablissement" value="{{ $entreprise->directeur_etablissement }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="directeur_etablissement" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Téléphone</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->telephone)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="telephone" value="{{ $entreprise->telephone }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="telephone" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Responsable traitement :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->responsable_traitement)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="responsable_traitement" value="{{ $entreprise->responsable_traitement }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="responsable_traitement" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Sous-traitant :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->sous_traitant)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="sous_traitant" value="{{ $entreprise->sous_traitant }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="sous_traitant" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Si oui Liste intégrale :</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->liste_sous_traitant)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="liste_sous_traitant" value="{{ $entreprise->liste_sous_traitant }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="liste_sous_traitant" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Groupe utilisateurs (Habilitations 1)</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->groupe_user_habilitation_1)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="groupe_user_habilitation_1" value="{{ $entreprise->groupe_user_habilitation_1 }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="groupe_user_habilitation_1" placeholder="A renseigner" >
                    @endif
                </div>
            </div>

            <div class="flex align-start mt-4">
                <div class="w-1/4">
                    <label for="">Groupe utilisateurs (Habilitations 2)</label>
                </div>
                <div class="w-3/4">
                    @if($entreprise->groupe_user_habilitation_2)
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="groupe_user_habilitation_2" value="{{ $entreprise->groupe_user_habilitation_2 }}" >
                    @else
                        <input class="h-10 border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full bg-gris" type="text" name="groupe_user_habilitation_2" placeholder="A renseigner" >
                    @endif
                </div>
            </div>
            <div class="flex items-center justify-around mt-4">
                <x-jet-button class="ml-4">
                    Envoyer
                </x-jet-button>

        </form>
        <form class="" action="{{URL::to("entreprise/showClient/$entreprise->id_entreprise")}}" method="get">
            <input type="submit" name="" value="Retour à l'entreprise" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 :opacity-25 transition no-underline">
        </form>
            </div>

    </div>
</x-app-layout>
