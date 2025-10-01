<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'ingredientes';
    protected $fillable = ['id','descricao','descricaoSimples','unidMedida','valor','qtd_porcao','tipo','id_produto','qtdEmb','bonificacao','qtd_estoque','estMinimo'];
}
