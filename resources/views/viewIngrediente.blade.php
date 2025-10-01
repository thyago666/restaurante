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
      <h2>CADASTRO DE INGREDIENTES</h2>
      <br>
      <a href="{{url("/cadastro/ingrediente")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
      <br>      <br> 
    <table class="table" >
        <thead>
          <tr align="center">
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Unidade de Medida</th>
            <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>

            @foreach($ingredientes as $ingrediente)
          <tr align="left">
            <th scope="row">{{$ingrediente->id}}</th>
            @if($ingrediente->tipo === 'fp')
            <td><a href="{{url("/atualiza/ingrediente/$ingrediente->id")}}">{{$ingrediente->descricao}}</a></td>
            @else
            <td>{{$ingrediente->descricao}}</td>
            @endif
            <td>{{$ingrediente->unidMedida}}</td>
   
            <td>{{  'R$ '.number_format($ingrediente->valor, 2, ',', '.') }}</td>
 
                <td>
        <a href="{{url("/edit/ingrediente/$ingrediente->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>
        <a href="{{url("/delete/ingrediente/$ingrediente->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a>           
        @if($ingrediente->tipo === 'fp')
       <a href="{{url("/atualiza/ingrediente/$ingrediente->id")}}"><button type="button" class="btn btn-info">Recalcular</button></a>           
        @else
        <a href="#"><button type="button" class="btn btn-infof" disabled>Recalcular</button></a>           
   
       @endif
      </td>
            </tr>
         @endforeach
       
   
        </tbody>
      </table>

    </div>

</body>
</html>