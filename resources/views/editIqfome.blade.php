<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container">
      <h1>ALTERAR TAXAS DO IQFOME</h1>
    <form method="post" action="{{url("/update/iqfome/config/$item->id")}}">
      @csrf
     <div class="form-group">
          <label for="qtd"><b>Descrição</b></label>
          <input type="TEXT" class="form-control" id="descricao" name="descricao" value="{{$item->descricao}}">
          <small id="descricao" class="form-text text-muted">Informe aqui a descrição do ifood, Ex: Taxa de comissão, Adiantamento etc...</small>
        </div>


        <div class="form-group">
          <label for="valor"><b>Valor</b></label>
          <input type="text" class="form-control" id="valor" name="valor" value="{{$item->valor}}">
          <small id="valor" class="form-text text-muted">Informe aqui o valor do ifood</small>
        </div>
         
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
  

      </form>
</body>
</html>