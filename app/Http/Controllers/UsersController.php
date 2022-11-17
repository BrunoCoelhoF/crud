<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(){
        //$users = User::get();
        $users= DB::table('users')
        ->join('profiles','users.id_profiles','=','profiles.id')
        ->select('users.*','profiles.description')
        ->get();
        return view('users.list',['users' => $users]);
    }

    public function new(){
        $profiles = DB::table('profiles')->get();
        return view('users.form',['profiles'=>$profiles]);
    }

    public function add(Request $request){
        $user = new User;
        $user = $user->create([
            'name' => $request['inputName'],
            'email' => $request['inputEmail'],
            'password' => Hash::make($request['inputPassword']),
            'cpf' => $request['inputCpf'],
            'id_profiles' => (int) $request['idProfile']
        ]);
        return Redirect::to('/users/edit/'.$user->id);
    }

    public function edit($id){
        $user = User::findOrFail( $id );
        $user['password'] =  '';
        $profiles = DB::table('profiles')->get();
        $address = DB::table('users_address')->where('id_users','=',$id)->get();
        return view('users.form',['user' => $user, 'profiles'=>$profiles, 'address' => $address]);
    }

    public function update($id, Request $request){
        $user = User::findOrFail( $id );
        $user->update([
            'name' => $request['inputName'],
            'email' => $request['inputEmail'],
            'password' => Hash::make($request['inputPassword']),
            'cpf' => $request['inputCpf'],
            'id_profiles' => (int) $request['idProfile']
        ]);
        return Redirect::to('/users');
    }

    public function delete($id){
        $user = User::findOrFail( $id );
        $user->delete();
        return Redirect::to('/users');
    }

    public function addr($id, Request $request){
        DB::table('users_address')->insert(
            ['cep' => $request['inputCep'], 
            'description' => $request['inputLogradouro'],
            'id_users' => $id
            ]
        );
        return Redirect::to('/users/edit/'.$id);
    }

    public function deladdr($id,$idUser){
        DB::table('users_address')->where('id', '=', $id)->delete();
        return Redirect::to('/users/edit/'.$idUser);
    }
}
