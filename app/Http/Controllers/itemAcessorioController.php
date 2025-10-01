<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acessorio;
use App\Models\ItemAcessorio;
use App\Models\Produto;
use DB;

class itemAcessorioController extends Controller
{
    public function index(Request $request){
      $psq=$request->selectLanche;
      $lanches = Produto::all();
      $dados = DB::connection('mysql_2')->select('select ace.*,ace.descricao as ace_descricao,pr.*, pr.descricao as desc_prod,it.*
      FROM itens_acessorios it, acessorios ace, produtos pr
      WHERE ace.id=it.id_acessorio and pr.id=it.id_produto');
        return view('viewLanches',compact('dados','lanches','psq'));
      }

     public function create($id){
              $importar = DB::connection('mysql_2')->table('itens_acessorios as ia')
              ->join('produtos as pr', 'pr.id', '=', 'ia.id_produto')
              ->select('pr.descricao', 'pr.id')
              ->distinct()
              ->get();

         $itens = DB::connection('mysql_2')->table('itens_acessorios as it')
         ->join('acessorios as ace', 'it.id_acessorio', '=', 'ace.id')
         ->select('it.*', 'it.id as id_item', 'ace.*', 'ace.valor as vl_unit')
         ->where('it.id_produto', $id)
         ->get();


         $produto = Produto::find($id);
           $acessorios = Acessorio::orderBy('descricao')->get();
        return view('cadItemAcessorio',compact('produto','acessorios','itens','importar'));
     }

        public function insert(Request $request){
              $dados = new ItemAcessorio([
              'id_acessorio'=>$request->acessorios,
              'id_produto'=>$request->produto,
              'qtd'=>$request->qtd
          ]);
              $dados->save();
            // return $this->create($request->produto);
            return redirect("cadastro/item-acessorio/$request->produto");
        }

        public function insertImportacao(Request $request){
         $id=$request->selectLanche;//id do lanche do campo select, que é referencia da importacao
         $id_produto=$request->produto;//id do produto que ira receber a importacao
         $dadosImportacao = DB::connection('mysql_2')->select('SELECT i.*
         FROM itens_acessorios i WHERE i.id_produto = ?',[$id]);

         foreach($dadosImportacao as $dadosImportacoes)
         {
         $dados = new ItemAcessorio([
              'id_acessorio'=>$dadosImportacoes->id_acessorio,
            'id_produto'=>$id_produto,
            'qtd'=>$dadosImportacoes->qtd
        ]);
            $dados->save();
      }
          // return $this->create($id_produto);
          return redirect("cadastro/item-acessorio/$id_produto");
      }

        public function delete(Request $request, $id,$id_produto){
              $item = ItemAcessorio::find($id);
              $item->delete();
              return redirect("cadastro/item-acessorio/$id_produto");
             // return $this->create($id_produto);
         }

}
