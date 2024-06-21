<?php

namespace Controllers;

use Model\Memoria;
use Model\Pdf;
use MVC\Router;

class MemoriaController {
    public static function memoria(Router $router) {
        if (!is_auth()) {
            header('Location: /login');
        }

        if(es_directivo()) {
            header('Location: /login');
        }

        // Me traigo todos los planning almacenados en la base de datos:
        $memorias = Memoria::all('DESC');
        // debuguear($memorias);

        // Render a la vista 
        $router->render('/admin/dashboard/memoria', [
            'titulo' => 'Memorias Económicas',
            'memorias' => $memorias
        ]);
    }

    public static function memorias_direccion(Router $router) {

        if(!es_directivo() && !is_admin()) {
            header('Location: /login');
        }

        // Me traigo todos los planning almacenados en la base de datos:
        $memorias = Memoria::all('DESC');
        // debuguear($memorias);

        // Render a la vista 
        $router->render('/consultas_direccion/informes/memorias', [
            'titulo' => 'Memorias Económicas',
            'memorias' => $memorias
        ]);
    }

    public static function añadir_memoria(Router $router) {
        if (!is_admin()) {
            header('Location: /login');
        }

        $documento = new Memoria();
        // debuguear($documento);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }

            // Leer archivo PDF:
            if (!empty($_FILES['file']['tmp_name'])) {
                // Crear una carpeta para los archivos PDF
                $carpeta_archivos = '../public/memorias_economicas';

                // Si la carpeta no existe, créala
                if (!is_dir($carpeta_archivos)) {
                    mkdir($carpeta_archivos, 0755, true);
                }

                // debuguear($carpeta_archivos);

                // Generar un nombre único para el archivo PDF
                // $nombre_archivo = md5(uniqid(rand(), true));
                $nombre_archivo = "Temporada ". $_POST['fecha_memoria'];
                $_POST['documento'] = $nombre_archivo;
                // debuguear($nombre_archivo);
                // Mueve el archivo PDF al servidor
                move_uploaded_file($_FILES['file']['tmp_name'], $carpeta_archivos . '/' . $nombre_archivo . '.pdf');

                // Asigno valores del post al objeto documento
                $documento->documento = $_POST['documento'];
                $documento->fecha = $_POST['fecha_memoria'];

                // debuguear($documento);

                $alertas = $documento->validar_memoria();
                // debuguear($alertas);

                //Guardar el registro
                if (empty($alertas)) {
                    //Funcion para descargar el pdf con ciertos cambios (el nombre)
                    // $documento->descargar_memoria($nombre_archivo);

                    //Guardar en la base de datos:
                    $resultado = $documento->guardar();

                    if ($resultado) {
                        sleep(1.5);
                        header('Location: /admin/dashboard/memoria');
                    }
                }
            }
            // debuguear($documento);
        }

        // Render a la vista 
        $router->render('/admin/dashboard/añadir-memoria', [
            'titulo' => 'Subir Memoria Económica',
            'alertas' => $alertas,
            'documento' => $documento,
            'nombre_archivo', $nombre_archivo
        ]);
    }

    public static function eliminar_memoria() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);
            $id = $_POST['id'];
            $memoria = Memoria::find($id);

            if(!isset($memoria)) {
                header('Location: /admin/dashboard/memoria');
            }
            
            $resultado = $memoria->eliminar();

            if($resultado) {
                sleep(2);
                header('Location: /admin/dashboard/memoria');
            }
        }
    }
}
