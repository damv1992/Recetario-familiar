<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion';
    protected $primarykey = 'IdConfiguracion';
    protected $allowedFields = ['IdConfiguracion', 'NombrePagina', 'LogoPagina', 'IconoPagina', 'SobreNosotros'];
}