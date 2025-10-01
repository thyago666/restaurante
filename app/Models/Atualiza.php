<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atualiza extends Model
{
    use HasFactory;
    protected $connection = 'mysql_2';
    protected $table = 'atualiza';
    protected $fillable = ['id', 'id_produto', 'valor_anterior', 'valor_atual','valor_cardapio'];
}
