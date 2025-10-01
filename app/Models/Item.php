<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'itens';
    protected $fillable = ['id','id_ingrediente','id_produto','qtd','qtdPorcaoFritadeira','qtdOleoFritadeira'];
}
