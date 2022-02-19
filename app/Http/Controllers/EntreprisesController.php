<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use App\Models\activites;
use App\Models\client;

class EntreprisesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function entreprisejson()
    {
        $entreprises = Entreprise::all();
        return $entreprises;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $entreprise = entreprise::find($id);
        //id client pcq pour la relation pour accéder au questionnaire du client depuis la vue entreprise
        $client = client::find($request->IDClient);
        return view('entreprise.show', compact('entreprise', 'client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showClient($id)
    {
        $entreprise = entreprise::find($id);
        return view('entreprise.showClient', compact('entreprise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $entreprise = entreprise::find($id);
        // id client pcq update en a besoin
        $client = client::find($request->IDClient);
        return view('entreprise.update', compact('entreprise', 'client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editClient($id)
    {
        $entreprise = entreprise::find($id);
        return view('entreprise.updateClient', compact('entreprise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entreprise = entreprise::find($id);
        $tableAdresse = explode(" ", $request->siege_social);
        $entreprise->nom_entreprise = $request->nom_entreprise;
        $entreprise->adresse_entreprise = $request->adresse_entreprise;
        $entreprise->code_postal = $tableAdresse[0];
        $entreprise->ville = $tableAdresse[1];
        $entreprise->denomination_commerciale = $request->denomination_commerciale;
        $entreprise->forme_juridique = $request->forme_juridique;
        $entreprise->site_exploitation = $request->site_exploitation;
        $entreprise->nb_sites = $request->nb_sites;
        $entreprise->siret = $request->siret;
        $entreprise->rc = $request->rc;
        $entreprise->activite = $request->activite;
        $entreprise->code_ape= $request->code_ape;
        $entreprise->representant_legal= $request->representant_legal;
        $entreprise->dpo= $request->dpo;
        $entreprise->directeur_etablissement= $request->directeur_etablissement;
        $entreprise->telephone= $request->telephone;
        $entreprise->responsable_traitement= $request->responsable_traitement;
        $entreprise->sous_traitant= $request->sous_traitant;
        $entreprise->liste_sous_traitant= $request->liste_sous_traitant;
        $entreprise->groupe_user_habilitation_1= $request->groupe_user_habilitation_1;
        $entreprise->groupe_user_habilitation_2= $request->groupe_user_habilitation_2;
        $entreprise->save();

        // activité update entreprise
        $activite = new activites;
        $activite->type_activite = 'update';
        $activite->type_entite = 'entreprise';
        $activite->nom_entite = $request->nom_entreprise;
        $activite->date = date('Y-m-d');
        $activite->save();
        //id du client pcq le show en a besoin de base
        $client = client::find($request->IDClient);

        if($client===null){
            return redirect('entreprise/show/'.$entreprise->id_entreprise)->with('message', 'L\'entreprise a bien été modifiée.');
        }else {
            return redirect()->route('entreprise.show',$entreprise->id_entreprise)->with(['client' => $client])->with('message', 'L\'entreprise a bien été modifiée.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateClient(Request $request, $id)
    {
        $entreprise = entreprise::find($id);
        $tableAdresse = explode(" ", $request->siege_social);
        $entreprise->nom_entreprise = $request->nom_entreprise;
        $entreprise->adresse_entreprise = $request->adresse_entreprise;
        $entreprise->code_postal = $tableAdresse[0];
        $entreprise->ville = $tableAdresse[1];
        $entreprise->denomination_commerciale = $request->denomination_commerciale;
        $entreprise->forme_juridique = $request->forme_juridique;
        $entreprise->site_exploitation = $request->site_exploitation;
        $entreprise->nb_sites = $request->nb_sites;
        $entreprise->siret = $request->siret;
        $entreprise->rc = $request->rc;
        $entreprise->activite = $request->activite;
        $entreprise->code_ape= $request->code_ape;
        $entreprise->representant_legal= $request->representant_legal;
        $entreprise->dpo= $request->dpo;
        $entreprise->directeur_etablissement= $request->directeur_etablissement;
        $entreprise->telephone= $request->telephone;
        $entreprise->responsable_traitement= $request->responsable_traitement;
        $entreprise->sous_traitant= $request->sous_traitant;
        $entreprise->liste_sous_traitant= $request->liste_sous_traitant;
        $entreprise->groupe_user_habilitation_1= $request->groupe_user_habilitation_1;
        $entreprise->groupe_user_habilitation_2= $request->groupe_user_habilitation_2;
        $entreprise->save();

        // activité update entreprise
        $activite = new activites;
        $activite->type_activite = 'update';
        $activite->type_entite = 'entreprise';
        $activite->nom_entite = $request->nom_entreprise;
        $activite->date = date('Y-m-d');
        $activite->save();

        return redirect()->route('entreprise.showClient',$entreprise->id_entreprise)->with('message', 'L\'entreprise a bien été modifiée.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function showEntreprise($id)
    {
        // vue entreprise, par rapport à la barre de recherche, et vu que le show veux l'id client bah...
        // j'dois en créer une autre, sinon faut m'expliquer comment avoir l'id du client qu'on veux
        // depuis la recherche entreprise, alors que l'entreprise peux avoir plusieurs clients
        $entreprise = entreprise::find($id);
        return view('entreprise.showEntreprise', compact('entreprise'));
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function editEntreprise($id)
    {
        // vue entreprise, par rapport à la barre de recherche, et vu que le show veux l'id client bah...
        // j'dois en créer une autre, sinon faut m'expliquer comment avoir l'id du client qu'on veux
        // depuis la recherche entreprise, alors que l'entreprise peux avoir plusieurs clients
        $entreprise = entreprise::find($id);
        return view('entreprise.updateEntreprise', compact('entreprise'));
    }*/


}
