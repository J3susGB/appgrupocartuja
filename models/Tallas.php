<?php

namespace Model;

class Tallas extends ActiveRecord {
    protected static $tabla = 'tallas';
    protected static $columnasDB = ['id', 'nombre_talla'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_talla = $args['nombre_talla'] ?? '';
    }
}