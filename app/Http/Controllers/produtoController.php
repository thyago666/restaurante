<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Ingrediente;
use App\Models\Item;
use App\Models\Atualiza;
use DB;
use App\Repositories\ParametrosRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class produtoController extends Controller
{
    protected $parametrosRepository;

    public function __construct(ParametrosRepository $parametrosRepository)
    {
        $this->parametrosRepository = $parametrosRepository;
    }

    public function index(){
       $user = auth()->user();
       $company = $user->company;
      

       $produtos = Produto::where('situacao',1)->orderBy('descricao')->get();
       return view('produtosView',compact('produtos','company'));
    }

    public function create(){
        return view('cadProdutos');
    }

    public function habilitar(){
        $produto = Produto::where('situacao',0)->get();
        return view('habilitarProdutos',compact('produto'));
    }
    public function insert(Request $request){

           $user = auth()->user();
           $company = $user->company;
           $dados = new Produto;
           $dados->descricao = $request->descricao;
           $dados->tipo = $request->tipo;
           $dados->situacao = 1;

           if($request->hasFile('formFile') && $request->file('formFile')->isValid())
            {
                $requestImage = $request->formFile;
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName().strtotime("now")).".".$extension;
                $request->formFile->move(public_path("storage/$company/images"), $imageName);
                $dados->imagem = $imageName;
            }else{
                $dados->imagem = "sem_imagem.png";
            }
                $dados->save();
                return redirect("/produtos");
          
    }

    public function alterar($id){
       $produto = Produto::find($id);
          return view('produtosAlterar',compact('produto'));
        }

    public function update(Request $request){

        $user = auth()->user();
        $company = $user->company;
        $produto=Produto::find($request->id);
        $produto->descricao = $request->descricao;
        $produto->tipo = $request->tipo;
        
        if($request->hasFile('formFile') && $request->file('formFile')->isValid())
        {
              //excluindo a imagem antiga
              if ($produto->imagem) {
                $oldImagePath = public_path("storage/$company/images/{$produto->imagem}");
                if (file_exists($oldImagePath)) {
                    if($produto->imagem != "sem_imagem.png"){
                        unlink($oldImagePath);
                    }
                }
            }

            $requestImage = $request->formFile;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName().strtotime("now")).".".$extension;
            $request->formFile->move(public_path("storage/$company/images"), $imageName);
            $produto->imagem = $imageName;
        }
        $produto->save();
        return redirect("/produtos");
    }
    public function habilitarAlt($id){
        $produto = Produto::find($id);
        $produto->situacao = 1;
        $produto->save();
        return redirect("/produtos");
    }

    public function delete($id){
        $produto = Produto::find($id);
        $produto->situacao = 0;
        $produto->save();
        return redirect("/produtos");
    }

    public function cardapio(){
        $dados[]= $this->parametrosRepository->parametros();
        $markup = $dados[0][3];
        $markupIfood = $dados[0][6];
        $markupIqfome = $dados[0][7];
        $lastDescProd = null;
         
        $resultados = DB::connection('mysql_2')->table('produtos as prod')
        ->select('prod.descricao as descProd', 'at.valor_atual', 'ig.descricaoSimples as descIng', 'at.id_produto')
        ->join('atualiza as at', 'prod.id', '=', 'at.id_produto')
        ->join('itens as it', 'it.id_produto', '=', 'prod.id')
        ->join('ingredientes as ig', 'it.id_ingrediente', '=', 'ig.id')
        ->where('prod.tipo', '<>', 'ingrediente')
        ->orderBy('descProd')
        ->get();

       foreach($resultados as $resultado){
            if($lastDescProd !== $resultado->descProd)
            {
               echo'<br>';
               echo'<br>';
               echo '<b>'.$resultado->descProd.'</b>';
               echo'<br>';
               echo '<b>'.'Loja: '.'</b>' .'<font color="red">'.number_format($resultado->valor_atual*$markup, 2, '.', '.').'</font>'.'</b>';
               echo '&nbsp';
               echo '<b>'.'Iqfome: '.'</b>'.'<font color="red">' .number_format($resultado->valor_atual*$markupIqfome, 2, '.', '.').'</font>'.'</b>';
               echo '&nbsp';
               echo '<b>'.'Ifood: '.'</b>'.'<font color="red">' .number_format($resultado->valor_atual*$markupIfood, 2, '.', '.').'</font>'.'</b>'; 
               echo'<br>';
               $lastDescProd = $resultado->descProd;
            }
                    echo $resultado->descIng.', ';
            }
    }

    public function painelCardapio(){
        return view('viewPainelCardapio');
    }

    public function cardapioDigital(){

        $lastDescProd = null;
        $dataHoraAtual = date('Y-m-d_H-i-s');
       
        $resultados = DB::connection('mysql_2')->table('produtos as prod')
        ->select('prod.descricao as descProd','prod.imagem as imagem','prod.tipo as tipo', 'at.valor_atual', 'ig.descricaoSimples as descIng', 'at.id_produto')
        ->join('atualiza as at', 'prod.id', '=', 'at.id_produto')
        ->join('itens as it', 'it.id_produto', '=', 'prod.id')
        ->join('ingredientes as ig', 'it.id_ingrediente', '=', 'ig.id')
        ->where('prod.tipo', '<>', 'ingrediente')
        ->orderBy('descProd')
        ->get();
      
        $produtos = $resultados->groupBy('descProd')->map(function ($grupo) {
        $dados[]= $this->parametrosRepository->parametros();
        $markup = $dados[0][3];
        $markupIfood = $dados[0][6];
        $markupIqfome = $dados[0][7];
            // Combina todos os ingredientes em uma única string
        $ingredientes = $grupo->pluck('descIng')->unique()->implode(', ');
        // Considera o primeiro valor_atual do grupo (assumindo que é o mesmo para todos os ingredientes)
        $valor = number_format($grupo->first()->valor_atual*$markup, 2, ',', '.');
        $user = auth()->user();
        $company = $user->company;
        return [
            'nome' => $grupo->first()->descProd,
            'tipo' => $grupo->first()->tipo,
            'ingredientes' => $ingredientes,
            'valor' => 'R$ ' . $valor,
            'imagem' => asset('storage/'. $company.'/'.'/images/' . $grupo->first()->imagem)
         
        ];
    });
        $user = auth()->user();
        $company = $user->company;
        $nomeArquivo = "produtos_{$dataHoraAtual}.json";
        $path = storage_path("app/public/$company/{$nomeArquivo}");
    
        // Cria o diretório se não existir
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
        // Salva o JSON no arquivo
    File::put($path, $produtos->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo '<tr class="table-info"><th colspan="2"><h2 class="font-weight-bold">' . '<center>'.'Cardápio gerado com sucesso'.'</center>' . '</h2></th></tr>';
    echo '<tr class="table-info"><th colspan="2"><h2 class="font-weight-bold">' . '<center>'.'Link do seu cardápio é : https://pricegenius.com.br/cardapio/'.$company.'.php' . '</center>' . '</h2></th></tr>';
  
    //procedimento para o valor anterior dos produtos alterados, sempre pegar o valor atual do cardapio
    $atualiza=Atualiza::get();
    foreach($atualiza as $atual)
    {
    $atual->valor_cardapio = $atual->valor_atual;
    $atual->save();
    }
    }
}

