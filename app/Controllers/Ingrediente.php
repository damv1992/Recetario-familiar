<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\CategoriasModel;
use App\Models\RecetasModel;
use App\Models\IngredientesModel;

class Ingrediente extends Home {

	public function __construct() {
		$this->session = \Config\Services::session();
        $this->session->start();
		$this->configuraciones = new ConfiguracionModel();
		$this->categorias = new CategoriasModel();
		$this->recetas = new RecetasModel();
		$this->ingredientes = new IngredientesModel();
	}

	public function listar($receta) {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
            $ingredientess = $this->ingredientes->where('Receta', $receta)->orderBy('NombreIngrediente ASC')->findAll();
            $registros = count($ingredientess);
            $datosJson = '{"data": [';
			$contador = 0;
            foreach ($ingredientess as $ingrediente) {
				$contador++;
				$acciones = "<form action='".site_url('ingrediente/editar')."' method='post'>";
				$acciones .= "<input name='id' value='".$ingrediente['IdIngrediente']."' type='number' style='display: none;'>";
                $acciones .= "<button class='btn btn-warning'><i class='fa fa-pencil text-white'></i></button>";
                $acciones .= "<a class='btnBorrar btn btn-danger' codigo='".$ingrediente['IdIngrediente']."'><i class='fa fa-trash text-white'></i></a>";
				$acciones .= "</form>";
				$cantidad = $ingrediente['Cantidad'].' '.$ingrediente['UnidadMedida'];
                if ($contador < $registros) {
                    $datosJson .= '[
                        "' . $ingrediente['NombreIngrediente'] . '",
                        "' . $cantidad . '",
                        "' . $acciones . '"
                    ],';
                } else {
                    $datosJson .= '[
                        "' . $ingrediente['NombreIngrediente'] . '",
                        "' . $cantidad . '",
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
			'titulo' => 'Agregar ingrediente para '.strtolower($receta['NombreReceta']),
			'receta' => $receta
		];
		if ($this->session->get('Usuario')) return view('administracion/ingredientes/formulario', $datos);
		else return redirect()->to(base_url());
	}

	public function editar() {
		$datos = $this->datosPrincipales();
		$id = $this->request->getPost('id');
		$ingrediente = $this->ingredientes->where('IdIngrediente', $id)->first();
		$receta = $this->recetas->where('IdReceta', $ingrediente['Receta'])->first();
		$datos += [
			'titulo' => 'Modificar ingrediente',
			'ingrediente' => $ingrediente,
			'receta' => $receta
		];
		if ($this->session->get('Usuario')) return view('administracion/ingredientes/formulario', $datos);
		else return redirect()->to(base_url());
	}

    public function validar() {
        if ($this->request->isAjax() && $this->request->getMethod() == "post") {
			$receta = $this->request->getPost('receta');
			$id = $this->request->getPost('id');
			$nombre = $this->request->getPost('nombre');
			$cantidad = $this->request->getPost('cantidad');
			$medida = $this->request->getPost('medida');
			$verificar = $this->ingredientes->where([
				'NombreIngrediente' => $nombre,
				'Receta' => $receta
			])->first();
            $campos = ''; $mensajes = ''; $contador = 0;
			if (!$receta) return 'error';
			if (!$nombre) {
				$contador++; $campos .= 'nombre,';
				$mensajes .= 'Este dato es obligatorio,';
			} else {
				if ($verificar && $verificar['IdIngrediente'] <> $id) {
					$contador++; $campos .= 'nombre,';
					$mensajes .= 'Ya existe este registro,';
				}
			}
			if (!$cantidad || ($cantidad < 1)) {
				$contador++; $campos .= 'cantidad,';
				$mensajes .= 'El número debe ser mayor a cero,';
			}
			if (!$medida) {
				$contador++; $campos .= 'medida,';
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
			$nombre = ucfirst($this->request->getPost('nombre'));
			$cantidad = $this->request->getPost('cantidad');
			$medida = $this->request->getPost('medida');
			if ($id) {
				$ingrediente = $this->ingredientes->where('IdIngrediente', $id)->first();
				$this->ingredientes->where([
					'IdIngrediente' => $id,
					'Receta' => $receta
				])->set([
					'NombreIngrediente' => $nombre,
					'Cantidad' => $cantidad,
					'UnidadMedida' => $medida
				])->update();
			} else {
				$id = $this->generarId();
				$this->ingredientes->insert([
					'IdIngrediente' => $id,
					'NombreIngrediente' => $nombre,
					'Cantidad' => $cantidad,
					'UnidadMedida' => $medida,
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
			if ($this->ingredientes->where('IdIngrediente', $id)->delete()) return "ok";
			else return "uso";
        } else return "error";
	}

	public function generarId() {
        $id = 0;
        while (true) {
            $id++;
            if (!$this->ingredientes->where('IdIngrediente', $id)->first()) return $id;
        }
	}
}