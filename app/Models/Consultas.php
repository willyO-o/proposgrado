<?php

namespace App\Models;

use CodeIgniter\Database\Database;
use PhpParser\Node\Stmt\Else_;

class Consultas extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    function seleccionarTabla($tabla = null, $seleccion = '*', $condicion = [], $orden = '', $limite = '')
    {
        $builder = $this->db->table($tabla);
        $builder->select($seleccion);
        empty($orden) ?: $builder->orderBy($orden);
        empty($limite) ?: $builder->limit($limite);
        return  $condicion !== null ? $builder->getWhere($condicion) : $builder->get();
    }
    function insertarTabla($tabla, $datos)
    {
        $builder = $this->db->table($tabla)->insert($datos);
        return  $this->db->insertID();
        // $builder = $this->db->table($tabla);
        // $sql = $builder->set($datos)->getCompiledInsert('pagina_web.psg_inscripcion');
        // echo $sql;
    }

    function actualizarTabla($tabla, $datos, $condicion = [])
    {
        $builder = $this->db->table($tabla);
        empty($condicion) ?: $builder->where($condicion);
        return  $builder->update($datos);
    }
    function listarPublicacion($seleccion, $condicion = [], $orden = '', $limite = '')
    {
        $descripcion_programa = $this->db->table('pagina_web.psg_publicacion_descripcion pd')->select('objetivo')
            ->join('pagina_web.psg_descripcion_programa dp', 'dp.id_descripcion_programa = pd.id_descripcion_programa')
            ->getCompiledSelect();
        $requisito_programa = $this->db->table('pagina_web.psg_publicacion_descripcion pd')->select('requisitos_inscripcion')
            ->join('pagina_web.psg_descripcion_programa dp', 'dp.id_descripcion_programa = pd.id_descripcion_programa')
            ->getCompiledSelect();
        $afiche_programa = $this->db->table('pagina_web.psg_respaldo_multimedia')->select('url')->where('id_tipo_respaldo is null')
            ->getCompiledSelect();
        $infograma_programa = $this->db->table('pagina_web.psg_respaldo_multimedia')->select('url as infograma')->where(['id_tipo_respaldo' => 1])
            ->getCompiledSelect();
        $descripcion = $this->db->table('pagina_web.psg_publicacion_descripcion')->select('descripcion')
            ->getCompiledSelect();
        $contenidoMinimo = $this->db->table('pagina_web.psg_publicacion_descripcion pd')->select('contenido_minimo')
            ->join('pagina_web.psg_descripcion_programa dp', 'dp.id_descripcion_programa = pd.id_descripcion_programa')
            ->getCompiledSelect();
        switch ($seleccion) {
            case 'programasDivididos':
                $datos = [];
                foreach ($this->distintoTabla('pagina_web.psg_publicacion', 'grado_academico') as $key => $value) {
                    $builder = $this->db->table('pagina_web.psg_publicacion p')
                    ->select("p.*,g.*,per.nombre,per.paterno,per.materno, 
                     ($afiche_programa  and id_publicacion = p.id_publicacion limit 1), 
                     ($infograma_programa and id_publicacion = p.id_publicacion limit 1), 
                      ($descripcion_programa where id_publicacion = p.id_publicacion limit 1)")
                        ->join('gestion g', 'g.id_gestion =  p.id_gestion', 'left')
                        ->join('persona per', 'p.id_responsable_interno =  per.id_persona', 'left')
                        ->where(['grado_academico' => $value]);
                    if (!empty(IDSEDE)) {
                        $builder->where(array('sede' => SEDE));
                        // if ($value == 'DIPLOMADO') {
                        //     $builder->groupStart();
                        //     $builder->orWhere(array('sede' => SEDE, 'id_publicacion' => 52));
                        //     $builder->groupEnd();
                        // } else {
                        // }
                    }
                    empty($orden) ?: $builder->orderBy($orden);
                    $datos[$value] = empty($condicion) ? $builder->get()->getResultArray() : $builder->getWhere($condicion)->getResultArray();
                    // echo $this->db->getLastQuery();
                }
                return $datos;
                break;
            case 'programa':
                $builder = $this->db->table('pagina_web.psg_publicacion p')
                    ->select("*, ($afiche_programa AND id_publicacion = p.id_publicacion limit 1), 
                    ($infograma_programa and id_publicacion = p.id_publicacion limit 1), 
                ($descripcion_programa where id_publicacion = p.id_publicacion limit 1),
                ($descripcion where id_publicacion = p.id_publicacion limit 1),
                ($requisito_programa where id_publicacion = p.id_publicacion limit 1),
                ($contenidoMinimo where id_publicacion = p.id_publicacion limit 1)")
                    ->join('gestion g', 'g.id_gestion =  p.id_gestion', 'left');
                empty($orden) ?: $builder->orderBy($orden);
                empty($limite) ?: $builder->limit($limite);

                return
                    empty($condicion) ? $builder->get() : $builder->getWhere($condicion);
                // $query = $this->db->getLastQuery();
                // echo (string)$query;
                break;
            case 'programasFiltro':
                $datos = [];
                    $campos = "p.id_publicacion,p.nombre_programa,p.sede,grado_academico,
                    COALESCE(modalidad, '') as modalidad, COALESCE(area_especialidad, '') as area_especialidad,
                    concat(p.grado_academico,' EN ',p.nombre_programa,' VERSION ', p.numero_version) as nombre_programa_completo ";

                    $builder = $this->db->table('pagina_web.psg_publicacion p')->select($campos)
                        ->join('gestion g', 'g.id_gestion =  p.id_gestion', 'left')
                        ->join('persona per', 'p.id_responsable_interno =  per.id_persona', 'left');

                        empty(IDSEDE) ? :  $builder->where(array('sede' => SEDE));

                        

                    empty($orden) ?: $builder->orderBy($orden);
                    $datos = empty($condicion) ? $builder->get()->getResultArray() : $builder->getWhere($condicion)->getResultArray();

                return $datos;

                break;
            default:
                # code...
                break;
        }
        // $builder->orderBy($orden);
    }

    public function listarPrograma($seleccion, $condicion = [], $orden = '', $limite = '')
    {
        switch ($seleccion) {
            case 'programasDivididos':
                $programa = [];
                foreach ($this->distintoTabla('public.psg_vista_programas', 'descripcion_grado_academico', 'id_grado_academico desc') as $key => $value) {
                    $builder = $this->db->table('public.psg_vista_programas')->select('id_gestion_programa, nombre_programa, id_tipo_programa, id_grado_academico')
                        ->groupBy('id_gestion_programa, nombre_programa, id_tipo_programa, id_grado_academico');
                    empty($orden) ?: $builder->orderBy($orden);
                    empty($limite) ?: $builder->limit($limite);
                    $builder->where(['descripcion_grado_academico' => $value]);
                    $programa[$value] = empty($condicion) ? $builder->get()->getResultArray() : $builder->getWhere($condicion)->getResultArray();
                }
                return $programa;
                break;

            default:
                # code...
                break;
        }
    }

    public function distintoTabla($tabla, $columna, $orden = '')
    {
        return array_unique(array_column($this->db->table($tabla)
            ->select($columna)->orderBy($orden)->get()->getResultArray(), $columna));
    }
    public function respaldoMultimedia($columnas, $condicion = [], $orden = '')
    {
        $builder = $this->db->table('pagina_web.psg_respaldo_multimedia rm')->select($columnas)
            ->join('pagina_web.psg_tipo_respaldo tr', 'tr.id_tipo_respaldo = rm.id_tipo_respaldo');

        $builder->orderBy($orden);
        return  $condicion !== null ? $builder->getWhere($condicion) : $builder->get();
    }
}
