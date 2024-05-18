<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user['email'] == 'admin@gmail.com') {
                return redirect()->intended('/admin/dashboard');
            }
        } else {
            return back()->withErrors([
                'email' => 'Verififer',
                'password' => 'Verifier'
            ])->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function clientlog(Request $request){
        $data = $request->validate([
            'password' => 'required|regex:#03[2843][0-9]{7}$#',
        ],[
            'password.regex' => 'Vous devez inserer un numero valides'
        ]);


        $contact = $request->input('password');
        $client = Client::where('contact',$contact)->first();
        if($client){
            $request->session()->regenerate();
            Session::put('client',$client->idclient);
            return redirect()->intended('/client/demand');
        }else{
            $user = new Client();
            $request->session()->regenerate();
            $id = $user->insertContact($contact);
            Session::put('client',$id);
            return redirect()->intended('/client/demand');
        }

    }


    public function inscription(Request $request){
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $data['profile']=1;
        $client = $request->validate([
            'nom' => 'required',
            'datedenaissance' => 'required',
            'numero' => 'required',
            'adresse' => 'required',
        ]);
        $user = new User();
        $id = $user->insert($data);
        $user->insertClient($id,$client);
        return redirect()->intended('/');
    }
}
