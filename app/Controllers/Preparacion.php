<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\CategoriasModel;
use App\Models\RecetasModel;

use App\Models\PreparacionesModel;

class Preparacion extends Home {

	public function __construct() {
		$this->session = \Config\Services::session();
        $this->session->start();
		$this->configuraciones = new ConfiguracionModel();
		$this->categorias = new CategoriasModel();
		$this->recetas = new RecetasModel();
		$this->preparaciones = new PreparacionesModel();
	}

	public function listar($receta) {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
            $preparacioness = $this->preparaciones->where('Receta', $receta)->orderBy('PasoNumero ASC')->findAll();
            $registros = count($preparacioness);
            $datosJson = '{"data": [';
			$contador = 0;
            foreach ($preparacioness as $preparacion) {
				$contador++;
				$acciones = "<form action='".site_url('preparacion/editar')."' method='post'>";
				$acciones .= "<input name='id' value='".$preparacion['IdPreparacion']."' type='number' style='display: none;'>";
                $acciones .= "<button class='btn btn-warning'><i class='fa fa-pencil text-white'></i></button>";
                $acciones .= "<a class='btnBorrar btn btn-danger' codigo='".$preparacion['IdPreparacion']."'><i class='fa fa-trash text-white'></i></a>";
				$acciones .= "</form>";
                if ($contador < $registros) {
                    $datosJson .= '[
                        "' . $preparacion['PasoNumero'] . '",
                        "' . $preparacion['DescripcionPaso'] . '",
                        "' . $acciones . '"
                    ],';
                } else {
                    $datosJson .= '[
                        "' . $preparacion['PasoNumero'] . '",
                        "' . $preparacion['DescripcionPaso'] . '",
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

	public function nuevo($receta) {
		$datos = $this->datosPrincipales();
		$receta = $this->recetas->where('IdReceta', $receta)->first();
		$datos += [
			'titulo' => 'Agregar paso para '.strtolower($receta['NombreReceta']),
			'receta' => $receta
		];
		if ($this->session->get('Usuario')) return view('administracion/preparacion/formulario', $datos);
		else return redirect()->to(base_url());
	}

	public function editar() {
		$datos = $this->datosPrincipales();
		$id = $this->request->getPost('id');
		$preparacion = $this->preparaciones->where('IdPreparacion', $id)->first();
		$receta = $this->recetas->where('IdReceta', $preparacion['Receta'])->first();
		$datos += [
			'titulo' => 'Modificar preparación',
			'preparacion' => $preparacion,
			'receta' => $receta
		];
		if ($this->session->get('Usuario')) return view('administracion/preparacion/formulario', $datos);
		else return redirect()->to(base_url());
	}

    public function validar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$receta = $this->request->getPost('receta');
			$id = $this->request->getPost('id');
			$paso = $this->request->getPost('paso');
			$descripcion = $this->request->getPost('descripcion');
			$verificar = $this->preparaciones->where([
				'PasoNumero' => $paso,
				'Receta' => $receta
			])->first();
            $campos = ''; $mensajes = ''; $contador = 0;
			if (!$receta) return 'error';
			if (!$paso || ($paso < 1)) {
				$contador++; $campos .= 'paso,';
				$mensajes .= 'El número debe ser mayor a cero,';
			} else {
				if ($verificar && $verificar['IdPreparacion'] <> $id) {
					$contador++; $campos .= 'paso,';
					$mensajes .= 'Ya existe este registro,';
				}
			}
			if (!$descripcion) {
				$contador++; $campos .= 'descripcion,';
				$mensajes .= 'Este dato es obligatorio,';
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
			$receta = $this->request->getPost('receta');
			$id = $this->request->getPost('id');
			$paso = $this->request->getPost('paso');
			$descripcion = $this->request->getPost('descripcion');
			if ($id) {
				$preparacion = $this->preparaciones->where('IdPreparacion', $id)->first();
				$this->preparaciones->where([
					'IdPreparacion' => $id,
					'Receta' => $receta
				])->set([
					'PasoNumero' => $paso,
					'DescripcionPaso' => $descripcion
				])->update();
			} else {
				$id = $this->generarId();
				$this->preparaciones->insert([
					'IdPreparacion' => $id,
					'PasoNumero' => $paso,
					'DescripcionPaso' => $descripcion,
					'Receta' => $receta
				]);
			}
            return 'success';
        } else return 'danger';
    }

	public function borrar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$id = $this->request->getPost('id');
            if (!$id) return "error";
			if ($this->preparaciones->where('IdPreparacion', $id)->delete()) return "ok";
			else return "uso";
        } else return "error";
	}

	public function generarId() {
        $id = 0;
        while (true) {
            $id++;
            if (!$this->preparaciones->where('IdPreparacion', $id)->first()) return $id;
        }
	}
}