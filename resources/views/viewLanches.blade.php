<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <form method="post" action="{{url('/pesquisa')}}">
        @csrf
    <div class="form-group">
        <label for="exampleFormControlSelect1"><b>Selecione o lanche para pesquisa</b></label>
        <select class="form-control" id="id_lanche" name="selectLanche">
            @foreach($lanches as $lanche)
          <option id="{{$lanche->id}}" value="{{$lanche->descricao}}">{{$lanche->descricao}}</option>
          @endforeach
          </select>
      </div>
      <button type="submit" class="btn btn-primary">Pesquisar</button>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
    </form><br>

    @if($params == 0)

    <div align="center">
        <h1>{{$psq}}</h1>
    </div>

    @php
    $resul = 0;
  $total_ingredientes = 0;
  $total_acessorio=0;
  @endphp

    <table class="table">
        <thead class="thead-dark">
          <tr>
           <th>Ingredientes</th>
           <th>Medida</th>
           <th>Qtd</th>
            <th>Valor Custo Total</th>
           </tr>
        </thead>
        <tbody>
            @foreach ($ingredientes as $ingrediente)
            @if($ingrediente->desc_prod == $psq)
          <tr>
         <td>{{$ingrediente->ing_descricao}}</td>
         <td>{{$ingrediente->unidMedida}}</td>
         <td>{{$ingrediente->qtd}}</td>

     @if($ingrediente->unidMedida == 'kilo' && $ingrediente->desc_prod == $psq)
   @php
        $resul = ($ingrediente->valor*$ingrediente->qtd)/1000;
        $total_ingredientes = $total_ingredientes + $resul;
     @endphp
        <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
    @endif


    @if($ingrediente->unidMedida == 'litro' && $ingrediente->qtdOleoFritadeira == null && $ingrediente->qtdPorcaoFritadeira == null && $ingrediente->desc_prod == $psq)
   @php
        $resul = ($ingrediente->valor*$ingrediente->qtd)/$ingrediente->qtdEmb;
        $total_ingredientes = $total_ingredientes + $resul;
     @endphp
     <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
@endif
     @if($ingrediente->qtdOleoFritadeira != null and $ingrediente->qtdPorcaoFritadeira != null )
      @php
        $resul = ($ingrediente->valor*$ingrediente->qtdOleoFritadeira)/$ingrediente->qtdPorcaoFritadeira;
        $total_ingredientes = $total_ingredientes + $resul;
        @endphp
        <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
    @endif

    @if($ingrediente->unidMedida == 'porcao' && $ingrediente->desc_prod == $psq)
    @php
         $valor_cada_porcao = ($ingrediente->valor/$ingrediente->qtd_porcao);
         $resul = ($valor_cada_porcao*$ingrediente->qtd);
         $total_ingredientes = $total_ingredientes + $resul;

       @endphp
             <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
        @endif


       @if($ingrediente->unidMedida == 'unidade' && $ingrediente->desc_prod == $psq)
        @php
         $resul = ($ingrediente->valor*$ingrediente->qtd);
         $total_ingredientes = $total_ingredientes + $resul;
      @endphp
             <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
         @endif
         </tr>
          @endif
          @endforeach
         </tbody>
      </table>

  
    <table class="table">
        <thead class="thead-dark">
          <tr>
           <th>Acessórios</th>
           <th>QTD</th>
            <th>Valor Custo</th>
           </tr>
        </thead>
        <tbody>
            @foreach ($acessorios as $acessorio)
            @if($acessorio->desc_prod == $psq)
          <tr>
         <td>{{$acessorio->ace_descricao}}</td>
         <td>{{$acessorio->qtd_itens}}</td>

         <td> {{  'R$ '.number_format($acessorio->valor*$acessorio->qtd_itens, 2, ',', '.') }}</td>
         </tr>

         @php
            $total_acessorio = ($total_acessorio+$acessorio->valor*$acessorio->qtd_itens);
         @endphp
          @endif
          @endforeach
         </tbody>
      </table>

        @php
      $custo_produto = ($total_acessorio+$total_ingredientes);
      @endphp

    
      <table class="table">
    <thead class="bg-secondary">
      <tr>
        <th scope="col"><font color="white">  CMV (Universal) = 
        {{number_format($custo_produto/($custo_produto*$valorMarkup)*100, 2, ',', '.')}}%
        @php
        $result = $custo_produto/($custo_produto*$valorMarkup)*100;
        if($result >= 30 and $result <= 35)
        {
          @endphp
          (Seu CMV esta dentro dos padrões)
          @php
          }
          else
          {
            @endphp
              <center>Seu CMV esta fora dos padrões</center>
            @php
          }
      @endphp
      </font></th>
      
      </tr>
    </thead>
</table>

<table class="table">
    <thead class="bg-success">
      <tr>
        <th scope="col"><font color="white">  Valor Custo = 
        {{  'R$ '.number_format($custo_produto, 2, ',', '.') }}</font></th>
      
      </tr>
    </thead>
</table>

<table class="table">
    <thead class="bg-primary">
      <tr>
        <th scope="col"> <font color="white">  Valor S/ Markup = 
         {{  'R$ '.number_format($custo_produto*2, 2, ',', '.') }}</font></th>
      
      </tr>
    </thead>
</table>

<table class="table">
    <thead class="bg-warning">
      <tr>
        <th scope="col"> Valor Venda Loja C/ Markup= 
           {{  'R$ '.number_format($custo_produto*$valorMarkup, 2, ',', '.') }}</th>
      
      </tr>
    </thead>
</table>

@foreach($parametros as $params)
 @if($params->id == 1 and $params->opcao == 'Sim')
<table class="table">
    <thead class="bg-danger">
      <tr>
        <th scope="col"> Valor Venda Ifood = 
           {{  'R$ '.number_format($custo_produto*$valorMarkupIfood, 2, ',', '.') }}</th>
        </tr>
      </thead>
</table>
@endif

@if($params->id == 2 and $params->opcao == 'Sim')
      <table class="table">
    <thead class="bg-info">
      <tr>
        <th scope="col"> Valor Venda Iqfome = 
           {{  'R$ '.number_format($custo_produto*$valorMarkupIqfome, 2, ',', '.') }}</th>
         </tr>
    </thead>
    </table>
    @endif
    @endforeach
   
    @endif

  <br>
</div>
</body>
</html>














