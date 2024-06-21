<?php

namespace Model;

class Pack extends ActiveRecord {
    protected static $tabla = 'pack';
    protected static $columnasDB = ['id', 'nombre_pack', 'precio'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_pack = $args['nombre_pack'] ?? '';
        $this->precio = $args['precio'] ?? 50;
    }

    public function validar_edicion_pack() {
        if(!$this->nombre_pack) {
            self::$alertas['error'][] = 'Debes dar un nombre al pack';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'Debes dar un precio al pack';
        }
        if($this->precio && $this->precio <= 0) {
            self::$alertas['error'][] = 'El precio del pack no es correcto';
        }
        return self::$alertas;
    }

}