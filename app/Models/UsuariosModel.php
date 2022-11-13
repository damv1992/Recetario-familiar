<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios';
    protected $primarykey = 'IdUsuario';
    protected $allowedFields = ['IdUsuario', 'Usuario', 'Contraseña', 'NombreCompleto', 'RolAsignado'];
}