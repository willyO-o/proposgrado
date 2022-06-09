<?php

namespace App\Controllers;

class Inicio extends BaseController
{
	public function index()
	{
		// return var_dump($this->consultas->listarProgramas('programas_divididos'));
		// $this->data['publicacion'] = $this->consultas->listarPublicacion('programa', [], 'id_publicacion desc', 5)->getResultArray();
		$this->data['publicacion'] = [];
		$orden = ['DIPLOMADO', 'ESPECIALIDAD', 'MAESTRÍA', 'DOCTORADO', 'POST DOCTORADO'];
		$programas = $this->consultas->listarPublicacion('programasDivididos', ['estado_publicacion' => 'PUBLICADO', 'fecha_fin_publicacion >= ' => date('Y-m-d')]);
		foreach ($orden as $key => $value) {
			$this->data['publicacion'] = array_merge($this->data['publicacion'], isset($programas[$value]) ? $programas[$value] : []);
		}
		// return var_dump($this->data['publicacion']);
		// $this->data['programa'] = $this->consultas->listarPrograma('programasDivididos', ['id_gestion_programa >=' => 20]);
		$this->data['programa'] = [
			'DIPLOMADO' => [
				['nombre_programa' => "DIPLOMADO EN EDUCACIÓN SUPERIOR"],
				['nombre_programa' => "DIPLOMADO EN DOCENCIA Y GESTIÓN DE AULA EN EDUCACIÓN SUPERIOR"],
				['nombre_programa' => "DIPLOMADO EN METODOLOGÍA DE LA INVESTIGACIÓN CIENTÍFICA"],
				['nombre_programa' => "DIPLOMADO EN GESTION DE LA CALIDAD ISO 9001"],
				['nombre_programa' => "DIPLOMADO EN ADMINISTRACIÓN Y GESTIÓN EDUCATIVA"],
				['nombre_programa' => "DIPLOMADO EN DIDÁCTICA DE LA EDUCACIÓN SUPERIOR PARA DOCENTES DE AULA"],
				['nombre_programa' => "DIPLOMADO EN LENGUA DE SEÑAS"],
				['nombre_programa' => "DIPLOMADO EN GESTIÓN EDUCATIVA DE CENTROS INFANTILES"],
				['nombre_programa' => "DIPLOMADO EN MUSICOTERAPIA APLICADA A LA EDUCACIÓN"],
				['nombre_programa' => "DIPLOMADO EN METODOLOGIA DE LA INVESTIGACION CIENTIFICA PARA INGENIERIA"],
				['nombre_programa' => "DIPLOMADO EN GESTIÓN DE RIESGOS FINANCIEROS"],
				['nombre_programa' => "DIPLOMADO EN RECURSOS Y HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL"],
				['nombre_programa' => "DIPLOMADO EN ECOGRAFÍA BASICA ABDOMINAL Y GINECOOBSTETRICA"],
				['nombre_programa' => "DIPLOMADO EN ADMINISTRACIÓN Y GERENCIA HOSPITALARIA Y DE SERVICIOS DE SALUD"],
				['nombre_programa' => "DIPLOMADO EN POLÍTICA FISCAL Y TRIBUTARIA"]
			],
			'ESPECIALIDAD' => [
				['nombre_programa' => "ESPECIALIDAD EN DOCENCIA UNIVERSITARIA"],
				['nombre_programa' => "ORTODONCIA Y ORTOPEDIA DENTO MAXILAR"],
				['nombre_programa' => "IMAGENOLOGÍA BUCO MAXILOFACIAL"],
				['nombre_programa' => "REHABILITACIÓN ORAL Y ESTÉTICA"],
				['nombre_programa' => "CIRUGÍA BUCAL E IMPLANTOLOGÍA"],
			], 'MAESTRÍA' => [
				['nombre_programa' => "MAESTRÍA EN EDUCACIÓN SUPERIOR"],
				['nombre_programa' => "MAESTRÍA EN EDUCACIÓN SUPERIOR Y TIC"],
				['nombre_programa' => "MAESTRÍA EN ADMINISTRACIÓN Y GESTIÓN EDUCATIVA"],
				['nombre_programa' => "MAESTRÍA EN DIRECCIÓN Y GERENCIA EDUCATIVA"],
				['nombre_programa' => "MAESTRÍA EN DIRECCIÓN Y GESTIÓN ESTRATÉGICA DE INSTITUCIONES EDUCATIVAS"],
				['nombre_programa' => "MAESTRÍA EN EDUCACIÓN SUPERIOR E INVESTIGACIÓN"],
				['nombre_programa' => "MAESTRÍA EN EDUCACIÓN SUPERIOR POR COMPETENCIAS"],
				['nombre_programa' => "MAESTRÍA EN INNOVACIÓN EDUCATIVA EN EDUCACIÓN SUPERIOR"],
				['nombre_programa' => "MAESTRÍA EN EDUCACIÓN INFANTIL E INVESTIGACIÓN"],
				['nombre_programa' => "MAESTRÍA EN GERENCIA EDUCATIVA Y DESARROLLO HUMANO"],
				['nombre_programa' => "MAESTRÍA EN INVESTIGACIÓN CIENTÍFICA"],
				['nombre_programa' => "MAESTRÍA EN MEDICINA CRÍTICA Y TERAPIA INTENSIVA EN ENFERMERÍA"],
				['nombre_programa' => "MAESTRÍA EN SALUD PÚBLICA MENCIÓN EPIDEMIOLOGÍA CLÍNICA"],
				['nombre_programa' => "MAESTRÍA EN INVESTIGACIÓN EN CIENCIAS DE LA SALUD Y DISEÑO DE PROYECTOS"],
				['nombre_programa' => "MAESTRÍA EN PSICOLOGÍA CLÍNICA SISTÉMICA"]
			], 'DOCTORADO' => [
				['nombre_programa' => "DOCTORADO EN CIENCIAS DE LA EDUCACIÓN E INVESTIGACIÓN"],
				['nombre_programa' => "DOCTORADO EN EDUCACIÓN ESPECIAL E INCLUSIVA"],
				['nombre_programa' => "DOCTORADO EN CIENCIA Y TECNOLOGIA"]
			],
			'POST DOCTORADO' => [
				['nombre_programa' => "INVESTIGACION Y TIC'S"],
				['nombre_programa' => "EPISTEMOLOGÍA E INVESTIGACIÓN"]
			]
		];
		// return var_dump($this->data['programa']);
		return $this->templater->view('inicio/index', $this->data);
	}

	public function mision_vision()
	{
		$this->data['mision'] = '';
		return $this->templater->view('inicio/mision_vision', $this->data);
	}

	public function organizacion()
	{
		$this->data['organizacion'] = '';
		return $this->templater->view('inicio/organizacion', $this->data);
	}

	public function expocruz()
	{
		$this->data['expocruz'] = '';
		return $this->templater->view('inicio/expocruz', $this->data);
	}

	public function contacto()
	{
		$this->data['contacto'] = '';
		return $this->templater->view('inicio/contacto', $this->data);
	}

    public function feicobol()
    {
        $this->data['expocruz'] = '';
        return $this->templater->view('inicio/feicobol', $this->data);
    }
}
