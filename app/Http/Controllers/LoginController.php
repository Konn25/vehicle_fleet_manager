<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $loginData = [
                'username' => $user->name,
                'email' => $user->email,
                'admin' => $user->admin ?? 0
            ];

            return view('index', ['data' => $loginData]);
        }

        return back()->withErrors([
            'email' => 'Hibás email vagy jelszó.'
        ]);
    }


    public function index()
    {
        $users = User::all();
        return $users;
    }
}
