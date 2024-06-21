<?php

namespace Model;

class Tallasusuarios extends ActiveRecord {
    protected static $tabla = 'tallasusuarios';
    protected static $columnasDB = ['id', 'camiseta', 'calzona', 'chandal', 'Cortavientos', 'id_usuario'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->camiseta = $args['camiseta'] ?? null;
        $this->calzona = $args['calzona'] ?? null;
        $this->chandal = $args['chandal'] ?? null;
        $this->Cortavientos = $args['Cortavientos'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
    }

    public function validar_tallas() {
            if(!$this->camiseta) {
                self::$alertas['error'][] = 'Tienes que añadir una talla de camiseta';
            }
            if(!$this->calzona) {
                self::$alertas['error'][] = 'Tienes que añadir una talla de calzonas';
            }
            if(!$this->chandal) {
                self::$alertas['error'][] = 'Tienes que añadir una talla de chandal';
            }
            if(!$this->Cortavientos) {
                self::$alertas['error'][] = 'Tienes que añadir una talla de cortavientos';
            }
        return self::$alertas;
    }

    public function validar_añadir_talla() {
        if(!$this->id_usuario) {
            self::$alertas['error'][] = 'Tienes que elegir a un usuario';
        }
        if(!$this->camiseta) {
            self::$alertas['error'][] = 'Tienes que añadir una talla de camiseta';
        }
        if(!$this->calzona) {
            self::$alertas['error'][] = 'Tienes que añadir una talla de calzonas';
        }
        if(!$this->chandal) {
            self::$alertas['error'][] = 'Tienes que añadir una talla de chandal';
        }
        if(!$this->Cortavientos) {
            self::$alertas['error'][] = 'Tienes que añadir una talla de cortavientos';
        }
    return self::$alertas;
    }
}