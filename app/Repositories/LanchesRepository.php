<?php

namespace App\Repositories;

use App\Models\Produto;
use App\Models\Atualiza;
use App\Models\Ingrediente;
use App\Models\Entrada;
use App\Models\EntradaAcessorio;
use App\Models\Historico;
use App\Models\HistoricoIngredientes;
use App\Models\Acessorio;
use App\Models\Item;
use DB;
use Illuminate\Http\Request;
use App\Repositories\ParametrosRepository;


class LanchesRepository
{

    protected $lancheRepository;
    protected $parametrosRepository;

    public function __construct(ParametrosRepository $parametrosRepository)
    {
        $this->parametrosRepository = $parametrosRepository;
    }

    public function obterDados(Request $request)
    {
        $psq=$request->selectLanche;
        $lanches = Produto::where('situacao',1)->orderBy('descricao')->get();
        $acessorios = DB::connection('mysql_2')->table('itens_acessorios as ita')
        ->join('acessorios as ace', 'ace.id', '=', 'ita.id_acessorio')
        ->join('produtos as pr', 'pr.id', '=', 'ita.id_produto')
        ->select('ita.qtd as qtd_itens', 'ace.*', 'pr.*', 'pr.descricao as desc_prod', 'pr.id as idProd', 'ace.descricao as ace_descricao')
        ->get();

        $ingredientes = DB::connection('mysql_2')->table('itens as it')
        ->join('ingredientes as ig', 'ig.id', '=', 'it.id_ingrediente')
        ->join('produtos as pr', 'pr.id', '=', 'it.id_produto')
        ->select('ig.*', 'ig.descricao as ing_descricao', 'ig.unidMedida', 'pr.*','pr.id as id_produto', 'pr.descricao as desc_prod', 'it.*')
        ->get();

       return ([$psq,$lanches,$acessorios,$ingredientes]);
    }
    
    
    public function calculoIngredientes(Request $request)
    {
         
      $dados[]= $this->obterDados($request);
        $acessorios = $dados[0][2];

        $valor_total = str_replace(",",".",$request->valor_total);
        $dados = new Entrada([
            'id_ingrediente'=>$request->ingrediente,
            'qtd'=>$request->qtd,
            'valor_total'=>$valor_total

        ]);
            $dados->save();
            $ingredientes=Ingrediente::find($request->ingrediente);

            //atualizando valor da tabela ingredientes
            if($request->unid_medida == 'kg'){
                $atual = ($valor_total*1000)/$request->qtd;//calcula o valor do kilo
            }elseif($request->unid_medida == 'un' || $request->unid_medida == 'po' ){
                $atual = ($valor_total/$request->qtd);
            }
            elseif($request->unid_medida == 'lt'){
                $atual = ($valor_total/$request->qtd);
            }

            $ingredientes->valor = $atual;
            $ingredientes->qtdEmb = $request->qtdEmb;
           
            //acerto de estoque
            if($request->unid_medida == 'po'){
                $ingredientes->qtd_estoque += ($request->qtd * 5);
                //dd($ingredientes->qtd_estoque );
            }
             elseif($request->unid_medida == 'lt'){
                $ingredientes->qtd_estoque += ($request->qtdEmb + $ingredientes->qtd_estoque);
            }
            else{
                $ingredientes->qtd_estoque = ($request->qtd  + $ingredientes->qtd_estoque); 
            }
            $ingredientes->save();
             
             $dados = new HistoricoIngredientes([
                'id_ingrediente'=>$request->ingrediente,
                'valor'=>$atual,
             
            ]);
              $dados->save();

            //calculo novo valor
           $markup[]= $this->parametrosRepository->parametros();
            $valorMarkup = $markup[0][3];
              $resul = 0;
              $total_ingredientes = 0;
              $total_kg = 0;

              $idsProduto = DB::connection('mysql_2')->select("SELECT id_produto FROM itens WHERE id_ingrediente = ?", [$request->ingrediente]);
                if(!$idsProduto){
                    dd('Esse ingrediente não está cadastrado em nenhum produto ainda');
                }

              $ids_produto = [];
              foreach ($idsProduto as $row) {
                  $ids_produto[] = $row->id_produto;
                }
                $ids_produto_str = implode(',', $ids_produto);

                $calculos=DB::connection('mysql_2')->select("select ig.unidMedida, 
                ig.qtd_porcao,ig.qtdEmb, ig.valor,ig.tipo,ig.id, it.qtd, it.qtdOleoFritadeira,
                it.qtdPorcaoFritadeira, it.id_produto
                from itens it, ingredientes ig
                where it.id_produto IN($ids_produto_str) and ig.id = it.id_ingrediente");
              //  dd($calculos);
                $total_ingredientes = array();
                foreach ($calculos as $calculo)
                {
                    $codigo = $calculo->id_produto;

                if (!isset($total_ingredientes[$codigo])) {
                    $total_ingredientes[$codigo] = 0;
                }

                if($calculo->unidMedida === 'kilo'){
                    $resul = ($calculo->valor*$calculo->qtd)/1000;
                    $total_ingredientes[$codigo] += $resul;
                    $total_kg += $calculo->qtd;
                }

                if($calculo->unidMedida === 'litro' && $calculo->qtdOleoFritadeira == null && $calculo->qtdPorcaoFritadeira == null)
                {
                       $resul = ($calculo->valor*$calculo->qtd)/$calculo->qtdEmb;
                            $total_ingredientes[$codigo] += $resul;
                        }
                        if($calculo->qtdOleoFritadeira != null and $calculo->qtdPorcaoFritadeira != null ){
                        $resul = ($calculo->valor*$calculo->qtdOleoFritadeira)/$calculo->qtdPorcaoFritadeira;
                        $total_ingredientes[$codigo] += $resul;
                        }

                        if($calculo->unidMedida === 'porcao')
                        {
                            $valor_cada_porcao = ($calculo->valor/$calculo->qtd_porcao);
                            $resul = ($valor_cada_porcao*$calculo->qtd);
                            $total_ingredientes[$codigo] += $resul;
                        }

                        if($calculo->unidMedida === 'unidade')
                        {
                            $resul = ($calculo->valor*$calculo->qtd);
                            $total_ingredientes[$codigo] += $resul;
                        }
              }
         
    
                //somando o calculo dos acessorios
                $acessorios = DB::connection('mysql_2')->select("SELECT it.qtd as qtd, it.id_produto as IdProd,
                 ac.id as Idacessorio, ac.valor
                FROM itens_acessorios as it, acessorios as ac
                WHERE it.id_produto IN ($ids_produto_str) AND ac.id = it.id_acessorio");

                    $total_acessorios = array();
                    foreach ($acessorios as $key => $acessorio)
                    {
                     $codigo = $acessorio->IdProd;
                    if (!isset($total_acessorios[$codigo])) {
                    $total_acessorios[$codigo] = 0;
                    }
                    $total_acessorios[$codigo] += ($acessorio->valor*$acessorio->qtd);
                }
                //fim somando o calculo dos acessorios
       
                
                foreach ($total_ingredientes as $codigo => $somaIngredientes) {
                    if(isset($total_acessorios[$codigo])){
                        $somaTotal = ($total_acessorios[$codigo]+$somaIngredientes);
                            }else{
                                $somaTotal = (0+$somaIngredientes);
                            }
                      //  $somaMarkup = $somaTotal*$valorMarkup;
                        $produto=Atualiza::where('id_produto',$codigo)->first();
                
                        if($produto){
                            $produto=Atualiza::find($produto->id);

                        if($produto->valor_atual != $somaTotal){
                            $produto->valor_atual = number_format($somaTotal, 2, '.', '.');
                          
                          $valorAnterior = DB::connection('mysql_2')->select("SELECT * 
                            FROM historico_produtos 
                            WHERE id_produto = $produto->id_produto
                            AND DATE(created_at) <> CURDATE()
                            ORDER BY created_at DESC
                            LIMIT 1;
                         ");
                         if(!$valorAnterior){
                            $produto->valor_anterior = 0;
                         }else{
                         $produto->valor_anterior = $valorAnterior[0]->valor;
                         }
                         $produto->save();

                         $codProduto = Historico::where('id_produto', $produto->id_produto)
                         ->whereDate('created_at', '=', now()->toDateString())
                         ->first();
                       //  dd($codProduto->id);
                         
                         if(!$codProduto){
                             $dados = new Historico([
                                 'id_produto'=>$codigo,
                                 'valor'=>number_format($somaTotal, 2, '.', '.'),
                                ]);
                                $dados->save();
                            }else{
                                $chavePrimaria = $codProduto->id;
                         $codProduto = Historico::find($chavePrimaria);
                         $codProduto->valor = number_format($somaTotal, 2, '.', '.');
                         $codProduto->save();
                       }
                        }
                    }
                        else{
                             $dados = new Atualiza([
                          'id_produto'=>$codigo,
                          'valor_anterior'=>0,
                          'valor_atual'=>number_format($somaTotal, 2, '.', '.')
                      ]);
                          $dados->save();
                      }
            }
            
   //atualizando produtos do tipo ingredientes
    $chaves = Ingrediente::whereNotNull('id_produto')->pluck('id');

    if(!$chaves->isEmpty())
    {
        foreach($chaves as $chave)   
        {
           $this->atualizaIngredienteTipoProduto($chave);
        }   
    }

    //atualizando estoque

    //fim
            return redirect()->route('entrada');
        }

         public function calculoAcessorios(Request $request){

           $markup[]= $this->parametrosRepository->parametros();
            $valorMarkup = $markup[0][3];
               $dados[]= $this->obterDados($request);
               $total_ingredientes = 0;
              $valor_total = str_replace(",",".",$request->valor_total);

              $dados = new EntradaAcessorio([
                 'id_acessorio'=>$request->acessorios,
                  'qtd'=>$request->qtd,
                  'valor_total'=>$valor_total,
              ]);
                  $dados->save();

                  $vl_unitario = ($valor_total/$request->qtd);
                  $acessorios=Acessorio::find($request->acessorios);
                  $acessorios->valor = $vl_unitario;
                  $acessorios->save();

                //calculando novo valor dos acessorios

                $idsAcessorios = DB::connection('mysql_2')->select("SELECT id_acessorio, id_produto FROM itens_acessorios WHERE id_acessorio = ?", [$request->acessorios]);
                if(!$idsAcessorios){
                    dd('Esse acessório não está cadastrado em nenhum produto ainda');
                }

                 $ids_produto = [];
                foreach ($idsAcessorios as $row) {
                    $ids_produto[] = $row->id_produto;
                  }
                  $ids_produto_str = implode(',', $ids_produto);

                    $acessorios = DB::connection('mysql_2')->select("SELECT it.qtd as qtd, it.id_produto as IdProd,
                     ac.id as Idacessorio, ac.valor
                    FROM itens_acessorios as it, acessorios as ac
                    WHERE it.id_produto IN ($ids_produto_str) AND ac.id = it.id_acessorio");

                        $total_acessorios = array();
                        foreach ($acessorios as $key => $acessorio)
                        {
                         $codigo = $acessorio->IdProd;
                        if (!isset($total_acessorios[$codigo])) {
                        $total_acessorios[$codigo] = 0;
                        }
                        $total_acessorios[$codigo] += ($acessorio->valor*$acessorio->qtd);
                   }

                    //iniciando calculo dos ingredientes
                    $calculos=DB::connection('mysql_2')->select("select ig.unidMedida, ig.qtd_porcao, ig.valor,ig.tipo,ig.id,ig.qtdEmb, it.qtd, it.qtdOleoFritadeira, it.qtdPorcaoFritadeira, it.id_produto
                    from itens it, ingredientes ig
                    where it.id_produto IN($ids_produto_str) and ig.id = it.id_ingrediente");

                    $total_ingredientes = array();
                    foreach ($calculos as $key => $calculo)
                  {

                   $codigo = $calculo->id_produto;

                   if (!isset($total_ingredientes[$codigo])) {
                       $total_ingredientes[$codigo] = 0;
                   }

                   if($calculo->unidMedida === 'kilo'){
                       $resul = ($calculo->valor*$calculo->qtd)/1000;
                       $total_ingredientes[$codigo] += $resul;
                   }

                   if($calculo->unidMedida === 'litro' && $calculo->qtdOleoFritadeira == null && $calculo->qtdPorcaoFritadeira == null)
                   {
                          $resul = ($calculo->valor*$calculo->qtd)/$calculo->qtdEmb;
                               $total_ingredientes[$codigo] += $resul;
                           }
                           if($calculo->qtdOleoFritadeira != null and $calculo->qtdPorcaoFritadeira != null ){
                           $resul = ($calculo->valor*$calculo->qtdOleoFritadeira)/$calculo->qtdPorcaoFritadeira;
                           $total_ingredientes[$codigo] += $resul;
                           }

                           if($calculo->unidMedida === 'porcao')
                           {
                               $valor_cada_porcao = ($calculo->valor/$calculo->qtd_porcao);
                               $resul = ($valor_cada_porcao*$calculo->qtd);
                               $total_ingredientes[$codigo] += $resul;
                           }

                           if($calculo->unidMedida === 'unidade')
                           {
                               $resul = ($calculo->valor*$calculo->qtd);
                               $total_ingredientes[$codigo] += $resul;
                           }
                 }


                 foreach ($total_acessorios as $codigo => $somaAcessorios) {

                      $somaTotal = ($somaAcessorios + $total_ingredientes[$codigo]);
                      // $somaMarkup = $somaTotal*$valorMarkup;

                       $produto=Atualiza::where('id_produto',$codigo)->first();
                       if($produto){
                           $produto=Atualiza::find($produto->id);

                       if($produto->valor_atual != $somaTotal){
                           $produto->valor_atual = number_format($somaTotal, 2, '.', '.');
                           $valorAnterior = DB::connection('mysql_2')->select("SELECT * 
                           FROM historico_produtos 
                           WHERE id_produto = $produto->id_produto
                           AND DATE(created_at) <> CURDATE()
                           ORDER BY created_at DESC
                           LIMIT 1;
                        "); 
                           if(!$valorAnterior){
                            $produto->valor_anterior = 0;
                         }else{
                         $produto->valor_anterior = $valorAnterior[0]->valor;
                         }
                           $produto->save();

                           $codProduto = Historico::where('id_produto', $produto->id_produto)
                           ->whereDate('created_at', '=', now()->toDateString())
                           ->first();
       
                         if(!$codProduto){
                           $dados = new Historico([
                               'id_produto'=>$codigo,
                               'valor'=>number_format($somaTotal, 2, '.', '.'),
                           ]);
                           $dados->save();
                         }else{
                            $chavePrimaria = $codProduto->id;
                           $codProduto = Historico::find($chavePrimaria);
                           $codProduto->valor = number_format($somaTotal, 2, '.', '.');
                           $codProduto->save();
                         }
                       }
                   }
                       else{
                           $dados = new Atualiza([
                         'id_produto'=>$codigo,
                         'valor_anterior'=>0,
                         'valor_atual'=>number_format($somaTotal, 2, '.', '.')
                     ]);
                         $dados->save();
                     }

                    }
                      return view("dashboard");
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
                   // return redirect('/ingrediente');
    }

      
}
