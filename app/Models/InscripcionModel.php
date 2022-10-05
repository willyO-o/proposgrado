<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class InscripcionModel extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    function inscripcion($condicion = null, $orden = '')
    {
        $builder = $this->db->table('pagina_web.psg_publicacion p')
            ->select('*')
            ->join('inscripcion_online io', 'io.id_publicacion = p.id_publicacion', 'left')
            ->join('persona_externa pe', 'pe.id_persona_externa = io.id_persona_interesado', 'left')
            ->join('informacion_adicional_inscripcion iai', 'iai.id_inscripcion_online = io.id_inscripcion_online', 'left')
            ->join('unidad_academica ua', 'ua.id_unidad_academica = iai.id_unidad_academica', 'left')
            ->join('grado_academico ga', 'ga.id_grado_academico = iai.id_grado_academico', 'left')
            ->join('locacion l', 'l.id_locacion = iai.id_locacion', 'left')
            ->orderBy($orden);
        return  $condicion !== null ? $builder->getWhere($condicion) : $builder->get();
    }
    function persona($seleccion, $condicion = [], $orden = '', $limite = '')
    {
        $persona = $this->db->table('persona_externa p')->select($seleccion);
        empty($orden) ?: $persona->orderBy($orden);
        empty($limite) ?: $persona->limit($limite);
        $persona = empty($condicion) ? $persona->get() : $persona->getWhere($condicion);

        $personaPosgrado = $this->db->table('persona p')->select($seleccion);
        empty($orden) ?: $personaPosgrado->orderBy($orden);
        empty($limite) ?: $personaPosgrado->limit($limite);
        $personaPosgrado = empty($condicion) ? $personaPosgrado->get() : $personaPosgrado->getWhere($condicion);
        return [$persona, $personaPosgrado];
    }
}
