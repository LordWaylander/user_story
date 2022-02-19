<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\QuestionnairesController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\EntreprisesController;
use App\Http\Controllers\MailClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CguController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::group(['middleware' => ['guest']], function() {

        //Routes d'enregistrement utilisateur
        Route::get('/register', 'RegisterController@show')->name('register');
        Route::post('/register', 'RegisterController@register')->name('register.perform');
        Route::get('/', function () {
            return view('auth.login');
        });

        //Routes de login utilisateur
        Route::get('/login', 'LoginController@show')->name('login');
        Route::post('/login', 'LoginController@login')->name('login.perform');

        // route login admin, faire nouvelle fonction, pour retourner un "return view('auth.login');"
        // différent du client
        //Route::get('/login/admin', 'LoginController@show')->name('login');
        //Route::post('/login/admin', 'LoginController@login')->name('login.perform');

        //new pwd
        Route::get('create-password/{token}', [MailClientController::class, 'create'])->name('mdp.create');
    });

    Route::group(['middleware' => ['auth']], function() {

        //Route de déconnexion
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('questionnaire/listing', [QuestionnairesController::class, 'index'])->name('questionnaire.listing');
        Route::get('questionnaire/show/{parameter}', [QuestionnairesController::class, 'show'])->name('questionnaire.show');
        Route::get('questionnaire/showDisable/{parameter}', [QuestionnairesController::class, 'showDisable'])->name('questionnaire.showDisable');
        Route::post('reponse/questionnaire/{parameter}',[ReponseController::class, 'store'])->name('reponse.store');
        Route::get('/cgu', [CguController::class, 'cgu'])->name('cgu');
        Route::get('/mentionsLegales', [CguController::class, 'mentionsLegales'])->name('mentionsLegales');
        Route::get('/entreprise/showClient/{parameter}',[EntreprisesController::class, 'showClient'])->name('entreprise.showClient');
        Route::get('/entreprise/editClient/{parameter}',[EntreprisesController::class, 'editClient'])->name('entreprise.editClient');
        Route::post('/entrepriseClient/{parameter}',[EntreprisesController::class, 'updateClient'])->name('entreprise.updateClient');
    });

    // accessible uniquement aux users du groupe admin
    Route::group(['middleware' => ['checkAdmin']], function() {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('client/destroyclient/{parameter}', [AdminController::class, 'destroyclient']);
        Route::get('client/json', [AdminController::class, 'clientjson']);
        Route::post('client', [AdminController::class, 'store'])->name('client.store');
        Route::get('client', [AdminController::class, 'index'])->name('client.index');
        Route::get('client/create', [AdminController::class, 'create'])->name('client.create');
        Route::post('client/{parameter}', [AdminController::class, 'update'])->name('client.update');
        Route::get('client/{parameter}/edit', [AdminController::class, 'edit'])->name('client.edit');

        Route::get('questionnaire/create', [QuestionnairesController::class, 'create'])->name('questionnaire.create');
        Route::post('questionnaire',[QuestionnairesController::class, 'store'])->name('questionnaire.store');
        Route::get('questionnaire/update/{parameter}', [QuestionnairesController::class, 'edit'])->name('questionnaire.edit');
        Route::post('questionnaire/{parameter}',[QuestionnairesController::class, 'update'])->name('questionnaire.update');
        Route::get('questionnaire/delete/{parameter}',[QuestionnairesController::class, 'destroy'])->name('questionnaire.delete');
        Route::get('questionnaire/active/{parameter}',[QuestionnairesController::class, 'active'])->name('questionnaire.active');
        Route::get('questionnaire/listingclient/{parameter}',[QuestionnairesController::class, 'listingclient'])->name('questionnaire.listing.client');
        Route::get('questionnaire/showclient/{parameter}/{parameter2}', [QuestionnairesController::class, 'showclient'])->name('questionnaire.show.client');
        Route::get('questionnaire/jsonclient/{idQuestionnaire}/{idClient}', [QuestionnairesController::class, 'jsonclient'])->name('questionnaire.jsonclient');

        //Routes pour les questions
        Route::get('/question/create',[QuestionController::class, 'create']);
        Route::post('/question/store',[QuestionController::class, 'store'])->name('question.store');
        Route::get('/question/delete/{parameter}',[QuestionController::class, 'destroy']);

        // Routes entreprises
        Route::get('/entreprise/show/{parameter}',[EntreprisesController::class, 'show'])->name('entreprise.show');
        Route::get('/entreprise/edit/{parameter}',[EntreprisesController::class, 'edit'])->name('entreprise.edit');
        Route::post('/entreprise/{parameter}',[EntreprisesController::class, 'update'])->name('entreprise.update');
        Route::get('/entreprises/json', [EntreprisesController::class, 'entreprisejson']);

        //envoie mail pour mdp client
        Route::post('/mdp-reset/client', [MailClientController::class, 'linkmail'])->name('mdp.client');
        //rappel-questionnaire
        Route::post('/rappel/client', [MailClientController::class, 'rappel'])->name('rappel.client');

    });
});
