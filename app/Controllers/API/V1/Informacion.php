<?php


namespace App\Controllers\API\V1;

use App\Controllers\BaseControllerAPI;
use App\Models\InformacionModel;


class Informacion extends BaseControllerAPI
{
    public function __construct()
    {
        parent::__construct();
        $this->informacionModel = new InformacionModel();

    }

    public function informacionRegistrar()
    {
        header('Access-Control-Allow-Origin: *');
        helper(['form']);
        $validation =  \Config\Services::validation();


        // return $this->response->setJSON($this->request);

        $id_publicacion = $this->request->getVar('publicacion');
        $area_interes = $this->request->getVar('area_interes');

        if (is_null($id_publicacion) && is_null($area_interes)) {
            return $this->response->setJSON([
                'success' => false,
                'mensaje' => 'Ocurrio un error al procesar su solicitud, por favor intente nuevamente.',

            ]);
        }

        

        $validation->setRule("nombre_persona", 'Nompre Completo', 'required');
        $validation->setRule("celular", 'Numero de Celular', 'required|numeric|min_length[8]|max_length[8]|greater_than_equal_to[60000000]|less_than_equal_to[79999999]');
        $validation->setRule("ciudad", 'Ciudad', 'required');
        $validation->setRule("informacion", 'Recibir Informacion', 'required');
        // $validation->setRule("correo", 'Correo Electronico', 'valid_email');




        if ($validation->withRequest($this->request)->run()) {

            $celular = $this->request->getVar('celular');

            $query = $this->informacionModel->seleccionar_tabla("persona_contacto", ["nro_celular" => $celular]);
            $id_persona = null;
            $datos_persona = [];

            
            if ($query->getNumRows() == 0) {
            

                $datos_persona = [
                    'nombre_completo' => mb_convert_case($this->request->getVar('nombre_persona'), MB_CASE_UPPER),
                    'nro_celular' => $this->request->getVar('celular'),
                    'correo' => $this->nuloSiVacio($this->request->getVar('correo')),
                    'ciudad_contacto' => $this->request->getVar('ciudad'),
                    'fecha_registro_contacto' => date("Y-m-d H:i:s"),
                    'estado_contacto' => "REGISTRADO",
                ];


                $id_persona = $this->informacionModel->insertar_tabla("persona_contacto", $datos_persona);
            } else {
                $datos_persona = $query->getRowArray();
                $id_persona = $datos_persona['id_persona_contacto'];
            }
            if ($id_publicacion != null && is_int($id_publicacion)) {
                $area_especialidad = $this->informacionModel->seleccionar_tabla("publicacion", ["id_publicacion" => $id_publicacion], "area_especialidad")->getRowArray();
                $area_interes = $area_especialidad['area_especialidad'];

            }


            $datos_solicitud = [
                'id_persona_contacto' => $id_persona,
                'id_publicacion' => $this->nuloSiVacio($id_publicacion),
                'area_interes' => $this->nuloSiVacio($area_interes),
                'fecha_registro_area_interes' => date("Y-m-d H:i:s"),
                'tipo_informacion_solicitada' => implode(",", $this->request->getVar('informacion')),
                'otra_informacion' =>  $this->nuloSiVacio($this->request->getVar('otra_info')),
                'estado_area_interes' => "PENDIENTE",
            ];
            $id_area_interes = $this->informacionModel->insertar_tabla("area_interes_contacto", $datos_solicitud);
          

            if ($id_area_interes > 0) {


                return $this->response->setJSON([
                    'success' => true,
                    'mensaje' => "Solicitud enviada correctamente, Nuestro equipo se contactara con usted a la brevedad para brindarle la informacion solicitada.",
                    'programa' => $id_publicacion != null ? $this->consultas->listarPublicacion('programa', ['id_publicacion' => $id_publicacion])->getRowArray() : null,
                    'solicitud' => $datos_solicitud,
                    'area_interes' => $this->request->getVar('area_interes') != null ? $this->consultas->seleccionarTabla("area", "*", ["id_area" => $this->request->getVar('area_interes')])->getRowArray() : null,
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'mensaje' => 'Ocurrio un error al enviar la solicitud, por favor intente nuevamente.',

                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'error' => $validation->getErrors(),
            ]);
        }
    }


    public function nuloSiVacio($dato)
    {
        return is_null($dato) ? null : (empty($dato) ? null : trim($dato));
    }
}

/* End of file Controllername.php */
