<?php
namespace App\Controllers;

use App\Models\ConfiguracionModel;

class Administrador extends Home {

	public function __construct() {
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->configuraciones = new ConfiguracionModel();
	}

	public function index() {
		$datos = $this->datosPrincipales();
		$datos += [
			'titulo' => 'Administrador'
		];
		if ($this->session->get('Usuario')) return view('administracion/index', $datos);
		else return redirect()->to(site_url('usuario/login'));
    }

	public function pagina() {
		$datos = $this->datosPrincipales();
		$datos += [
			'titulo' => 'Datos de la página'
		];
		if ($this->session->get('RolAsignado') == 'Administrador') return view('administracion/pagina', $datos);
		else return redirect()->to(base_url());
    }
}