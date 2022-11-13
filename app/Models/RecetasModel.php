<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetasModel extends Model
{
    protected $table = 'recetas';
    protected $primarykey = 'IdReceta';
    protected $allowedFields = ['IdReceta', 'NombreReceta', 'FotoReceta', 'Tiempo', 'Dificultad', 'Porciones', 'Categoria'];
}