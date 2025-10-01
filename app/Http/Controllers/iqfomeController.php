<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iqfome;

class iqfomeController extends Controller
{
     public function create(){
      return view('createIqfome');
    }

    public function insert(Request $request){
      $valor = str_replace(",",".",$request->valor);
        $dados = new Iqfome([
            'descricao'=>$request->descricao,
            'valor'=>$valor,
        ]);
            $dados->save();
           return redirect()->route('indexParam');
    }

    public function delete($id){
        $item = Iqfome::find($id);
        $item->delete();
       return redirect()->route('indexParam');
       
  }

  public function alterar($id){
    $item = Iqfome::find($id);
    return view('editIqfome',compact('item'));
   
}

  public function update($id, Request $request){
        $valor = str_replace(",",".",$request->valor);
        $ifood=Iqfome::find($id);
        $ifood->descricao = $request->descricao;
        $ifood->valor = $valor;
        $ifood->save();
   return redirect()->route('indexParam');
  }
}
