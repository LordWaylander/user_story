<?php

namespace App\Extensions\RappelMail;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;
use App\Models\RelationCompteUsers;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Support\Str;
use App\Extensions\Mail\linkQuestionnaire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RappelMailClient
{
 /**
     * Send a password reset link to a user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendRappelLink($request)
    {
        $idclient=$request['idclient'];
        $idquestionnaire = $request['idquestionnaire'];

        $client = RelationCompteUsers::where('client_id', $idclient)->first();
        $questionnaire = Questionnaire::where('id_questionnaire', $idquestionnaire)->first();
        $user = User::where('id', $client->user_id)->first();

        $status=$user->notify(new linkQuestionnaire($user, $questionnaire));
        return 'RESET_LINK_SENT';
    }
}
