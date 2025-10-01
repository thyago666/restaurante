<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaAcessorio extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'entrada_acessorio';
    protected $fillable = ['id','id_acessorio','qtd','valor_total'];
}
