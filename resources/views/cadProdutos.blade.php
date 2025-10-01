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
    <form method="post" action="{{url('/insert/produtos')}}" enctype="multipart/form-data">
      @csrf
        <div class="form-group">
          <label for="descricao"><b>Descrição</b></label>
          <input type="text" class="form-control" id="descricao" name="descricao">
          <small id="descricao" class="form-text text-muted">Informe aqui a descrição de seu produto ex: Hot Dog, Batata Frita, Isca de Frango etc</small>
        </div>

        <div class="form-group">
            <label for="tipo"><b>Tipo</b></label>
            <select class="form-control" id="tipo" name="tipo">
  
              <option value="lanche">Lanche</option>
              <option value="porcao">Porção</option>
              <option value="pizza">Pizza</option>
              <option value="combo">Combo</option>
              <option value="marmitex">Marmitex</option>
              <option value="pf">Prato Feito</option>
              <option value="ingrediente">Ingrediente</option>
       
              </select>
          </div>

          <div class="mb-3">
          <label for="formFile" class="form-label"><b>Escolha a imagem do produto</b></label>
          <input class="form-control" type="file" id="formFile" name="formFile">
          </div>
      
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>

      </form>
    </div>
</body>
</html>