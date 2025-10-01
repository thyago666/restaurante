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
    <form method="post" action="{{url("/update/ingrediente/$ingredientes->id")}}">
      @csrf
        <div class="form-group">
          <label for="descricao"><b>Descrição</b></label>
          <input type="text" class="form-control" id="descricao" name="descricao" value="{{$ingredientes->descricao}}">
        </div>

        <div class="form-group">
          <label for="descricaoSimples"><b>Descrição Simples</b></label>
          <input type="text" class="form-control" id="descricaoSimples" name="descricaoSimples" value="{{$ingredientes->descricaoSimples}}">
         
        </div>

        <div class="form-group">
            <label for="unidade_medida"><b>Unidade de Medida</b></label>
            <select class="form-control" id="unidade_medida" name="unidade_medida">
  
              @if($ingredientes->unidMedida == 'kilo')
              <option value="{{$ingredientes->unidMedida}}" selected>Kilo</option>
              @elseif($ingredientes->unidMedida == 'unidade')
              <option value="{{$ingredientes->unidMedida}}" selected>Unidade</option>
              @elseif($ingredientes->unidMedida == 'porcao')
              <option value="{{$ingredientes->unidMedida}}" selected>Porção</option>
              @elseif($ingredientes->unidMedida == 'litro')
              <option value="{{$ingredientes->unidMedida}}" selected>Litro</option>
              @endif
              <option  value="kilo">Kilo</option>
              <option value="unidade">Unidade</option>
              <option  value="porcao">Porção</option>
              <option  value="litro">Litro</option>
             </select>
          </div>

                    <div class="form-group">
          <label for="estoqueMinimo"><b>Estoque Minimo</b></label>
          <input type="number" class="form-control" id="estoqueMinimo" name="estoqueMinimo" value="{{$ingredientes->estMinimo}}">
          <small id="estoqueMinimo" class="form-text text-muted">Quantidade minima que esse produto tem que ter no estoque</small>
        </div>
     
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>

      </form>
    </div>
</body>
</html>