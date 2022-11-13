<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\CategoriasModel;
use App\Models\RecetasModel;

class Receta extends Home {

	public function __construct() {
		$this->session = \Config\Services::session();
        $this->session->start();
		$this->configuraciones = new ConfiguracionModel();
		$this->categorias = new CategoriasModel();
		$this->recetas = new RecetasModel();
	}

	public function listar($categoria) {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
            $recetass = $this->recetas->where('Categoria', $categoria)->orderBy('NombreReceta ASC')->findAll();
            $cantidad = count($recetass);
            $datosJson = '{"data": [';
			$contador = 0;
            foreach ($recetass as $receta) {
				$contador++;
				$acciones = "<form action='".site_url('receta/editar')."' method='post'>";
				$acciones .= "<input name='id' value='".$receta['IdReceta']."' type='number' style='display: none;'>";
                $acciones .= "<button class='btn btn-warning'><i class='fa fa-pencil text-white'></i></button>";
                $acciones .= "<a class='btnBorrarReceta btn btn-danger' codigo='".$receta['IdReceta']."'><i class='fa fa-trash text-white'></i></a>";
                $acciones .= "<a href='".site_url('receta/ingredientes/'.$receta['IdReceta'])."' class='btn btn-success'>Ingredientes <i class='fa fa-arrow-right text-white'></i></a>";
                $acciones .= "<a href='".site_url('receta/preparacion/'.$receta['IdReceta'])."' class='btn btn-success'>Preparación <i class='fa fa-arrow-right text-white'></i></a>";
				$acciones .= "</form>";
				$imagen = "<img src='".base_url().$receta['FotoReceta']."' height='35'>";
                if ($contador < $cantidad) {
                    $datosJson .= '[
                        "' . $receta['NombreReceta'] . '",
                        "' . $imagen . '",
                        "' . $acciones . '"
                    ],';
                } else {
                    $datosJson .= '[
                        "' . $receta['NombreReceta'] . '",
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

	public function nuevo($categoria) {
		$datos = $this->datosPrincipales();
		$categoria = $this->categorias->where('IdCategoria', $categoria)->first();
		$datos += [
			'titulo' => 'Agregar receta de '.strtolower($categoria['NombreCategoria']),
			'categoria' => $categoria
		];
		if ($this->session->get('Usuario')) return view('administracion/recetas/formulario', $datos);
		else return redirect()->to(base_url());
	}

	public function editar() {
		$datos = $this->datosPrincipales();
		$id = $this->request->getPost('id');
		$receta = $this->recetas->where('IdReceta', $id)->first();
		$categoria = $this->categorias->where('IdCategoria', $receta['Categoria'])->first();
		$datos += [
			'titulo' => 'Modificar receta',
			'receta' => $receta,
			'categoria' => $categoria
		];
		if ($this->session->get('Usuario')) return view('administracion/recetas/formulario', $datos);
		else return redirect()->to(base_url());
	}

    public function validar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$categoria = $this->request->getPost('categoria');
			$id = $this->request->getPost('id');
			$nombre = $this->request->getPost('nombre');
			$foto = $this->request->getFile('foto');
			$horas = $this->request->getPost('horas');
			$minutos = $this->request->getPost('minutos');
			$segundos = $this->request->getPost('segundos');
			$porciones = $this->request->getPost('porciones');
			$verificar = $this->recetas->where('NombreReceta', $nombre)->first();
            $campos = ''; $mensajes = ''; $contador = 0;
			if (!$categoria) return 'error';
			if (!$nombre) {
				$contador++; $campos .= 'nombreReceta,';
				$mensajes .= 'Este dato es obligatorio,';
			} else {
				if ($verificar && $verificar['IdReceta'] <> $id) {
					$contador++; $campos .= 'nombreReceta,';
					$mensajes .= 'Ya existe este registro,';
				}
			}
            if ($foto == null) {
				if (!$id) {
					$contador++; $campos .= 'fotoReceta,';
					$mensajes .= 'Seleccione una foto de la receta finalizada,';
				}
            } else {
				$extension = $foto->getExtension();
                if (($extension <> 'jpg') && ($extension <> 'jpeg') && ($extension <> 'png')) {
					$contador++; $campos .= 'fotoReceta,';
					$mensajes .= 'El archivo debe ser formato .jpg o .jpeg o .png,';
				}
			}
			if ($horas || $minutos || $segundos) {} else {
				$contador++; $campos .= 'segundosReceta,';
				$mensajes .= 'Debe haber al menos un dato,';
			}
			if (!$porciones || ($porciones < 1)) {
				$contador++; $campos .= 'porcionesReceta,';
				$mensajes .= 'Las porciones deben ser mayor a cero,';
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
			$categoria = $this->request->getPost('categoria');
			$id = $this->request->getPost('id');
			$nombre = ucfirst($this->request->getPost('nombre'));
			$foto = $this->request->getFile('foto');
			$horas = $this->request->getPost('horas');
			$minutos = $this->request->getPost('minutos');
			$segundos = $this->request->getPost('segundos');
			$dificultad = $this->request->getPost('dificultad');
			$porciones = $this->request->getPost('porciones');
			$tiempo = $horas.':'.$minutos.':'.$segundos;
			if ($id) {
				$receta = $this->recetas->where('IdReceta', $id)->first();
				if ($foto <> null) $archivo = $this->subirArchivo($id, $foto);
				else $archivo = $receta['FotoReceta'];
				$this->recetas->where([
					'IdReceta' => $id,
					'Categoria' => $categoria
				])->set([
					'NombreReceta' => $nombre,
					'FotoReceta' => $archivo,
					'Tiempo' => $tiempo,
					'Dificultad' => $dificultad,
					'Porciones' => $porciones
				])->update();
			} else {
				$id = $this->generarId();
				$archivo = $this->subirArchivo($id, $foto);
				$this->recetas->insert([
					'IdReceta' => $id,
					'NombreReceta' => $nombre,
					'FotoReceta' => $archivo,
					'Tiempo' => $tiempo,
					'Dificultad' => $dificultad,
					'Porciones' => $porciones,
					'Categoria' => $categoria
				]);
			}
            return 'success';
        } else return 'danger';
    }

	public function borrar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
            if (!$id) return "error";
			if ($this->recetas->where('IdReceta', $id)->delete()) return "ok";
			else return "uso";
        } else return "error";
	}

	public function subirArchivo($nombre, $archivo) {
		$extension = $archivo->getExtension();
		$ruta = '/RecipeBook/images/recetas';
		$ruta .= '/'.$nombre.'.'.$extension;
		if (file_exists($ruta)) unlink('.'.$ruta);
		\Config\Services::image()
			->withFile($archivo)
			->resize(640, 378, false, 'auto')
			->save('.'.$ruta);
		return $ruta;
	}

	public function generarId() {
        $id = 0;
        while (true) {
            $id++;
            if (!$this->recetas->where('IdReceta', $id)->first()) return $id;
        }
	}

	public function ingredientes($id) {
		$datos = $this->datosPrincipales();
		$receta = $this->recetas->where('IdReceta', $id)->first();
		$categoria = $this->categorias->where('IdCategoria', $receta['Categoria'])->first();
		$datos += [
			'titulo' => 'Ingredientes para '.$receta['NombreReceta'].' ('.$categoria['NombreCategoria'].')',
			'receta' => $receta,
			'categoria' => $categoria
		];
		if ($this->session->get('Usuario')) return view('administracion/ingredientes/index', $datos);
		else return redirect()->to(base_url());
	}

	public function preparacion($id) {
		$datos = $this->datosPrincipales();
		$receta = $this->recetas->where('IdReceta', $id)->first();
		$categoria = $this->categorias->where('IdCategoria', $receta['Categoria'])->first();
		$datos += [
			'titulo' => 'Preparación para '.$receta['NombreReceta'].' ('.$categoria['NombreCategoria'].')',
			'receta' => $receta,
			'categoria' => $categoria
		];
		if ($this->session->get('Usuario')) return view('administracion/preparacion/index', $datos);
		else return redirect()->to(base_url());
	}
}