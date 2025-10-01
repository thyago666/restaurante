<?php

namespace App\Http\Controllers;
use DB;
use App\Repositories\ParametrosRepository;

use Illuminate\Http\Request;

class atualizaController extends Controller
{
    protected $parametrosRepository;

    public function __construct(ParametrosRepository $parametrosRepository)
    {
        $this->parametrosRepository = $parametrosRepository;
    }
    public function mostrarProdutos(){

        $dados[]= $this->parametrosRepository->parametros();
        $markup = $dados[0][3];

        $registros=DB::connection('mysql_2')->select("SELECT at.*, prod.descricao
                    FROM atualiza as at
                    JOIN produtos as prod ON prod.id = at.id_produto
                    WHERE DATE(at.updated_at) = CURDATE()
                    AND prod.situacao = 1 AND prod.tipo != 'ingrediente'");
  
         return view('viewMostraprodutos',compact('registros','markup'));
    }
}
