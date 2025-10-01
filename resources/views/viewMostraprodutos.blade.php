<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Produtos Alterados</title>
</head>
<body>

    <div class="container">
      <h2>PRODUTOS ALTERADOS</h2>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
      <br>
    <table class="table" >
    <br>
        <thead>
          <tr align="center">
            <th scope="col">#</th>
            <th scope="col">Produto</th>
            <th scope="col">Valor Anterior</th>
            <th scope="col">Valor Atual</th>
            <th scope="col">Última Alteração</th>
   
          </tr>
        </thead>
        <tbody>

            @foreach($registros as $registro)
            @if($registro->valor_atual < $registro->valor_anterior || $registro->valor_atual > $registro->valor_anterior)
          <tr >
            <th scope="row">{{$registro->id_produto}}</th>
            <td>{{$registro->descricao}}</td>
            <td>{{  'R$ '.number_format($registro->valor_cardapio*$markup, 2, ',', '.') }}</td>
            <td>{{  'R$ '.number_format($registro->valor_atual*$markup, 2, ',', '.') }}</td>
            <td>{{ \Carbon\Carbon::parse($registro->updated_at)->format('d/m/Y')}}</td>
          </tr>
           @endif
         @endforeach
       
   
        </tbody>
      </table>

    </div>

</body>
</html>