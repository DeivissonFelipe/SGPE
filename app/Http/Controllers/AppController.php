<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;


class AppController extends Controller
{
    /**
     * Renderiza a página de configuração dos roles para cada usuário.
     */
    public function getAdminPage(){
        $users = User::all();
        return view('admin', ['users' => $users]);
    }

    /**
     * Registra uma função (role) para o usuário selecionado.
     * 
     * @param Request $request - Requisição HTTP com os campos do formulário
     * @return Illuminate\Http\RedirectResponse - Retorna a página de registro
     */
    public function postAdminAssignRoles(Request $request){
    	$user = User::where('email', $request['email'])->first();
    	$user->roles()->detach();
        
    	if($request['role_admin']){
    		$user->roles()->attach(Role::where('name', 'Admin')->first());
    	}
    	if($request['role_professor']){
    		$user->roles()->attach(Role::where('name', 'Professor')->first());
    	}
    	return redirect()->back();
    }

    /**
     * Desloga a sessão do usuário.
     */
    public function logout(){
        Auth::guard("web")->logout();
         
        return redirect('auth/login');
    }
}


 