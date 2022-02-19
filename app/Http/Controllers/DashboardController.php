<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRegisterRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\{client, Questionnaire, relationQuestionnaireClient, activites};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = client::all();
        $questionnairesEnvoyes = relationQuestionnaireClient::all();
        $questionnaires = Questionnaire::all();
        $activites = activites::all();
        $date=date('Y-m-d');
        $date=\DateTime::createFromFormat('Y-m-d',$date);

        return view('dashboard', compact('clients', 'questionnairesEnvoyes', 'questionnaires', 'activites', 'date'));
    }





}
