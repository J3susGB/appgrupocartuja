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
    // Obtener PATH_INFO o REQUEST_URI y remover cualquier query string
    $url_actual = $_SERVER['PATH_INFO'] ?? urldecode(strtok($_SERVER['REQUEST_URI'], '?')) ?? '/';
    return str_contains($url_actual, $path) ? true : false;
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
    error_log("is_admin: " . ($is_admin ? 'true' : 'false')); // Para depuración
    return $is_admin;
}

function es_organizador() : bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_organizador = isset($_SESSION['organizador']) && $_SESSION['organizador'] === '1';
    error_log("es_organizador: " . ($is_organizador ? 'true' : 'false')); // Para depuración
    return $is_organizador;
}

function es_directivo() : bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_directivo = isset($_SESSION['directivo']) && $_SESSION['directivo'] === '1';
    error_log("es_directivo: " . ($is_directivo ? 'true' : 'false')); // Para depuración
    return $is_directivo;
}