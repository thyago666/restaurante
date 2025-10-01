<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acessorio extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'acessorios';
    protected $fillable = ['id','descricao','valor'];
}
