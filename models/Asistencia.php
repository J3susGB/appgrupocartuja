<?php

namespace Model;

class Asistencia extends ActiveRecord {
    protected static $tabla = 'asistencia';
    protected static $columnasDB = ['id', 'id_usuario', 'id_categoria', 'asiste', 'fecha', 'id_turno'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? 1;
        $this->id_categoria = $args['id_categoria'] ?? '';
        $this->asiste = $args['asiste'] ?? 0;
        $this->fecha = $args['fecha'] ?? '';
        $this->id_turno = $args['id_turno'] ?? 2;
    }

    // Validar que la fecha no se deja en blanco
    public function validarFecha() {
        if(!$this->fecha) {
            self::$alertas['error'][] = 'Debes introducir una fecha';
        }
        return self::$alertas;
    }

}