<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .page-content {
            display: none;
        }
        .active-content {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
<div class="nav nav-tabs" id="nav-tab" role="tablist">
<li class="nav-item" role="presentation">
    <a class="nav-link active" aria-current="page" href="#" onclick="showContent('custoFixo')">Custo Fixo</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" href="#" onclick="showContent('custoVariavel')">Custo Variável</a>
  </li>

  <li class="nav-item" role="presentation">
    <a class="nav-link" href="#" onclick="showContent('ifood')">Ifood</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" href="#" onclick="showContent('iqfome')">Iqfome</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" href="#" onclick="showContent('faturamento')">Faturamento</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" href="#" onclick="showContent('parametros')">Parâmetros</a>
  </li>
    </div>

<div id="custoFixo" class="page-content active-content">
  <br>
    <h1>Custo Fixo</h1>
<br>

<div class="container">
     <br>
      <a href="{{url("/create/config")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
      <br>      <br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
             <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>
            @foreach($custoFixo as $custoFixoS)
          <tr>
            <th scope="row">{{$custoFixoS->id}}</th>
            <td>{{$custoFixoS->descricao}}</td>
              <td>{{  'R$ '.number_format($custoFixoS->valor, 2, ',', '.') }}</td>
            <td>
        <a href="{{url("/delete/config/$custoFixoS->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a>
                  </td>
            </tr>
         @endforeach
       </tbody>
      </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
</div>

<div id="custoVariavel" class="page-content">
  <br>
    <h1>Custo Variável</h1>
    <br>
    <div class="container">
     <br>
      <a href="{{url("/create/var/config")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
      <br>      <br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
             <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>
            @foreach($custoVariavel as $custoVariaveis)
          <tr>
            <th scope="row">{{$custoVariaveis->id}}</th>
            <td>{{$custoVariaveis->descricao}}</td>
      
            <td>{{$custoVariaveis->valor}}%</td>
                 <td>
        <a href="{{url("/delete/var/config/$custoVariaveis->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a>
                  </td>
            </tr>
         @endforeach
        </tbody>
      </table>
    </div>
</div>

<div id="ifood" class="page-content">
  <br>
    <h1>Ifood</h1>
    <br>
    <div class="container">
     <br>
      <a href="{{url("/create/ifood/config")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
     
      <br>      <br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
             <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>
            @foreach($ifood as $ifoods)
          <tr>
            <th scope="row">{{$ifoods->id}}</th>
            <td>{{$ifoods->descricao}}</td>
            <td>{{$ifoods->valor}}</td>
 
                <td>
        <a href="{{url("/alterar/ifood/config/$ifoods->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>
        <a href="{{url("/delete/ifood/config/$ifoods->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a>          
      </td>
          </tr>
         @endforeach
          </tbody>
      </table>
   </div>
</div>

<div id="iqfome" class="page-content">
  <br>
    <h1>iqfome</h1>
    <br>
    <div class="container">
     <br>
      <a href="{{url("/create/iqfome/config")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
     
      <br>      <br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
             <th scope="col">Valor</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>
            @foreach($iqfome as $iqfomes)
          <tr>
            <th scope="row">{{$iqfomes->id}}</th>
            <td>{{$iqfomes->descricao}}</td>
            <td>{{$iqfomes->valor}}</td>
 
                <td>
        <a href="{{url("/alterar/iqfome/config/$iqfomes->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>
        <a href="{{url("/delete/iqfome/config/$iqfomes->id")}}"><button type="button" class="btn btn-danger">Excluir</button></a>          
      </td>
          </tr>
         @endforeach
          </tbody>
      </table>
   </div>
</div>

<div id="faturamento" class="page-content">
  <br>
    <h1>Faturamento</h1>
    <br>
    <div class="container">
     <br>
     <!-- <a href="{{url("/create/fat/config")}}"> <button type="button" class="btn btn-success">+ Incluir</button></a>-->
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
   
      <br>      <br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Margem de Lucro</th>
             <th scope="col">Valor do seu Faturamento Mensal</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        <tbody>
            @foreach($faturamento as $faturamentos)
          <tr>
            <th scope="row">{{$faturamentos->id}}</th>
            <td>{{$faturamentos->lucro}}%</td>
      
            <td>{{  'R$ '.number_format($faturamentos->valor, 2, ',', '.') }}</td>
 
                <td>
        <a href="{{url("/alterar/fat/config/$faturamentos->id")}}"><button type="button" class="btn btn-primary">Alterar</button></a>
                  </td>
            </tr>
         @endforeach
          </tbody>
      </table>
      <div class="card" style="width: 18rem;">
  <div class="card-header">
    Markups
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><b>Loja:</b> {{ number_format($markup, 2, ',', '.') }} </li>
    <li class="list-group-item"><b>Ifood:</b> {{ number_format($markupIfood, 2, ',', '.') }} </li>
    <li class="list-group-item"><b>Iqfome:</b> {{ number_format($markupIqfome, 2, ',', '.') }} </li>
  </ul>
</div>
   </div>
</div>


<div id="parametros" class="page-content">
  <br>
    <h1>Parametros</h1>
    <br>
    <div class="container">
     <br>
      
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
     
      <br>  <br> 
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Titulo</th>
             <th scope="col">Descrição</th>
             <th scope="col">Status</th>
              <th scope="col">Acionar</th>
          </tr>
        </thead>
        <tbody>
            @foreach($parametros as $params)
          <tr>
            <th scope="row">{{$params->id}}</th>
            <td>{{$params->titulo}}</td>
            <td>{{$params->descricao}}</td>
            <td>{{$params->opcao}}</td>
            <td>
        <a href="{{url("/alterar/param/config/$params->id")}}"><button type="button" class="btn btn-primary">Alterar Status</button></a>
                  </td>
          </tr>
         @endforeach
          </tbody>
      </table>
   </div>
</div>





</div>
   </div>
<script>
    function showContent(contentId) {
        var pages = document.getElementsByClassName("page-content");
        for (var i = 0; i < pages.length; i++) {
            pages[i].classList.remove("active-content");
        }
        document.getElementById(contentId).classList.add("active-content");
    }


</script>


</body>
</html>
