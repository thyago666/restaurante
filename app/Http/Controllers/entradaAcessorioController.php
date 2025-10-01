<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acessorio;
use App\Models\EntradaAcessorio;
use App\Models\Atualiza;
use App\Models\Historico;
use DB;
use App\Repositories\LanchesRepository;
use App\Repositories\ParametrosRepository;

class entradaAcessorioController extends Controller
{
    protected $lancheRepository;
    protected $parametrosRepository;
  
    public function __construct(LanchesRepository $lancheRepository, ParametrosRepository $parametrosRepository)
    {
        $this->lancheRepository = $lancheRepository;
        $this->parametrosRepository = $parametrosRepository;
    }
    public function index(){
        $acessorios = Acessorio::orderBy('descricao')->get();
         return view('cadEntradaAcessorioView',compact('acessorios'));
     }
  
      public function pesquisa(Request $request){
          $acessorios = Acessorio::all();
           $data_inicial = $request->dt_inicial;
           $data_final = $request->dt_final;
        
            $psq = DB::connection('mysql_2')->table('entrada_acessorio as ent')
        ->join('acessorios as ace', 'ent.id_acessorio', '=', 'ace.id')
        ->select('ent.valor_total as valor', 'ent.created_at as data_compra', 'ace.descricao', 'ace.id')
        ->whereBetween(DB::raw('DATE(ent.created_at)'), [$data_inicial, $data_final])
        ->get();
            return view('cadEntradaAcessorioView',compact('psq','acessorios'));
    }
  
      public function insert(Request $request){
        $this->lancheRepository->calculoAcessorios($request);
        return redirect()->route('entradaAcessorio');
    }
}
