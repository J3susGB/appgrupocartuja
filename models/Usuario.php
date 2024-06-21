<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido1', 'apellido2', 'categoria_id', 'pack_id', 'pendiente_pagar', 'abona', 'telefono', 'email', 'foto', 'password', 
        'confirmado', 'token', 'admin', 'organizador', 'directivo'];

    public $id;
    public $nombre;
    public $apellido1;
    public $apellido2;
    public $categoria_id;
    public $pack_id;
    public $pendiente_pagar;
    public $abona;
    public $telefono;
    public $email;
    public $foto;
    public $password;
    public $password2;
    public $confirmado;
    public $token;
    public $admin;
    public $organizador;
    public $directivo;

    public $password_actual;
    public $password_nuevo;

    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido1 = $args['apellido1'] ?? '';
        $this->apellido2 = $args['apellido2'] ?? '';
        $this->categoria_id = $args['categoria_id'] ?? 0;
        $this->pack_id = $args['pack_id'] ?? 1;
        $this->pendiente_pagar = $args['pendiente_pagar'] ?? 0.00;
        $this->abona = $args['abona'] ?? 0.00;
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->organizador = $args['organizador'] ?? 0;
        $this->directivo = $args['directivo'] ?? 0;
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas;

    }

    // Validación para cuentas nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido1) {
            self::$alertas['error'][] = 'El primer apellido es obligatorio';
        }
        if(!$this->apellido2) {
            self::$alertas['error'][] = 'El segundo apellido es obligatorio';
        }
        if(!$this->categoria_id) {
            self::$alertas['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->pack_id) {
            self::$alertas['error'][] = 'El pack es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->foto) {
            self::$alertas['error'][] = 'La foto es obligatoria';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }
        return self::$alertas;
    }

    // Validación para cuentas nuevas
    public function validar_edicion() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido1) {
            self::$alertas['error'][] = 'El primer apellido es obligatorio';
        }
        if(!$this->apellido2) {
            self::$alertas['error'][] = 'El segundo apellido es obligatorio';
        }
        if(!$this->categoria_id) {
            self::$alertas['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->pack_id) {
            self::$alertas['error'][] = 'El pack es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->foto) {
            self::$alertas['error'][] = 'La foto es obligatoria';
        }
        return self::$alertas;
    }

    // Validación para cuentas nuevas
    public function validar_edicion_privada() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido1) {
            self::$alertas['error'][] = 'El primer apellido es obligatorio';
        }
        if(!$this->apellido2) {
            self::$alertas['error'][] = 'El segundo apellido es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->foto) {
            self::$alertas['error'][] = 'La foto es obligatoria';
        }
        return self::$alertas;
    }

    public function validar_edicionPerfil() {
        if(!$this->admin) {
            self::$alertas['error'][] = 'El campo administrador no puede estar vacío';
        }
        if(!$this->organizador) {
            self::$alertas['error'][] = 'El campo organizador no puede estar vacío';
        }
        if(!$this->directivo) {
            self::$alertas['error'][] = 'El campo directivo no puede estar vacío';
        }
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function contraseña_privada() : array {
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes introducir la constraseña actual';
        }
        if(!$this->password2) {
            self::$alertas['error'][] = 'Debes introducir la nueva contraseña';
        }
        if(strlen($this->password2) < 6) {
            self::$alertas['error'][] = 'La nueva contraseña debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}