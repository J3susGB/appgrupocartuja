<?php

namespace Controllers;


use DateTime;
use MVC\Router;
use Model\Fotos;
use Model\Turnos;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FotosController {
    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        // creo arrays por meses para almacenar las fotos de los entrenamientos
        $septiembre = [];
        $octubre = [];
        $noviembre = [];
        $diciembre = [];
        $enero = [];
        $febrero = [];
        $marzo = [];
        $abril = [];
        $mayo = [];

        $turnos = Turnos::allTurnos('ASC');

        $septiembre = Fotos::findFotosMes(9);
        $octubre = Fotos::findFotosMes(10);
        $noviembre = Fotos::findFotosMes(11);
        $diciembre = Fotos::findFotosMes(12);
        $enero = Fotos::findFotosMes(1);
        $febrero = Fotos::findFotosMes(2);
        $marzo = Fotos::findFotosMes(3);
        $abril = Fotos::findFotosMes(4);
        $mayo = Fotos::findFotosMes(5);
        // debuguear($enero);

        // Render a la vista 
        $router->render('admin/registrados/fotos', [
            'titulo' => 'Fotos por meses',
            'septiembre' => $septiembre,
            'octubre' => $octubre,
            'noviembre' => $noviembre,
            'diciembre' => $diciembre,
            'enero' => $enero,
            'febrero' => $febrero,
            'marzo' =>$marzo,
            'abril' => $abril,
            'mayo' => $mayo,
            'turnos' => $turnos
        ]);
    }

    public static function index_org(Router $router) {
        if(!is_admin() && !es_organizador()) {
            header('Location: /login');
        }

        // creo arrays por meses para almacenar las fotos de los entrenamientos
        $septiembre = [];
        $octubre = [];
        $noviembre = [];
        $diciembre = [];
        $enero = [];
        $febrero = [];
        $marzo = [];
        $abril = [];
        $mayo = [];

        $turnos = Turnos::allTurnos('ASC');

        $septiembre = Fotos::findFotosMes(9);
        $octubre = Fotos::findFotosMes(10);
        $noviembre = Fotos::findFotosMes(11);
        $diciembre = Fotos::findFotosMes(12);
        $enero = Fotos::findFotosMes(1);
        $febrero = Fotos::findFotosMes(2);
        $marzo = Fotos::findFotosMes(3);
        $abril = Fotos::findFotosMes(4);
        $mayo = Fotos::findFotosMes(5);
        // debuguear($enero);

        // Render a la vista 
        $router->render('organizacion/registrados/fotos-organizacion', [
            'titulo' => 'Fotos por meses',
            'septiembre' => $septiembre,
            'octubre' => $octubre,
            'noviembre' => $noviembre,
            'diciembre' => $diciembre,
            'enero' => $enero,
            'febrero' => $febrero,
            'marzo' =>$marzo,
            'abril' => $abril,
            'mayo' => $mayo,
            'turnos' => $turnos
        ]);
    }

    public static function fotos_dir(Router $router) {
        if(!is_admin() && !es_directivo()) {
            header('Location: /login');
        }

        // creo arrays por meses para almacenar las fotos de los entrenamientos
        $septiembre = [];
        $octubre = [];
        $noviembre = [];
        $diciembre = [];
        $enero = [];
        $febrero = [];
        $marzo = [];
        $abril = [];
        $mayo = [];

        $turnos = Turnos::allTurnos('ASC');

        $septiembre = Fotos::findFotosMes(9);
        $octubre = Fotos::findFotosMes(10);
        $noviembre = Fotos::findFotosMes(11);
        $diciembre = Fotos::findFotosMes(12);
        $enero = Fotos::findFotosMes(1);
        $febrero = Fotos::findFotosMes(2);
        $marzo = Fotos::findFotosMes(3);
        $abril = Fotos::findFotosMes(4);
        $mayo = Fotos::findFotosMes(5);
        // debuguear($enero);

        // Render a la vista 
        $router->render('consultas_direccion/fotos-direccion/index', [
            'titulo' => 'Fotos por meses',
            'septiembre' => $septiembre,
            'octubre' => $octubre,
            'noviembre' => $noviembre,
            'diciembre' => $diciembre,
            'enero' => $enero,
            'febrero' => $febrero,
            'marzo' =>$marzo,
            'abril' => $abril,
            'mayo' => $mayo,
            'turnos' => $turnos
        ]);
    }

    public static function añadir(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $turnos = Turnos::allTurnos('ASC');
        $fotos = new Fotos;
        // debuguear($turnos);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }

             //Leer imagen:
             if( !empty($_FILES['foto']['tmp_name'])) {
                //Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/entrenamientos';

                //Si la carpeta no existe, la creará
                if( !is_dir($carpeta_imagenes) ) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                //Crea las imágenes
                $nombre_imagen = md5( uniqid( rand(), true ) );

                $manager = new ImageManager(new Driver());

                $imagen_png = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_png->scale(1000,1000);
                
                $imagen_webp = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_webp->scale(1000,800);

                $imagen_avif = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_avif->scale(1000,1000);

                //Agregar el nombre de la imagen al POST:
                $_POST['foto'] = $nombre_imagen;
            }
            // debuguear($_POST);
            $fotos->nombre_foto =$_POST['foto'];

            // Recuperar la fecha de la solicitud POST y convertirla
            $fecha = isset($_POST['dia']) ? $_POST['dia'] : null;
            // Recuperar el mes de la fecha de la solicitud POST
            $mes = date('m', strtotime($fecha)); 
            // Convertir la fecha a formato deseado
            $fecha_convertida = $fecha ? date('d/m/y', strtotime($fecha)) : null;
            //Asigna fecha con nuevo formato al post
            $_POST['dia'] = $fecha_convertida;
            $fotos->fecha = $_POST['dia'];
            $fotos->mes = (int) $mes;

            $fotos->turno = (int) $_POST['turno'];
            // debuguear($fotos);


            $alertas = $fotos->validarFoto();
            // debuguear($alertas);

            //Guardar el registro
            if(empty($alertas)) {
                //Guardar las imágenes:
                $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');

                //Guardar en la base de datos:
                $resultado = $fotos->guardar();

                if( $resultado ) {
                    header('Location: /admin/registrados/fotos');
                }
            }
        }

        // Render a la vista 
        $router->render('admin/registrados/fotos-añadir', [
            'titulo' => 'Fotos de entrenamientos', 
            'alertas' => $alertas,
            'turnos' => $turnos,
            'fotos' => $fotos
        ]);
    }

    public static function añadir_org(Router $router) {

        if(!is_admin() && !es_organizador()) {
            header('Location: /login');
        }

        $alertas = [];
        $turnos = Turnos::allTurnos('ASC');
        $fotos = new Fotos;
        // debuguear($turnos);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin() && !es_organizador()) {
                header('Location: /login');
            }

             //Leer imagen:
             if( !empty($_FILES['foto']['tmp_name'])) {
                //Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/entrenamientos';

                //Si la carpeta no existe, la creará
                if( !is_dir($carpeta_imagenes) ) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                //Crea las imágenes
                $nombre_imagen = md5( uniqid( rand(), true ) );

                $manager = new ImageManager(new Driver());

                $imagen_png = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_png->scale(1000,1000);
                
                $imagen_webp = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_webp->scale(1000,800);

                $imagen_avif = $manager->read( $_FILES['foto']['tmp_name'] );
                $imagen_avif->scale(1000,1000);

                //Agregar el nombre de la imagen al POST:
                $_POST['foto'] = $nombre_imagen;
            }
            // debuguear($_POST);
            $fotos->nombre_foto =$_POST['foto'];

            // Recuperar la fecha de la solicitud POST y convertirla
            $fecha = isset($_POST['dia']) ? $_POST['dia'] : null;
            // Recuperar el mes de la fecha de la solicitud POST
            $mes = date('m', strtotime($fecha)); 
            // Convertir la fecha a formato deseado
            $fecha_convertida = $fecha ? date('d/m/y', strtotime($fecha)) : null;
            //Asigna fecha con nuevo formato al post
            $_POST['dia'] = $fecha_convertida;
            $fotos->fecha = $_POST['dia'];
            $fotos->mes = (int) $mes;

            $fotos->turno = (int) $_POST['turno'];
            // debuguear($fotos);


            $alertas = $fotos->validarFoto();
            // debuguear($alertas);

            //Guardar el registro
            if(empty($alertas)) {
                //Guardar las imágenes:
                $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');

                //Guardar en la base de datos:
                $resultado = $fotos->guardar();

                if( $resultado ) {
                    header('Location: /organizacion/registrados/fotos-organizacion');
                }
            }
        }

        // Render a la vista 
        $router->render('organizacion/registrados/fotos-organizacion-añadir', [
            'titulo' => 'Fotos de entrenamientos', 
            'alertas' => $alertas,
            'turnos' => $turnos,
            'fotos' => $fotos
        ]);
    }

    public static function editar_foto(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero
        // debuguear($id);

        if( !$id ) {
            header('Location: /admin/registrados/fotos');
        }

        //Obtener todos los turnos
        $turnos = Turnos::allTurnos();

        //Obtener el miembro a editar:
        $foto = Fotos::find($id);
        // debuguear($foto);

        //Añado fecha en formato date para la vista
        if (isset($foto->fecha)) {
            $fecha_obj = DateTime::createFromFormat('d/m/y', $foto->fecha);
            if ($fecha_obj) {
                $foto->fecha_formateada = $fecha_obj->format('Y-m-d');
            } else {
                $foto->fecha_formateada = '';
            }
        } else {
            $foto->fecha_formateada = '';
        }

        // debuguear($foto);

        if( !$foto ) {
            header('Location: /admin/registrados/fotos');
        }

        $foto->foto_actual = $foto->nombre_foto;
        // debuguear($foto);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            
            if(!is_admin()) {
                header('Location: /login');
            }

            if( !empty($_FILES['foto']['tmp_name'])) {
                //Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/entrenamientos';

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
            } else {
                $_POST['foto'] = $foto->foto_actual;
            }
            // debuguear($_POST);

            

            if( $foto->fecha_formateada !== $_POST['dia'] ) {
                $foto->fecha_formateada = $_POST['dia'];
            }
            if( $foto->turno !== $_POST['turno'] ) {
                $foto->turno = $_POST['turno'];
            }
            if( $foto->nombre_foto !== $_POST['foto'] ) {
                $foto->nombre_foto = $_POST['foto'];
            }

            // Añado la fecha formateada al campo fecha con el formato deseado
            if (isset($foto->fecha_formateada)) {
                $fecha_obj = DateTime::createFromFormat('Y-m-d', $foto->fecha_formateada);
                if ($fecha_obj) {
                    $foto->fecha = $fecha_obj->format('d/m/y');
                } else {
                    $foto->fecha = '';
                }
            } else {
                $foto->fecha = '';
            }
            
            // debuguear($foto);

            $foto->sincronizar($_POST);
            // debuguear($foto);

            $alertas = $foto->validarFoto();
            // debuguear($alertas);

            if(empty($alertas)) {

                if(isset($nombre_imagen)) {
                    //Guardar las imágenes:
                    $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                    $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
                }
    
                $resultado = $foto->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('Location: /admin/registrados/fotos');
                } 
            } 
        }

        // Render a la vista 
        $router->render('admin/registrados/editar-foto', [
            'titulo' => 'Editar foto', 
            'alertas' => $alertas,
            'turnos' => $turnos,
            'foto' => $foto
        ]);
    }

    public static function editar_foto_org(Router $router) {

        if(!es_organizador()) {
            header('Location: /login');
        }

        $alertas = [];

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero
        // debuguear($id);

        if( !$id ) {
            header('Location: /organizacion/registrados/fotos-organizacion');
        }

        //Obtener todos los turnos
        $turnos = Turnos::allTurnos();

        //Obtener el miembro a editar:
        $foto = Fotos::find($id);
        // debuguear($foto);

        //Añado fecha en formato date para la vista
        if (isset($foto->fecha)) {
            $fecha_obj = DateTime::createFromFormat('d/m/y', $foto->fecha);
            if ($fecha_obj) {
                $foto->fecha_formateada = $fecha_obj->format('Y-m-d');
            } else {
                $foto->fecha_formateada = '';
            }
        } else {
            $foto->fecha_formateada = '';
        }

        // debuguear($foto);

        if( !$foto ) {
            header('Location: /organizacion/registrados/fotos-organizacion');
        }

        $foto->foto_actual = $foto->nombre_foto;
        // debuguear($foto);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            
            if(!is_admin()) {
                header('Location: /login');
            }

            if( !empty($_FILES['foto']['tmp_name'])) {
                //Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/entrenamientos';

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
            } else {
                $_POST['foto'] = $foto->foto_actual;
            }
            // debuguear($_POST);

            

            if( $foto->fecha_formateada !== $_POST['dia'] ) {
                $foto->fecha_formateada = $_POST['dia'];
            }
            if( $foto->turno !== $_POST['turno'] ) {
                $foto->turno = $_POST['turno'];
            }
            if( $foto->nombre_foto !== $_POST['foto'] ) {
                $foto->nombre_foto = $_POST['foto'];
            }

            // Añado la fecha formateada al campo fecha con el formato deseado
            if (isset($foto->fecha_formateada)) {
                $fecha_obj = DateTime::createFromFormat('Y-m-d', $foto->fecha_formateada);
                if ($fecha_obj) {
                    $foto->fecha = $fecha_obj->format('d/m/y');
                } else {
                    $foto->fecha = '';
                }
            } else {
                $foto->fecha = '';
            }
            
            // debuguear($foto);

            $foto->sincronizar($_POST);
            // debuguear($foto);

            $alertas = $foto->validarFoto();
            // debuguear($alertas);

            if(empty($alertas)) {

                if(isset($nombre_imagen)) {
                    //Guardar las imágenes:
                    $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                    $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
                }
    
                $resultado = $foto->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('Location: /organizacion/registrados/fotos-organizacion');
                } 
            } 
        }

        // Render a la vista 
        $router->render('organizacion/registrados/editar-foto_org', [
            'titulo' => 'Editar foto', 
            'alertas' => $alertas,
            'turnos' => $turnos,
            'foto' => $foto
        ]);
    }

    public static function eliminar_foto() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            // debuguear($_POST);
            $id = $_POST['id'];
            $foto = Fotos::find($id);
            // debuguear($foto);

            if(!isset($foto)) {
                header('Location: /admin/registrados/fotos');
            }
            
            $resultado = $foto->eliminar();

            if($resultado) {
                sleep(1.5);
                header('Location: /admin/registrados/fotos');
            }
        }
    }

    public static function eliminar_foto_org() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!es_organizador()) {
                header('Location: /login');
            }

            // debuguear($_POST);
            $id = $_POST['id'];
            $foto = Fotos::find($id);
            // debuguear($foto);

            if(!isset($foto)) {
                header('Location: /organizacion/registrados/fotos-organizacion');
            }
            
            $resultado = $foto->eliminar();

            if($resultado) {
                sleep(1.5);
                header('Location: /organizacion/registrados/fotos-organizacion');
            }
        }
    }
}