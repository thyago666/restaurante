<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'produtos';
    protected $fillable = ['id','descricao','tipo','situacao','imagem','updated_at','created_at'];
}
