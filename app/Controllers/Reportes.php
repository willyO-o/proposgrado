<?php

namespace App\Controllers;

header('Access-Control-Allow-Origin: *');

// header('Access-Control-Allow-Origin: https://sistemaposgrado.upea.bo');
// header('Access-Control-Allow-Origin: https://devposgrado.upea.bo');

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InscripcionModel;
use App\Controllers\Reportes\InscripcionReporte;
use App\Models\Consultas;

class Reportes extends ResourceController
{
    use ResponseTrait;
    protected $helpers = ['Psg'];

    public function cartasPreInscripcion($idPersona, $idPublicacion, $tipos = '')
    {
        $this->data['publicacion'] = (new Consultas)->listarPublicacion('programa', ['md5(p.id_publicacion::text)' => $idPublicacion])->getRowArray();
        $datos = (new InscripcionModel)->inscripcion(['md5(id_persona_externa::text)' => $idPersona, 'md5(p.id_publicacion::text)' => $idPublicacion])->getRowArray();

        if (!is_null($this->data['publicacion']) && !is_null($datos)) {

            $this->data['cartaCompromiso'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->cartaCompromisoInscripcion($datos));
            $pagos = [];
            foreach ((new Consultas)->seleccionarTabla('tipo_pago', 'id_tipo_pago, descripcion_tipo_pago', ['estado_tipo_pago' => 'ACTIVO'])->getResultArray() as $key => $value) {
                $deposito = (new Consultas)->seleccionarTabla('deposito', '*', ['id_tipo_pago' => $value['id_tipo_pago'], 'id_inscripcion_online' => $datos['id_inscripcion_online']])->getResultArray();
                if (!empty($deposito))
                    $pagos[$value['descripcion_tipo_pago']] = $deposito;
            }
            $this->data['formulario'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->formularioInscripcion(array_merge($datos, ['pagos' => $pagos])));
            $this->data['solicitud'] = 'data:application/pdf;base64,' . base64_encode((new InscripcionReporte())->solicitudInscripcion($datos));

            $reportes = [];
            foreach (empty($tipos) ? [] : explode(',', $tipos) as $key => $value) {
                $reportes[$value] = $this->data[$value];
            }
            return $this->respond($reportes);
        } else {
            return $this->failNotFound('No se encontro las cartas solicitadas');
        }
    }
}
