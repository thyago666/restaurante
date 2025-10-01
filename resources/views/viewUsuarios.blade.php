<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Usuários</title>
</head>
<body>

    <div class="container">
      <h2>CADASTRO DE USUÁRIOS</h2>
      <br>
      <a href="{{url("/registrar/create")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
      <br>      <br> 
    <table class="table" >
        <thead>
          <tr align="center">
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Administrador</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>

            @foreach($usuario as $usuarios)
          <tr align="center">
            <th scope="row">{{$usuarios->id}}</th>
            <td>{{$usuarios->name}}</td>
            <td>{{$usuarios->email}}</td>
            <td>{{$usuarios->admin}}</td>
          <td>
       <!-- <a href="{{url("/edit/usuario/$usuarios->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>-->
      <!--  <a href="{{url("/registrar/delete/$usuarios->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a> -->          
      </td>
            </tr>
         @endforeach
       
   
        </tbody>
      </table>

    </div>

</body>
</html>