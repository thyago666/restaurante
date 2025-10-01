<?php

namespace App\Http\Controllers;
use App\Models\Faturamento;
use Illuminate\Http\Request;
use App\Repositories\ParametrosRepository;
use Illuminate\Support\Facades\Gate;

class faturamentoController extends Controller
{
    protected $parametrosRepository;

    public function __construct(ParametrosRepository $parametrosRepository)
    {
        $this->parametrosRepository = $parametrosRepository;
    }

    public function create(){
        if (Gate::allows('viewUser')) {
        return view('createFaturamento');
        }else{
            abort(403);
        }
    }

   /* public function insert(Request $request){
        if (Gate::allows('viewUser')) {
            $valor = str_replace(",",".",$request->valor);
        $dados = new Faturamento([
            'lucro'=>$request->lucro,
            'valor'=>$valor,
            'markup'=>0,
        ]);
            $dados->save();
            return redirect()->route('indexParam');
    }else{
        abort(403);
    }
    }*/

    public function alterar($id){
        if (Gate::allows('viewUser')) {
        $item = Faturamento::find($id);
        return view('editFaturamento',compact('item'));
        }else{
            abort(403);
        }
       
  }

  public function update($id, Request $request){
    if (Gate::allows('viewUser')) {
        $valor = str_replace(",",".",$request->valor);
    $faturamento=Faturamento::find($id);
    $faturamento->valor = $valor;
    $faturamento->lucro = $request->lucro;
    $faturamento->save();
    return redirect()->route('indexParam');
    }else{
        abort(403);
    }
  }

          
}
