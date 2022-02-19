<?php

namespace App\Extensions\Passwords;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Str;
use App\Extensions\Mail\createMdpClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordClient
{
 /**
     * Send a password reset link to a user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendCreateLink($request)
    {

        $mail=$request['email'];
        $user = user::where('email', $mail)->first();
        $token = str::random(40);
        $tokenCrypt = Hash::make($token);
        $date = date('Y-m-d H:i:s');

        $resetExist=DB::table('password_resets')->where(['email' => $mail])->first();
        if($resetExist){
            $password_resets = DB::table('password_resets')->where(['email' => $mail])->delete();
        }

        $password_resets=DB::table('password_resets')->UpdateOrInsert(
            ['email' => $mail, 'token' => $tokenCrypt, 'created_at' => $date],
        );


        if($password_resets===true){
            $user->notify(new createMdpClient($user, $token));
        }else {
            return 'RESET_LINK_NOT_SENT';
        }
        return 'RESET_LINK_SENT';
    }
}
