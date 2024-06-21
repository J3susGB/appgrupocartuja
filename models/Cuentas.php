<?php

namespace Model;

class Cuentas extends ActiveRecord {
    protected static $tabla = 'cuentas';
    protected static $columnasDB = ['id', 'concepto', 'ingreso', 'gasto', 'balance'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->concepto = $args['concepto'] ?? '';
        $this->ingreso = $args['ingreso'] ?? 0.00;
        $this->gasto = $args['gasto'] ?? 0.00;
        $this->balance = $args['balance'] ?? 0.00;
    }

    // Validación 
    public function validar_formulario_cuentas() {
        if(!$this->concepto) {
            self::$alertas['error'][] = 'Tienes que indicar un concepto al movimiento';
        }
        if(!$this->ingreso && !$this->gasto) {
            self::$alertas['error'][] = 'Tienes que anotar un ingreso o un gasto';
        }
        if(!is_numeric($this->ingreso)) {
            self::$alertas['error'][] = 'Tienes que introducir un número para ingreso o gasto';
        }
        if(!is_numeric($this->gasto)) {
            self::$alertas['error'][] = 'Tienes que introducir un número para ingreso o gasto';
        }
        return self::$alertas;
    }

}