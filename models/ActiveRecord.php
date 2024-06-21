<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los Registros de dias
    public static function allDias($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id_dia {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los Registros de turnos
    public static function allTurnos($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id_turno {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los Registros de asistencia ordenados por categoría
    public static function allAsistencia($orden = 'ASC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id_categoria {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los registros ordenados 
    public static function all_ord($primero = 'apellido1', $segundo = 'apellido2', $tercero = 'nombre') {
        // Cambiar la consulta para ordenar por primer apellido, luego segundo apellido y finalmente nombre
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$primero}, {$segundo}, {$tercero}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca fotos por su mes
    public static function findFotosMes($mes) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE mes = {$mes}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }
    // Busca todos los registros de en id
    public static function find_all($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro de talla por el id del miembro
    public static function find_registro_talla($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id_usuario = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT {$limite}" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Paginar los registros
    public static function paginar($primero, $segundo, $tercero, $por_pagina, $offset) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$primero}, {$segundo}, {$tercero} LIMIT {$por_pagina} OFFSET {$offset}" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }
    // Busqueda Where todo con Columna
    public static function whereAll($columna, $valor) {
        // Define la consulta SQL con una cláusula WHERE y ORDER BY
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'" .
                " ORDER BY categoria_id, apellido1, apellido2, nombre";

        // Ejecuta la consulta y devuelve los resultados
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    // Busqueda Where todo con Columna
    public static function whereAll_unorder($columna, $valor) {
        // Define la consulta SQL con una cláusula WHERE y ORDER BY
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'" ;

        // Ejecuta la consulta y devuelve los resultados
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function whereAll_order($columna, $valor, $orden = 'DESC') {
        // Define la consulta SQL con una cláusula WHERE y ORDER BY
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}' ORDER BY id {$orden}";
    
        // Ejecuta la consulta y devuelve los resultados
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Retornar los registros por un orden 
    public static function ordenar($columna, $orden) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$columna} {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Retornar por orden y con un límite:
    public static function ordenarLimite($columna, $orden, $limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$columna} {$orden} LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con múltiples opciones 
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            if( $key === array_key_last($array) ) { //Evaluará si está en al última llave del array, 
                $query .= " {$key} = '{$value}'"; //Si es la última, no añadirá en AND al final
            } else {
                $query .= " {$key} = '{$value}' AND "; //Si no es la ultima, lo añadirá
            }    
        }

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Traer un total de registros
    public static function total ($columna = '', $valor = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if( $columna ) {
            $query .= " WHERE {$columna} = {$valor}";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();

        return array_shift($total); //Array_shift lo saca del array y trae el valor
    }

    //Traer un total de registros con array Where
    public static function totalArray ($array=[]) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            if( $key === array_key_last($array) ) { //Evaluará si está en al última llave del array, 
                $query .= " {$key} = '{$value}'"; //Si es la última, no añadirá en AND al final
            } else {
                $query .= " {$key} = '{$value}' AND "; //Si no es la ultima, lo añadirá
            }    
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();

        return array_shift($total); //Array_shift lo saca del array y trae el valor
    }

    // crea un nuevo registro
    public function crear() {
    // Sanitizar los datos
    $atributos = $this->sanitizarAtributos();
 
    // Insertar en la base de datos
    $query = " INSERT INTO " . static::$tabla . " ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES ('"; 
    $query .= join("', '", array_values($atributos));
    $query .= "') ";
 
    // debuguear($query); // Descomentar si no te funciona algo
 
    // Resultado de la consulta
    $resultado = self::$db->query($query);
    return [
        'resultado' =>  $resultado,
        'id' => self::$db->insert_id
    ];
}

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }
}