<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use App\Models\Item;
use App\Models\Produto;
use App\Models\HistoricoIngredientes;

use Illuminate\Http\Request;
use App\Repositories\LanchesRepository;
use App\Repositories\ParametrosRepository;
use Illuminate\Support\Facades\DB;


class ingredienteController extends Controller
{
    protected $lancheRepository;
    protected $parametrosRepository;

    public function __construct(LanchesRepository $lancheRepository, ParametrosRepository $parametrosRepository)
  {
      $this->lancheRepository = $lancheRepository;
      $this->parametrosRepository = $parametrosRepository;
  }

    public function index(){
       $ingredientes = Ingrediente::orderBy('descricao')->get();
      return view('viewIngrediente',compact('ingredientes'));
    }


    public function create(){
     
        $produtos = Produto::where('tipo','=','ingrediente')->orderBy('descricao')->get();
     return view('cadIngredienteView',compact('produtos'));
    }

    public function update($id, Request $request){

        $ingredientes=Ingrediente::find($id);
        $ingredientes->descricao = $request->descricao;
        $ingredientes->descricaoSimples = $request->descricaoSimples;
        $ingredientes->unidMedida = $request->unidade_medida;
          $ingredientes->estMinimo = $request->estoqueMinimo;
        $ingredientes->save();
        return redirect('/ingrediente');
   }

    public function edit($id){

        $ingredientes=Ingrediente::where('id',$id)->first();
        return view('editIngredienteView',compact('ingredientes'));
   }

    public function insert(Request $request){

        $verifica = Ingrediente::where('descricao',$request->descricao)->get();
         if($verifica->count()){
         return 'Ingrediente já cadastrado';
        }
        else
        {

            if($request->tp == 'fn'){

                $idProd = null;
            }else{
                $idProd = $request->id_produto;
            }
     $dados = new Ingrediente([
            'descricao'=>$request->descricao,
            'descricaoSimples'=>$request->descricaoSimples,
            'unidMedida'=>$request->unidade_medida,
            'valor'=>'0.00',
            'qtd_porcao'=>$request->qtdField,
            'tipo'=>$request->tp,
            'id_produto'=>$idProd,
            'tipoProduto'=>$request->unidade_medida,
            'estMinimo'=>$request->estoqueMinimo
        ]);
          $dados->save();
       return $this->index();
   }

}
    public function delete($id){
        $item = Ingrediente::find($id);
        $item->delete();
        return redirect('/ingrediente');
    }

    public function selectIngrediente(){
        $ingredientes = Ingrediente::orderBy('descricao')->get();
        $params = 0;
        return view('viewHistoricoIngredientes',compact('params','ingredientes'));
    }

    public function historicoIngrediente(Request $request){

       $markup[]= $this->parametrosRepository->parametros();
        $valorMarkup = $markup[0][3];
          $params = 1;
         $psq = $request->selectIngrediente;
         if($psq != null){
              $dados_historico = historicoIngredientes::where('id_ingrediente',$psq)->get();
            }
          else{
             $dados_historico[] = ["created_at"=>"1900","valor"=>0];
          }
          $ingredientes = Ingrediente::orderBy('descricao')->get();
          $ing = Ingrediente::where('id',$psq)->first();

          return view('viewHistoricoIngredientes',compact('psq','ing','ingredientes','dados_historico','params'));
    }

    public function atualizaIngredienteTipoProduto($idIngrediente)
    {
    

        $ing = Ingrediente::where('id',$idIngrediente)->first();
        $itens = Item::join('ingredientes', 'ingredientes.id', '=', 'itens.id_ingrediente')
       ->selectRaw('itens.*, ingredientes.*') // Seleciona todas as colunas de ambas as tabelas
       ->where('itens.id_produto', $ing->id_produto)
       ->get();
       
                 $soma = 0;
                $vl_kg = 0;
                $total_ingredientes = 0;
                $tipoProduto = 'unidade';
                foreach($itens as $item)
                {
                    
                    if($ing->tipoProduto === 'kilo')
                    {
                 
                        if($item->unidMedida === 'kilo' || $item->unidMedida === 'litro')
                        {
                        $soma+= ($item->valor * $item->qtd)/1000;
                        $vl_kg += $item->qtd/1000;
                        }
                         $total_ingredientes = $soma/$vl_kg;
                    }
                    
                
                    elseif($ing->tipoProduto === 'unidade')
                    {
                
                        if($item->unidMedida === 'kilo')
                        {
                            $soma = ($item->valor*$item->qtd)/1000;
                        $total_ingredientes = $total_ingredientes + $soma;
                        }
                        if($item->unidMedida === 'unidade')
                        {
                            $soma = ($item->valor*$item->qtd);
                        $total_ingredientes = $total_ingredientes + $soma;
                        }
                        if($item->unidMedida === 'porcao')
                        {
                            $valor_cada_porcao = ($item->valor/$item->qtd_porcao);
                            $soma = ($valor_cada_porcao*$item->qtd);
                        $total_ingredientes = $total_ingredientes + $soma;
                        }
                    }

                    
                }
                  //  $somaTotal = $soma/$vl_kg;
                    $ing->valor = $total_ingredientes;
                    $ing->save();
                    return redirect('/ingrediente');
    }

    public function baixaEstoque(Request $request)
    {
        $params = 1;
        $dados[]= $this->lancheRepository->obterDados($request);
        $lanches = $dados[0][1];
        return view('viewBaixaIng',compact('params','lanches'));
    }

    public function baixaIngrediente(Request $request)
    {
        $codigoProduto = $request->selectLanche;
            $itens = DB::table('itens')
                ->select('id_ingrediente', DB::raw('SUM(qtd) as total_qtd'))
                ->where('id_produto', $codigoProduto)
                ->groupBy('id_ingrediente')
                ->get();
            foreach ($itens as $item) {
                DB::table('ingredientes')
                    ->where('id', $item->id_ingrediente)
                    ->decrement('qtd_estoque', $item->total_qtd);
                }
                return redirect()->back()->with('success', 'Ingredientes atualizados com sucesso');
    }

    public function exibeEstoque()
    {
        $ingredientes = Ingrediente::orderBy('descricao')->get();
         return view('viewExibeEstoque',compact('ingredientes'));
    }

}
