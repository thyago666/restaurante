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
<div class="d-grid gap-2">
</br>
<a href="{{url("/cardapio")}}"><button type="button" class="btn btn-secondary btn-lg btn-block">Conferir Cardápio Atualizado</button></a>
</br>
<button type="button" class="btn btn-primary btn-lg btn-block"  data-bs-toggle="modal" data-bs-target="#cardapio">Gerar Novo Cardápio Digital</button>
@include('confirmaNovoCardapio')    
</div>
</br>
<a href="{{url("/dashboard")}}"><button type="button" class="btn btn-secondary btn-lg btn-block">Voltar</button></a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>