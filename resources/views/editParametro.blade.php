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
      <h1>ALTERAR PARAMETRO</h1>
    <form method="post" action="{{url("/update/param/config/$id")}}">
      @csrf
      <div class="form-group">
        <label for="status"><b>Status</b></label>
        <select class="form-control" id="status" name="status">
          <option value="Sim">Sim</option>
          <option value="Nao">Não</option>
          </select>       
</button></small>
      </div>
         
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
  

      </form>
</div>
</body>
</html>