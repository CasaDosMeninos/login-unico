<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\User;
use Validator;
use Illuminate\Support\Facades\Mail;

class CadastroController extends Controller
{

    public function get()
    {

        return view('cadastro');
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [ 'email' => 'ldap_exists' ]);
        if ($validator->fails()) {
            $_SESSION['error'] = 1;
            return redirect()->route('cadastro');
        }

        $user = new User();
        $user->fill($request->except('submit'));

        if($user->cadastra()) {
            $_SESSION['success'] = 1;
//            $this->enviaEmail($user);
            return redirect()->route('cadastro');
        }

        return view('cadastro');
    }

    public function enviaEmail(User $user)
    {
        Mail::send('email.ativar', ['nome' => $user->nome, 'url' => 'teste'], function($m) use ($user) {
            $m->to($user->email, $user->nome)
                ->subject('[Casa dos Meninos] Ativar conta');
        });
    }
}
