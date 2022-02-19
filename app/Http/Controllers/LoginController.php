<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\client;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):

            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {

        if($user->role == 1){
            return redirect()->intended('/dashboard');
        }elseif($user->role == 0){
            // passage du client de "en attente" à "actif", lors de sa 1ere connexion
            $client = client::where('mail', $user->email)->get();
            if($client[0]->status==0){
                $client[0]->status = 1;
                $client[0]->save();
            }
            return redirect()->intended('/questionnaire/listing');
        }else {
            return redirect()->intended('/login');
        }
    }
}
