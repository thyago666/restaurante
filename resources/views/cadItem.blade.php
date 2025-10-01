
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
    <form method="post" action="{{url('/insert/item/')}}">
        @csrf

        <input type="hidden" class="form-control" value={{$produto->id}} id="produto" name="produto">

    <div class="form-group">
        <label for="unidade_medida"><b>Ingredientes</b></label>
        <select class="form-control" id="ingredientes" name="ingredientes" onchange="showFritadeiraSelect(this.value)">
            @foreach($ingredientes as $ingrediente)
          <option value={{$ingrediente->id}}>{{$ingrediente->descricao}} - {{$ingrediente->unidMedida}}</option>
           @endforeach
           </select>
      </div>

      <!-- quando o ingrediente for oleo aparece esses selects -->
     <div class="form-group" id="fritadeiraDiv" style="display: none;">
        <label for="fritadeira"><b>Fritadeira</b></label>
        <select class="form-control" id="fritadeira" name="fritadeira" onchange="showFritadeira(this.value)">
        <option value='default'>Escolha</option> 
        <option value='S'>Sim</option>
          <option value='N'>Não</option>
        </select>
        <small id="descricao" class="form-text text-muted"><b>Informe 'SIM' caso esse produto usar o óleo da fritadeira, e click em 'INSERIR'</b></small>
      </div>

      <div class="form-group" id="qtdOleoFritadeira" style="display: none;">
        <label for="descricao"><b>Qtd de Óleo</b></label>
        <input type="number" class="form-control" id="qtdOleoFritadeiraInput" name="qtdOleoFritadeira">
        <small id="qtdOleoFritadeira" class="form-text text-muted"><b>Informe aqui a quantidade de óleo que vai na sua fritadeira, Ex: 20 un</b></small>
      </div>

      <div class="form-group" id="qtdPorcaoFritadeira" style="display: none;">
        <label for="descricao"><b>Qtd de Porção</b></label>
        <input type="number" class="form-control" id="qtdPorcaoFritadeiraInput" name="qtdPorcaoFritadeira">
        <small id="qtdPorcaoFritadeira" class="form-text text-muted"><b>Informe aqui a quantidade de porção que esse óleo consegue fritar</b></small>
      </div>
        <!-- fim -->
   
      <div class="form-group" id="qtdDiv">
        <label for="descricao"><b>Qtd</b></label>
        <input type="number" class="form-control" id="qtd" name="qtd">
        <small id="qtd" class="form-text text-muted">Informe aqui a quantidade que vai 
            desse ingrediente nesse produto, geralmente essa quantidade é em grama, unidade ou porção</small>
      </div>


      <button type="submit" class="btn btn-primary">Inserir</button>

      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>
    </form><br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Medida</th>
            <th scope="col">Qtd</th>
            <th scope="col">Custo Total</th>
            <th scope="col">Opções</th>
        
          </tr>
        </thead>
        <tbody>
          @php
  $resul = 0;
  $total = 0;
  $valor_cada_porcao = 0;
  @endphp
              @foreach($itens as $item)
         
          <tr>
            <th scope="row">{{$item->id}}</th>
            <td>{{$item->descricao}}</td>
            <td>{{$item->unidMedida}}</td>
            <td>{{$item->qtd}}</td>

    @if($item->unidMedida == 'kilo')
     @php
        $resul = ($item->valor*$item->qtd)/1000;
     @endphp
     <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
    @endif

    @if($item->unidMedida == 'unidade')
      @php
       $resul = ($item->valor*$item->qtd);
      @endphp
     <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
    @endif

    @if($item->unidMedida == 'porcao')
    @php
      $valor_cada_porcao = ($item->valor/$item->qtd_porcao);
      $resul = ($valor_cada_porcao*$item->qtd);
    @endphp
     <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
    @endif

    @if($item->unidMedida == 'litro' and $item->qtdOleoFritadeira == null and $item->qtdPorcaoFritadeira == null)
      @php
        $resul = ($item->valor*$item->qtd)/$item->qtdEmb;
      @endphp
      <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td><!-- vai dar problema no oleo da fritadeira-->
      @endif

      @if($item->qtdOleoFritadeira != null and $item->qtdPorcaoFritadeira != null )
      @php
        $resul = ($item->valor*$item->qtdOleoFritadeira)/$item->qtdPorcaoFritadeira;
      @endphp
      
      <td>{{  'R$ '.number_format($resul, 2, ',', '.') }}</td>
      @endif


        <td>
           <a href="{{url("/delete/item/$item->id_item/$item->id_produtos")}}"><button type="button" class="btn btn-danger">Excluir</button></a>
          
           
            </td>
            </tr>
                @endforeach
         </tbody>
      </table>
</div>


<script>
    function showFritadeiraSelect(value) {
        var fritadeiraDiv = document.getElementById("fritadeiraDiv");
        var fritadeiraSelect = document.getElementById("fritadeira");
        var qtdInput = document.getElementById("qtdDiv");
        var qtdPorcaoFritadeira = document.getElementById("qtdPorcaoFritadeira");
        var qtdOleoFritadeira = document.getElementById("qtdOleoFritadeira");
        
        if (value == 1) {
            fritadeiraDiv.style.display = "block";
            fritadeiraSelect.required = true;
            qtdInput.style.display = "block";
            qtdOleoFritadeira.style.display = "block";
            qtdPorcaoFritadeira.style.display = "block";

          } else {
            fritadeiraDiv.style.display = "none";
            fritadeiraSelect.required = false;
            qtdInput.style.display = "block";
            qtdOleoFritadeira.style.display = "none";
            qtdPorcaoFritadeira.style.display = "none";
          
        }
    }

    function showFritadeira(value) {
        var qtdPorcaoFritadeira = document.getElementById("qtdPorcaoFritadeira");
        var qtdOleoFritadeira = document.getElementById("qtdOleoFritadeira");
        var qtdInput = document.getElementById("qtdDiv");
        
        if (value === 'S') {
            qtdOleoFritadeira.style.display = "block";
            qtdPorcaoFritadeira.style.display = "block";
            qtdInput.style.display = "none";
        } else {
            qtdOleoFritadeira.style.display = "none";
            qtdPorcaoFritadeira.style.display = "none";
            qtdInput.style.display = "block";
        }
    }
</script>

</body>
</html>
