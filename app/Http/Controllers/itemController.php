<?php
namespace App\Http\Controllers;

use DB;
use App\Models\Produto;
use App\Models\Ingrediente;
use App\Models\Item;
use App\Models\Atualiza;
use App\Models\Historico;
use App\Models\Parametros;

use App\Repositories\LanchesRepository;
use App\Repositories\ParametrosRepository;


use Illuminate\Http\Request;

class itemController extends Controller
{

  protected $lancheRepository;
  protected $parametrosRepository;

  public function __construct(LanchesRepository $lancheRepository, ParametrosRepository $parametrosRepository)
  {
      $this->lancheRepository = $lancheRepository;
      $this->parametrosRepository = $parametrosRepository;
  }

   public function index(Request $request){

    $params = 0;

    $markup[]= $this->parametrosRepository->parametros();
    $valorMarkup = $markup[0][3];
    $valorMarkupIfood = $markup[0][6];
    $valorMarkupIqfome = $markup[0][7];
    $parametros = $markup[0][8];

    $dados[]= $this->lancheRepository->obterDados($request);
    $psq = $dados[0][0];
    $lanches = $dados[0][1];
    $acessorios = $dados[0][2];
    $ingredientes = $dados[0][3];

return view('viewLanches',compact('params','ingredientes','lanches','psq','acessorios','valorMarkup','valorMarkupIfood','valorMarkupIqfome','parametros'));

   }

   public function index2(Request $request){
    $params = 1;
    $dados[]= $this->lancheRepository->obterDados($request);
    $lanches = $dados[0][1];
    return view('viewLanches',compact('params','lanches'));
   }

   public function create($id){
     $itens = DB::connection('mysql_2')->select('SELECT it.*, it.id as id_item, it.id_produto as id_produtos, ing.* FROM itens it, ingredientes ing WHERE it.id_ingrediente = ing.id and it.id_produto = ?',[$id]);

        $produto = Produto::find($id);
         $ingredientes = Ingrediente::orderBy('descricao')->get();
      return view('cadItem',compact('produto','ingredientes','itens'));
   }

      public function insert(Request $request){

         $dados = new Item([
            'id_ingrediente'=>$request->ingredientes,
            'id_produto'=>$request->produto,
            'qtd'=>$request->qtd,
            'qtdOleoFritadeira'=>$request->qtdOleoFritadeira,
            'qtdPorcaoFritadeira'=>$request->qtdPorcaoFritadeira
        ]);
            $dados->save();
            return redirect("/cadastro/item/$request->produto");
            }

      public function delete(Request $request, $id,$id_produto){
            $item = Item::find($id);
            $item->delete();
          return redirect("/cadastro/item/$id_produto");
      }

      public function historicoProduto(Request $request)
      {
        $params = Parametros::find(3);

        $markup[]= $this->parametrosRepository->parametros();
        $valorMarkup = $markup[0][3];

          $dados[] = $this->lancheRepository->obterDados($request);
          $psq = $dados[0][0];
          $lanches = $dados[0][1];
          $acessorios = $dados[0][2];
          $ingredientes = $dados[0][3];

          $resul = 0;
          $total_ingredientes = 0;
          $total_acessorio=0;


          foreach ($ingredientes as $ingrediente)
          {
          if($ingrediente->desc_prod == $psq){

            $id_produto = $ingrediente->id_produto;

        /*  if($ingrediente->unidMedida == 'kilo' && $ingrediente->desc_prod == $psq){
          $resul = ($ingrediente->valor*$ingrediente->qtd)/1000;
          $total_ingredientes = $total_ingredientes + $resul;
          }


  if($ingrediente->unidMedida == 'litro' && $ingrediente->qtdOleoFritadeira == null && $ingrediente->qtdPorcaoFritadeira == null && $ingrediente->desc_prod == $psq)
  {
      $resul = ($ingrediente->valor*$ingrediente->qtd)/900;
      $total_ingredientes = $total_ingredientes + $resul;
  }

   if($ingrediente->qtdOleoFritadeira != null and $ingrediente->qtdPorcaoFritadeira != null ){
      $resul = ($ingrediente->valor*$ingrediente->qtdOleoFritadeira)/$ingrediente->qtdPorcaoFritadeira;
      $total_ingredientes = $total_ingredientes + $resul;
   }


  if($ingrediente->unidMedida == 'porcao' && $ingrediente->desc_prod == $psq)
  {
       $valor_cada_porcao = ($ingrediente->valor/$ingrediente->qtd_porcao);
       $resul = ($valor_cada_porcao*$ingrediente->qtd);
       $total_ingredientes = $total_ingredientes + $resul;
  }


     if($ingrediente->unidMedida == 'unidade' && $ingrediente->desc_prod == $psq)
            {
                $resul = ($ingrediente->valor*$ingrediente->qtd);
                $total_ingredientes = $total_ingredientes + $resul;
            }*/

   }
   }
     /* foreach ($acessorios as $acessorio)
          {
          if($acessorio->desc_prod == $psq)
            {
         $total_acessorio = ($total_acessorio+$acessorio->valor*$acessorio->qtd_itens);
            }
          }*/

        //  $custo_produto = ($total_acessorio+$total_ingredientes);
         // $valor_lucro = number_format($custo_produto*$valorMarkup, 2, '.', '.');

          if($psq != null){
            $item = Atualiza::where('id_produto',$id_produto)->first();
            if($item){
              $produto=Atualiza::find($item->id);
              $valor_atual = $produto->valor_atual;
              $valor_anterior = $produto->valor_anterior;

              $dados_historico = historico::where('id_produto',$id_produto)->get();
            }

          }else{

          $valor_atual = 0;
          $valor_anterior = 0;
          $dados_historico[] = ["created_at"=>"1900","valor"=>0];
          }

          return view('viewHistoricoProdutos',compact('lanches','psq','valor_atual','valor_anterior','dados_historico','valorMarkup'));
      }

}
