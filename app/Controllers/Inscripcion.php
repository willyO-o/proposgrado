<?php

namespace App\Controllers;

use App\Models\InscripcionModel;
use App\Libraries\Email;
use App\Controllers\Reportes\InscripcionReporte;
use PHPUnit\Framework\Constraint\IsEmpty;


class Inscripcion extends BaseController
{
	public function formulario($idPublicacion, $carnet = null)
	{
		$this->data['id_publicacion'] = $idPublicacion;
		$this->data['carnet'] = $carnet;
		$this->data['publicacion'] = $this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray();
		$this->data["grados_academicos"] = $this->consultas->seleccionarTabla('grado_academico')->getResultArray();
		$this->data["locaciones"] = $this->consultas->seleccionarTabla('locacion', "id_locacion, municipio, departamento")->getResultArray();

		if ($this->data['publicacion'] != null)
			if ($carnet != null) {
				$validarCarnet = $this->validarCarnet($carnet);
				// if (isset($validarCarnet['true'])) {
				$persona = $this->consultas->seleccionarTabla('persona_externa', '*', ['ci' => $carnet])->getRowArray();
				$this->data['ciudades'] = $this->consultas->seleccionarTabla('ciudad')->getResultArray();
				$this->data['ci'] = $carnet;
				if ($persona != null) {
					$nombreCompleto = "{$persona['nombre']} {$persona['paterno']} {$persona['materno']}";
					if ($this->verificarInscripcion(['p.id_publicacion' => $idPublicacion, 'id_persona_interesado' => $persona['id_persona_externa'], 'estado_inscripcion_online <> ' => 'INTERESADO']) != null) {

						$this->data['mensaje'] = ['estado' => 'esta_inscrito', "¡{$nombreCompleto}! con CI:{$persona['ci']}, Usted ya se encuentra inscrito en este programa, descargue sus cartas y formularios de su inscripción.", 'idPersonaExterna' => md5($persona['id_persona_externa']), 'idPublicacion' => md5($idPublicacion)];
					} else {
						$this->data['info_adicional'] = $this->listarInformacionAdicional($persona['id_persona_externa']);
						$this->data['mensaje'] = ['estado' => 'no_esta_inscrito', "¡{$nombreCompleto}! con CI:{$persona['ci']}, Sus Datos Personales ya se encuentran registrados, complete los siguientes campos."];
					}
				} else $this->data['mensaje'] = ['estado' => 'no_existe_persona', 'Por favor complete y verifique detalladamente sus datos personales.'];

				return $this->templater->view('inscripcion/formulario', $this->data);
				// } else {
				// 	(\Config\Services::session())->setFlashdata('error', implode('<br>', $validarCarnet['false']));
				// 	return redirect()->to("verificar/$idPublicacion");
				// }
			} else {
				return $this->templater->view('inscripcion/formularioCarnet', $this->data);
			}
		else throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	}

	public function verificarInscripcion($condicion)
	{
		// ['p.id_publicacion' => $idPublicacion, 'id_persona_interesado' => $idPersona]
		return (new InscripcionModel)->inscripcion($condicion)->getRowArray();
	}

	public function listarInformacionAdicional($idPersonaExterna)
	{
		$builder = $this->db->table('inscripcion_online io')
			->select('iai.*,ua.nombre_unidad_academica')
			->join('informacion_adicional_inscripcion iai', 'iai.id_inscripcion_online = io.id_inscripcion_online')
			->join('unidad_academica ua', 'ua.id_unidad_academica = iai.id_unidad_academica')
			->where('io.id_persona_interesado', $idPersonaExterna)
			->orderBy('iai.id_inscripcion_online,iai.fecha_registro_informacion', 'DESC')
			->limit(1);
		return $builder->get()->getRowArray();
	}

	public function inscribir()
	{

		// header("Access-Control-Allow-Origin: https://sistemaposgrado.upea.bo");
		header('Access-Control-Allow-Origin: *');

		// var_dump($_REQUEST);
		// return var_dump($_FILES);
		$carnet = str_replace(' ', '', $this->request->getPost('ci'));
		$idPublicacion = $this->request->getPost('id_publicacion');

		$persona = $this->consultas->seleccionarTabla('persona_externa', '*', ['ci' => $carnet])->getRowArray();
		$publicacion = $this->consultas->seleccionarTabla('publicacion', '*', ['id_publicacion' => $idPublicacion])->getRowArray();
		// return var_dump($persona, $personaPosgrado, $carnet, $idPublicacion);
		if ($persona != null) {
			$inscripcion = $this->verificarInscripcion(['p.id_publicacion' => $idPublicacion, 'id_persona_interesado' => $persona['id_persona_externa']]);
			$nombreCompleto = "{$persona['nombre']} {$persona['paterno']}";
			if ($inscripcion != null) {
				$this->consultas->actualizarTabla('inscripcion_online', ['estado_inscripcion_online' => $this->request->getVar('tipo_deposito_matricula') != null ? 'PREINSCRITO' : 'INTERESADO'], ['id_inscripcion_online' => $inscripcion['id_inscripcion_online']]);
				$this->registrarDepositos($this->request, $inscripcion['id_inscripcion_online']);
				return $this->response->setJSON(['exito' => "$nombreCompleto, ya se encuentra inscrito en el programa {$publicacion['nombre_programa']} ¿Desea ver sus cartas y formularios de su inscripción?.", 'idPersonaExterna' => md5($persona['id_persona_externa']), 'idPublicacion' => md5($idPublicacion)]);
			} else {
				$tipoInscripcion = $this->request->getVar('tipo_inscripcion') != null ? 'SISTEMA' : 'PAGINA WEB';
				$responsable = $this->nuloSiVacio($this->request->getVar('responsable'));
				$idInscripcionOnline = $this->inscribirInformar($idPublicacion, $persona['id_persona_externa'], $this->request->getVar('tipo_deposito_matricula') != null ? 'PREINSCRITO' : 'INTERESADO', $tipoInscripcion, $responsable);

				$informacionAdicional = [
					'id_inscripcion_online' => $idInscripcionOnline,
					'id_grado_academico' => $this->nuloSiVacio($this->request->getVar('id_grado_academico')),
					'id_unidad_academica' => $this->nuloSiVacio($this->request->getVar('id_unidad_academica')),
					'anio_expedicion_titulo' => $this->nuloSiVacio($this->request->getVar('anio_expedicion_titulo')),
					'nro_titulo_academico' => $this->nuloSiVacio($this->request->getVar('nro_titulo_academico')),
					'profesion' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('profesion'), MB_CASE_UPPER)),
					'area_especializacion' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('area_especializacion'), MB_CASE_UPPER)),
					'nombre_institucion' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('nombre_institucion'), MB_CASE_UPPER)),
					'cargo_trabajo' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('cargo_trabajo'), MB_CASE_UPPER)),
					'vigencia_trabajo' => $this->nuloSiVacio($this->request->getVar('vigencia_trabajo')),
					'id_locacion' => $this->nuloSiVacio($this->request->getVar('id_municipio')),
					'fecha_registro_informacion' => date('Y-m-d'),
				];
				$this->consultas->insertarTabla('informacion_adicional_inscripcion', $informacionAdicional);

				$this->registrarDepositos($this->request, $idInscripcionOnline);
				return $this->response->setJSON(['exito' => "$nombreCompleto, se inscribio correctamente al programa {$publicacion['nombre_programa']}, descargue sus cartas y formularios de su inscripción", 'idPersonaExterna' => md5($persona['id_persona_externa']), 'idPublicacion' => md5($idPublicacion)]);
			}
		} else {

			$validation =  \Config\Services::validation();
			$validation->setRules([
				'id_publicacion' => ['label' => 'nro publicación', 'rules' => 'required|is_natural_no_zero'],
				'ci' => ['label' => 'ci', 'rules' => 'required|max_length[10]|min_length[5]'],
				'expedido' => ['label' => 'expedido', 'rules' => 'required|max_length[2]|min_length[2]'],
				'paterno' => ['label' => 'paterno', 'rules' => 'max_length[40]'],
				'materno' => ['label' => 'materno', 'rules' => 'max_length[40]'],
				'nombre' => ['label' => 'nombre', 'rules' => 'required|min_length[3]|max_length[40]'],
				'genero' => ['label' => 'genero', 'rules' => 'required|min_length[1]|max_length[1]'],
				'fecha_nacimiento' => ['label' => 'fecha nacimiento', 'rules' => 'required|fechaCorrecta|fechaPasada'],
				'celular' => ['label' => 'celular', 'rules' => 'required|min_length[8]|max_length[8]|is_natural_no_zero'],
				'correo' => ['label' => 'correo electronico', 'rules' => 'max_length[40]'],
				'oficio_trabajo' => ['label' => 'oficio trabajo', 'rules' => 'max_length[90]'],
				'ciudad' => ['label' => 'ciudad', 'rules' => 'required|max_length[90]'],
				'domicilio' => ['label' => 'domicilio', 'rules' => 'required|max_length[140]'],
				'id_grado_academico' => ['label' => 'Titulo Obtenido', 'rules' => 'required|is_natural_no_zero'],
				'id_unidad_academica' => ['label' => 'Universidad', 'rules' => 'required|is_natural_no_zero', 'errors' => ['is_natural_no_zero' => 'Debe seleccionar una universidad de la Lista']],
				'anio_expedicion_titulo' => ['label' => 'Año Expedicion Titulo', 'rules' => 'required|is_natural_no_zero|exact_length[4]|greater_than_equal_to[1900]|less_than_equal_to[' . date("Y") . ']'],
				'nro_titulo_academico' => ['label' => 'Numero de Registro', 'rules' => 'required|is_natural_no_zero|min_length[5]|max_length[10]'],
				'profesion' => ['label' => 'Profesion', 'rules' => 'required|max_length[80]'],
				'area_especializacion' => ['label' => 'Area de Especializacion', 'rules' => 'required|max_length[180]'],


			]);

			if (!$validation->withRequest($this->request)->run()) {
				return $this->response->setJSON(['error' => $validation->listErrors()]);
			} else {
				$idPersona = $this->consultas->insertarTabla('persona_externa', [
					'ci' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('ci'), MB_CASE_UPPER)),
					'expedido' => $this->nuloSiVacio($this->request->getVar('expedido')),
					'paterno' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('paterno'), MB_CASE_UPPER)),
					'materno' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('materno'), MB_CASE_UPPER)),
					'nombre' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('nombre'), MB_CASE_UPPER)),
					'celular' => $this->nuloSiVacio($this->request->getVar('celular')),
					'correo' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('correo'), MB_CASE_LOWER)),
					'genero' => $this->nuloSiVacio($this->request->getVar('genero')),
					'fecha_nacimiento' => $this->nuloSiVacio($this->request->getVar('fecha_nacimiento')),
					'celular' => $this->nuloSiVacio($this->request->getVar('celular')),
					'oficio_trabajo' => $this->nuloSiVacio($this->request->getVar('oficio_trabajo')),
					'ciudad' => $this->nuloSiVacio($this->request->getVar('ciudad')),
					'domicilio' => $this->nuloSiVacio($this->request->getVar('domicilio')),
					'estado_persona' => 'REGISTRADO',
				]);
				if (is_numeric($idPersona)) {
					$tipoInscripcion = $this->request->getVar('tipo_inscripcion') != null ? 'SISTEMA' : 'PAGINA WEB';
					$responsable = $this->nuloSiVacio($this->request->getVar('responsable'));
					$idInscripcion = $this->inscribirInformar($idPublicacion, $idPersona, $this->request->getVar('tipo_deposito_matricula') != null ? 'PREINSCRITO' : 'INTERESADO', $tipoInscripcion, $responsable);
					if (is_numeric($idInscripcion)) {
						$informacionAdicional = [
							'id_inscripcion_online' => $idInscripcion,
							'id_grado_academico' => $this->nuloSiVacio($this->request->getVar('id_grado_academico')),
							'id_unidad_academica' => $this->nuloSiVacio($this->request->getVar('id_unidad_academica')),
							'anio_expedicion_titulo' => $this->nuloSiVacio($this->request->getVar('anio_expedicion_titulo')),
							'nro_titulo_academico' => $this->nuloSiVacio($this->request->getVar('nro_titulo_academico')),
							'profesion' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('profesion'), MB_CASE_UPPER)),
							'area_especializacion' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('area_especializacion'), MB_CASE_UPPER)),
							'nombre_institucion' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('nombre_institucion'), MB_CASE_UPPER)),
							'cargo_trabajo' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('cargo_trabajo'), MB_CASE_UPPER)),
							'vigencia_trabajo' => $this->nuloSiVacio($this->request->getVar('vigencia_trabajo')),
							'id_locacion' => $this->nuloSiVacio($this->request->getVar('id_municipio')),
							'fecha_registro_informacion' => date('Y-m-d'),
						];
						$this->consultas->insertarTabla('informacion_adicional_inscripcion', $informacionAdicional);

						$this->registrarDepositos($this->request, $idInscripcion);
						return $this->response->setJSON(['exito' => "Se inscribio correctamente al programa {$publicacion['nombre_programa']}, descargue sus cartas y formularios de su inscripción", 'idPersonaExterna' => md5($idPersona), 'idPublicacion' => md5($idPublicacion)]);
						// return $this->response->setJSON(['exito' => 'Su inscripción se realizo correctamente, descargue sus cartas y formularios de su inscripción', 'idPersonaExterna' => md5($idPersona), 'idPublicacion' => md5($idPublicacion)]);
					} else return $this->response->setJSON(['error' => 'No se completo su inscripción, por favor actualize la pagina.']);
				}
			}
		}
	}

	public function actualizar()
	{
		// var_dump($_REQUEST);
		// return var_dump($_FILES);
		if ($this->request->getVar('authorization') == "nbm9pn5p54gte7pmfnp7umfjqh3hv2vo") {
			$carnet = str_replace(' ', '', $this->request->getPost('ci'));
			$idPublicacion = $this->request->getPost('id_publicacion');

			$persona = $this->consultas->seleccionarTabla('persona_externa', '*', ['ci' => $carnet])->getRowArray();
			$publicacion = $this->consultas->seleccionarTabla('publicacion', '*', ['id_publicacion' => $idPublicacion])->getRowArray();

			if ($persona != null) {
				$inscripcion = $this->verificarInscripcion(['p.id_publicacion' => $idPublicacion, 'id_persona_interesado' => $persona['id_persona_externa']]);
				// $nombreCompleto = "{$persona['nombre']} {$persona['paterno']}";
				if ($inscripcion != null) {
					$validation =  \Config\Services::validation();
					$validation->setRules([
						'id_publicacion' => ['label' => 'nro publicación', 'rules' => 'required|is_natural_no_zero'],
						'ci' => ['label' => 'ci', 'rules' => 'required|is_natural_no_zero|max_length[9]'],
						'expedido' => ['label' => 'expedido', 'rules' => 'max_length[2]'],
						'paterno' => ['label' => 'paterno', 'rules' => 'max_length[40]'],
						'materno' => ['label' => 'materno', 'rules' => 'max_length[40]'],
						'nombre' => ['label' => 'nombre', 'rules' => 'max_length[40]'],
						'genero' => ['label' => 'genero', 'rules' => 'max_length[1]'],
						// 'fecha_nacimiento' => ['label' => 'fecha nacimiento', 'rules' => 'fechaCorrecta|fechaPasada'],
						'celular' => ['label' => 'celular', 'rules' => 'max_length[8]'],
						'correo' => ['label' => 'correo electronico', 'rules' => 'max_length[40]'],
						'oficio_trabajo' => ['label' => 'oficio trabajo', 'rules' => 'max_length[90]'],
						'ciudad' => ['label' => 'ciudad', 'rules' => 'max_length[90]'],
						'domicilio' => ['label' => 'domicilio', 'rules' => 'max_length[140]'],
					]);

					if (!$validation->withRequest($this->request)->run()) {
						return $this->response->setJSON(['error' => $validation->listErrors()]);
					} else {
						$idPersona = $this->consultas->actualizarTabla('persona_externa', [
							// 'ci' => $this->mismoDatoSiVacio($this->request->getVar('ci'), $inscripcion, 'ci'),
							'expedido' => $this->mismoDatoSiVacio($this->request->getVar('expedido'), $inscripcion, 'expedido'),
							'paterno' => $this->mismoDatoSiVacio($this->request->getVar('paterno'), $inscripcion, 'paterno'),
							'materno' => $this->mismoDatoSiVacio($this->request->getVar('materno'), $inscripcion, 'materno'),
							'nombre' => $this->mismoDatoSiVacio($this->request->getVar('nombre'), $inscripcion, 'nombre'),
							'celular' => $this->mismoDatoSiVacio($this->request->getVar('celular'), $inscripcion, 'celular'),
							'correo' => $this->mismoDatoSiVacio($this->request->getVar('correo'), $inscripcion, 'correo'),
							'genero' => $this->mismoDatoSiVacio($this->request->getVar('genero'), $inscripcion, 'genero'),
							'fecha_nacimiento' => $this->mismoDatoSiVacio($this->request->getVar('fecha_nacimiento'), $inscripcion, 'fecha_nacimiento'),
							'celular' => $this->mismoDatoSiVacio($this->request->getVar('celular'), $inscripcion, 'celular'),
							'oficio_trabajo' => $this->mismoDatoSiVacio($this->request->getVar('oficio_trabajo'), $inscripcion, 'oficio_trabajo'),
							'ciudad' => $this->mismoDatoSiVacio($this->request->getVar('ciudad'), $inscripcion, 'ciudad'),
							'domicilio' => $this->mismoDatoSiVacio($this->request->getVar('domicilio'), $inscripcion, 'domicilio'),
							'estado_persona' => 'REGISTRADO'
						], ['id_persona_externa' => $inscripcion['id_persona_externa']]);
						if ($idPersona) {
							$this->registrarDepositos($this->request, $inscripcion['id_inscripcion_online']);
							return $this->response->setJSON(['exito' => "Se actualizo los datos correctamente del programa {$publicacion['nombre_programa']}, descargue sus cartas y formularios de su inscripción", 'idPersonaExterna' => md5($idPersona), 'idPublicacion' => md5($idPublicacion)]);
						}
					}
				} else {
					return $this->response->setJSON(['error' => 'No se completo su inscripción, por favor actualize la pagina.']);
				}
			}
		}
	}

	function registrarDepositos($request, $idInscripcion)
	{
		$c = 0;
		// return var_dump($tieneRespaldo);
		foreach ($request->getVar('tipo_deposito_matricula') != null ? $request->getVar('tipo_deposito_matricula') : [] as $key => $value) {
			$idDeposito = $this->consultas->insertarTabla('deposito', [
				'id_inscripcion_online' => $idInscripcion,
				'numero_deposito' => $request->getVar('numero_deposito_matricula')[$key],
				'monto_deposito' => $request->getVar('monto_matricula')[$key],
				'fecha_deposito' => $request->getVar('fecha_deposito_matricula')[$key],
				'estado_deposito' => 'REGISTRADO',
				'id_tipo_pago' => $request->getVar('tipo_deposito_matricula')[$key],
			]);
			if (is_numeric($idDeposito)) {
				if ($request->getVar('tiene_respaldo')[$key] == 'true') {
					if ($imagefile = $this->request->getFiles()) {
						$img = $imagefile['imagen_matricula'][$c];
						if ($img->isValid() && !$img->hasMoved()) {
							$nuevoNombre = $img->getRandomName();
							$img->move(WRITEPATH . 'uploads/depositos_preinscripcion', $nuevoNombre);

							$this->consultas->insertarTabla('respaldo_multimedia', [
								'id_deposito' => $idDeposito,
								'url' => $nuevoNombre,
								'estado_respaldo' => 'REGISTRADO',
							]);
						}
					}
					$c++;
				}
			}
		}
		// var_dump(__DIR__);
		// var_dump(FCPATH);
		// var_dump(APPPATH);
		// var_dump(WRITEPATH);
	}

	public function informacion()
	{
		$validation =  \Config\Services::validation();
		$validation->setRules([
			'id_publicacion' => ['label' => 'nro publicación', 'rules' => 'required|is_natural_no_zero'],
			'ci' => ['label' => 'ci', 'rules' => 'required|max_length[10]'],
			'expedido' => ['label' => 'expedido', 'rules' => 'required|max_length[2]'],
			'paterno' => ['label' => 'paterno', 'rules' => 'required|min_length[3]|max_length[40]'],
			'materno' => ['label' => 'materno', 'rules' => 'max_length[40]'],
			'nombre' => ['label' => 'nombre', 'rules' => 'required|min_length[3]|max_length[40]'],
			'celular' => ['label' => 'celular', 'rules' => 'required|min_length[8]|max_length[8]|is_natural_no_zero|is_unique[persona_externa.celular]'],
			'correo' => ['label' => 'correo electronico', 'rules' => 'max_length[40]'],
		]);

		if (!$validation->withRequest($this->request)->run()) {
			return $this->response->setJSON(['error' => $validation->listErrors()]);
		} else {
			$carnet = str_replace(' ', '', $this->request->getPost('ci'));
			$celular = str_replace(' ', '', $this->request->getPost('celular'));
			$correo = str_replace(' ', '', $this->request->getPost('correo'));
			$idPublicacion = $this->request->getPost('id_publicacion');
			$publicacion = $this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray();
			$persona = $this->consultas->seleccionarTabla('persona_externa', '*', ['ci' => $carnet])->getRowArray();

			$message = [];
			$message1 = [];
			$msg = "Sea bienvenid@ a *POSGRADO UPEA*
Para seguir nuestra amplia oferta académica de 
DIPLOMADOS, ESPECIALIDADES, MAESTRIAS, DOCTORADOS Y POST DOCTORADOS visítenos en *https://posgrado.upea.bo*
=============================
*CONTENIDO DEL PROGRAMA:* " . $publicacion["nombre_programa"] . ", MODALIDAD: " . $publicacion["modalidad"] . ", VERSIÓN: " . $publicacion["numero_version"] . " \n";
			foreach ($this->request->getPost('informacion') as $value) {
				if ($value == 'Contenido') {
					$message['contenido'] = $this->formtarListaWhatsapp(explode('<li>', strip_tags(trim($publicacion['contenido_minimo']), '<li>')));
					$message1['contenido'] = $publicacion['contenido_minimo'];

					$msg .= $message['contenido'];
				}

				if ($value == 'Precio') {
					$msg .= "=============================\n*PRECIO* \n";
					$precio = [
						'matricula' => $publicacion['monto_matricula'] . " Bs.",
						'colegiatura' => $publicacion['precio_programa'] . " Bs.",
					];
					$message['precio'] = $precio;
					$message1['precio'] = $precio;
					$msg .= "Costo Mátricula: " . $precio['matricula'] . "\n";
					$msg .= "Costo Colegiatura: " . $precio['colegiatura'] . "\n";
				}

				if ($value == 'Duración') {
					$msg .= "=============================\n*DURACIÓN* \n";
					$message['duracion'] = $publicacion['duracion'] . " meses";
					$message1['duracion'] = $publicacion['duracion'] . " meses";
					$msg .= "Duración: " . $publicacion['duracion'] . " meses \n";
				}

				if ($value == 'Requisitos mínimos') {
					$msg .= "=============================\n*REQUISITOS INSCRIPCIÓN* \n";
					$message['requisitos'] = $this->formtarListaWhatsapp(explode('<li>', strip_tags(trim($publicacion['requisitos_inscripcion']), '<li>')));
					$message1['requisitos'] = $publicacion['requisitos_inscripcion'];
					$msg .= $message['requisitos'];
				}
			}
			//** FIN PERSONALIZAR MENSAJE */
			if (is_null($persona)) {
				$idPersona = $this->consultas->insertarTabla('persona_externa', [
					'ci' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('ci'), MB_CASE_UPPER)),
					'expedido' => $this->nuloSiVacio($this->request->getPost('expedido')),
					'paterno' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('paterno'), MB_CASE_UPPER)),
					'materno' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('materno'), MB_CASE_UPPER)),
					'nombre' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('nombre'), MB_CASE_UPPER)),
					'celular' => $this->nuloSiVacio($this->request->getPost('celular')),
					'correo' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('correo'), MB_CASE_LOWER)),
					'estado_persona' => 'REGISTRADO'
				]);
				if (is_numeric($idPersona)) {
					$persona = $this->consultas->seleccionarTabla('persona_externa', '*', ['id_persona_externa' => $idPersona])->getRowArray();
					$persona['correo'] = $this->request->getPost('correo');
					if ($this->verificarInscripcion(['p.id_publicacion' => $idPublicacion, 'id_persona_interesado' => $idPersona]) == null) {
						$this->inscribirInformar($idPublicacion, $idPersona, 'INTERESADO');
					}

					if ($persona['correo'] != '') {
						(new Email)->correoInformacion($persona, $publicacion, base_url("programa/{$publicacion['id_publicacion']}"), $message1);
						return $this->response->setJSON(['exito' => lang('global.informacionPrograma')]);
					} else {

						return $this->response->setJSON(['exito' => lang('global.informacionCelular'), 'message' => $msg, 'celular' => $celular]);
					}
				}
			} else {
				$persona = array_merge($persona, ['correo' => $this->request->getPost('correo')]);
				if ($this->verificarInscripcion(['p.id_publicacion' => $idPublicacion, 'id_persona_interesado' => $persona['id_persona_externa']]) == null) {
					$this->inscribirInformar($idPublicacion, $persona['id_persona_externa'], 'INTERESADO');
				}
				if ($persona['correo'] != '') {
					(new Email)->correoInformacion($persona, $publicacion, base_url("programa/{$publicacion['id_publicacion']}"), $message1);
					return $this->response->setJSON(['exito' => lang('global.informacionPrograma')]);
				} else {
					return $this->response->setJSON(['exito' => lang('global.informacionCelular'), 'message' => $msg, 'celular' => $celular]);
				}
			}
		}
	}

	public function formtarListaWhatsapp($campo)
	{
		$d = '';
		$cn = 1;
		foreach ($campo as $value) {
			if ($value != '') {
				$d .= $cn . '. ' . str_replace('&nbsp;', '', strip_tags($value)) . "\n";
				$cn++;
			}
		}
		return $d;
	}

	public function mensaje()
	{
	}

	public function suscripcionArea()
	{
		// return var_dump($_REQUEST);
		$validation =  \Config\Services::validation();
		$validation->setRules([
			'ci' => ['label' => 'ci', 'rules' => 'required|max_length[10]|min_length[7]'],
			'expedido' => ['label' => 'expedido', 'rules' => 'required|max_length[2]|min_length[2]'],
			'paterno' => ['label' => 'paterno', 'rules' => 'required|min_length[3]|max_length[40]'],
			'materno' => ['label' => 'materno', 'rules' => 'max_length[40]'],
			'nombre' => ['label' => 'nombre', 'rules' => 'required|min_length[3]|max_length[40]'],
			'celular' => ['label' => 'celular', 'rules' => 'required|min_length[8]|max_length[8]|is_natural_no_zero'],
			'correo' => ['label' => 'correo electronico', 'rules' => 'required|valid_email|max_length[40]'],
		]);

		if (!$validation->withRequest($this->request)->run()) {
			// return var_dump($validation->listErrors());
			return $this->response->setJSON(['error' => $validation->listErrors()]);
		} else {
			$carnet = str_replace(' ', '', $this->request->getPost('ci'));
			// $idPublicacion = $this->request->getPost('id_publicacion');
			// $publicacion = $this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray();

			$persona = $this->consultas->seleccionarTabla('persona_externa', '*', ['ci' => $carnet])->getRowArray();
			// $persona['correo'] = $this->request->getPost('correo');
			// $personaPosgrado = $this->consultas->seleccionarTabla('persona','*', ['ci' => $carnet])->getRowArray();
			if ($persona == null) {
				$idPersonaExterna = $this->consultas->insertarTabla('persona_externa', [
					'ci' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('ci'), MB_CASE_UPPER)),
					'expedido' => $this->nuloSiVacio($this->request->getPost('expedido')),
					'paterno' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('paterno'), MB_CASE_UPPER)),
					'materno' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('materno'), MB_CASE_UPPER)),
					'nombre' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('nombre'), MB_CASE_UPPER)),
					'celular' => $this->nuloSiVacio($this->request->getPost('celular')),
					'correo' => $this->nuloSiVacio(mb_convert_case($this->request->getVar('correo'), MB_CASE_LOWER)),
					'estado_persona' => 'REGISTRADO'
				]);
				if (is_numeric($idPersonaExterna)) {
					$idAreaInteres = $this->consultas->insertarTabla('area_interes', [
						'id_area' => $this->request->getVar('id_area'),
						'id_persona_externa' => $idPersonaExterna,
						'fecha' => date('Y-m-d'),
						'fecha_registro' => date('Y-m-d H:i:s'),
						'estado_suscripcion' => 'ACTIVO',
						'estado_area_interes' => 'REGISTRADO',
					]);
				}
				return $this->response->setJSON(['exito' => 'Se suscribio correctamente']);
			} else {
				$idAreaInteres = $this->consultas->insertarTabla('area_interes', [
					'id_area' => $this->request->getVar('id_area'),
					'id_persona_externa' => $persona['id_persona_externa'],
					'fecha' => date('Y-m-d'),
					'fecha_registro' => date('Y-m-d H:i:s'),
					'estado_suscripcion' => 'ACTIVO',
					'estado_area_interes' => 'REGISTRADO',
				]);
				return $this->response->setJSON(['exito' => 'Se suscribio correctamente']);
			}
		}
	}

	function informacionWhatsapp($idPublicacion)
	{
		return $this->response->setJSON($this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray());
	}
	public function inscribirInformar($idPublicacion, $idPersona, $estadoInscripcionOnline, $tipoInscripcion = null, $responsable = null)
	{
		$consulta_nro = $this->consultas->seleccionarTabla('inscripcion_online', 'MAX(correlativo_ficha_inscripcion) AS nro', ['extract(YEAR FROM fecha_registro)' => date("Y")])->getRowArray();
		$nro_formulario = $consulta_nro['nro'] == null ? 1 : $consulta_nro['nro'] + 1;
		$idInscripcionOnline = $this->consultas->insertarTabla('inscripcion_online', [
			'id_publicacion' => $idPublicacion,
			'id_persona_interesado' => $idPersona,
			'estado_inscripcion_online' => $estadoInscripcionOnline,
			'tipo_inscripcion' => $tipoInscripcion,
			'id_usuario_registro' => $responsable,
			'correlativo_ficha_inscripcion' => $nro_formulario,
		]);
		return $idInscripcionOnline;
	}

	public function mensajeFinalInscripcion($idPersona, $idPublicacion, $tipos = '')
	{
		$this->data['publicacion'] = $this->consultas->listarPublicacion('programa', ['md5(p.id_publicacion::text)' => $idPublicacion])->getRowArray();
		$datos = (new InscripcionModel)->inscripcion(['md5(id_persona_externa::text)' => $idPersona, 'md5(p.id_publicacion::text)' => $idPublicacion])->getRowArray();

		if (!is_null($this->data['publicacion']) && !is_null($datos)) {

			$this->data['solicitud'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->solicitudInscripcion($datos));
			$this->data['cartaCompromiso'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->cartaCompromisoInscripcion($datos));
			$pagos = [];
			foreach ($this->consultas->seleccionarTabla('tipo_pago', 'id_tipo_pago, descripcion_tipo_pago', ['estado_tipo_pago' => 'ACTIVO'])->getResultArray() as $key => $value) {
				$deposito = $this->consultas->seleccionarTabla('deposito', '*', ['id_tipo_pago' => $value['id_tipo_pago'], 'id_inscripcion_online' => $datos['id_inscripcion_online']])->getResultArray();
				if (!empty($deposito))
					$pagos[$value['descripcion_tipo_pago']] = $deposito;
			}
			$this->data['formulario'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->formularioInscripcion(array_merge($datos, ['pagos' => $pagos])));
			$this->data['solicitudProrroga'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->solicitudProrroga($datos));

			$this->data['formulario01'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->formulario01($datos));
			// is ajax request
			if ($this->request->isAJAX()) {
				$reportes = [];
				foreach (empty($tipos) ? [] : explode(',', $tipos) as $key => $value) {
					$reportes[$value] = $this->data[$value];
				}
				return $this->response->setStatusCode(200)->setJSON($reportes);
			} else {
				return $this->templater->view('inscripcion/cartasFormularios', $this->data);
			}
		} else {
			(\Config\Services::session())->setFlashdata('error', 'No se encontro las cartas solicitadas');
			return redirect()->to("oferta");
		}
	}

	// public function copiarPersonaPosgradoPersonaExterna($personaPosgrado)
	// {
	// 	$idPersonaExterna = $this->consultas->insertarTabla('persona_externa', [
	// 		'id_persona_posgrado' => $personaPosgrado['id_persona'],
	// 		'ci' => $this->nuloSiVacio($personaPosgrado['ci']),
	// 		'expedido' => $this->nuloSiVacio($personaPosgrado['expedido']),
	// 		'paterno' => $this->nuloSiVacio($personaPosgrado['paterno']),
	// 		'materno' => $this->nuloSiVacio($personaPosgrado['materno']),
	// 		'nombre' => $this->nuloSiVacio($personaPosgrado['nombre']),
	// 		'celular' => $this->nuloSiVacio($personaPosgrado['celular']),
	// 		'correo' => $this->nuloSiVacio($personaPosgrado['email']),
	// 		'genero' => $this->nuloSiVacio($personaPosgrado['genero']),
	// 		'fecha_nacimiento' => $this->nuloSiVacio($personaPosgrado['fecha_nacimiento']),
	// 		'oficio_trabajo' => $this->nuloSiVacio($personaPosgrado['oficio_trabajo']),
	// 		'domicilio' => $this->nuloSiVacio($personaPosgrado['domicilio']),
	// 		'domicilio' => $this->nuloSiVacio($personaPosgrado['domicilio']),
	// 		'domicilio' => $this->nuloSiVacio($personaPosgrado['domicilio'])
	// 	]);
	// 	return is_numeric($idPersonaExterna) ? $idPersonaExterna : false;
	// }
	public function nuloSiVacio($dato)
	{
		return is_null($dato) ? null : (empty($dato) ? null : trim($dato));
	}
	public function mismoDatoSiVacio($dato, $datos, $columna)
	{
		return is_null($dato) ? trim($datos[$columna]) : (empty($dato) ? trim($datos[$columna]) : trim($dato));
	}
	public function validarCarnet($carnet)
	{
		// Que sea número
		// Que tenga 7 digitos minimo y maximo 9
		// Que el carnet sea mayor 1111111

		$respuesta = [];
		if (is_numeric($carnet)) {
			if (strlen($carnet) >= 7 && strlen($carnet) <= 9) {
				if ($carnet >= 1111111) {
					$respuesta['true'][] = 'El numero de carnet es correcto';
				} else {
					$respuesta['false'][] = 'El numero de carnet no es correcto';
				}
			} else {
				$respuesta['false'][] = 'El numero carnet debe contener entre 7 y 9 digitos';
			}
		} else {
			$respuesta['false'][] = 'El numero de carnet debe contener solo números';
		}
		return $respuesta;
	}
	public function buscarPersona($carnet)
	{
		$carnet = preg_replace('/\s+/', '', $carnet);
		$instancia = $this->inscripcionModel->persona("concat(nombre,' ',paterno,' ',materno) as nombre_completo", ['ci' => mb_convert_case($carnet, MB_CASE_UPPER, "UTF-8")]);
		// if ($instancia[0]->getRowArray() == null && $instancia[1]->getRowArray() == null) {
		// 	return $this->response->setJSON(['mensaje' => lang('global.registroDatosPersonales')]);
		// } else
		if ($instancia[0]->getRowArray() != null) {
			$nombreCompleto = $instancia[0]->getRowArray()['nombre_completo'];
			return $this->response->setJSON(['mensaje' => "Usted es $nombreCompleto, ¿Desea continuar?"]);
		} else {
			return $this->response->setJSON(['mensaje' => lang('global.registroDatosPersonales')]);
		}
		// else if ($instancia[1]->getRowArray() != null) {
		// 	$nombreCompleto = $instancia[1]->getRowArray()['nombre_completo'];
		// 	return $this->response->setJSON(['mensaje' => "Usted es $nombreCompleto, ¿Desea continuar?"]);
		// }
	}
	function verificarDepositos($conjuntoDepositos, array &$error = null): bool
	{
		$validation =  \Config\Services::validation();
		$validation->setRules([
			'tipo_deposito_matricula' => ['label' => 'tipo deposito', 'rules' => 'required|in_list[1,2]'],
			'numero_deposito_matricula' => ['label' => 'fecha deposito', 'rules' => 'required|is_natural_no_zero|min_length[10]|max_length[15]'],
			'fecha_deposito_matricula' => ['label' => 'fecha deposito', 'rules' => 'required|fechaCorrecta|fechaPasada'],
		]);

		foreach ($conjuntoDepositos as $key => $value) {
			if (!$validation->withRequest($conjuntoDepositos)) {
				$error =  $validation->listErrors();
				var_dump($validation->listErrors());
				return false;
			} else {
				return true;
			}
		}
	}

	public function listarUniversidades()
	{
		if ($this->request->isAJAX()) {
			$universidades = $this->consultas->seleccionarTabla("unidad_academica", "id_unidad_academica, concat(nombre_unidad_academica,' (',abreviatura,')') as nombre")->getResultArray();

			return $this->response->setJSON($universidades);
		}
	}

	public function verificar($idPersona, $idPublicacion)
	{

		$datos = (new InscripcionModel)->inscripcion(['md5(id_persona_externa::text)' => $idPersona, 'md5(p.id_publicacion::text)' => $idPublicacion])->getRowArray();
		$publicacion = $this->consultas->listarPublicacion('programa', ['md5(p.id_publicacion::text)' => $idPublicacion])->getRowArray();
		$this->data['datos'] = $datos;
		$this->data['publicacion'] = $publicacion;
		$this->data['mensaje'] = "";
		$this->data['estadoInscripcion'] = false;
		$this->data["idPersona"] = $idPersona;
		$this->data["idPublicacion"] = $idPublicacion;

		// return var_dump($publicacion);

		if (!is_null($this->data["publicacion"]) && !is_null($datos)) {
			$this->data['estadoInscripcion'] = true;
			$this->data['mensaje'] = "{$datos["nombre"]} {$datos["paterno"]} {$datos["materno"]} con C.I.: {$datos["ci"]}, se encuentra inscrito en el programa <b>{$publicacion["grado_academico"]}  EN  {$publicacion["nombre_programa"]} VERSION {$publicacion["numero_version"]} </b>";
		} else {
			$this->data['estadoInscripcion'] = false;
			$this->data['mensaje'] = "No se encotro persona Inscrita";
		}

		return $this->templater->view('inscripcion/verificacionInscripcion', $this->data);
	}

	public function verificarNroDeposito()
	{
		$nro_deposito = $this->request->getPost("nro_deposito") != null ? $this->request->getPost("nro_deposito") :  0;

		$resultado = $this->consultas->seleccionarTabla("pagina_web.psg_deposito", "count(*) as cantidad", ["numero_deposito" => $nro_deposito])->getRow();
		return $this->response->setJSON(["cantidad" => (int) $resultado->cantidad]);
	}
}
