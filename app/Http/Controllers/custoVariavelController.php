<?php

namespace App\Http\Controllers;
use App\Models\CustoVariavel;

use Illuminate\Http\Request;

class custoVariavelController extends Controller
{
   public function create(){

        return view('createCustoVariavel');
    }

    public function insert(Request $request){
        $valor = str_replace(",",".",$request->valor);
        $dados = new CustoVariavel([
            'descricao'=>$request->descricao,
            'valor'=>$valor,
        ]);
            $dados->save();
          return redirect()->route('indexParam');
    }

    public function delete($id){
        $item = CustoVariavel::find($id);
        $item->delete();
       return redirect()->route('indexParam');
       
  }
    
}
