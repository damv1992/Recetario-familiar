<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriasModel extends Model
{
    protected $table = 'categorias';
    protected $primarykey = 'IdCategoria';
    protected $allowedFields = ['IdCategoria', 'NombreCategoria', 'IconoCategoria'];
}