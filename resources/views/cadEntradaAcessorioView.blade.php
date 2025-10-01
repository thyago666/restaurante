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
      <h1>ENTRADA DE ACESSÓRIOS</h1>
    <form method="post" action="{{url('/cadastro/entrada-acessorio')}}">
      @csrf

      <div class="form-group">
        <label for="acessorios"><b>Acessórios</b></label>
        <select class="form-control" id="acessorios" name="acessorios">

            @foreach($acessorios as $acessorio)
          <option  value={{$acessorio->id}}>{{$acessorio->descricao}}</option>
          @endforeach
        </select>
      </div>

        <div class="form-group">
          <label for="qtd"><b>Qtd</b></label>
          <input type="text" class="form-control" id="qtd" name="qtd">
          <small id="qtd" class="form-text text-muted">Informe aqui a quantidade comprada desse acessório</small>
        </div>

        <div class="form-group">
          <label for="descricao"><b>Valor Total</b></label>
          <input type="text" class="form-control" id="valor_total" name="valor_total">
          <small id="descricao" class="form-text text-muted">Informe aqui o valor total que você pagou nesse acessório</small>
        </div>
         
        <button type="submit" class="btn btn-primary">Gravar</button>
        <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
  

      </form><br>

      <form method="post" action="{{url('/pesquisa/entrada-acessorio')}}">
        @csrf
      <div>
     <h5> Data Inicial</h5>
      <input type="date" name="dt_inicial">
     
      <h5>Data Final</h5>
      <input type="date" name="dt_final">
      <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
      </div>
      <br>
      <table class="table table-success table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Data</th>
            <th scope="col">Valor</th>
          </tr>
        </thead>
        <tbody>
          @php
           $total=0;
           @endphp   
      
          @if (isset($psq))
          @foreach($psq as $psqs)
          <tr>
            <th scope="row">{{$psqs->id}}</th>
            <td>{{$psqs->descricao}}</td>
          
            <td>{{ \Carbon\Carbon::parse($psqs->data_compra)->format('d/m/Y')}}</td>
            <td>{{  'R$ '.number_format($psqs->valor, 2, ',', '.') }}</td>

              @php
            $total = $total + $psqs->valor;
            @endphp
          </tr>
          @endforeach
   
          @endif
              </tbody>
                   
   
      </table>
      <table class="table table-success table-striped">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th><h3>Total = {{  'R$ '.number_format($total, 2, ',', '.') }}</h3></th>
          </tr>
        </thead>
    
      </table>
      
      </form>
  
    </div>
</body>
</html>