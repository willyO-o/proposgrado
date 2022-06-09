<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class OfertaModel extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    function listarEtiquetas($condicion = null)
    {
        $builder = $this->db->table('pagina_web.psg_etiqueta_area ea')
            ->select('e.nombre_etiqueta as text')
            ->join('pagina_web.psg_etiqueta e', 'ea.id_etiqueta = e.id_etiqueta');
        return  $condicion !== null ? $builder->getWhere($condicion) : $builder->get();
    }
}
