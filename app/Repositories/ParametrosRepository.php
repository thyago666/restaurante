<?php

namespace App\Repositories;

use App\Models\CustoVariavel;
use App\Models\CustoFixo;
use App\Models\Faturamento;
use App\Models\Ifood;
use App\Models\Iqfome;
use App\Models\Parametros;

use Illuminate\Http\Request;

class ParametrosRepository
{
    public function parametros()
    {
        $custoFixo = CustoFixo::orderBy('descricao')->get();
        $custoVariavel = CustoVariavel::orderBy('descricao')->get();
        $faturamento = Faturamento::all();
        $ifood = Ifood::all();
        $iqfome = Iqfome::all();
        $parametros = Parametros::all();


       //calculo markup (cuidado ao mexer nesse codigo)

       $somaIfood = 0;
       foreach($ifood as $ifoods){
         $somaIfood += $ifoods->valor;
       }
       $somaIqfome = 0;
       foreach($iqfome as $iqfomes){
         $somaIqfome += $iqfomes->valor;
       }
        $somaFixo = 0;
        foreach($custoFixo as $custoFixos){
        $somaFixo += $custoFixos->valor;
      }
      $somaVariavel = 0;
      foreach($custoVariavel as $custoVariaveis){
        $somaVariavel += $custoVariaveis->valor;
      }
      foreach($faturamento as $faturamentos){
        $lucro = $faturamentos->lucro;
        $valorFaturamento = $faturamentos->valor;
        $idFaturamento = $faturamentos->id;
      }
      $percentFixo = ($somaFixo*100)/$valorFaturamento;
      $somaTotal = ($percentFixo + $somaVariavel + $lucro);
      $markup = (100/(100-$somaTotal));

      foreach($parametros as $params){
        //markup do ifood
        if($params->id == 1 and $params->opcao == 'Sim'){
        //  $somaTotalIfood = ($percentFixo + $somaVariavel + $lucro + $somaIfood);
        //  $markupIfood = (100/(100-(number_format($somaTotalIfood, 2, '.', '.'))));;
        $percentIfood = ($somaIfood/100);
        $somIfood = ($markup*$percentIfood);
        $markupIfood = $markup+$somIfood;

      //  dd($markupIfood);
        }else{
          $markupIfood = 0;
        }
        break;
      }
        //markup do iqfome

      foreach($parametros as $params){
        if($params->id == 2 and $params->opcao == 'Sim'){
          $percentIqfome = ($somaIqfome/100);
        $somIqfome = ($markup*$percentIqfome);
        $markupIqfome = $markup+$somIqfome;
          break;
        }else{
          $markupIqfome = 0;
        }
      }
      $campoMarkup=Faturamento::find($idFaturamento);
      $campoMarkup->markup = number_format($markup, 2, '.', '.');
      $campoMarkup->save();

       return ([$custoFixo,$custoVariavel,$faturamento,$markup,$ifood,$iqfome,$markupIfood,$markupIqfome,$parametros]);
    }
}
