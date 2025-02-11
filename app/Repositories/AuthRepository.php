<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class AuthRepository 
{

    public function login($request)
    {
      
        if(Auth::attempt([
            'email'     => $request['email'],
            'password'  => $request['password'],
            'status'    => 1 ] ,
            isset($request['remember']) && ( $request['remember'] == 1 ? true : false ) ))
        {
            return true;

        }

        return false;
    }
}
