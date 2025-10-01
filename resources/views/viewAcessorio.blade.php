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
      <h2>CADASTRO DE ACESSÓRIOS</h2>
      <br>      <br>
      <a href="{{url("/cadastro/acessorios")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
      <br>      <br>
    <table class="table">
        <thead>
          <tr align="center">
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
             <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>

            @foreach($acessorios as $acessorio)
          <tr align="center">
            <th scope="row">{{$acessorio->id}}</th>
            <td>{{$acessorio->descricao}}</td>
      
            <td>{{  'R$ '.number_format($acessorio->valor, 2, ',', '.') }}</td>
 
                <td>
        <a href="{{url("/edit/acessorios/$acessorio->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>
        <a href="{{url("/delete/acessorios/$acessorio->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a>
                  </td>
            </tr>
         @endforeach
       
   
        </tbody>
      </table>
   

    </div>

</body>
</html>