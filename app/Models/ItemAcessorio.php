<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAcessorio extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'itens_acessorios';
    protected $fillable = ['id','id_acessorio','id_produto','qtd'];
}
