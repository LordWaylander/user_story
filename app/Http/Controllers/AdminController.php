<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRegisterRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\{client, User, RelationCompteUsers, Entreprise, Questionnaire, relationQuestionnaireClient, Reponse};
use App\Models\activites;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class AdminController extends Controller
{
    // recupération des données client en JSON (plus simple pour les modals)
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientJson()
    {
        $clients = client::all();
        foreach ($clients as $client) {
            // recup de infos du contact principal, pour les mettres à la place de l'ID,
            // il y aura toutes les infos du contact en relation avec le client
            $idContact=$client->contact_principal_id;
            $identreprise=$client->entreprise_id;
            $client->contact_principal_id = user::find($idContact);
            $client->entreprise_id = Entreprise::find($identreprise);
        }
        return $clients;
    }

    // définition d'une nouvelle route pour le destroy
    // car la route par défaut veut impérativement un paramètre (id du client)
    // et a cause de la modal de confirmation en JS, il a pas le paramètre directement (vive le PHP)
    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyClient($id)
    {
        $client = client::find($id);
        $mailclient=$client->mail;
        $user = User::where('email', $mailclient)->first();
        $idUser = $user->id;
        //supression de la relation entre le compte utilisateur et le client + de son compte de connection lors de sa suppression
        $reponses = Reponse::where('id_user_TEST', $idUser)->delete();
        $relationClient_User = RelationCompteUsers::where('client_id', $id)->delete();
        $compteClient_User = User::where('email', $mailclient)->delete();
        $relationClientQuestionnaire = relationQuestionnaireClient::where('client_id', $id)->delete();


        $client->delete();

        //activité suppression client
        $activite = new activites;
        $activite->type_activite = 'supression';
        $activite->type_entite = 'client';
        $activite->nom_entite = $client->nom;
        $activite->date = date('Y-m-d');
        $activite->save();
        return redirect('/client')->with('message', "Le client a bien été supprimé !");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = client::all();
        $entreprises= entreprise::all();
        $contacts = user::where('role',1)->get(); // retourne uniquement les admins en tant que contacts principaux
        $questionnaires = Questionnaire::all();
        return view('admin.listing', compact('clients', 'contacts', 'entreprises', 'questionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contacts = User::all();
        return view('admin.create',  compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mailuser=explode("@", $request->email);
        if($mailuser[1]=='itsense.fr' || $mailuser[1]=='admin.fr'){
            return redirect('/client')->with('error', "Cette adresse mail est utilisée pour les comptes d'administration.");
        }
        // se référer au ClientRegisterRequest, qui va checker les champs du formulaire et renvoyer une erreur si besoin
        $mail=$request->email; // variable mail pour plus bas
        $entreprise = $request->entreprise;

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:clients,mail',
            'telephone' => 'required',
            'entreprise' => 'required',
        ]);

        if($request->entreprise=='default'){
            // si le select a "default" en value,il faut créer l'entreprise avant le client (clé étrangère)
            $data = $request->validate([
                'nom_entreprise' => 'required',
                'adresse_entreprise' => 'required',
                'code_postal_entreprise' => 'required',
                'ville_entreprise' => 'required',
            ]);

            $entreprise= new Entreprise;
            $entreprise->nom_entreprise=$request->nom_entreprise;
            $entreprise->adresse_entreprise=$request->adresse_entreprise;
            $entreprise->code_postal=$request->code_postal_entreprise;
            $entreprise->ville=$request->ville_entreprise;
            $date=date('Y-m-d H:i:s');
            $entreprise->save();

            //activité création entreprise
            $activite = new activites;
            $activite->type_activite = 'creation';
            $activite->type_entite = 'entreprise';
            $activite->nom_entite = $request->nom_entreprise;
            $activite->date = date('Y-m-d');
            $activite->save();

            // récupération de la dernière entreprise créé
            $entreprises=Entreprise::where('created_at', $date)->first();
            $entreprise = $entreprises->id_entreprise;

        }

        $client = new client;
        $client->nom = $request->name;
        $client->telephone = $request->telephone;
        $client->mail = $request->email;
        $client->entreprise_id = $entreprise;
        $client->status = 0; // client définit à 0 -> "en attente", dès la Création
        $client->contact_principal_id = $request->contact_principal;
        $client->save();

        // une fois mis en DBB, création du compte client pour se connecter
        // ici mdp en clair, car crypté depuis le modèle user.php
        // lien a envoyer par mail depuis le listing client pour création mdp
        $clientUser = new user;
        $clientUser->name = $request->name;
        $clientUser->username = $request->name;
        $clientUser->email = $request->email;
        $clientUser->password = bcrypt('useruser');
        $clientUser->role = 0; // role du compte -> compte client lambda
        $clientUser->save();

        //maj de la BDD de relation entre compte user_client et les infos $clients
        $client=DB::table('clients')->where('mail', $mail)->first();
        $relationClient_User=array(
            'client_id' => $client->id_client,
            'user_id' => $clientUser->id,
        );
        $relation=RelationCompteUsers::create($relationClient_User);

        // autorisation accès questionnaire
        $client=DB::table('clients')->where('mail', $mail)->first();
        $regexQuestionnaire='/^(questionnaire)([0-9]+$)/';

        foreach ($request->input() as $key => $value) {
            if(preg_match($regexQuestionnaire, $key)){
                $relationClient_questionnaire=array(
                    'client_id' => $client->id_client,
                    'questionnaire_id' => $value,
                );
                $relation=relationQuestionnaireClient::create($relationClient_questionnaire);
            }
        }


        if($request->file()){
            $client=DB::table('clients')->where('mail', $mail)->first();
            $id=$client->id_client;
            $avatar = $request->file('avatar');
            $filename = $id . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->save( public_path('/avatars/' . $filename ) );
            $client = client::find($id);
            $client->logo = $filename;
            $client->save();
        }

        // activité création client
        $activite = new activites;
        $activite->type_activite = 'creation';
        $activite->type_entite = 'client';
        $activite->nom_entite = $request->name;
        $activite->date = date('Y-m-d');
        $activite->save();

        //envoie mail
        MailClientController::linkmail($request);

      return redirect('/client')->with('message', "Le client a bien été créé !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $client = client::find($id);
      // obtention des contacts principaux (role admin), pour les afficher dans le select de la view update
      $contacts = User::where('role',1)->get(); // retourne uniquement les admins en tant que contacts principaux
      $entreprises = Entreprise::all();
      $questionnaires = Questionnaire::all();

      // -> ça sert a rien, mais ça peut être utile pour cocher les questionnaires au quel le client a déjà accès, mais je trouve pas comment faire, ça me casse les couilles, donc tout est décoché, faut juste re-sélectionner les questionnaires.
      $relations=DB::table('questionnaires')
        ->select('*')
        ->addSelect('relation_questionnaire_client.client_id')
        ->join('relation_questionnaire_client', 'questionnaire_id','=','id_questionnaire')
        ->where('client_id', $id)
        ->get();


      return view('admin.update',  compact('client', 'contacts', 'entreprises', 'questionnaires', 'relations'));
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
        $entreprise = $request->entreprise;
        //upload avatar
        if($request->file()){
            $avatar = $request->file('avatar');
            $filename = $id . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->save( public_path('/avatars/' . $filename ) );
            $client = client::find($id);
            $client->logo = $filename;
            $client->save();
        }

        $data = $request->validate([
            'name' => 'required',
            'telephone' => 'required',
            'entreprise' => 'required',
        ]);
        if($request->entreprise=='default'){
            $data = $request->validate([
                'nom_entreprise' => 'required',
                'adresse_entreprise' => 'required',
                'code_postal_entreprise' => 'required',
                'ville_entreprise' => 'required',
            ]);
            // si le select a "default" en value,il faut créer l'entreprise avant le client (clé étrangère)
            $entreprise= new Entreprise;
            $entreprise->nom_entreprise=$request->nom_entreprise;
            $entreprise->adresse_entreprise=$request->adresse_entreprise;
            $entreprise->code_postal=$request->code_postal_entreprise;
            $entreprise->ville=$request->ville_entreprise;
            $date=date('Y-m-d H:i:s');
            $entreprise->save();

            $activite = new activites;
            $activite->type_activite = 'creation';
            $activite->type_entite = 'entreprise';
            $activite->nom_entite = $request->nom_entreprise;
            $activite->date = date('Y-m-d');
            $activite->save();

            // récupération de la dernière entreprise créé
            $entreprises=Entreprise::where('created_at', $date)->first();
            $entreprise = $entreprises->id_entreprise;
        }

        $client = client::find($id);
        $client->nom = $request->name;
        $client->telephone = $request->telephone;
        $client->entreprise_id = $entreprise;
        $client->status = 0; // client définit à 0 -> "en attente", car si modifié, il est pas à jour
        $client->contact_principal_id = $request->contact_principal;
        $client->save();

        // autorisation accès questionnaire
        $client = client::find($id);
        $relation=relationQuestionnaireClient::where('client_id', $id);
        $relation->delete();
        $regexQuestionnaire='/^(questionnaire)([0-9]+$)/';
        foreach ($request->input() as $key => $value) {
            if(preg_match($regexQuestionnaire, $key)){
                $relationClient_questionnaire=array(
                    'client_id' => $client->id_client,
                    'questionnaire_id' => $value,
                );
                $relation=relationQuestionnaireClient::create($relationClient_questionnaire);
            }
        }

        //activité update client

        $activite = new activites;
        $activite->type_activite = 'update';
        $activite->type_entite = 'client';
        $activite->nom_entite = $request->name;
        $activite->date = date('Y-m-d');
        $activite->save();

        return redirect('/client')->with('message', "Le client a bien été modifié !");
    }
}
