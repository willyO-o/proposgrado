<?php

namespace App\Controllers\API\V1;

use App\Controllers\BaseControllerAPI;
use CodeIgniter\RESTful\ResourceController;


class Oferta extends BaseControllerAPI
{

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    private $areas_especialidad = [];

    public function __construct()
    {
        parent::__construct();
        $this->areas_especialidad = $this->consultas->listarAreas("llaves");
    }






    public function index()
    {

        $programa = $this->consultas->listarPublicacion('programasDivididos', ['estado_publicacion' => 'PUBLICADO', 'fecha_fin_publicacion >= ' => date('Y-m-d')], 'nombre_programa');
        // $data['areas'] = $this->consultas->seleccionarTabla('area', '*')->getResult();s
        // $data['ciudades'] = $this->consultas->seleccionarTabla('ciudad', '*')->getResult();

        if ($programa) {
            $respuesta = ["success" => true, "programas" => $programa];

            return $this->respond($respuesta, 200, "OK");
        } else {
            return $this->fail(["error" => "no se encontraron resultados"], 500);
        }
    }

    public function programas($sede = "EL ALTO", $grado_academico = "TODOS", $area = 0)
    {

        $condiciones = ['estado_publicacion' => 'PUBLICADO', 'fecha_fin_publicacion >= ' => date('Y-m-d')];

        $sede= strtoupper($sede);
        $grado_academico= strtoupper($grado_academico);
        $programas = $this->consultas->listarPublicaciones($sede, $grado_academico, $area, $condiciones);


        $programa_aux = [];
        foreach ($programas as $programa) {
            $programa["imagen"] = base_url("imagenes/afiches") . "/" . (trim($programa["imagen"]) ? $programa["imagen"] : "programa.jpg");

            $programa["carga_horaria"] = $programa["carga_horaria"] . " Horas";
            $programa["duracion"] = $programa["duracion"] . " Meses";
            $programa["numero_version"] = numero_romano($programa["numero_version"]);
            $programa["fecha_fin_inscripcion"] = date("d-m-Y", strtotime($programa["fecha_fin_inscripcion"]));
            $programa["infograma"] = $programa["infograma"] ?  base_url('descargas_programa/' . $programa["infograma"]) : null;

            $programa["nombre_area"] = $this->areas_texto($programa["area_especialidad"]);
            $programa_aux[] = $programa;
        }

        $programas = $programa_aux;

        $respuesta = [
            "success" => true,
            "programas" => $programas ? $programas : []
        ];

        return $this->respond($respuesta, 200, "OK");
    }

    public function grados()
    {
        $grados = $this->consultas->distintoTabla('pagina_web.psg_publicacion', 'grado_academico');

        $lista_grados = ["TODOS"];
        foreach ($grados as $grado) {
            $lista_grados[] = $grado;
        }

        $respuesta = [
            "success" => true,
            "grados" => $lista_grados ? $lista_grados : [],
        ];

        return $this->respond($respuesta, 200, "OK");
    }

    public function sedes()
    {
        $sedes = $this->consultas->seleccionarTabla('administrativo.psg_sede', "id_sede,denominacion_sede", null, "id_sede ASC")->getResultArray();

        $listadoSedes = ["TODOS"];

        foreach ($sedes as $sede) {
            $listadoSedes[] = $sede["denominacion_sede"];
        }

        if ($listadoSedes) {
            $respuesta = ["success" => true, "sedes" => $listadoSedes];

            return $this->respond($respuesta, 200, "OK");
        } else {

            return $this->respond($listadoSedes, 200, "OK");
        }
    }


    public function ciudades()
    {

        $ciudades = $this->consultas->listarCiudades();

        $respuesta = [
            "success" => true,
            "ciudades" => $ciudades ? $ciudades : []
        ];

        return $this->respond($respuesta, 200, "OK");
    }

    public function areas()
    {
        $areas = $this->consultas->listarAreas();
        $respuesta = [
            "success" => true,
            "areas" => $areas ? $areas : []
        ];
        return $this->respond($respuesta, 200, "OK");
    }






    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function detalle($idPublicacion)
    {
        $programa = $this->consultas->listarPublicacion('programa', ['id_publicacion' => $idPublicacion])->getRowArray();

        if ($programa) {
            $programa['imagen'] = base_url("imagenes/afiches") . "/" . (trim($programa["imagen"]) ? $programa["imagen"] : "programa.jpg");

            $requisitos = $programa["requisitos_inscripcion"];

            $programa["infograma"] = $programa["infograma"] ?  base_url('descargas_programa/' . $programa["infograma"]) : null;

            $programa["numero_version"] = numero_romano($programa["numero_version"]);
            $programa["requisitos_inscripcion"] = str_ireplace("&nbsp;", " ", strip_tags($requisitos));
            $programa["objetivo"] = str_ireplace("&nbsp;", " ", strip_tags($programa["objetivo"]));
            $programa["contenido_minimo"] = strip_tags(str_ireplace(["<li>","</li>", "<p>","</p>"], "  ", strip_tags($programa["contenido_minimo"], "<li>",)));
            $programa["fecha_fin_inscripcion"] = date("d-m-Y", strtotime($programa["fecha_fin_inscripcion"]));
            $programa["carga_horaria"] = $programa["carga_horaria"] . " Horas";
            $programa["duracion"] = $programa["duracion"] . " Meses";

            $programa["nombre_area"] = $this->areas_texto($programa["area_especialidad"]);

            $respuesta = [
                "success" => true,
                "programa" => $programa ? $programa : [],
            ];
            return $this->respond($respuesta, 200, "OK");
        } else {

            return $this->fail("No se encontro el elemento solicitado", 400, "No se encontro el programa");
        }
    }


    private function areas_texto($area)
    {

        if ($area && !empty($this->areas_especialidad)) {
            $areas_texto = "";
            $areas_array = explode(",", $area);

            foreach ($areas_array as $key => $value) {
                $areas_texto .= $this->areas_especialidad[$value] . ", ";
            }

            return substr($areas_texto, 0, -2);
        } else {
            return null;
        }
    }
}
