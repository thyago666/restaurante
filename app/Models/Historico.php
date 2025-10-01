<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'historico_produtos';
    protected $fillable = ['id','id_produto','valor'];
}
