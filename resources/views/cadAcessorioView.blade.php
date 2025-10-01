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
        @if(isset($acessorios))
    <form method="post" action="{{url("/update/acessorios/$acessorios->id")}}">
        @endif
        @if(!isset($acessorios))
        <form method="post" action="{{url('/insert/acessorios')}}">
            @endif
      @csrf
          <div class="form-group">
          <label for="descricao"><b>Descrição</b></label>
          @if(isset($acessorios))

          <input type="text" class="form-control" id="descricao" name="descricao"
           value="{{$acessorios->descricao}}" >
           @else
           <input type="text" class="form-control" id="descricao" name="descricao">
           @endif
       
          <small id="descricao" class="form-text text-muted">Informe aqui a descrição de seu acessório, ex: Sacolinha, Vasilha Isopor 500gr, Papel Embrulho etc</small>
        </div>

      
        
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>

      </form>
    </div>
</body>
</html>