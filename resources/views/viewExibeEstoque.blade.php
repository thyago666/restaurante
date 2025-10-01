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
      <h2>ESTOQUE DE INGREDIENTES</h2>
     <table class="table" >
        <thead>
          <tr align="">
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Unidade de Medida</th>
            <th scope="col">Qtd Estoque</th>
          </tr>
        </thead>
        <tbody>
            @foreach($ingredientes as $ingrediente)
            @php
            $estoqueAtual = $ingrediente->qtd_estoque;
            $estoqueMinimo = $ingrediente->estMinimo;
     
        @endphp
        @if($ingrediente->unidMedida === 'porcao')
            @php
               $estoquePorcao = ($ingrediente->qtd_estoque/$ingrediente->qtd_porcao)
            @endphp
            <tr align="left" class="{{ $estoquePorcao <= $estoqueMinimo ? 'table-danger' : '' }}">
        @endif

         @if($ingrediente->unidMedida != 'porcao')
             <tr align="left" class="{{ $ingrediente->qtd_estoque <= $estoqueMinimo ? 'table-danger' : '' }}">
         @endif     

            <th scope="row">{{$ingrediente->id}}</th>
            <td>{{$ingrediente->descricao}}</td>
              @if($ingrediente->unidMedida === 'porcao')
            <td>Unidade</td>
            @else
                <td>{{$ingrediente->unidMedida}}</td>
            @endif

            @if($ingrediente->unidMedida == 'porcao' and $ingrediente->qtd_estoque != 0)
               @php
            $estoquePorcao = ($ingrediente->qtd_estoque/$ingrediente->qtd_porcao)
                 @endphp
            <td>{{$estoquePorcao}}</td>
             @elseif($ingrediente->unidMedida == 'litro' and $ingrediente->qtd_estoque != 0)
             @php
             $estoqueLitro = ($ingrediente->qtd_estoque/$ingrediente->qtdEmb)
                  @endphp
             <td>{{$estoqueLitro}}</td>
             @else
             <td>{{$ingrediente->qtd_estoque}}</td>
             @endif
         
       </td>
            </tr>
         @endforeach
         </tbody>
      </table>
    </div>
</body>
</html>