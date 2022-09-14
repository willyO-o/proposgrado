<?php

namespace App\Controllers;

use App\Models\OfertaModel;
use Exception;

class Oferta extends BaseController
{
	public function index()
	{

		$this->data['programa'] = $this->consultas->listarPublicacion('programasDivididos', ['estado_publicacion' => 'PUBLICADO', 'fecha_fin_publicacion >= ' => date('Y-m-d')], 'nombre_programa');
		$this->data['areas'] = $this->consultas->seleccionarTabla('area', '*')->getResult();
		$this->data['ciudades'] = $this->consultas->seleccionarTabla('ciudad', '*')->getResult();
		// var_dump($this->db->getLastQuery());
		// return var_dump($this->data['areas']);
		return $this->templater->view('oferta/index', $this->data);
	}

	public function detalle($idPublicacion)
	{
		$this->data['programa'] = $this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray();
		$this->data['programasRecientes'] = $this->consultas->listarPublicacion('programa', [], 'id_publicacion desc', 5)->getResultArray();
		return $this->templater->view('oferta/detalle', $this->data);
	}
	public function descargarArchivosPrograma($idPublicacion)
	{

		$publicacion = $this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray();
		// this response pdf

		$filepath = FCPATH . "imagenes/afiches/{$publicacion['infograma']}";
		// EDIT: I added some permission/file checking.
		if (!file_exists($filepath)) {
			throw new Exception("File $filepath does not exist");
		}
		if (!is_readable($filepath)) {
			throw new Exception("File $filepath is not readable");
		}
		http_response_code(200);
		header('Content-Length: ' . filesize($filepath));
		header("Content-Type: application/pdf");
		// header('Content-Disposition: attachment; filename="' . $publicacion['grado_academico'] . ' EN ' . $publicacion['nombre_programa'] . ', MODALIDAD ' . $publicacion['modalidad'] . ', VERSIÓN ' . $publicacion['numero_version'] . '.pdf"'); // feel free to change the suggested filename
		header('Content-Disposition: attachment; filename="' . $publicacion['grado_academico'] . ' EN ' . $publicacion['nombre_programa'] . ', MODALIDAD ' . $publicacion['modalidad'] . ', VERSIÓN ' . $publicacion['numero_version'] . '.pdf"'); // feel free to change the suggested filename
		readfile($filepath);
	}

	public function detalleProgramaJson($campos, $idPublicacion)
	{
		return $this->response->setJSON(array_intersect_key(
			$this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray(),
			array_flip(explode(',', $campos))
		));
	}

	public function verificar_etiqueta()
	{
		$id = $this->request->getPost('id');
		$todos = $this->request->getPost('todos');
		$oferta = new OfertaModel();
		if ($todos == 'si') {
			$data = $oferta->listarEtiquetas(null)->getResult();
		} else {
			$data = $oferta->listarEtiquetas(['ea.id_area' => $id])->getResult();
		}

		$datos = [];
		foreach ($data as $key => $value) {
			$value->weight = floatval(9);
			$value->color = (string) $this->colorHEX();
		}
		// return var_dump($datos);
		return $this->response->setJSON(json_encode($data));
	}

	function generarLetra()
	{
		$letras = ["a", "b", "c", "d", "e", "f", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
		$numero = random_int(0, 15);
		return $letras[$numero];
	}

	function colorHEX()
	{
		$coolor = "";
		for ($i = 0; $i < 6; $i++) {
			$coolor .= $this->generarLetra();
		}
		return  "#" . $coolor;
	}
}
