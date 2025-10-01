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
    <h1>{{$produto->descricao}}</h1>
    <form method="post" action="{{url('/insert/item-acessorio/')}}">
        @csrf

        <input type="hidden" class="form-control" value={{$produto->id}} id="produto" name="produto">

    <div class="form-group">
        <label for="acessorio"><b>Acessórios</b></label>
        <select class="form-control" id="acessorios" name="acessorios">
            @foreach($acessorios as $acessorio)
          <option value={{$acessorio->id}}>{{$acessorio->descricao}}</option>
          @endforeach
     
   
          </select>
      </div>
      <div class="form-group">
        <label for="descricao"><b>Qtd</b></label>
        <input type="number" class="form-control" id="qtd" name="qtd">
        <small id="qtd" class="form-text text-muted">Informe aqui a quantidade que vai 
            desse acessório</small>
      </div>
      <button type="submit" class="btn btn-primary">Inserir</button>

      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>





    </form><br>
    
      
    <br>
    <form method="post" action="{{url('/insert/importacao/')}}">
      @csrf
      <input type="hidden" class="form-control" value={{$produto->id}} id="produto" name="produto">
    <div class="form-group">
      <label for="exampleFormControlSelect1"><b>Selecione o lanche para importação</b></label>
      <select class="" id="id_lanche" name="selectLanche">
          @foreach($importar as $imps)
        <option id="{{$imps->id}}" value="{{$imps->id}}">{{$imps->descricao}}</option>
        @endforeach
        </select>
      <button type="submit" class="btn btn-warning">Importar</button></a>
    </div>
    </form>
    <table class="table">
        <thead>
          <tr align="center">
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Qtd</th>
            <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
          <tr align="center">
            <th scope="row">{{$item->id}}</th>
            <td>{{$item->descricao}}</td>
            <td>{{$item->qtd}}</td>
            <td>{{  'R$ '.number_format($item->vl_unit*$item->qtd, 2, ',', '.') }}</td>
           <td> <a href="{{url("/delete/item-acessorio/$item->id_item/$item->id_produto")}}"><button type="button" class="btn btn-danger">Excluir</button></a></td>
          </tr>
           </tr>
                @endforeach
         </tbody>
      </table>
</div>
</body>
</html>