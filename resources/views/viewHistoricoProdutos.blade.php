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
    <form method="post" action="{{url('/historico/pesquisa')}}">
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

    <div align="center">
        <h1>{{$psq}}</h1>
    </div>



<table class="table">
    <thead class="bg-primary">
      <tr>
        <th scope="col"><font color="white"> Valor Anterior = 
           {{  'R$ '.number_format($valor_anterior*$valorMarkup, 2, ',', '.') }}</font></th>
      
      </tr>
    </thead>
</table>

<table class="table">
    <thead class="bg-dark">
      <tr>
        <th scope="col"><font color="white"> Valor Loja Atual = 
           {{  'R$ '.number_format($valor_atual*$valorMarkup, 2, ',', '.') }}</font></th>
      
      </tr>
    </thead>
</table>
  <br>


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Valor'],
         <?php
            foreach($dados_historico as $dados){
              $date = new DateTimeImmutable($dados['created_at']);
              $ano = $date->format('d/m/Y');;
              $valor = number_format($dados['valor']*$valorMarkup, 2, '.', '.');
              ?>
              ["<?php echo $ano ?>", <?php echo $valor ?>],
           <?php } ?>
        ]);

        var options = {
          title: 'Histórico de Variações',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
</div>
</body>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
</html>