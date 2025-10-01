<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'parametros';
    protected $fillable = ['id','titulo','descricao','opcao'];
}
