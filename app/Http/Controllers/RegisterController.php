<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Display register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        $mailuser=explode("@", $request->email);
        // if dans if car je sais pas pourquoi
        // if($mailuser[1]!=='itsense.fr' || $mailuser[1]!=='admin.fr')
        // ça marchait pour admin.fr mais pas itsense.fr
        // alors que comme ça ça marche
        if($mailuser[1]!=='itsense.fr'){
            if($mailuser[1]!=='admin.fr') {
                return redirect('/forgot-password')->with('error', "Seul l'entreprise peut créer votre compte, si vous avez oublié votre mot de passe merci de faire une demande de réinitialisation");
            }
            return redirect('/forgot-password')->with('error', "Seul l'entreprise peut créer votre compte, si vous avez oublié votre mot de passe merci de faire une demande de réinitialisation");
        }

        $user = new user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->name;
        $user->role = 1;
        $user->password = bcrypt($request->password); //et on crypte le MDP
        $user->save();

        auth()->login($user);
        return redirect('/dashboard')->with('success', "Account successfully registered.");
    }
}
