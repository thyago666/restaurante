<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
      <h1>ENTRADA DE INGREDIENTES</h1>
    <form method="post" action="{{url('/cadastro/entrada')}}">
      @csrf

      <div class="form-group">
        <label for="unidade_medida"><b>Ingredientes</b></label>
        <select class="form-control" id="ingrediente" name="ingrediente" onchange="toggleMedida()">

            @foreach($ingredientes as $ingrediente) 
          <option value={{$ingrediente->id}}>{{$ingrediente->descricao}} - {{$ingrediente->unidMedida}}</option>
          @endforeach
        </select>
      </div>

      
      <div class="form-group">
        <label for="unid_medida"><b>Unidade de Medida</b></label>
        <select class="form-control" id="unid_medida" name="unid_medida" onchange="toggleLitro()">

              <option value="po">PORÇÃO</option>
          <option value="kg">KG</option>
          <option value="un">UNIDADE</option>
          <option value="lt">LITRO</option>
        </select>
        <small id="descricao" class="form-text text-muted">Informe aqui a unidade de medida que você comprou desse ingrediente <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="EX: Kilo (informe KG), Litro (informe Litro), Unidade (informe Unidade), Porção (informe Porção)">  ?
</button></small>
      </div>
   
           
      <div class="form-group">
          <label for="qtd"><b>Quantidade</b></label>
          <input type="number" class="form-control" id="qtd" name="qtd">
          <small id="descricao" class="form-text text-muted">
            Informe aqui a quantidade que você comprou desse ingrediente <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="EX: 1KG (informe 1000), 1LT (informe 1), 100GR (informe 100), 10UN (informe 10)">
  ?
</button> </small>
        </div>

        <div class="form-group" id="qtdEmb" style="display: none;">
          <label for="qtdEmb"><b>Quantidade Embalagem</b></label>
          <input type="number" class="form-control" id="qtdEmb" name="qtdEmb">
          <small id="descricao" class="form-text text-muted">
            Informe aqui a quantidade em ML que vem na embalagem desse produto <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="EX: 900, 1000, 500, 1200">
  ?
</button> </small>
        </div>
      
        <div class="form-group">
          <label for="descricao"><b>Valor Total</b></label>
          <input type="text" class="form-control" id="valor_total" name="valor_total">
          <small id="descricao" class="form-text text-muted">Informe aqui o valor total que você pagou nesse ingrediente</small>
        </div>
         
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
  

      </form><br>

      <form method="post" action="{{url('/pesquisa/entrada')}}">
        @csrf
      <div>
     <h5> Data Inicial</h5>
      <input type="date" name="dt_inicial">
     
      <h5>Data Final</h5>
      <input type="date" name="dt_final">
      <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
      </div>
      <br>
      <table class="table table-success table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Un. Medida</th>
            <th scope="col">Qtd</th>
            <th scope="col">Data</th>
            <th scope="col">Valor</th>
          </tr>
        </thead>
        <tbody>
          @php
           $total=0;
           @endphp   

          @if (isset($psq))
          @foreach($psq as $psqs)
          <tr>
            <th scope="row">{{$psqs->id}}</th>
            <td>{{$psqs->descricao}}</td>
            <td>{{$psqs->unidMedida}}</td>
            <td>{{$psqs->qtd}}</td>
          
            <td>{{ \Carbon\Carbon::parse($psqs->data_compra)->format('d/m/Y')}}</td>
            <td>{{  'R$ '.number_format($psqs->valor, 2, ',', '.') }}</td>

              @php
            $total = $total + $psqs->valor;
            @endphp
          </tr>
          @endforeach
   
          @endif
              </tbody>
                   
   
      </table>
      <table class="table table-success table-striped">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th><h3>Total = {{  'R$ '.number_format($total, 2, ',', '.') }}</h3></th>
          </tr>
        </thead>
    
      </table>
      
      </form>
  
    </div>
</body>
</html>

<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

function toggleLitro() {
          var select = document.getElementById("unid_medida");
          var id = document.getElementById("qtdEmb");
        
          if (select.value === "lt") {
            id.style.display = "block";
          } else {
            id.style.display = "none";
          }
        }

        function toggleMedida() {
   
    var ingredienteSelect = document.getElementById('ingrediente');
    var unidMedidaSelect = document.getElementById('unid_medida');

    var selectedIngrediente = ingredienteSelect.options[ingredienteSelect.selectedIndex];
    var descricao = selectedIngrediente.textContent.split(' - ')[1];
  
  
  }
  </script>


