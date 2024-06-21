<?php

namespace Controllers;

use Model\Pdf;
use MVC\Router;
use Model\Usuario;
use Model\Mensajes;
use Model\MensajesLeidos;

class PlanningController {
    public static function index(Router $router) {
        if (!is_auth()) {
            header('Location: /login');
        }

        if(es_directivo()) {
            header('Location: /login');
        }

        // Me traigo todos los planning almacenados en la base de datos:
        $plannings = Pdf::all('DESC');
        // debuguear($plannings);

        // Render a la vista 
        $router->render('/admin/entrenamientos/index', [
            'titulo' => 'Planing de entrenamientos',
            'plannings' => $plannings
        ]);
    }

    public static function añadir_entrenamiento(Router $router) {
        if (!is_admin()) {
            header('Location: /login');
        }

        $documento = new Pdf;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }

            // Leer archivo PDF:
            if (!empty($_FILES['file']['tmp_name'])) {
                // Crear una carpeta para los archivos PDF
                $carpeta_archivos = '../public/entrenamientos';

                // Si la carpeta no existe, créala
                if (!is_dir($carpeta_archivos)) {
                    mkdir($carpeta_archivos, 0755, true);
                }

                // Generar un nombre único para el archivo PDF
                // $nombre_archivo = md5(uniqid(rand(), true));
                $nombre_archivo = $_POST['numero_plannig'] . ": " . $_POST['fecha_plannig'];
                $_POST['documento'] = $nombre_archivo;

                // Mueve el archivo PDF al servidor
                move_uploaded_file($_FILES['file']['tmp_name'], $carpeta_archivos . '/' . $nombre_archivo . '.pdf');

                // Asigno valores del post al objeto documento
                $documento->documento = $_POST['documento'];
                $documento->nombre = $_POST['numero_plannig'];
                $documento->fecha = $_POST['fecha_plannig'];
                $documento->notas = $_POST['nota'];

                // debuguear($documento);

                $alertas = $documento->validar_pdf();
                // debuguear($alertas);

                //Guardar el registro
                if (empty($alertas)) {
                    //Funcion para descargar el pdf con ciertos cambios (el nombre)
                    $documento->descargar_entrenamiento($nombre_archivo);

                    //Guardar en la base de datos:
                    $resultado = $documento->guardar();

                    if ($resultado) {
                        
                        // Bandera para controlar la creación y envío del mensaje
                        $mensajeEnviado = false;
            
                        // Crear un objeto de la clase Mensajes para que se envíe un mensaje automático de subida de planning
                        $mensaje = new Mensajes();
                        // Asignar valores del post al objeto mensaje
                        $mensaje->asunto = 'Nuevo planning de entrenamientos disponible';
                        $mensaje->cuerpo = 'Hola' . "\n\n" . 'Tienes disponible un nuevo planning de entrenamientos en tu área privada.' . "\n\n" . 'Un saludo.';
            
                        // Guardar el mensaje
                        $resultado2 = $mensaje->guardar();
            
                        if ($resultado2 && !$mensajeEnviado) {
                            // Marcar que el mensaje ha sido enviado
                            $mensajeEnviado = true;
            
                            // Obtener el id del mensaje guardado
                            $mensajes_usuarios = Mensajes::all();
                            $mensaje_id = $mensajes_usuarios[0]->id;
            
                            // Obtener todos los usuarios
                            $usuarios = Usuario::all();
                            if (is_array($usuarios) && !empty($usuarios)) {
                                foreach ($usuarios as $usuario) {
                                    // Crear instancia de MensajesLeidos y asignar valores
                                    $mensajeLeido = new MensajesLeidos([
                                        'usuario_id' => $usuario->id,
                                        'mensaje_id' => $mensaje_id,
                                        'leido' => 0
                                    ]);
            
                                    // Guardar el mensaje en mensajesLeidos
                                    $resultado_leido = $mensajeLeido->guardar();
                                }
                            } else {
                                $alertas[] = 'No se encontraron usuarios para asignar el mensaje';
                                error_log('Error: No se encontraron usuarios para asignar el mensaje');
                            }
                        } else {
                            $alertas[] = 'Error al guardar el mensaje';
                        }
                        
                        sleep(1.5);
                        header('Location: /admin/entrenamientos');
                    }
                }
            }
            // debuguear($documento);
        }

        // Render a la vista 
        $router->render('/admin/entrenamientos/añadir', [
            'titulo' => 'Subir planning de entrenamiento',
            'alertas' => $alertas,
            'documento' => $documento,
            'nombre_archivo', $nombre_archivo
        ]);
    }

    public static function editar_entrenamiento(Router $router) {

        if (!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $planning = new Pdf();

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

        // debuguear($id);
        if (!$id) {
            header('Location: /admin/entrenamientos');
        }

        // //Obtener el planning a editar:
        $planning = Pdf::find($id);
        // debuguear($planning);

        if (!$planning) {
            header('Location: /admin/entrenamientos');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_admin()) {
                header('Location: /login');
            }

            // Leer archivo PDF:
            if (!empty($_FILES['file']['tmp_name'])) {
                // Crear una carpeta para los archivos PDF
                $carpeta_archivos = '../public/entrenamientos';

                // Si la carpeta no existe, créala
                if (!is_dir($carpeta_archivos)) {
                    mkdir($carpeta_archivos, 0755, true);
                }

                // Generar un nombre único para el archivo PDF
                $nombre_archivo = $_POST['numero_plannig'] . ": " . $_POST['fecha_plannig'];
                $_POST['documento'] = $nombre_archivo;

                // Eliminar el archivo PDF antiguo del servidor
                if ($planning->documento) {
                    $archivo_actual = $carpeta_archivos . '/' . $planning->documento . '.pdf';
                    if (file_exists($archivo_actual)) {
                        unlink($archivo_actual);
                    }
                }

                // Mueve el archivo PDF al servidor
                move_uploaded_file($_FILES['file']['tmp_name'], $carpeta_archivos . '/' . $nombre_archivo . '.pdf');
                // debuguear($_POST);
            } else {
                // Si no se ha subido un archivo nuevo, mantén el documento actual
                $_POST['documento'] = $planning->nombre . ": " . $planning->fecha;
            }

            // debuguear($_POST);

            // Asignar valores al objeto $planning
            $planning->documento = $_POST['documento'];
            $planning->nombre = $_POST['numero_plannig'];
            $planning->fecha = $_POST['fecha_plannig'];
            $planning->notas = $_POST['nota'];

            // debuguear($planning);

            $planning->sincronizar($_POST);

            // debuguear($planning);

            // exit;
            $resultado = $planning->guardar();

            if ($resultado) {
                sleep(1.5);
                header('Location: /admin/entrenamientos');
            }
        }

        // debuguear($planning);

        // Render a la vista 
        $router->render('/admin/entrenamientos/editar', [
            'titulo' => 'Editar Planning',
            'planning' => $planning
        ]);
    }

    public static function eliminar_entrenamiento() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);
            $id = $_POST['id'];
            $planning = Pdf::find($id);

            if(!isset($planning)) {
                header('Location: /admin/entrenamientos');
            }
            
            $resultado = $planning->eliminar();

            if($resultado) {
                sleep(2);
                header('Location: /admin/entrenamientos');
            }
        }
    }
}
