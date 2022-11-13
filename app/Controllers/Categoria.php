<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\CategoriasModel;
use App\Models\RecetasModel;

class Categoria extends Home {

	public function __construct() {
		$this->session = \Config\Services::session();
        $this->session->start();
		$this->configuraciones = new ConfiguracionModel();
		$this->categorias = new CategoriasModel();
		$this->recetas = new RecetasModel();
	}

	public function index() {
		$datos = $this->datosPrincipales();
		$datos += [
			'titulo' => 'Categorías'
		];
		if ($this->session->get('Usuario')) return view('administracion/categorias/index', $datos);
		else return redirect()->to(base_url());
    }

	public function listar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
            $categoriass = $this->categorias->orderBy('NombreCategoria ASC')->findAll();
            $cantidad = count($categoriass);
            $datosJson = '{"data": [';
			$contador = 0;
            foreach ($categoriass as $categoria) {
				$contador++;
				$acciones = "<form action='".site_url('categoria/editar')."' method='post'>";
				$acciones .= "<input name='id' value='".$categoria['IdCategoria']."' type='number' style='display: none;'>";
                $acciones .= "<button class='btn btn-warning'><i class='fa fa-pencil text-white'></i></button>";
                $acciones .= "<a class='btnBorrarCategoria btn btn-danger' codigo='".$categoria['IdCategoria']."'><i class='fa fa-trash text-white'></i></a>";
                $acciones .= "<a href='".site_url('categoria/recetas/'.$categoria['IdCategoria'])."' class='btn btn-success'>Recetas <i class='fa fa-arrow-right text-white'></i></a>";
				$acciones .= "</form>";
				$imagen = "<img src='".base_url().$categoria['IconoCategoria']."' height='35'>";
                if ($contador < $cantidad) {
                    $datosJson .= '[
                        "' . $categoria['NombreCategoria'] . '",
                        "' . $imagen . '",
                        "' . $acciones . '"
                    ],';
                } else {
                    $datosJson .= '[
                        "' . $categoria['NombreCategoria'] . '",
                        "' . $imagen . '",
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

	public function nuevo() {
		$datos = $this->datosPrincipales();
		$datos += [
			'titulo' => 'Agregar categoría'
		];
		if ($this->session->get('Usuario')) return view('administracion/categorias/formulario', $datos);
		else return redirect()->to(base_url());
	}

    public function validar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
			$nombre = $this->request->getPost('nombre');
			$icono = $this->request->getFile('icono');
			$verificar = $this->categorias->where('NombreCategoria', $nombre)->first();
            $campos = ''; $mensajes = ''; $contador = 0;
			if (!$nombre) {
				$contador++; $campos .= 'nombreCategoria,';
				$mensajes .= 'Este dato es obligatorio,';
			} else {
				if ($verificar && $verificar['IdCategoria'] <> $id) {
					$contador++; $campos .= 'nombreCategoria,';
					$mensajes .= 'Ya existe este registro,';
				}
			}
            if ($icono == null) {
				if (!$id) {
					$contador++; $campos .= 'iconoCategoria,';
					$mensajes .= 'Seleccione el ícono de la categoría,';
				}
            } else {
				$extension = $icono->getExtension();
                if ($extension <> 'png') {
					$contador++; $campos .= 'iconoCategoria,';
					$mensajes .= 'El archivo debe ser formato .png,';
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
			$nombre = ucfirst($this->request->getPost('nombre'));
			$icono = $this->request->getFile('icono');
			if ($id) {
				$categoria = $this->categorias->where('IdCategoria', $id)->first();
				if ($icono <> null) $archivo = $this->subirArchivo($id, $icono);
				else $archivo = $categoria['IconoCategoria'];
				$this->categorias->where([
					'IdCategoria' => $id
				])->set([
					'NombreCategoria' => $nombre,
					'IconoCategoria' => $archivo
				])->update();
			} else {
				$id = $this->generarId();
				$archivo = $this->subirArchivo($id, $icono);
				$this->categorias->insert([
					'IdCategoria' => $id,
					'NombreCategoria' => $nombre,
					'IconoCategoria' => $archivo
				]);
			}
            return 'success';
        } else return 'danger';
    }

	public function editar() {
		$datos = $this->datosPrincipales();
		$id = $this->request->getPost('id');
		$categoria = $this->categorias->where('IdCategoria', $id)->first();
		$datos += [
			'titulo' => 'Modificar categoría',
			'categoria' => $categoria
		];
		if ($this->session->get('Usuario')) return view('administracion/categorias/formulario', $datos);
		else return redirect()->to(base_url());
	}

	public function subirArchivo($nombre, $archivo) {
		$extension = $archivo->getExtension();
		$ruta = '/RecipeBook/images/categorias';
		$ruta .= '/'.$nombre.'.'.$extension;
		if (file_exists($ruta)) unlink('.'.$ruta);
		\Config\Services::image()
			->withFile($archivo)
			->resize(100, 100, false, 'auto')
			->save('.'.$ruta);
		return $ruta;
	}

	public function borrar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
            if (!$id) return "error";
			if ($this->categorias->where('IdCategoria', $id)->delete()) return "ok";
			else return "uso";
        } else return "error";
	}

	public function generarId() {
        $id = 0;
        while (true) {
            $id++;
            if (!$this->categorias->where('IdCategoria', $id)->first()) return $id;
        }
	}

	public function recetas($id) {
		$datos = $this->datosPrincipales();
		$categoria = $this->categorias->where('IdCategoria', $id)->first();
		$datos += [
			'titulo' => 'Recetas de '.strtolower($categoria['NombreCategoria']),
			'categoria' => $categoria
		];
		if ($this->session->get('Usuario')) return view('administracion/recetas/index', $datos);
		else return redirect()->to(base_url());
	}
}