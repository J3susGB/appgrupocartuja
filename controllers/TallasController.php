<?php

namespace Controllers;

use Model\Tallas;
use Model\Tallasusuarios;
use Model\Usuario;
use MVC\Router;

class TallasController {

    public static function index(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $tallasUsuarios = Tallasusuarios::all('ASC');
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });

        $tallas = Tallas::all('ASC');

        foreach($tallasUsuarios as $x) {
            foreach($miembros as $miembro) {
                if($x->id_usuario === $miembro->id) {
                    $x->apellido1 = $miembro->apellido1;
                    $x->apellido2 = $miembro->apellido2;
                    $x->nombre = $miembro->nombre;
                }
            }
        }

        foreach($tallasUsuarios as $talla) {
            foreach($tallas as $t) {
                if($t->id === $talla->camiseta) {
                    $talla->nombre_talla_camiseta = $t->nombre_talla;
                }
                if($t->id === $talla->calzona) {
                    $talla->nombre_talla_calzona = $t->nombre_talla;
                }
                if($t->id === $talla->chandal) {
                    $talla->nombre_talla_chandal = $t->nombre_talla;
                }
                if($t->id === $talla->Cortavientos) {
                    $talla->nombre_talla_cortavientos = $t->nombre_talla;
                }
            }
        }

        // debuguear($tallasUsuarios);

        // Render a la vista 
        $router->render('admin/miembros/tallas', [
            'titulo' => 'Tallas',
            'tallas' => $tallas,
            'tallasUsuarios' => $tallasUsuarios,
            'miembros' => $miembros
        ]);
    }

    public static function añadir(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }
        
        $alertas = [];
        $miembros = Usuario::all();
        // Filtra miembros para eliminar aquellos que sean administradores o directivos
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        // Filtra miembros para eliminar aquellos que sean pack entrenos y entrenos + cenas
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->pack_id !== "1" && $tot->pack_id !== '2';
        });
        // debuguear($miembros);

        // //Obtener todas las tallas
        $tallas_disponibles = Tallas::all('ASC');
        // debuguear($tallas);

        // //Obtener todas los usuarios que tienen talla establecida:
        $tallas = Tallasusuarios::all();
        // debuguear($tallas);

        // Crear un array de ids de usuarios que ya tienen tallas
        $tallas_ids = array_map(function($talla) {
            return $talla->id_usuario;
        }, $tallas);

        // Filtrar los miembros que no tienen tallas
        $miembros_sin_tallas = array_filter($miembros, function($miembro) use ($tallas_ids) {
            return !in_array($miembro->id, $tallas_ids);
        });

        // Reindexar el array de miembros
        $miembros_sin_tallas = array_values($miembros_sin_tallas);

        // debuguear($miembros_sin_tallas);
        
        // if( !$miembros ) {
        //     header('Location: /admin/miembros');
        // }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);
        
            //Creo objeto tallasusuario para almacenar la información del post:
            $talla_usuario = new Tallasusuarios();

            //Cruzo los datos del post con el nuevo objeto talla_usuario:
            $talla_usuario->camiseta = $_POST['camiseta'];
            $talla_usuario->calzona = $_POST['calzona'];
            $talla_usuario->chandal = $_POST['chandal'];
            $talla_usuario->Cortavientos = $_POST['cortavientos'];
            $talla_usuario->id_usuario = $_POST['usuario'];

            // debuguear($talla_usuario);

            $alertas = $talla_usuario->validar_añadir_talla();
            // debuguear($alertas);

            //Guardar el registro
            if(empty($alertas)) {
                $resultado = $talla_usuario->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('Location: /admin/miembros/tallas');
                } 
            }
        }
        
        // Render a la vista 
        $router->render('admin/miembros/añadir-talla', [
            'titulo' => 'Añadir talla',
            'alertas' => $alertas,
            'miembros_sin_tallas' => $miembros_sin_tallas,
            'tallas_disponibles' => $tallas_disponibles
        ]);
    }

    public static function editar(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }
        
        $alertas = [];
        $miembro = new Tallasusuarios;
        
        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero
        
        // debuguear($id);
        if( !$id ) {
            header('Location: /admin/miembros');
        }
        
        //Obtener el miembro a editar:
        $miembro = Tallasusuarios::find_registro_talla($id);
        // debuguear($miembro);

        //Obtener resultado para cruzar datos:
        $usuario = Usuario::find($id);

        //Obtener todas las tallas:
        $tallas = Tallas::all('ASC');
        // debuguear($tallas);

        //Cruzar datos entre objetos:
        $miembro->apellido1 = $usuario->apellido1;
        $miembro->apellido2 = $usuario->apellido2;
        $miembro->nombre = $usuario->nombre;
        
        foreach($tallas as $talla) {
            if($talla->id === $miembro->camiseta) {
                $miembro->nombre_talla_camiseta = $talla->nombre_talla;
            }
            if($talla->id === $miembro->calzona) {
                $miembro->nombre_talla_calzona = $talla->nombre_talla;
            }
            if($talla->id === $miembro->chandal) {
                $miembro->nombre_talla_chandal = $talla->nombre_talla;
            }
            if($talla->id === $miembro->Cortavientos) {
                $miembro->nombre_talla_cortavientos = $talla->nombre_talla;
            }
        }
        
        // debuguear($miembro);

        
        if( !$miembro || !$usuario ) {
            header('Location: /admin/miembros');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_admin()) {
                header('Location: /login');
            }

            if( $miembro->camiseta !== $_POST['camiseta'] ) {
                $miembro->camiseta = $_POST['camiseta'];
            }
            if( $miembro->calzona !== $_POST['calzona'] ) {
                $miembro->calzona = $_POST['calzona'];
            }
            if( $miembro->chandal !== $_POST['chandal'] ) {
                $miembro->chandal = $_POST['chandal'];
            }
            if( $miembro->Cortavientos !== $_POST["cortavientos"] ) {
                $miembro->Cortavientos = $_POST["cortavientos"];
            }
        
            $miembro->sincronizar($_POST);

            // debuguear($miembro);

            $resultado = $miembro->guardar();
        
            if( $resultado ) {
                sleep(2);
                header('Location: /admin/miembros/tallas');
            } 
        }
        
        // Render a la vista 
        $router->render('admin/miembros/editar-talla', [
            'titulo' => 'Editar talla',
            'alertas' => $alertas,
            'miembro' => $miembro,
            'tallas' => $tallas
        ]);
    }

    public static function eliminar() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);
            $id = $_POST['id'];
            $miembro = Usuario::find($id);
            // debuguear($miembro);

            $talla_usuario = Tallasusuarios::find_registro_talla($miembro->id);
            // debuguear($talla_usuario);

            if(!isset($talla_usuario)) {
                header('Location: /admin/miembros/tallas');
            }
            
            $resultado = $talla_usuario->eliminar();

            if($resultado) {
                header('Location: /admin/miembros/tallas');
            }
        }
    }
}