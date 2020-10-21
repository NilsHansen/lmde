<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    public function authenticate(Request $request) {

        $this->validate($request, [
            'email' => 'required|max:255|email',
            'password' => 'required',
        ]);

        $cred = $request->only('email','password');

        if(Auth::attempt($cred)) {
            return redirect()->intended();
        }

        return back()->withErrors(new MessageBag(['email' => [__('Email and/or password invalid')]]));
    }
}
