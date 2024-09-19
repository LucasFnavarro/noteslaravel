<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class AuthController extends Controller
{
    // Retorna a página de login pra rota 
    public function index()
    {
        return view('login');
    }

    // faz toda a regra de negócios do login
    public function loginSubmit(Request $request)
    {
        // Validação dos campos inputs do formulário
        $request->validate(
            [
                // Força o usuário inserir algo no input
                // e força ser do tipo email, faz o mesmo na senha
                // e pede para que a senha seja de 6 a 16 caracteres
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

        // Recebe os dados passados pelo input do front-end
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // Verifica se o usuário passado no input existe,
        //  ele verifica se o mesmo não foi deletado e trás o primeiro
        $user = User::where('username', $username)->where('deleted_at', null)->first();

        // Mensagem de erro caso o usuário não siga as regras a cima...
        // Faz o redirecionamento caso o usuário não existe, mantendo os dados no input!
        if (!$user) {
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha incorreto.');
        }

        // Verifica se a password não foi verificada,
        // E faz o redirecionamento mostrando a msg de erro e mantendo os dados no input.
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha incorreto.');
        }

        // Cria a data e a hora que o usuário fez o último login
        // E salva no BD
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // Se o usuário exister no BD e não cair nas condições a cima,
        // Ele passa pra session que tem um user nela!
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // redireciona para a página inicial após a validação
        return redirect()->to('/');
    }

    // Regra de negócio do logout.
    public function logout()
    {
        // Remove os dados do usuário na sessão 
        // e redireciona para pag. login
        session()->forget('user');
        return redirect()->to('/login');
    }
}
