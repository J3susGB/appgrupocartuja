<?php

namespace Model;

class Mensajes extends ActiveRecord {
    protected static $tabla = 'mensajes';
    protected static $columnasDB = ['id', 'asunto', 'cuerpo'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->asunto = $args['asunto'] ?? '';
        $this->cuerpo = $args['cuerpo'] ?? '';
    }

    // Validación 
    public function validar_mensaje() {
        if(!$this->asunto) {
            self::$alertas['error'][] = 'Tienes que añadir un asunto al mensaje';
        }
        if(!$this->cuerpo) {
            self::$alertas['error'][] = 'El mensaje no puede estar vacío';
        }
        return self::$alertas;
    }

}