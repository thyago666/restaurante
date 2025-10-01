<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class usuarioController extends Controller
{
    public function index(){

            $usuario = User::all();
           // dd($user);
           return view('viewUsuarios',compact('usuario'));


    }

    public function create(){
        return view('auth.register');
    }
}
