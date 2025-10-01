<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
@if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


    <form method="post" action="{{url('/baixa/estoque/')}}">
        @csrf
    <div class="form-group">
        <label for="exampleFormControlSelect1"><b>Selecione o lanche para dar a baixa</b></label>
        <select class="form-control" id="id_lanche" name="selectLanche">
            @foreach($lanches as $lanche)
            <option value="{{$lanche->id}}">{{$lanche->descricao}}</option>

          @endforeach
          </select>
      </div>
      <button type="submit" class="btn btn-primary">Atualizar Estoque</button>
      <a href="{{url("/view/estoque")}}"> <button type="button" class="btn btn-success">Consultar Estoque</button></a>
      <a href="{{url("/dashboard")}}"> <button type="button" class="btn btn-warning">Voltar</button></a>

    </form><br>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9eY2lT9e1vOQj4tWjzk5W4k2ZCMN5yxhw7fT" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script>
    setTimeout(function() {
        var alert = document.getElementById('success-alert');
        if (alert) {
            alert.classList.remove('show'); // inicia o fade
            alert.classList.add('fade');
            setTimeout(function() {
                alert.remove(); // remove completamente após fade
            }, 500); // espera o fade-out terminar (0.5s)
        }
    }, 5000); // 5000ms = 5 segundos
</script>

</body>
</html>