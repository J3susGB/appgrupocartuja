<?php

namespace Model;

class Categoria extends ActiveRecord {
    protected static $tabla = 'categoria';
    protected static $columnasDB = ['id', 'nombre_cat'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_cat = $args['nombre_cat'] ?? '';
    }

    // Validación 
    public function validar_categoria() {
        if(!$this->nombre_cat) {
            self::$alertas['error'][] = 'Tienes que elegir una categoría';
        }
    
        return self::$alertas;
    }

}