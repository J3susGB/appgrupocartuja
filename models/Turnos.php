<?php

namespace Model;

class Turnos extends ActiveRecord {
    protected static $tabla = 'turnos';
    protected static $columnasDB = ['id_turno', 'nombre_turno'];

    public function __construct($args = [])
    {
        $this->id_turno = $args['id_turno'] ?? null;
        $this->nombre_turno = $args['nombre_turno'] ?? '';
    }

}