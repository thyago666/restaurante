<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cardapioController extends Controller
{
    public function clientes($clientes){
    
        $directory = storage_path("app/public/{$clientes}");
       // Obter todos os arquivos JSON na pasta
        $files = glob("{$directory}/*.json");
        // Verificar se existem arquivos
        if (empty($files)) {
            abort(404, 'Nenhum arquivo JSON encontrado.');
        }
        // Ordenar arquivos por data de modificação, do mais recente para o mais antigo
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        // Pegar o último arquivo (o mais recente)
        $latestFile = $files[0];
        return response()->json(json_decode(file_get_contents($latestFile)));
    }
}
