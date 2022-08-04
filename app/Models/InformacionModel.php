<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class InformacionModel extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    function listar_ciudades($id_ciudad = null)
    {
        $builder = $this->db->table('pagina_web.psg_ciudad');
        return  $id_ciudad !== null ? $builder->getWhere(["id_ciudad" => $id_ciudad]) : $builder->get();
    }

    public function listar_areas($id_area = null)
    {
        $builder = $this->db->table('pagina_web.psg_area');
        return  $id_area !== null ? $builder->getWhere(["id_area" => $id_area]) : $builder->get();
    }


    public function insertar_persona_contacto($datos)
    {
        $builder = $this->db->table('persona_contacto');
        $builder->insert($datos);
        return $this->db->insertID();
    }

    public function seleccionar_tabla($tabla, $condicion = null, $columnas = "*")
    {

        $builder = $this->db->table($tabla);
        $builder->select($columnas);
        return  $condicion !== null ? $builder->getWhere($condicion) : $builder->get();
    }

    public function insertar_tabla($tabla, $datos)
    {

        $builder = $this->db->table($tabla)->insert($datos);
        return  $this->db->insertID();
        // $builder = $this->db->table($tabla);
        // $builder->insert($datos);
        // return $this->db->insertID();
    }
}
