<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;
use App\Models\Entrada;
use App\Models\Item;
use App\Models\Atualiza;
use App\Models\Historico;
use DB;
use App\Repositories\LanchesRepository;
use App\Repositories\ParametrosRepository;


class entradaController extends Controller
{

    protected $lancheRepository;
    protected $parametrosRepository;
  
    public function __construct(LanchesRepository $lancheRepository, ParametrosRepository $parametrosRepository)
    {
        $this->lancheRepository = $lancheRepository;
        $this->parametrosRepository = $parametrosRepository;
    }


    public function index(){
      $ingredientes = Ingrediente::where('tipo','<>','fp')->orderBy('descricao')->get();
       return view('cadEntradaIngredienteView',compact('ingredientes'));
   }

    public function pesquisa(Request $request){
        $ingredientes = Ingrediente::orderBy('descricao')->get();
         $data_inicial = $request->dt_inicial;
         $data_final = $request->dt_final;

         $psq = DB::connection('mysql_2')->table('entrada as ent')
    ->join('ingredientes as ing', 'ent.id_ingrediente', '=', 'ing.id')
    ->select('ent.valor_total as valor', 'ent.created_at as data_compra', 'ing.descricao','ing.unidMedida','ing.id', 'ing.tipo','ent.qtd')
    ->whereBetween(DB::raw('DATE(ent.created_at)'), [$data_inicial, $data_final])
    ->where('ing.tipo', '<>', 'fp')
    ->orderBy('ing.descricao')->get();
        return view('cadEntradaIngredienteView',compact('psq','ingredientes'));
    }

    public function insert(Request $request)
    {
        $this->lancheRepository->calculoIngredientes($request);
        return redirect()->route('entrada');
    }
}
