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
      
      <H2>CADASTRO DE PRODUTOS</H2>
      <br>  <br>
      <a href="{{url("/cadastro/produtos")}}"> <button type="button" class="btn btn-success">+ Incluir Produtos</button></a>
      <a href="{{url("/habilitar/produtos")}}"> <button type="button" class="btn btn-info"> Habilitar Produtos</button></a>
      
     <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
     <br>  <br>
    <table class="table">
        <thead>
          <tr align="center">
 
          <th scope="col">Foto</th>
            <th scope="col">Descrição</th>
            <th scope="col">Tipo</th>
            <th scope="col">Inserir</th>
            <th scope="col">Opções</th>
      
          </tr>
        </thead>
        <tbody>

            @foreach($produtos as $produto)
          <tr align="center">
          <td> <img src="{{ asset('storage/' . $company . '/images/' . $produto->imagem) }}" width="50" height="50" alt="Imagem do produto"></td>
            <td>{{$produto->descricao}}</td>
            <td>{{$produto->tipo}}</td>
            <td>
              <a href="{{url("/cadastro/item/$produto->id")}}"><button type="button" class="btn btn-info">Criar Receita</button></a>
              <a href="{{url("/cadastro/item-acessorio/$produto->id")}}"><button type="button" class="btn btn-secondary">Acessórios</button></a>
           </td>
              <td>
         <a href="{{url("/alterar/produto/$produto->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>
<input type="hidden" value="{{$produto->id}}" id="id">
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#produto_{{ $produto->id }}">
Desabilitar
</button>

@include('confirmaDelete')       
            </td>
            </tr>
         @endforeach
        </tbody>
      </table>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>