<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoIngredientes extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'historico_ingredientes';
    protected $fillable = ['id','id_ingrediente','valor'];
}
