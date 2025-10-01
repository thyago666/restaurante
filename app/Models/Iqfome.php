<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iqfome extends Model
{
    use HasFactory;
    protected $connection ='mysql_2';
    protected $table = 'iqfome';
    protected $fillable = ['id','descricao','valor'];
}
