<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function calendar() {
        return view('calendar');
    }

    public function submit(Request $request) {

        //form validations
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ],
            [
                //email error
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'Introduza um endereço de email válido.',

                //password error
                'password.required' => 'A palavra-passe é obrigatória',
                'password.min' => 'A palavra-passe deve ter pelo menos :min caracteres.',
            ]
        );

        //get user input
        $email = $request->input('email');
        $password = $request->input('password');

        //check user exists
        $user = Users::where('email', $email)
                    ->first();

        if(!$user){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('LoginError' , 'Email ou Password incorretos');
        }

        //check password is correct
        if(!password_verify($password, $user->password)){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('LoginError' , 'Email ou Password incorretos');
        }

        //last login
        $user->last_login = now();
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'force_password_reset' => password_verify('abc123456', $user->password),
        ]);

        //redirect to page
        return redirect()->route('dashboard');

    }

    public function updatePassword(Request $request)
    {
        $sessionUser = session('user');

        if (!$sessionUser) {
            return redirect()->route('login');
        }

        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'A nova palavra-passe é obrigatória',
            'password.min' => 'A nova palavra-passe deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação não coincide.',
        ]);

        $user = Users::find($sessionUser['id']);

        if (!$user) {
            return redirect()->route('login');
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        session()->forget('force_password_reset');

        return redirect()->back()->with('success', 'Palavra-passe alterada com sucesso.');
    }

    public function logout(){

        session()->forget('user');
        return redirect()->to('login');
    }
}
