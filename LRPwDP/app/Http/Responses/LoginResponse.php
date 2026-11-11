<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Handle the response after a successful login.
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        // Check the user's role
        if ($user->role === 'customer') { 
            return redirect()->intended('/home');
        }
        else{
        return redirect()->intended('/dashboard');
        }
    }
}
