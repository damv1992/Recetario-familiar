<?php

namespace App\Models;

use CodeIgniter\Model;

class PreparacionesModel extends Model
{
    protected $table = 'preparaciones';
    protected $primarykey = 'IdPreparacion';
    protected $allowedFields = ['IdPreparacion', 'PasoNumero', 'DescripcionPaso', 'Receta'];
}