<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function loginSubmit(Request $request) {
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            [
                'text_username.required' => 'É obrigatório fornecer um username',
                'text_username.email' => 'O username deve ser um email válido!',
                'text_password.required' => 'É obrigatório fornecer uma password',
                'text_password.min' => 'A password deve conter no minimo :min caracteres',
                'text_password.max' => 'A password deve conter no máximo :max caracteres'
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');


        $user = User::where('username', $username)->where('deleted_at', null)->first();

        if(!$user){
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou password incorreto.');
        }

        if(!password_verify($password, $user->password)){
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou password incorreto.');
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user' =>[
                'id' => $user->id,
                'username' => $user->username
            ]
            ]);

        echo "Login efetuado com sucesso.";
    }


    public function logout(){
        session()->forget('user');
        return redirect()->to('/login');
    }
}
