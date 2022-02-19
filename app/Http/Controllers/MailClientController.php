<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Extensions\Passwords\PasswordClient;
use App\Extensions\RappelMail\RappelMailClient;

class MailClientController extends Controller
{

    /**
     * Send a create link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function linkmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // We will send the password create link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = PasswordClient::sendCreateLink(
            $request->only('email')
        );
        if($status==='RESET_LINK_SENT'){
            //activité envoie mail
            return back()->with('message', "mail bien envoyé");
        }else {
            return back()->with('errors', "Problème lors de l'envoie du mail");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)//: ResetPasswordViewResponse
    {
        return view('mdp.createMdp', compact('request'));
    }

    /**
     * Send a rappel link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function rappel(Request $request)
    {
        $status = RappelMailClient::sendRappelLink(
            $request->input()
        );
        if($status==='RESET_LINK_SENT'){
            //activité envoie mail
            return back()->with('message', "mail bien envoyé");
        }else {
            return back()->with('errors', "Problème lors de l'envoie du mail");
        }
    }

}
