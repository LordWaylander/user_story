<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Reponse;
use App\Models\relationQuestionnaireClient;
use App\Models\RelationCompteUsers;
use App\Models\Question;
use App\Models\activites;
use App\Models\client;
use App\Models\Questionnaire;

class ReponseController extends Controller
{
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
    public function store(Request $request, $idUser)
    {
        $results=$request->input();
        // regex pour obtenir le fameux "questionX" -> X = id
        $regexQuestion='/^([a-z]){10}([0-9]+$)/';

        foreach ($results as $key => $value) {
            if(preg_match($regexQuestion, $key)){
                // si le regex obtiens true, je prends idquestionX, coupe à partir du 10e caractère pour obtenir l'id
                $id = substr($key, 10);
                $reponseForm=$results['reponse'.$id];
                $idQuestion=$results['idquestion'.$id];

                if ($reponseForm=="autre") {
                    $reponseForm = $results[$id];
                }

                $reponse = DB::table('reponses')
                    ->where([
                        ['question_id', '=', $id],
                        ['id_user_TEST', '=', $idUser]
                    ])->first();

                    // si reponse contient quelque chose, la réponse existe donc on update
                    // sinon on la créé
                if($reponse){
                    $reponse = Reponse::where('question_id',$id)->first();
                    $reponse->question_id = $id;
                    $reponse->reponse = $reponseForm;
                    $reponse->date_reponse = date('d/m/Y');
                    $reponse->id_user_TEST = $idUser;
                    $reponse->save();
                }else {
                    $reponse = new Reponse;
                    $reponse->question_id = $id;
                    $reponse->reponse = $reponseForm;
                    $reponse->date_reponse = date('d/m/Y');
                    $reponse->id_user_TEST = $idUser;
                    $reponse->save();
                }
            }
        }

        $relationUserClient=RelationCompteUsers::where('user_id', $idUser)->first();
        $client_id=$relationUserClient->client_id;
        $questionnaireId=Question::where('id_question',$id)->first();
        $id_Questionnaire=$questionnaireId->id_questionnaire;
        $relation=relationQuestionnaireClient::where('questionnaire_id', $id_Questionnaire)->where('client_id', $client_id)->first();
        $relation->repondu = 'oui';
        $relation->save();

        //activité réponse
        $client = client::where('id_client', $client_id)->first();
        $questionnaire = Questionnaire::where('id_questionnaire', $id_Questionnaire)->first();
        $activite = new activites;
        $activite->type_activite = 'reponse';
        $activite->type_entite = 'client';
        $activite->nom_entite = $client->nom;
        $activite->name_questionnaire = $questionnaire->nom_questionnaire;
        $activite->date = date('Y-m-d');
        $activite->save();

        return redirect('questionnaire/listing')->with('message', "Toutes les réponses ont bien été enregistrés.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
