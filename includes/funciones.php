<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// function pagina_actual($path) {
//     return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
// }

function pagina_actual($path) {
    $url_actual = $_SERVER['PATH_INFO'] ?? urldecode(strtok($_SERVER['REQUEST_URI'], '?')) ?? '/';
    return strpos($url_actual, $path) !== false;
}



// Genera (o reutiliza) el token CSRF de la sesión
function csrf_token() : string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Imprime el campo oculto CSRF listo para usar en formularios
function csrf_field() : string {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Valida el token CSRF del POST o de la cabecera X-CSRF-Token (para AJAX)
function csrf_verificar() : void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Acepta el token tanto del cuerpo del formulario como de la cabecera HTTP (AJAX)
    $token_request = $_POST['csrf_token']
        ?? $_SERVER['HTTP_X_CSRF_TOKEN']
        ?? '';
    $token_session = $_SESSION['csrf_token'] ?? '';
    if (!$token_session || !hash_equals($token_session, $token_request)) {
        http_response_code(403);
        die('Acción no permitida.');
    }
}

function is_auth() : bool {
    session_start();
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function is_admin() : bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_admin = isset($_SESSION['admin']) && $_SESSION['admin'] === '1';
    // error_log("is_admin: " . ($is_admin ? 'true' : 'false')); // Para depuración
    return $is_admin;
}

function es_organizador() : bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_organizador = isset($_SESSION['organizador']) && $_SESSION['organizador'] === '1';
    // error_log("es_organizador: " . ($is_organizador ? 'true' : 'false')); // Para depuración
    return $is_organizador;
}

function es_directivo() : bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_directivo = isset($_SESSION['directivo']) && $_SESSION['directivo'] === '1';
    // error_log("es_directivo: " . ($is_directivo ? 'true' : 'false')); // Para depuración
    return $is_directivo;
}