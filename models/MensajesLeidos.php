<?php

namespace Model;

class MensajesLeidos extends ActiveRecord {
    protected static $tabla = 'mensajes_leidos';
    protected static $columnasDB = ['id', 'usuario_id', 'mensaje_id', 'leido'];

    public $id;
    public $usuario_id;
    public $mensaje_id;
    public $leido;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->mensaje_id = $args['mensaje_id'] ?? null;
        $this->leido = $args['leido'] ?? 0;
    }

    public static function get_mensaje($usuario_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE usuario_id = {$usuario_id}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function marcarMensajeLeido($usuario_id, $mensaje_id) {
        $mensaje_leido = self::where('usuario_id', $usuario_id)
                            ->where('mensaje_id', $mensaje_id)
                            ->first();
    
        if ($mensaje_leido) {
            $mensaje_leido->leido = 1; // Marcar como leído
            $mensaje_leido->save();
        }
    }

}
