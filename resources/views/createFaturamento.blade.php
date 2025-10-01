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
  <br>
      <h1>CADASTRO DE FATURAMENTO</h1>
      <br>
    <form method="post" action="{{url('/insert/fat/config')}}">
      @csrf
     <div class="form-group">
          <label for="qtd"><b>Margem de Lucro</b></label>
          <input type="number" class="form-control" id="lucro" name="lucro">
          <small id="lucro" class="form-text text-muted">Informe aqui a magem que deseja lucrar depois de todas as contas pagas.</small>
        </div>

        <div class="form-group">
          <label for="valor"><b>Valor</b></label>
          <input type="text" class="form-control" id="valor" name="valor">
          <small id="valor" class="form-text text-muted">Informe aqui o valor médio do seu faturamento mensal</small>
        </div>
         
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
  

      </form>
</body>
</html>