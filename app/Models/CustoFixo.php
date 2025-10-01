<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustoFixo extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'custo_fixo';
    protected $fillable = ['id','descricao','valor'];
}
