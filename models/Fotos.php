<?php

namespace Model;

class Fotos extends ActiveRecord {
    protected static $tabla = 'fotos';
    protected static $columnasDB = ['id', 'nombre_foto', 'fecha', 'mes', 'turno'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_foto = $args['nombre_foto'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->mes = $args['mes'] ?? '';
        $this->turno = $args['turno'] ?? 1;
    }

    // Validar subida de foto
    public function validarFoto() {
        if(!$this->fecha) {
            self::$alertas['error'][] = 'Debes introducir una fecha';
        }
        if(!$this->turno) {
            self::$alertas['error'][] = 'Debes asignar un turno';
        }
        if(!$this->nombre_foto) {
            self::$alertas['error'][] = 'Debes seleccionar una imagen';
        }
        return self::$alertas;

    }
}