<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acessorio;


class acessorioController extends Controller
{
    public function index(){
        $acessorios = Acessorio::orderBy('descricao')->get();
        return view('viewAcessorio',compact('acessorios'));
    }

    public function edit($id){
            $acessorios=Acessorio::find($id);
            return view('cadAcessorioView',compact('acessorios'));
    }

    public function update(Request $request, $id){
        $acessorios=Acessorio::find($id);
        $acessorios->descricao = $request->descricao;
        $acessorios->save();
        return redirect('/acessorios');
    }

    public function create(){
        return view('cadAcessorioView');
    }

    public function insert(Request $request){
        $verifica = Acessorio::where('descricao',$request->descricao)->get();
        if($verifica->count()){
         return 'Acessório já cadastrado';
        }
        else{
     $dados = new Acessorio([
            'descricao'=>$request->descricao,
            'valor'=>'0.00'
        ]);
            $dados->save();
            return redirect('/acessorios');
            }
    }

    public function delete($id){
        $acessorios=Acessorio::find($id);
        $acessorios->delete();
        return redirect('/acessorios');

    }
}
