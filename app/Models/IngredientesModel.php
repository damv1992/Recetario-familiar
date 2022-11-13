<?php

namespace App\Models;

use CodeIgniter\Model;

class IngredientesModel extends Model
{
    protected $table = 'ingredientes';
    protected $primarykey = 'IdIngrediente';
    protected $allowedFields = ['IdIngrediente', 'NombreIngrediente', 'Cantidad', 'UnidadMedida', 'Receta'];
}