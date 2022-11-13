<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\UsuariosModel;

class Usuario extends Home {	

	public function __construct() {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->configuraciones = new ConfiguracionModel();
		$this->usuarios = new UsuariosModel();
	}

    public function index() {
		$datos = $this->datosPrincipales();
		$datos += [
			'titulo' => 'Usuarios'
		];
		if ($this->session->get('RolAsignado') == 'Administrador') return view('administracion/usuarios/index', $datos);
		else return redirect()->to(base_url());
    }

    public function listar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
            $usuarioss = $this->usuarios->orderBy('NombreCompleto ASC')->findAll();
            $cantidad = count($usuarioss);
            $datosJson = '{"data": [';
			$contador = 0;
            foreach ($usuarioss as $usuario) {
				$contador++;
				$acciones = "<form action='".site_url('usuario/editar')."' method='post'>";
				$acciones .= "<input name='id' value='".$usuario['IdUsuario']."' type='number' style='display: none;'>";
                $acciones .= "<button class='btn btn-warning'><i class='fa fa-pencil text-white'></i></button>";
                $acciones .= "<a class='btnBorrarUsuario btn btn-danger' codigo='".$usuario['IdUsuario']."'><i class='fa fa-trash text-white'></i></a>";
				$acciones .= "</form>";
                if ($contador < $cantidad) {
                    $datosJson .= '[
                        "' . $usuario['NombreCompleto'] . '",
                        "' . $usuario['Usuario'] . '",
                        "' . $usuario['RolAsignado'] . '",
                        "' . $acciones . '"
                    ],';
                } else {
                    $datosJson .= '[
                        "' . $usuario['NombreCompleto'] . '",
                        "' . $usuario['Usuario'] . '",
                        "' . $usuario['RolAsignado'] . '",
                        "' . $acciones . '"
                    ]';
                }
            }
            $datosJson .= ']}';
            return $datosJson;
        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function login() {
		$datos = $this->datosPrincipales();
        $datos += [
            'titulo' => 'Iniciar Sesión'
        ];
        if (!$this->session->get('Usuario')) return view('administracion/usuarios/login', $datos);
        else return redirect()->to(site_url('administrador'));
    }

    public function LoginAjax() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $usuario = $this->usuarios->where('Usuario', $username)->first();
            if (!$usuario['Usuario']) return "no_existe";
            if ($usuario['Contraseña'] <> $password) return "incorrecto";
            $this->session->set($usuario);
            return "ok";
        } else return "error";
    }

    public function logout() {
        $this->session->destroy();
        return redirect()->to(base_url());
    }

    public function nuevo() {
		$datos = $this->datosPrincipales();
		$datos += [
			'titulo' => 'Agregar usuario'
		];
		if ($this->session->get('RolAsignado') == 'Administrador') return view('administracion/usuarios/formulario', $datos);
		else return redirect()->to(base_url());
	}

    public function validar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
			$nombre = $this->request->getPost('nombre');
			$usuario = $this->request->getPost('usuario');
			$contraseña = $this->request->getPost('contraseña');
			$verificar = $this->usuarios->where('Usuario', $usuario)->first();
            $campos = ''; $mensajes = ''; $contador = 0;
			if (!$usuario) {
				$contador++; $campos .= 'usuario,';
				$mensajes .= 'Este dato es obligatorio,';
			} else {
				if ($verificar && $verificar['IdUsuario'] <> $id) {
					$contador++; $campos .= 'nombre,';
					$mensajes .= 'Ya existe este registro,';
				}
			}
            $json = array(
                'contador' => $contador,
                'mensajes' => $mensajes,
                'campos' => $campos
            );
            return json_encode($json);
        } else return 'error';
    }

	public function guardar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
			$nombre = ucwords($this->request->getPost('nombre'));
			$usuario = $this->request->getPost('usuario');
			$contraseña = $this->request->getPost('contraseña');
			$rol = $this->request->getPost('rol');
			if ($id) {
				$this->usuarios->where([
					'IdUsuario' => $id
				])->set([
					'NombreCompleto' => $nombre,
					'Usuario' => $usuario,
					'Contraseña' => $contraseña,
					'RolAsignado' => $rol
				])->update();
			} else {
				$id = $this->generarId();
				$this->usuarios->insert([
					'IdUsuario' => $id,
					'NombreCompleto' => $nombre,
					'Usuario' => $usuario,
					'Contraseña' => $contraseña,
					'RolAsignado' => $rol
				]);
			}
            return 'success';
        } else return 'danger';
    }

	public function editar() {
		$datos = $this->datosPrincipales();
		$id = $this->request->getPost('id');
		$usuario = $this->usuarios->where('IdUsuario', $id)->first();
		$datos += [
			'titulo' => 'Modificar usuario',
			'usuario' => $usuario
		];
		if ($this->session->get('RolAsignado') == 'Administrador') return view('administracion/usuarios/formulario', $datos);
		else return redirect()->to(base_url());
	}

    public function borrar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
            if (!$id) return "error";
			if ($this->usuarios->where('IdUsuario', $id)->delete()) return "ok";
			else return "uso";
        } else return "error";
	}

    public function generarId() {
        $codigo = 0;
        while (true) {
            $codigo++;
            if (!$this->usuarios->where('IdUsuario', $codigo)->first()) return $codigo;
        }
    }
}
?>