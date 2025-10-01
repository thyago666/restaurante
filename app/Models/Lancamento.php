<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;

    protected $connection = 'mysql_2';
    protected $table = 'saida';
    protected $fillable = ['id', 'descricao', 'valor', 'vencimento', 'status'];
}
