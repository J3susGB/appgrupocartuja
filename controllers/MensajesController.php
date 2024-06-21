<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Mensajes;
use Model\MensajesLeidos;

class MensajesController {
    
    public static function index(Router $router) {
        if (!is_admin()) {
            header('Location: /login');
        }

        // Me traigo todos los mensajes almacenados en la base de datos:
        $mensajes = Mensajes::all('DESC');
        // debuguear($plannings);

        // Render a la vista 
        $router->render('/admin/dashboard/mensajes', [
            'titulo' => 'Mensajes',
            'mensajes' => $mensajes
        ]);
    }

    public static function añadir_mensaje(Router $router) {
        if (!is_admin()) {
            header('Location: /login');
            exit;
        }
    
        $alertas = [];
        $mensaje = new Mensajes();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                exit;
            }
    
            // Asigno valores del post al objeto mensaje
            $mensaje->asunto = $_POST['asunto'];
            $mensaje->cuerpo = $_POST['cuerpo'];
    
            $alertas = $mensaje->validar_mensaje();
    
            // Guardar el registro
            if (empty($alertas)) {
                // Guardar en la base de datos
                $resultado = $mensaje->guardar();
                // debuguear($mensaje);

                $mensajes_usuarios = Mensajes::all();
                //  debuguear($mensajes_usuarios);

                
    
                if ($resultado) {
                   
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
                                if (!$resultado_leido) {
                                    error_log('Error: No se pudo guardar mensaje leído para usuario ID: ' . $usuario->id);
                                } else {
                                    error_log('Mensaje leído guardado para usuario ID: ' . $usuario->id);
                                }
                            }
                        } else {
                            $alertas[] = 'No se encontraron usuarios para asignar el mensaje';
                            error_log('Error: No se encontraron usuarios para asignar el mensaje');
                        }
    
                        sleep(1.5);
                        header('Location: /admin/dashboard/mensajes');
                        exit;
                    }
                } else {
                    $alertas[] = 'Error al guardar el mensaje';
                }
            }
        
    
        // Asegurarnos de que $alertas es un array
        if (!is_array($alertas)) {
            $alertas = [];
        }
    
        // Render a la vista
        $router->render('/admin/dashboard/añadir-mensaje', [
            'titulo' => 'Añadir mensaje',
            'alertas' => $alertas,
            'mensaje' => $mensaje,
        ]);
    }

    public static function editar_mensaje(Router $router) {

        if (!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $mensaje = new Mensajes();

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

        // debuguear($id);
        if (!$id) {
            header('Location: /admin/dashboard/mensajes');
        }

        // //Obtener el planning a editar:
        $mensaje = Mensajes::find($id);
        // debuguear($mensaje);

        if (!$mensaje) {
            header('Location: /admin/dashboard/mensajes');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);

            //Asignar valores al objeto $planning
            if($mensaje->asunto !== $_POST['asunto']) {
                $mensaje->asunto = $_POST['asunto'];
            }
            if($mensaje->cuerpo !== $_POST['cuerpo']) {
                $mensaje->cuerpo = $_POST['cuerpo'];
            }
            
            // debuguear($mensaje);

            $alertas = $mensaje->validar_mensaje();

            // debuguear($alertas);

            // //Guardar el registro
            if (empty($alertas)) {

                //Guardar en la base de datos:
                $resultado = $mensaje->guardar();

                if ($resultado) {
                    sleep(1.5);
                    header('Location: /admin/dashboard/mensajes');
                }
            }
        }

        // Render a la vista 
        $router->render('/admin/dashboard/editar-mensaje', [
            'titulo' => 'Editar Mensaje',
            'mensaje' => $mensaje
        ]);
    }

    public static function eliminar_mensaje() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);
            $id = $_POST['id'];
            $mensaje = Mensajes::find($id);

            if(!isset($mensaje)) {
                header('Location: /admin/dashboard/mensajes');
            }
            // debuguear($mensaje);
            
            $resultado = $mensaje->eliminar();

            if($resultado) {
                sleep(2);
                header('Location: /admin/dashboard/mensajes');
            }
        }
    }
}
