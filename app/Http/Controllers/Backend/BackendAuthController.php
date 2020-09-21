<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackendAuthController extends Controller
{

    public function index()
    {

        return view('backend.login');
    }

    public function login(Request $request)
    {
        // validate
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // auth
        $credentials = $request->only('email', 'password');

        $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;

        if (Auth::attempt($credentials, $remember_me)) {
            // Authentication passed...
            return redirect()->intended('backend');
        }

        return view('backend.login');
    }
}
