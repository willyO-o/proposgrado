<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\InformacionModel;
use App\Libraries\Captcha;

class Informacion extends BaseController
{
    protected $informacionModel;
    protected $captcha;

    public function __construct()
    {
        parent::__construct();
        $this->informacionModel = new InformacionModel();
        $this->captcha = new Captcha();
    }



    public function index($id_publicacion = null)
    {
        $consulta = $this->informacionModel->seleccionar_tabla("pagina_web.psg_publicacion", ["id_publicacion" => $id_publicacion], "nombre_programa,grado_academico,numero_version,id_publicacion");
        $programa = "";
        if ($consulta->getNumRows() == 0) {
            $id_publicacion = null;
        } else {
            $datos_programa = $consulta->getRowArray();
            $programa = $datos_programa["grado_academico"]. " EN " .$datos_programa["nombre_programa"] .  " " . ($datos_programa["numero_version"] ? "VERSION " . $datos_programa["numero_version"] : "");
        }
        $this->data['informacion'] = '';
        $this->data['programa'] = $programa;
        $this->data['id_publicacion'] = $id_publicacion;
        $this->data['ciudades'] = $this->informacionModel->listar_ciudades()->getResultArray();
        $this->data['areas'] = $this->informacionModel->listar_areas()->getResultArray();

        // dd($this->data['areas']);
        return $this->templater->view('informacion/index', $this->data);
    }

    public function informacion_generar_captcha()
    {
        if(!is_dir('imagenes/captchas/')){
            mkdir('imagenes/captchas/', 0777, true);
        }
        // return;
        // $this->eliminar_captchas();
        $respuesta = $this->captcha->generar_captcha("imagenes/captchas/");
        $respuesta["ruta"] = base_url() . "/" . $respuesta["ruta"];
        return $this->response->setJSON([
            'exito' => true,
            'captcha' => $respuesta,
        ]);
    }

    public function informacion_registrar_solicitud()
    {
        helper(['form']);
        $validation =  \Config\Services::validation();

        // $celular = $this->request->getPost('celular');
        // $datos_persona = $this->informacionModel->seleccionar_tabla("pagina_web.psg_persona_contacto", ["nro_celular" => $celular]);


        // var_dump($datos_persona->getNumRows());
        // return;
        $id_publicacion = $this->request->getPost('publicacion');

        $validation->setRule("nombre_persona", 'Nompre Completo', 'required');
        $validation->setRule("celular", 'Numero de Celular', 'required|numeric|min_length[8]|max_length[10]');
        $validation->setRule("ciudad", 'Ciudad', 'required');
        $validation->setRule("informacion", 'Recibir Informacion', 'required');
        $validation->setRule("captcha", 'Captcha', 'required');
        if ($validation->withRequest($this->request)->run()) {

            $input_captcha = (int)$this->request->getPost('captcha');
            $codigo_captcha =  $this->request->getPost("codigo_captcha");

            if ($this->captcha->getExpressionResult($codigo_captcha) === $input_captcha) {

                $celular = $this->request->getPost('celular');
                $query = $this->informacionModel->seleccionar_tabla("psg_persona_contacto", ["nro_celular" => $celular]);
                $id_persona = null;
                $datos_persona = [];
                if ($query->getNumRows() == 0) {

                    $datos_persona = [
                        'nombre_completo' => mb_convert_case($this->request->getPost('nombre_persona'), MB_CASE_UPPER),
                        'nro_celular' => $this->request->getPost('celular'),
                        'correo' => $this->nuloSiVacio($this->request->getPost('correo')),
                        'ciudad_contacto' => $this->request->getPost('ciudad'),
                        'fecha_registro_contacto' => date("Y-m-d H:i:s"),
                        'estado_contacto' => "REGISTRADO",
                    ];
                    $id_persona = $this->informacionModel->insertar_tabla("persona_contacto", $datos_persona);
                } else {
                    $datos_persona = $query->getRowArray();
                    $id_persona = $datos_persona['id_persona_contacto'];
                }
                $area_interes = $this->request->getPost('area_interes');
                if ($id_publicacion != null && is_int($id_publicacion)) {
                    $area_especialidad = $this->informacionModel->seleccionar_tabla("psg_publicacion", ["id_publicacion" => $id_publicacion], "area_especialidad")->getRowArray();
                    $area_interes = $area_especialidad['area_especialidad'];
                }

                $datos_solicitud = [
                    'id_persona_contacto' => $id_persona,
                    'id_publicacion' => $this->nuloSiVacio($id_publicacion),
                    'area_interes' => $this->nuloSiVacio($area_interes),
                    'fecha_registro_area_interes' => date("Y-m-d H:i:s"),
                    'tipo_informacion_solicitada' => implode(", ", $this->request->getPost('informacion')),
                    'otra_informacion' => $this->nuloSiVacio($this->request->getPost('otra_info')),
                    'estado_area_interes' => "PENDIENTE",
                ];

                $id_persona_contacto = $this->informacionModel->insertar_tabla("area_interes_contacto", $datos_solicitud);


                if ($id_persona_contacto > 0) {

     
                    return $this->response->setJSON([
                        'exito' => true,
                        'mensaje' => "Solicitud enviada correctamente, Nuestro equipo se contactara con usted a la brevedad para brindarle la informacion solicitada.",
                        'captcha' => true,
                        'programa' => $id_publicacion != null ? $this->consultas->listarPublicacion('programa', ['id_publicacion' => $id_publicacion])->getRowArray() : null,
                        'solicitud'=>$datos_solicitud,
                        'area_interes'=> $this->request->getPost('area_interes')!=null ? $this->consultas->seleccionarTabla("area","*",["id_area"=>$this->request->getPost('area_interes')])->getRowArray() : null,
                    ]);
                } else {
                    return $this->response->setJSON([
                        'exito' => false,
                        'mensaje' => 'Ocurrio un error al enviar la solicitud, por favor intente nuevamente.',
                        'captcha' => false,

                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'exito' => false,
                    'mensaje' => "Error de Captcha, por favor intente nuevamente.",
                    'captcha' => false,
                ]);
            }
        } else {
            return $this->response->setJSON([
                'exito' => false,
                'error' => $validation->getErrors(),
                'captcha' => false,
            ]);
        }
    }

    private function eliminar_captchas()
    {
        $files = glob('imagenes/captchas/*.png'); //obtenemos todos los nombres de los ficheros
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file); //elimino el fichero
        }
    }

    public function nuloSiVacio($dato)
    {
        return is_null($dato) ? null : (empty($dato) ? null : trim($dato));
    }
}
