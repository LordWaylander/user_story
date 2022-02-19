<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Preconisation;
use App\Models\client;
use App\Models\activites;
use App\Models\RelationCompteUsers;
use App\Models\User;
use App\Models\Reponse;
use App\Models\Entreprise;
use App\Models\relationQuestionnaireClient;
use Illuminate\Support\Facades\DB;
use Auth;

class QuestionnairesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //view all questionnaire
        $questionnaires=Questionnaire::all();
        return view('questionnaire.listing', compact('questionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $questionnaire = new Questionnaire;
        $questionnaire->nom_questionnaire = $request->name;
        $questionnaire->description = $request->description;
        $questionnaire->status = $request->status;
        $date=date('Y-m-d H:i:s');
        $questionnaire->save();
        $idQuestionnaire=Questionnaire::where('created_at', $date)->first();

        // récupération du nombre de datas dans le request et des datas
        $results=$request->input();
        $resultsCount= count($request->input());
        // je boucle dans le request -> -4 pour ne par tenir compte de partie du questionnaire (token, nom, description et status)
        // /2 -> car une question appelle une réponse obligatoirement
        for ($i=0; $i <= ($resultsCount-4)/2 ; $i++) {
            // si il trouve une key "question.$i" -> "question1"/"question2", etc
            // la réponse existe forcément donc mise dans des variables car $request->question.$i retourne la valeur de $i
            if(isset($results['question'.$i])){
                $questionForm=$results['question'.$i];
                $reponseForm=$results['typereponse'.$i];

                $question= new Question;
                $question->id_questionnaire = $idQuestionnaire->id_questionnaire;
                $question->question = $questionForm;
                $question->typereponse = $reponseForm;
                $question->status=1; // question activée
                $question->save();
                sleep(1); //sleep 1s pour obtenir le bon id de la question cf : juste en bas

                if($reponseForm==='radio') {
                    $idQuestion=Question::latest()->where('typereponse', 'radio')->first();
                    $preconisation = new Preconisation;
                    $preconisation->question_id = $idQuestion->id_question;
                    $preconisation->note_reponse = $results['oui'.$i];
                    $preconisation->type_reponse = 'oui';
                    $preconisation->conseil = $results['preconisationoui'.$i];
                    $preconisation->save();
                    $preconisation = new Preconisation;
                    $preconisation->question_id = $idQuestion->id_question;
                    $preconisation->note_reponse = $results['non'.$i];
                    $preconisation->type_reponse = 'non';
                    $preconisation->conseil = $results['preconisationnon'.$i];
                    $preconisation->save();
                    $preconisation = new Preconisation;
                    $preconisation->question_id = $idQuestion->id_question;
                    $preconisation->note_reponse = $results['autre'.$i];
                    $preconisation->type_reponse = 'autre';
                    $preconisation->conseil = $results['preconisationautre'.$i];
                    $preconisation->save();
                }
            }
        }
        //activité création questionnaires
        $activite = new activites;
        $activite->type_activite = 'creation';
        $activite->type_entite = 'questionnaire';
        $activite->nom_entite = $request->name;
        $activite->date = date('Y-m-d');
        $activite->save();

        return redirect('questionnaire/listing')->with('message', "Le questionnaire a bien été créé");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reponses= array();
        $questionnaire=Questionnaire::where('id_questionnaire', $id)->first();
        $questions=Question::where('id_questionnaire', $id)->get();
        foreach ($questions as $question) {
            array_push($reponses, Reponse::where('id_user_TEST', Auth::user()->id)->where('question_id', $question->id_question)->get());
        }

        return view('questionnaire.show', compact('questionnaire', 'reponses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDisable($id)
    {
        $reponses= array();
        $questionnaire=Questionnaire::where('id_questionnaire', $id)->first();
        $questions=Question::where('id_questionnaire', $id)->get();
        foreach ($questions as $question) {
            array_push($reponses, Reponse::where('id_user_TEST', Auth::user()->id)->where('question_id', $question->id_question)->get());
        }

        return view('questionnaire.showDisable', compact('questionnaire', 'reponses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $questionnaire=Questionnaire::where('id_questionnaire', $id)->first();
        return view('questionnaire.update', compact('questionnaire'));
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
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $questionnaire = Questionnaire::find($id);
        $questionnaire->nom_questionnaire = $request->name;
        $questionnaire->description = $request->description;
        $questionnaire->status = $request->status;
        $questionnaire->save();

        // récupération des dates ds le request
        $results=$request->input();
        // regex pour obtenir le fameux "questionX" -> X = id
        $regexQuestion='/^([a-z]){8}([0-9]+$)/';

        foreach ($results as $key => $value) {
            if(preg_match($regexQuestion, $key)){
                // si le regex obtiens true, je prends questionX, coupe à partir du 8e caractère pour obtenir l'id
                $idQuestion = substr($key, 8);
                //dd($idQuestion);

                //regarde si y'a match entre id_question ET id_questionnaire
                $question = DB::table('questions')
                    ->where([
                        ['id_question', '=', $idQuestion],
                        ['id_questionnaire', '=', $id]
                    ])->first();
                if($question){

                    $question = Question::find($idQuestion);
                    // si question return un truc, elle existe donc il faut juste update la BDD
                    $questionForm=$results['question'.$idQuestion];
                    $reponseForm=$results['typereponse'.$idQuestion];
                    $question->id_questionnaire = $id;
                    $question->question = $questionForm;
                    $question->typereponse = $reponseForm;
                    $question->status=1; // question activée
                    $question->save();

                    if($reponseForm==='radio') {
                        $idQuestion=Question::find($idQuestion);

                        $preconisation = Preconisation::where('question_id', $idQuestion->id_question)
                            ->where('type_reponse', 'oui')
                            ->first();
                            //
                        $preconisation->question_id = $idQuestion->id_question;
                        $preconisation->note_reponse = $results['oui'.$idQuestion->id_question];
                        $preconisation->type_reponse = 'oui';
                        $preconisation->conseil = $results['preconisationoui'.$idQuestion->id_question];
                        $preconisation->save();
                        //dd($preconisation);

                        $preconisation = Preconisation::where('question_id', $idQuestion->id_question)
                            ->where('type_reponse', 'non')
                            ->first();
                        $preconisation->question_id = $idQuestion->id_question;
                        $preconisation->note_reponse = $results['non'.$idQuestion->id_question];
                        $preconisation->type_reponse = 'non';
                        $preconisation->conseil = $results['preconisationnon'.$idQuestion->id_question];
                        $preconisation->save();

                        $preconisation = Preconisation::where('question_id', $idQuestion->id_question)
                            ->where('type_reponse', 'autre')
                            ->first();
                        $preconisation->question_id = $idQuestion->id_question;
                        $preconisation->note_reponse = $results['autre'.$idQuestion->id_question];
                        $preconisation->type_reponse = 'autre';
                        $preconisation->conseil = $results['preconisationautre'.$idQuestion->id_question];
                        $preconisation->save();

                    }


                }else {
                    // Sinon il faut la créer

                    //suppression reponse si ajout de questions
                    $questionsClient=Question::where('id_questionnaire', $id)->get();
                    foreach ($questionsClient as $value) {
                        $id_question = $value->id_question;
                        Reponse::where('question_id', $id_question)->delete();
                    }
                    $relationQuestionnaireClient = relationQuestionnaireClient::where('questionnaire_id', $id)->get();
                    foreach ($relationQuestionnaireClient as $value) {
                        $value->repondu = null;
                        $value->save();
                    }

                    $questionForm=$results['question'.$idQuestion];
                    $reponseForm=$results['typereponse'.$idQuestion];
                    $question= new Question;
                    $question->id_questionnaire = $id;
                    $question->question = $questionForm;
                    $question->typereponse = $reponseForm;
                    $question->status=1; // question activée
                    $question->save();
                    sleep(1);
                    if($reponseForm==='radio') {
                        $idQuestion=Question::latest()->where('typereponse', 'radio')->first();
                        $preconisation = new Preconisation;
                        $preconisation->question_id = $idQuestion->id_question;
                        $preconisation->note_reponse = $results['oui'.$idQuestion->id_question];
                        $preconisation->type_reponse = 'oui';
                        $preconisation->conseil = $results['preconisationoui'.$idQuestion->id_question];
                        $preconisation->save();
                        $preconisation = new Preconisation;
                        $preconisation->question_id = $idQuestion->id_question;
                        $preconisation->note_reponse = $results['non'.$idQuestion->id_question];
                        $preconisation->type_reponse = 'non';
                        $preconisation->conseil = $results['preconisationnon'.$idQuestion->id_question];
                        $preconisation->save();
                        $preconisation = new Preconisation;
                        $preconisation->question_id = $idQuestion->id_question;
                        $preconisation->note_reponse = $results['autre'.$idQuestion->id_question];
                        $preconisation->type_reponse = 'autre';
                        $preconisation->conseil = $results['preconisationautre'.$idQuestion->id_question];
                        $preconisation->save();
                    }
                }
            }
        }
            $activite = new activites;
            $activite->type_activite = 'update';
            $activite->type_entite = 'questionnaire';
            $activite->nom_entite = $request->name;
            $activite->date = date('Y-m-d');
            $activite->save();
        return redirect('questionnaire/listing')->with('message', "Le questionnaire à bien été modifié");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questionnaire = questionnaire::find($id);

        $questionnaire->status='unable';
        $questionnaire->save();
        return redirect('questionnaire/listing')->with('message', "Le questionnaire est désactivé");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $questionnaire = questionnaire::find($id);

        $questionnaire->status='enable';
        $questionnaire->save();
        return redirect('questionnaire/listing')->with('message', "Le questionnaire est activé");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listingclient(Request $request, $id)
    {
        //vue pour client
        $entreprise = entreprise::find($request->idEntreprise);
        $client = client::find($id);
        $questionnaires = questionnaire::all();

        return view('questionnaire.listingclient', compact('questionnaires', 'client', 'entreprise'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showclient($idQuestionnaire, $idClient)
    {
        $questionnaire=Questionnaire::where('id_questionnaire', $idQuestionnaire)->first();
        $client = client::find($idClient);
        return view('questionnaire.showclient', compact('questionnaire', 'client'));
    }

    /**
     * téléchargement du questionnaire.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jsonclient($idQuestionnaire, $idClient)
    {
        $reponsesClient = array();//array ou seront stocker le json

        $RelationCompteUsers = RelationCompteUsers::where('client_id', $idClient)->first();
        $idUser = $RelationCompteUsers->user_id; // idUser pour réponses
        $questionnaire=Questionnaire::where('id_questionnaire', $idQuestionnaire)->first(); // pour obtenir nom questionnaire
        $questions = Question::where('id_questionnaire', $idQuestionnaire)->get(); // obtenir les questions du questionnaire
        $client = client::find($idClient); //reponse de Mr machin

        $reponsesClient['Questionnaire'] = $questionnaire;
        foreach ($questions as $question) {
            //obtenir réponses questionnaire, suivant id question + idUser
            $idQuestion = $question->id_question;
            $reponses = Reponse::where('id_user_TEST', $idUser)->where('question_id', $idQuestion)->first();
            $reponsesClient['Question'.$idQuestion] = $question;
            $reponsesClient['Reponse'.$idQuestion] = $reponses;

            // préconisations suivant les réponses du client
            $preconisations = Preconisation::where('question_id', $idQuestion)->get();
            foreach ($preconisations as $preconisation) {
                if ($reponses->reponse == 'oui') {
                    if ($preconisation->type_reponse == 'oui') {
                        $reponsesClient['Preconisation'.$idQuestion] = $preconisation;
                    }
                }elseif ($reponses->reponse == 'non') {
                    if ($preconisation->type_reponse == 'non') {
                        $reponsesClient['Preconisation'.$idQuestion] = $preconisation;
                    }
                }else{
                    $reponsesClient['Preconisation'.$idQuestion] = $preconisation;
                }
            }
        }
        return $reponsesClient; //contient le questionnaire, les questions et les réponses du client + préconisations
    }
}
