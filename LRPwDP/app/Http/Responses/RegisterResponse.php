<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Illuminate\Support\Facades\Auth;

class RegisterResponse implements RegisterResponseContract
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
