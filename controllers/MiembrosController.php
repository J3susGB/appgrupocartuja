<?php

namespace Controllers;

use Model\Pack;
use MVC\Router;
use Classes\Email;
use Classes\Paginacion;
use Model\Usuario;
use Model\Categoria;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Model\Cuentas;

class MiembrosController {
    public static function index(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
            exit();
        }

        // Debug: Verificar el estado de la sesión
        error_log("Sesion admin: " . (isset($_SESSION['admin']) ? $_SESSION['admin'] : 'no establecido'));
        error_log("Sesion organizador: " . (isset($_SESSION['organizador']) ? $_SESSION['organizador'] : 'no establecido'));

        // debuguear($_SESSION);

        //PAGINACIÓN__________________________________________________________________
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/miembros?page=1');
        }

        $registros_por_pagina = 300;

        $total = Usuario::all();
        // Filtra total para eliminar aquellos que sean admin igual a "1"
        $total = array_filter($total, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });

        // debuguear($total);
        $total = count($total);

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/miembros?page=1');
        }
        //______________________________________________________________________________

        $miembros = Usuario::paginar('apellido1', 'apellido2', 'nombre', $registros_por_pagina, $paginacion->offset());
        $categorias = Categoria::all('ASC');
        $packs = Pack::all();

        //PACK:
        // // Filtra los packs para eliminar aquellos que sean especial solo ropa id 5
        // $packs = array_filter($packs, function($pack) {
        //     // Devuelve true para conservar el elemento, false para eliminarlo
        //     return $pack->id !== "5";
        // });

        //MIEMBROS:
        // Filtra los miembros para eliminar aquellos que sean admin igual a "1"
        $miembros = array_filter($miembros, function($miembro) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $miembro->admin !== "1";
        }); 

        // Filtra total para eliminar aquellos que sean directivo igual a "1"
        $miembros = array_filter($miembros, function($miembro) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $miembro->directivo !== "1";
        });

        // debuguear($packs);

        foreach($miembros as $miembro) {
            foreach($packs as $pack) {
                if($miembro->pack_id === $pack->id) {
                    $miembro->pendiente_pagar = intval($pack->precio) - $miembro->abona;
                } 
                // elseif($miembro->pack_id === "2" || $miembro->pack_id === "3") {
                //     $miembro->pendiente_pagar = 90 - $miembro->abona;
                // } elseif($miembro->pack_id === "4") {
                //     $miembro->pendiente_pagar = 130 - $miembro->abona;
                // }elseif($miembro->pack_id === "5") {
                //     $miembro->pendiente_pagar = 40 - $miembro->abona;
                // } 
            }

            $miembro->guardar();
        }  

        // Render a la vista 
        $router->render('admin/miembros/index', [
            'titulo' => 'Miembros del Grupo', 
            'miembros' => $miembros,
            'categorias' => $categorias,
            'packs' => $packs,
            'paginacion' => $paginacion->paginacion(),
            'sesion' => $_SESSION
        ]);
    }

    public static function index_organizacion(Router $router) {

        if(!is_admin() && !es_organizador()) {
            header('Location: /login');
            exit();
        }

        // Debug: Verificar el estado de la sesión
        error_log("Sesion admin: " . (isset($_SESSION['admin']) ? $_SESSION['admin'] : 'no establecido'));
        error_log("Sesion organizador: " . (isset($_SESSION['organizador']) ? $_SESSION['organizador'] : 'no establecido'));

        // debuguear($_SESSION);

        //PAGINACIÓN__________________________________________________________________
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /organizacion/miembros?page=1');
        }

        $registros_por_pagina = 200;

        $total = Usuario::all();
        // Filtra total para eliminar aquellos que sean admin igual a "1"
        $total = array_filter($total, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });
        // Filtra total para eliminar aquellos que sean directivo igual a "1"
        $total = array_filter($total, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->directivo !== "1";
        });
        $total = count($total);

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /organizacion/miembros?page=1');
        }
        //______________________________________________________________________________

        $miembros = Usuario::paginar('apellido1', 'apellido2', 'nombre', $registros_por_pagina, $paginacion->offset());
        $categorias = Categoria::all('ASC');
        $packs = Pack::all();

        //MIEMBROS:
        // Filtra los miembros para eliminar aquellos que sean admin igual a "1"
        $miembros = array_filter($miembros, function($miembro) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $miembro->admin !== "1";
        }); 
        // Filtra total para eliminar aquellos que sean directivo igual a "1"
        $miembros = array_filter($miembros, function($miembro) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $miembro->directivo !== "1";
        });


        foreach($miembros as $miembro) {
            foreach($packs as $pack) {
                if($miembro->pack_id === $pack->id) {
                    $miembro->pendiente_pagar = intval($pack->precio) - $miembro->abona;
                } 
                // elseif($miembro->pack_id === "2" || $miembro->pack_id === "3") {
                //     $miembro->pendiente_pagar = 90 - $miembro->abona;
                // } elseif($miembro->pack_id === "4") {
                //     $miembro->pendiente_pagar = 130 - $miembro->abona;
                // }elseif($miembro->pack_id === "5") {
                //     $miembro->pendiente_pagar = 40 - $miembro->abona;
                // } 
            }

            $miembro->guardar();
        } 

        // Render a la vista 
        $router->render('organizacion/miembros/index', [
            'titulo' => 'Miembros del Grupo', 
            'miembros' => $miembros,
            'categorias' => $categorias,
            'packs' => $packs,
            'paginacion' => $paginacion->paginacion(),
            'sesion' => $_SESSION
        ]);
    }

    public static function crear(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $miembro = new Usuario;
        $categorias = Categoria::all('ASC');
        $packs = Pack::all('ASC');

        // Filtra los packs para eliminar aquellos que sean especial solo ropa id 5
        // $packs = array_filter($packs, function($pack) {
        //     // Devuelve true para conservar el elemento, false para eliminarlo
        //     return $pack->id !== "5";
        // });
        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
            
            $categorias = new Categoria($_POST['categoria_id']);
            $categoria_id = intval($_POST['usuarios']['categoria_id']);
            $miembro->categoria_id = $categoria_id;

            $packs = new Pack($_POST['pack_id']);
            $pack_id = intval($_POST['usuarios']['pack_id']);
            $miembro->pack_id = $pack_id;

            //Leer imagen:
            if( !empty($_FILES['foto']['tmp_name'])) {
                //Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/miembros';

                //Si la carpeta no existe, la creará
                if( !is_dir($carpeta_imagenes) ) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                //Crea las imágenes
                $nombre_imagen = md5( uniqid( rand(), true ) );

                $manager = new ImageManager(new Driver());

                $imagen_png = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_png->scale(800,800);
                
                $imagen_webp = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_webp->scale(800,800);

                $imagen_avif = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_avif->scale(800,800);

                //Agregar el nombre de la imagen al POST:
                $_POST['foto'] = $nombre_imagen;
            }

            //Sincronizar con el post:
            $miembro->sincronizar($_POST);

            //Validar:
            $alertas = $miembro->validar_cuenta();
            
            //Guardar el registro
            if(empty($alertas)) {
                //Guardar las imágenes:
                $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');

                //Comprobar si el usuario ya está registrado:
                $existeUsuario = Usuario::where('email', $miembro->email);

                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $miembro->hashPassword();

                    // Eliminar password2
                    unset($miembro->password2);

                    // Generar el Token
                    $miembro->crearToken();
                    
                    //Guardar en la base de datos:
                    $resultado = $miembro->guardar();

                    // Enviar email
                    $email = new Email($miembro->email, $miembro->nombre, $miembro->token);
                    $email->enviarConfirmacion();

                    if( $resultado ) {
                        header('Location: /admin/miembros');
                    }
                }
            }    
        } 
        // debuguear($categorias);

        // Render a la vista 
        $router->render('admin/miembros/crear', [
            'titulo' => 'Registrar miembro',
            'alertas' => $alertas,
            'miembro' => $miembro,
            'categorias' => $categorias,
            'packs' => $packs
        ]);
    }

    public static function editar(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }
    
        $alertas = [];
        $categoria = Categoria::all();
        $packs = Pack::all('ASC');
        $miembro = new Usuario;
    
        // Validar el id:
        $id = $_GET['id']; // Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); // Validar que este id siempre sea un número entero
    
        if( !$id ) {
            header('Location: /admin/miembros');
        }
    
        // Obtener el miembro a editar:
        $miembro = Usuario::find($id);
    
        if( !$miembro ) {
            header('Location: /admin/miembros');
        }
    
        $miembro->foto_actual = $miembro->foto;
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_admin()) {
                header('Location: /login');
            }
    
            if( !empty($_FILES['foto']['tmp_name'])) {
                // Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/miembros';
    
                // Si la carpeta no existe, la creará
                if( !is_dir($carpeta_imagenes) ) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
    
                // Crear el nombre de la nueva imagen
                $nombre_imagen = md5( uniqid( rand(), true ) );
    
                $manager = new ImageManager(new Driver());
    
                $imagen_png = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_png->scale(800,800);
                
                $imagen_webp = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_webp->scale(800,800);
    
                $imagen_avif = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_avif->scale(800,800);
    
                // Eliminar la foto antigua del servidor
                if($miembro->foto_actual) {
                    $foto_actual = $miembro->foto_actual;
                    $formatos = ['png', 'webp', 'avif'];
                    foreach($formatos as $formato) {
                        $archivo = $carpeta_imagenes . '/' . $foto_actual . '.' . $formato;
                        if(file_exists($archivo)) {
                            unlink($archivo);
                        }
                    }
                }
    
                // Agregar el nombre de la imagen al POST
                $_POST['foto'] = $nombre_imagen;
            } else {
                $_POST['foto'] = $miembro->foto_actual;
            }

            // debuguear($_POST);

            if($_POST['abona']) {
                $miembro->abona = $miembro->abona + $_POST['abona'];
                $miembro->pendiente_pagar = $miembro->pendiente_pagar - $_POST['abona'];
        
                // Crear nuevo objeto del tipo cuentas para registrar el ingreso (abona) automáticamente en las cuentas
                $cuentas = new Cuentas;
        
                // Traer todos los registros de cuentas para sacar el balance actual
                $cuentas_all = Cuentas::all('ASC');
        
                // Acceder al último objeto de cuentas_all (donde estará almacenado el balance actual)
                $ultimo_objeto = end($cuentas_all);
        
                // Dar el valor del campo balance de ultimo_objeto a una variable que creo llamada balance_actual
                $balance_actual = (float)$ultimo_objeto->balance;
        
                // Asignar los valores al objeto $cuentas
                $cuentas->concepto = "Cuota " . $miembro->nombre . " " . $miembro->apellido1 . " " . $miembro->apellido2;
                $cuentas->ingreso = $_POST['abona'];
                $cuentas->balance = $balance_actual + $cuentas->ingreso;
        
                $_POST['abona'] = $miembro->abona;
            }
    
            if( $miembro->nombre !== $_POST['nombre'] ) {
                $miembro->nombre = $_POST['nombre'];
            }
            if( $miembro->apellido1 !== $_POST['apellido1'] ) {
                $miembro->apellido1 = $_POST['apellido1'];
            }
            if( $miembro->apellido2 !== $_POST['apellido2'] ) {
                $miembro->apellido2 = $_POST['apellido2'];
            }
            if( $miembro->categoria_id !== $_POST["usuarios"]["categoria_id"] ) {
                $miembro->categoria_id = $_POST["usuarios"]["categoria_id"];
            }
            if( $miembro->pack_id !== $_POST["usuarios"]["pack_id"] ) {
                $miembro->pack_id = $_POST["usuarios"]["pack_id"];
            }
            if( $miembro->telefono !== $_POST['telefono'] ) {
                $miembro->telefono = $_POST['telefono'];
            }
            if( $miembro->email !== $_POST['email'] ) {
                $miembro->email = $_POST['email'];
            }
    
            $miembro->sincronizar($_POST);
    
            $alertas = $miembro->validar_edicion();
    
            if(empty($alertas)) {
    
                if(isset($nombre_imagen)) {
                    // Guardar las imágenes
                    $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                    $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
                }

                // debuguear($_POST);
    
                if($_POST['abona']) {

                    $resultado2 = $cuentas->guardar();
                }

                $resultado = $miembro->guardar();
    
                if( $resultado || $resultado2 ) {
                    sleep(1.5);
                    header('Location: /admin/miembros');
                } 
            } 
        }
    
        // Render a la vista 
        $router->render('admin/miembros/editar', [
            'titulo' => 'Editar miembro',
            'alertas' => $alertas,
            'miembro' => $miembro,
            'categoria' => $categoria,
            'packs' => $packs
        ]);
    }
    

    // public static function editar(Router $router) {

    //     if(!is_admin()) {
    //         header('Location: /login');
    //     }

    //     $alertas = [];
    //     $categoria = Categoria::all();
    //     $packs = Pack::all('ASC');
    //     $miembro = new Usuario;

    //     //Validar el id:
    //     $id = $_GET['id']; //Leer el id de la url
    //     $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

    //     if( !$id ) {
    //         header('Location: /admin/miembros');
    //     }

    //     //Obtener el miembro a editar:
    //     $miembro = Usuario::find($id);

    //     if( !$miembro ) {
    //         header('Location: /admin/miembros');
    //     }

    //     $miembro->foto_actual = $miembro->foto;
    //     // debuguear($miembro);

    //     if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
    //         if(!is_admin()) {
    //             header('Location: /login');
    //         }

    //         if( !empty($_FILES['foto']['tmp_name'])) {
    //             //Crear una carpeta para las imágenes
    //             $carpeta_imagenes = '../public/img/miembros';

    //             //Si la carpeta no existe, la creará
    //             if( !is_dir($carpeta_imagenes) ) {
    //                 mkdir($carpeta_imagenes, 0755, true);
    //             }

    //             //Crea las imágenes
    //             $nombre_imagen = md5( uniqid( rand(), true ) );

    //             $manager = new ImageManager(new Driver());

    //             $imagen_png = $manager->read( $_FILES['foto']['tmp_name'] );
    //             $imagen_png->scale(800,800);
                
    //             $imagen_webp = $manager->read( $_FILES['foto']['tmp_name'] );
    //             $imagen_webp->scale(800,800);

    //             $imagen_avif = $manager->read( $_FILES['foto']['tmp_name'] );
    //             $imagen_avif->scale(800,800);

    //             //Agregar el nombre de la imagen al POST:
    //             $_POST['foto'] = $nombre_imagen;
    //         } else {
    //             $_POST['foto'] = $miembro->imagen_actual;
    //         }

    //         $miembro->abona = $miembro->abona + $_POST['abona'];
    //         $miembro->pendiente_pagar = $miembro->pendiente_pagar - $_POST['abona'];
    //         // $_POST['abona'] = $miembro->abona;

    //         //Creo nuevo objeto del tipo cuentas para registrar el ingreso (abona) automáticamente en las cuentas
    //         $cuentas = new Cuentas;

    //         //Me traigo todos los registros de cuentas para sacar el balance actual
    //         $cuentas_all = Cuentas::all('ASC');

    //         //Accedo al último objeto de cuentas_all (donde estará almacenado el balance actual)
    //         $ultimo_objeto = end($cuentas_all);

    //         //Doy el valor del campo balance de ultimo_objeto a una variable que creo llamada balance_actual
    //         $balance_actual = (float)$ultimo_objeto->balance;
    //         // debuguear($balance_actual);

    //         //Asigno los valores al objeto $cuentas
    //         $cuentas->concepto = "Cuota " . $miembro->nombre . " " . $miembro->apellido1 . " " . $miembro->apellido2;
    //         $cuentas->ingreso = $_POST['abona'];
    //         $cuentas->balance = $balance_actual + $cuentas->ingreso;

    //         $_POST['abona'] = $miembro->abona;

    //         // debuguear($miembro);
    //         // debuguear($cuentas);

    //         // debuguear($_POST);

    //         if( $miembro->nombre !== $_POST['nombre'] ) {
    //             $miembro->nombre = $_POST['nombre'];
    //         }
    //         if( $miembro->apellido1 !== $_POST['apellido1'] ) {
    //             $miembro->apellido1 = $_POST['apellido1'];
    //         }
    //         if( $miembro->apellido2 !== $_POST['apellido2'] ) {
    //             $miembro->apellido2 = $_POST['apellido2'];
    //         }
    //         if( $miembro->categoria_id !== $_POST["usuarios"]["categoria_id"] ) {
    //             $miembro->categoria_id = $_POST["usuarios"]["categoria_id"];
    //         }
    //         if( $miembro->pack_id !== $_POST["usuarios"]["pack_id"] ) {
    //             $miembro->pack_id = $_POST["usuarios"]["pack_id"];
    //         }
    //         if( $miembro->telefono !== $_POST['telefono'] ) {
    //             $miembro->telefono = $_POST['telefono'];
    //         }
    //         if( $miembro->email !== $_POST['email'] ) {
    //             $miembro->email = $_POST['email'];
    //         }


    //         $miembro->sincronizar($_POST);

    //         // $miembro->nombre = $_POST['nombre'];
    //         // $miembro->apellido1 = $_POST['apellido1'];
    //         // $miembro->apellido2 = $_POST['apellido2'];
    //         // $miembro->categoria_id = $_POST['categoria_id'];
    //         // $miembro->pack_id = $_POST['pack_id'];
    //         // $miembro->telefono = $_POST['telefono'];
    //         // $miembro->email = $_POST['email'];
            
    //         // $miembro->abona = $miembro->abona + $_POST['abona'];
    //         // $miembro->pendiente_pagar = $miembro->pendiente_pagar - $_POST['abona'];
    //         // debuguear($miembro);

    //         $alertas = $miembro->validar_edicion();
    //         // debuguear($alertas);

    //         if(empty($alertas)) {

    //             if(isset($nombre_imagen)) {
    //                 //Guardar las imágenes:
    //                 $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
    //                 $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
    //                 $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
    //             }
    
    //             $resultado = $miembro->guardar();
    //             $resultado2 = $cuentas->guardar();

    //             if( $resultado && $resultado2 ) {
    //                 sleep(2);
    //                 header('Location: /admin/miembros');
    //             } 
    //         } 
    //     }

    //     // Render a la vista 
    //     $router->render('admin/miembros/editar', [
    //         'titulo' => 'Editar miembro',
    //         'alertas' => $alertas,
    //         'miembro' => $miembro,
    //         'categoria' => $categoria,
    //         'packs' => $packs
    //     ]);
    // }

    public static function eliminar() {
        if(!is_admin()) {
            header('Location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $miembro = Usuario::find($id);

            if(!isset($miembro)) {
                header('Location: /admin/miembros');
            }
            
            $resultado = $miembro->eliminar();

            if($resultado) {
                sleep(2);
                header('Location: /admin/miembros');
            }
        }
    }
}