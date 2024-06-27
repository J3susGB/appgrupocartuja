<?php

namespace Controllers;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use stdClass;
use MVC\Router;
use Model\Usuario;
use Model\Asistencia;
use Model\Categoria;
use Model\Fotos;
use Model\Mensajes;
use Model\MensajesLeidos;
use Model\Pack;
use Model\Pdf;
use Model\Tallas;
use Model\Tallasusuarios;
use Model\Turnos;

class PaginasController {

    public static function index(Router $router) {
    
        //Router a la vista
        $router->render('paginas/index', [
            'titulo' => 'Inicio'
        ]);
    }

    public static function nosotros(Router $router) {
    
        //Router a la vista
        $router->render('paginas/nosotros', [
            'titulo' => 'Sobre nosotros'
        ]);
    }

    public static function packs(Router $router) {
        $packs = Pack::all();

        //Router a la vista
        $router->render('paginas/packs', [
            'titulo' => 'Nuestros packs',
            'packs' => $packs
        ]);
    }

    public static function patrocinadores(Router $router) {
    
        //Router a la vista
        $router->render('paginas/patrocinadores', [
            'titulo' => 'Nuestros patrocinadores'
        ]);
    }

    public static function area_privada(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
        }
        if(es_directivo()) {
            header('Location: /login');
        }
    
        $packs = Pack::all();
        $categorias = Categoria::all();
        $tallas = Tallas::all();
        $tallas_usuario = Tallasusuarios::all();
        $asistencia = Asistencia::allAsistencia();
    
        $asistencia = array_filter($asistencia, function($tot) {
            return $tot->id_usuario === $_SESSION['id'];
        });
    
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            return $tot->admin !== "1";
        });
    
        foreach($miembros as $miembro) {
            $miembro->idCamiseta = null;
            $miembro->idCalzona = null;
            $miembro->idChandal = null;
            $miembro->idCortaviento = null;
    
            foreach($tallas_usuario as $registro) {
                if($miembro->id === $registro->id_usuario) {
                    $miembro->idCamiseta = $registro->camiseta;
                    $miembro->idCalzona = $registro->calzona;
                    $miembro->idChandal = $registro->chandal;
                    $miembro->idCortaviento = $registro->Cortavientos;
                }
            }
        }
    
        foreach($miembros as $miembro) {
            foreach($tallas as $talla) {
                if($miembro->idCamiseta === $talla->id) {
                    $miembro->talla_camiseta = $talla->nombre_talla;
                }
                if($miembro->idCalzona === $talla->id) {
                    $miembro->talla_calzona = $talla->nombre_talla;
                }
                if($miembro->idChandal === $talla->id) {
                    $miembro->talla_chandal = $talla->nombre_talla;
                }
                if($miembro->idCortaviento === $talla->id) {
                    $miembro->talla_cortavientos = $talla->nombre_talla;
                }
            }
        }
    
        foreach($miembros as $miembro) {
            foreach($categorias as $categoria) {
                if($miembro->categoria_id === $categoria->id) {
                    $miembro->nombre_categoria = $categoria->nombre_cat;
                }
            }
        }
    
        foreach($miembros as $miembro) {
            foreach($packs as $pack) {
                if($miembro->pack_id === $pack->id) {
                    $miembro->nombre_pack = $pack->nombre_pack;
                    $miembro->precio_pack = $pack->precio;
                }
            }
        }
    
        $miembros = array_filter($miembros, function($tot) {
            return $tot->id === $_SESSION['id'];
        });
    
        foreach($asistencia as $as) {
            foreach($miembros as $mi) {
                if($as->id_usuario === $mi->id) {
                    $as->apellidos_nombre = $mi->apellido1 . " " . $mi->apellido2 . " " . $mi->nombre;
                }
            }
        }
    
        foreach ($asistencia as $as) {
            $fecha_original = $as->fecha;
            $fecha_formateada = date("y-m-d", strtotime(str_replace('/', '-', $fecha_original)));
            $as->fecha_formateada = $fecha_formateada;
        }
    
        foreach($asistencia as $as) {
            if($as->fecha_formateada) {
                $mes = date('m', strtotime($as->fecha_formateada));
                $as->mes = $mes;
            }
        }

        // debuguear($miembros);
    
        $router->render('paginas/area_privada', [
            'titulo' => 'Área privada',
            'asistencia' => $asistencia,
            'miembros' => $miembros
        ]);
    }

    public static function area_privada_editar(Router $router) {
    
        if (!is_auth()) {
            header('Location: /login');
        }
    
        if (es_directivo()) {
            header('Location: /');
        }
    
        $alertas = [];
        $id = s($_GET['id']);
    
        if ($id !== $_SESSION['id']) {
            header('Location: /login');
        }
    
        // Traigo todos los datos de packs
        $packs = Pack::all();
        // Traigo todos los datos categorias
        $categorias = Categoria::all();
        // Traigo todas las tallas
        $tallas = Tallas::all();
        // Traigo los registros de tallas del usuario autenticado
        $tallas_usuario = Tallasusuarios::all();
        // Traigo todos los registros de asistencia
        $asistencia = Asistencia::allAsistencia();
    
        // Filtrar la asistencia del usuario autenticado
        $asistencia = array_filter($asistencia, function($tot) {
            return $tot->id_usuario === $_SESSION['id'];
        });
    
        // Traigo todos los miembros diferentes a administradores
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            return $tot->admin !== "1";
        });
    
        if ($tallas_usuario) {
            // Inicializar las propiedades de tallas en los miembros
            foreach ($miembros as $miembro) {
                $miembro->idCamiseta = null;
                $miembro->idCalzona = null;
                $miembro->idChandal = null;
                $miembro->idCortaviento = null;
            }
    
            // Cruzar los datos de miembros y tallas usuarios para agregar a cada miembro sus tallas
            foreach ($miembros as $miembro) {
                foreach ($tallas_usuario as $registro) {
                    if ($miembro->id === $registro->id_usuario) {
                        $miembro->idCamiseta = $registro->camiseta;
                        $miembro->idCalzona = $registro->calzona;
                        $miembro->idChandal = $registro->chandal;
                        $miembro->idCortaviento = $registro->Cortavientos;
                    }
                }
            }
    
            // Cruzar los datos de miembros y tallas para agregar a miembros el nombre de la talla
            foreach ($miembros as $miembro) {
                foreach ($tallas as $talla) {
                    if ($miembro->idCamiseta === $talla->id) {
                        $miembro->talla_camiseta = $talla->nombre_talla;
                    }
                    if ($miembro->idCalzona === $talla->id) {
                        $miembro->talla_calzona = $talla->nombre_talla;
                    }
                    if ($miembro->idChandal === $talla->id) {
                        $miembro->talla_chandal = $talla->nombre_talla;
                    }
                    if ($miembro->idCortaviento === $talla->id) {
                        $miembro->talla_cortavientos = $talla->nombre_talla;
                    }
                }
            }
        }
    
        // Cruzar los miembros con las categorías para añadir a miembros el nombre de la categoría
        foreach ($miembros as $miembro) {
            foreach ($categorias as $categoria) {
                if ($miembro->categoria_id === $categoria->id) {
                    $miembro->nombre_categoria = $categoria->nombre_cat;
                }
            }
        }
    
        // Cruzar los miembros con el pack para añadir a miembros el nombre del pack
        foreach ($miembros as $miembro) {
            foreach ($packs as $pack) {
                if ($miembro->pack_id === $pack->id) {
                    $miembro->nombre_pack = $pack->nombre_pack;
                    $miembro->precio_pack = $pack->precio;
                }
            }
        }
    
        // Traer todos los datos del usuario autenticado
        $miembros = array_filter($miembros, function($tot) {
            return $tot->id === $_SESSION['id'];
        });
    
        // Añadir campo foto_actual
        foreach ($miembros as $miembro) {
            $miembro->foto_actual = $miembro->foto;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if (!is_auth()) {
                header('Location: /login');
            }
    
            // Obtener el miembro a editar:
            $miembro = Usuario::find($_SESSION['id']);
            $tallas_miembro = Tallasusuarios::find_registro_talla($_SESSION['id']);
    
            if ($tallas_miembro === null) {
                $tallas_miembro = new Tallasusuarios();
                $tallas_miembro->id_usuario = $_SESSION['id'];
            }
    
            if (!empty($_FILES['foto']['tmp_name'])) {
                // Crear una carpeta para las imágenes
                $carpeta_imagenes = '../public/img/miembros';
    
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
    
                // Crear las imágenes
                $nombre_imagen = md5(uniqid(rand(), true));
    
                $manager = new ImageManager(new Driver());
    
                $imagen_png = $manager->read($_FILES['foto']['tmp_name']);
                $imagen_png->scale(800, 800);
    
                $imagen_webp = $manager->read($_FILES['foto']['tmp_name']);
                $imagen_webp->scale(800, 800);
    
                $imagen_avif = $manager->read($_FILES['foto']['tmp_name']);
                $imagen_avif->scale(800, 800);
    
                // Eliminar la foto antigua del servidor
                if ($miembro->foto_actual) {
                    $foto_actual = $miembro->foto_actual;
                    $formatos = ['png', 'webp', 'avif'];
                    foreach ($formatos as $formato) {
                        $archivo = $carpeta_imagenes . '/' . $foto_actual . '.' . $formato;
                        if (file_exists($archivo)) {
                            unlink($archivo);
                        }
                    }
                }
    
                // Agregar el nombre de la imagen al POST:
                $_POST['foto'] = $nombre_imagen;
            } else {
                $_POST['foto'] = $miembro->foto;
            }
    
            // Sincronizar los datos del miembro
            $miembro->sincronizar($_POST);
    
            // Datos de tallas del usuario
            if ($miembro->pack_id !== "1" && $miembro->pack_id !== "2") {
                if ($tallas_miembro->camiseta !== $_POST['talla_camiseta']) {
                    $tallas_miembro->camiseta = $_POST['talla_camiseta'];
                }
                if ($tallas_miembro->calzona !== $_POST['talla_calzona']) {
                    $tallas_miembro->calzona = $_POST['talla_calzona'];
                }
                if ($tallas_miembro->chandal !== $_POST['talla_chandal']) {
                    $tallas_miembro->chandal = $_POST['talla_chandal'];
                }
                if ($tallas_miembro->Cortavientos !== $_POST['talla_cortavientos']) {
                    $tallas_miembro->Cortavientos = $_POST['talla_cortavientos'];
                }
            }
    
            // Validar datos de usuario y tallas
            $alertas = $miembro->validar_edicion_privada();
    
            if (empty($alertas)) {
    
                if (isset($nombre_imagen)) {
                    // Guardar las imágenes
                    $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                    $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
                }
    
                $resultado = $miembro->guardar();
    
                if ($resultado) {
                    sleep(1.5);
                    header('Location: /area_privada');
                    exit();
                }
            }
        }
    
        // Router a la vista
        $router->render('paginas/area_privada-editar', [
            'titulo' => 'Editar datos de usuario',
            'alertas' => $alertas,
            'miembros' => $miembros,
            'categorias' => $categorias,
            'packs' => $packs,
            'tallas' => $tallas
        ]);
    }
    

    public static function area_privada_editar_talla(Router $router) {
        
        if(!is_auth()) {
            header('Location: /');
        }

        if(es_directivo()) {
            header('Location: /');
        }

        $alertas = [];

        $id = s($_GET['id']);
        // debuguear($_SESSION);

        if($id !== $_SESSION['id']) {
            header('Location: /login');
        }
        //Traigo todos los datos de packs
        $packs = Pack::all();
        // debuguear($packs);

        //Traigo todos los datos categorias
        $categorias = Categoria::all();
        // debuguear($categorias);

        //Traigo todas las tallas
        $tallas = Tallas::all();
        // debuguear($tallas);

        // Traigo los registros de tallas del usuario autenticado
        $tallas_usuario = Tallasusuarios::all();
        // debuguear($tallas_usuario);

        //Traigo todos los registros de asistencia
        $asistencia = Asistencia::allAsistencia();

        // Traigo toda la asistencia del usuario autenticado
        $asistencia = array_filter($asistencia, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->id_usuario === $_SESSION['id'];
        });
        
        // debuguear($asistencia);

        //Traigo todos los miembros diferentes a administradores
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });
        // debuguear($miembros);

        if ($tallas_usuario) {
            //Cruzo los datos de miembros y tallas usuarios para agregar a cada miembro sus tallas
            foreach ($miembros as $miembro) {
                $miembro->idCamiseta = null;
                $miembro->idCalzona = null;
                $miembro->idChandal = null;
                $miembro->idCortaviento = null;

                foreach ($tallas_usuario as $registro) {
                    if ($miembro->id === $registro->id_usuario) {
                        $miembro->idCamiseta = $registro->camiseta;
                        $miembro->idCalzona = $registro->calzona;
                        $miembro->idChandal = $registro->chandal;
                        $miembro->idCortaviento = $registro->Cortavientos;
                    }
                }
            }
            // debuguear($miembros);

            //Cruzo los datos de miembros y tallas para agregar a miemros el nombre de la talla
            foreach ($miembros as $miembro) {
                foreach ($tallas_usuario as $registro) {
                    if ($miembro->id === $registro->id_usuario) {
                        $miembro->idCamiseta = isset($miembro->idCamiseta) ? $miembro->idCamiseta : null;
                        $miembro->idCalzona = isset($miembro->idCalzona) ? $miembro->idCalzona : null;
                        $miembro->idChandal = isset($miembro->idChandal) ? $miembro->idChandal : null;
                        $miembro->idCortaviento = isset($miembro->idCortaviento) ? $miembro->idCortaviento : null;
            
                        $miembro->idCamiseta = $registro->camiseta;
                        $miembro->idCalzona = $registro->calzona;
                        $miembro->idChandal = $registro->chandal;
                        $miembro->idCortaviento = $registro->Cortavientos;
                    }
                }
            }
            // debuguear($tallas_usuario);
        }

         // Cruzo los miembros con las categorías para añadir a miembros el nombre de la categoría
         foreach($miembros as $miembro) {
            foreach($categorias as $categoria) {
                if($miembro->categoria_id === $categoria->id) {
                    $miembro->nombre_categoria = $categoria->nombre_cat;
                }
            }
        }

        // Cruzo los miembros con el pack para añadir a miembros el nombre del pack
        foreach($miembros as $miembro) {
            foreach($packs as $pack) {
                if($miembro->pack_id === $pack->id) {
                    $miembro->nombre_pack = $pack->nombre_pack;
                    $miembro->precio_pack = $pack->precio;
                }
            }
        }
        // debuguear($miembros);

        // Traigo todos los datos del usuario autenticado
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->id === $_SESSION['id'];
        });

        // debuguear($miembros);
        
        // debuguear($miembros);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_auth()) {
                header('Location: /login');
            }

            //Obtener el miembro a editar:
            $miembro = Usuario::find($_SESSION['id']);
            // debuguear($miembro);
            $tallas_miembro = Tallasusuarios::find_registro_talla($_SESSION['id']);
            // debuguear($tallas_miembro);

            if ($tallas_miembro === null) {
                // Si no se encontraron datos de tallas, crear un nuevo objeto Tallasusuarios
                $tallas_miembro = new Tallasusuarios();
                // Asignar el ID del usuario actual
                $tallas_miembro->id_usuario = $_SESSION['id'];
            }


            //Datos de tallas del usuario
            if($miembro->pack_id !== "1" && $miembro->pack_id !== "2") {
                if( $tallas_miembro->camiseta !== $_POST['talla_camiseta'] ) {
                    $tallas_miembro->camiseta = $_POST['talla_camiseta'];
                }
                if( $tallas_miembro->calzona !== $_POST['talla_calzona'] ) {
                    $tallas_miembro->calzona = $_POST['talla_calzona'];
                }
                if( $tallas_miembro->chandal !== $_POST['talla_chandal'] ) {
                    $tallas_miembro->chandal = $_POST['talla_chandal'];
                }
                if( $tallas_miembro->Cortavientos !== $_POST['talla_cortavientos'] ) {
                    $tallas_miembro->Cortavientos = $_POST['talla_cortavientos'];
                }
            } 
            
            // Sincronizar los datos de tallas solo si el pack no es 1 o 2
            if($miembro->pack_id !== "1" && $miembro->pack_id !== "2") {
                $tallas_miembro->sincronizar($_POST);
            }
            // debuguear($miembro);

            // Validar datos de usuario y tallas
            if($miembro->pack_id !== "1" && $miembro->pack_id !== "2") {
                $alertas = $tallas_miembro->validar_tallas();
            } 
            
            // debuguear($alertas);

            if(empty($alertas)) {
    
                $resultado = $tallas_miembro->guardar();

                if( $resultado ) {
                    sleep(2);
                    header('Location: /area_privada');
                    exit();
                } 
            } 
        }

        // debuguear($miembros);
        //Router a la vista
        $router->render('paginas/area_privada-editar_tallas', [
            'titulo' => 'Editar tallas',
            'alertas' => $alertas,
            'miembros' => $miembros,
            'categorias' => $categorias,
            'packs' => $packs,
            'tallas' => $tallas
        ]);
    }

    public static function privada_entrenamientos(Router $router) {
        
        if (!is_auth()) {
            header('Location: /login');
        }

        if(es_directivo()) {
            header('Location: /login');
        }

        // Me traigo todos los planning almacenados en la base de datos:
        $plannings = Pdf::all('DESC');
        // debuguear($plannings);

        //Router a la vista
        $router->render('paginas/area_privada-plannings', [
            'titulo' => 'Plannings de entrenamiento',
            'plannings' => $plannings
        ]);
    }

    public static function area_privada_contraseña(Router $router) {
        
        if(!is_auth()) {
            header('Location: /login');
        }

        if(es_directivo()) {
            header('Location: /');
        }

        $id = s($_GET['id']);
        // debuguear($_SESSION);

        if($id !== $_SESSION['id']) {
            header('Location: /login');
        }

        $alertas = [];
        // Identificar el usuario con este id
        $usuario = Usuario::where('id', $id);
        // debuguear($usuario);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Se ha producido un error inesperado. Por favor, inténtalo de nuevo.');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // debuguear($_POST);
            if(!is_auth()) {
                header('Location: /login');
            }

            // $alertas = $usuario->contraseña_privada();
            // debuguear($alertas);

            //Comprobar si la contraseña plana es igual que la hasheada en la BD
            $contraseña_correcta = password_verify($_POST['password'], $usuario->password );
            // debuguear($contraseña_correcta);

            if($contraseña_correcta) {
                $usuario->sincronizar($_POST);
                // debuguear($usuario);

                $alertas = $usuario->validarPassword();
                // debuguear($alertas);

                if(empty($alertas)) {
                    $usuario->password = $usuario->password2;
                    $usuario->password2 = '';

                    $usuario->hashPassword();

                    // Guardar el usuario en la BD
                    $resultado = $usuario->guardar();

                    if( $resultado) {
                        sleep(1);
                        header('Location: /area_privada');
                    } 
                }
            }   
        }

        //Router a la vista
        $router->render('paginas/area_privada-contraseña', [
            'titulo' => 'Cambiar contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function privada_asistencia(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
        }

        if(es_directivo()) {
            header('Location: /login');
        }

        //Tabla de asistencia general___________________________________________________________

        //Traigo todos los datos de packs
        $packs = Pack::all();
        // debuguear($packs);

        //Traigo todos los datos categorias
        $categorias = Categoria::all();
        // debuguear($categorias);

        //Traigo todas las tallas
        $tallas = Tallas::all();
        // debuguear($tallas);

        // Traigo los registros de tallas del usuario autenticado
        $tallas_usuario = Tallasusuarios::all();
        // debuguear($tallas_usuario);

        //Traigo todos los registros de asistencia
        $asistencia = Asistencia::allAsistencia();

        // Traigo toda la asistencia del usuario autenticado
        $asistencia = array_filter($asistencia, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->id_usuario === $_SESSION['id'];
        });
        
        // debuguear($asistencia);

        //Traigo todos los miembros diferentes a administradores
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });
        // debuguear($miembros);

        //Cruzo los datos de miembros y tallas usuarios para agregar a cada miembro sus tallas
        foreach($miembros as $miembro) {
            $miembro->idCamiseta = null;
            $miembro->idCalzona = null;
            $miembro->idChandal = null;
            $miembro->idCortaviento = null;
            foreach($tallas_usuario as $registro) {
                if($miembro->id === $registro->id_usuario) {
                    $miembro->idCamiseta = $registro->camiseta;
                    $miembro->idCalzona = $registro->calzona;
                    $miembro->idChandal = $registro->chandal;
                    $miembro->idCortaviento = $registro->Cortavientos;
                }
            }
        }
        // debuguear($miembros);

        //Cruzo los datos de miembros y tallas para agregar a miemros el nombre de la talla
        foreach($miembros as $miembro) {
            $miembro->talla_camiseta = null;
            $miembro->talla_calzona = null;
            $miembro->talla_chandal = null;
            $miembro->talla_cortavientos = null;
            foreach($tallas as $talla) {
                if($miembro->idCamiseta === $talla->id) {
                    $miembro->talla_camiseta = $talla->nombre_talla;
                }
                if($miembro->idCalzona === $talla->id) {
                    $miembro->talla_calzona = $talla->nombre_talla;
                }
                if($miembro->idChandal === $talla->id) {
                    $miembro->talla_chandal = $talla->nombre_talla;
                }
                if($miembro->idCortaviento === $talla->id) {
                    $miembro->talla_cortavientos = $talla->nombre_talla;
                }
            }
        }
        // debuguear($tallas_usuario);

         // Cruzo los miembros con las categorías para añadir a miembros el nombre de la categoría
         foreach($miembros as $miembro) {
            $miembro->nombre_categoria = null;
            foreach($categorias as $categoria) {
                if($miembro->categoria_id === $categoria->id) {
                    $miembro->nombre_categoria = $categoria->nombre_cat;
                }
            }
        }

        // Cruzo los miembros con el pack para añadir a miembros el nombre del pack
        foreach($miembros as $miembro) {
            $miembro->nombre_pack = null;
            $miembro->precio_pack = null;
            foreach($packs as $pack) {
                if($miembro->pack_id === $pack->id) {
                    $miembro->nombre_pack = $pack->nombre_pack;
                    $miembro->precio_pack = $pack->precio;
                }
            }
        }
        // debuguear($miembros);

        // Traigo todos los datos del usuario autenticado
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->id === $_SESSION['id'];
        });

        // debuguear($miembros);

        //Cruzo los dos objetos para añadir nombre y apellidos al array de asistencia:
        foreach($asistencia as $as) {
            foreach($miembros as $mi) {
                if($as->id_usuario === $mi->id) {
                    $as->apellidos_nombre = $mi->apellido1 . " " . $mi->apellido2 . " " . $mi->nombre;
                }
            }
        }

        //Añado una nueva columna al objeto asistencia con la fecha en formato fecha:
        foreach ($asistencia as $as) {
            // Obtenemos la fecha en el formato almacenado en la base de datos
            $fecha_original = $as->fecha;
            
            // Convertimos la fecha al formato "yyyy-mm-dd"
            $fecha_formateada = date("y-m-d", strtotime(str_replace('/', '-', $fecha_original)));
            
            // Actualizamos la propiedad fecha del objeto Asistencia con el formato correcto
            $as->fecha_formateada = $fecha_formateada;
        }

        //Añado un dato de mes a cada miembro de asistencia
        foreach($asistencia as $as) {
            if($as->fecha_formateada) {
                $mes = date('m', strtotime($as->fecha_formateada));
                $as->mes = $mes;
            }
        }

        //Creo una array para almacenar los días en los que hubo asistencia:
        $dias = [];

        foreach($asistencia as $dia) {
            if($dia->fecha) {
                $dias[] = $dia->fecha;
            }
        }

        // Eliminar duplicados y obtener días diferentes
        $dias = array_unique($dias);

        // Convertir el array a listado de días sin repeticiones
        $dias_unicos = array_values($dias);
        // debuguear($dias_unicos);

        //Almacenar solo los nombres de asistencia
        $nombres_prov = [];
        $nombres_ofi = [];

        foreach($asistencia as $as) {
            if($as->apellidos_nombre && $as->id_categoria === "12") {
                $nombres_prov[] = $as->apellidos_nombre;
            }
        }

        $nombres_prov = array_unique($nombres_prov);

        // Convertir el array a listado de días sin repeticiones
        $nombres_prov = array_values($nombres_prov);

        sort($nombres_prov);

        foreach($asistencia as $as) {
            if($as->apellidos_nombre && $as->id_categoria === "13") {
                $nombres_ofi[] = $as->apellidos_nombre;
            }
        }
        
        $nombres_ofi = array_unique($nombres_ofi);

        // Convertir el array a listado de días sin repeticiones
        $nombres_ofi = array_values($nombres_ofi);

        // Ordenar el array alfabéticamente
        sort($nombres_ofi);

        //Creo objetos para alamacenar la asistencia de cada mes y la general
        //__Provinciales__
        $gen_prov_sept_list = [];  // Array para almacenar múltiples objetos
        $gen_prov_oct_list = []; 
        $gen_prov_nov_list = []; 
        $gen_prov_dic_list = []; 
        $gen_prov_ene_list = []; 
        $gen_prov_feb_list = []; 
        $gen_prov_mar_list = []; 
        $gen_prov_abr_list = []; 
        $gen_prov_mayo_list = []; 

        //__Oficiales__
        $gen_ofi_sept_list = [];  
        $gen_ofi_oct_list = [];  
        $gen_ofi_nov_list = [];  
        $gen_ofi_dic_list = [];  
        $gen_ofi_ene_list = [];  
        $gen_ofi_feb_list = [];  
        $gen_ofi_mar_list = [];  
        $gen_ofi_abr_list = [];  
        $gen_ofi_mayo_list = [];  

        foreach($asistencia as $as) {
            foreach($miembros as $m) {
                if($as->id_usuario === $m->id) {
                    //Septiembre:
                    if($as->id_categoria === '12' && $as->mes === '09') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_sept = new stdClass();
                        $gen_prov_sept->id_usuario = $as->id_usuario;
                        $gen_prov_sept->nombre = $as->apellidos_nombre;
                        $gen_prov_sept->fecha = $as->fecha_formateada;
                        $gen_prov_sept->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_sept_list[] = $gen_prov_sept;
                    }
                    //Septiembre:
                    if($as->id_categoria === '13' && $as->mes === '09') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_sept = new stdClass();
                        $gen_ofi_sept->id_usuario = $as->id_usuario;
                        $gen_ofi_sept->nombre = $as->apellidos_nombre;
                        $gen_ofi_sept->fecha = $as->fecha_formateada;
                        $gen_ofi_sept->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_sept_list[] = $gen_ofi_sept;
                    }
                    //Octubre:
                    if($as->id_categoria === '12' && $as->mes === '10') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_oct = new stdClass();
                        $gen_prov_oct->id_usuario = $as->id_usuario;
                        $gen_prov_oct->nombre = $as->apellidos_nombre;
                        $gen_prov_oct->fecha = $as->fecha_formateada;
                        $gen_prov_oct->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_oct_list[] = $gen_prov_oct;
                    }
                    //Octubre:
                    if($as->id_categoria === '13' && $as->mes === '10') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_oct = new stdClass();
                        $gen_ofi_oct->id_usuario = $as->id_usuario;
                        $gen_ofi_oct->nombre = $as->apellidos_nombre;
                        $gen_ofi_oct->fecha = $as->fecha_formateada;
                        $gen_ofi_oct->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_oct_list[] = $gen_ofi_oct;
                    }
                    //Noviembre:
                    if($as->id_categoria === '12' && $as->mes === '11') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_nov = new stdClass();
                        $gen_prov_nov->id_usuario = $as->id_usuario;
                        $gen_prov_nov->nombre = $as->apellidos_nombre;
                        $gen_prov_nov->fecha = $as->fecha_formateada;
                        $gen_prov_nov->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_nov_list[] = $gen_prov_nov;
                    }
                    //Noviembre:
                    if($as->id_categoria === '13' && $as->mes === '11') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_nov = new stdClass();
                        $gen_ofi_nov->id_usuario = $as->id_usuario;
                        $gen_ofi_nov->nombre = $as->apellidos_nombre;
                        $gen_ofi_nov->fecha = $as->fecha_formateada;
                        $gen_ofi_nov->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_nov_list[] = $gen_ofi_nov;
                    }
                    //Diciembre:
                    if($as->id_categoria === '12' && $as->mes === '12') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_dic = new stdClass();
                        $gen_prov_dic->id_usuario = $as->id_usuario;
                        $gen_prov_dic->nombre = $as->apellidos_nombre;
                        $gen_prov_dic->fecha = $as->fecha_formateada;
                        $gen_prov_dic->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_dic_list[] = $gen_prov_dic;
                    }
                    //Diciembre:
                    if($as->id_categoria === '13' && $as->mes === '12') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_dic = new stdClass();
                        $gen_ofi_dic->id_usuario = $as->id_usuario;
                        $gen_ofi_dic->nombre = $as->apellidos_nombre;
                        $gen_ofi_dic->fecha = $as->fecha_formateada;
                        $gen_ofi_dic->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_dic_list[] = $gen_ofi_dic;
                    }
                    //Enero:
                    if($as->id_categoria === '12' && $as->mes === '01') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_ene = new stdClass();
                        $gen_prov_ene->id_usuario = $as->id_usuario;
                        $gen_prov_ene->nombre = $as->apellidos_nombre;
                        $gen_prov_ene->fecha = $as->fecha_formateada;
                        $gen_prov_ene->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_ene_list[] = $gen_prov_ene;
                    }
                    //Enero:
                    if($as->id_categoria === '13' && $as->mes === '01') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_ene = new stdClass();
                        $gen_ofi_ene->id_usuario = $as->id_usuario;
                        $gen_ofi_ene->nombre = $as->apellidos_nombre;
                        $gen_ofi_ene->fecha = $as->fecha_formateada;
                        $gen_ofi_ene->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_ene_list[] = $gen_ofi_ene;
                    }
                    //febrero:
                    if($as->id_categoria === '12' && $as->mes === '02') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_feb = new stdClass();
                        $gen_prov_feb->id_usuario = $as->id_usuario;
                        $gen_prov_feb->nombre = $as->apellidos_nombre;
                        $gen_prov_feb->fecha = $as->fecha_formateada;
                        $gen_prov_feb->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_feb_list[] = $gen_prov_feb;
                    }
                    //Febrero:
                    if($as->id_categoria === '13' && $as->mes === '02') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_feb = new stdClass();
                        $gen_ofi_feb->id_usuario = $as->id_usuario;
                        $gen_ofi_feb->nombre = $as->apellidos_nombre;
                        $gen_ofi_feb->fecha = $as->fecha_formateada;
                        $gen_ofi_feb->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_feb_list[] = $gen_ofi_feb;
                    }
                    //Marzo:
                    if($as->id_categoria === '12' && $as->mes === '03') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_mar = new stdClass();
                        $gen_prov_mar->id_usuario = $as->id_usuario;
                        $gen_prov_mar->nombre = $as->apellidos_nombre;
                        $gen_prov_mar->fecha = $as->fecha_formateada;
                        $gen_prov_mar->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_mar_list[] = $gen_prov_mar;
                    }
                    //Marzo:
                    if($as->id_categoria === '13' && $as->mes === '03') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_mar = new stdClass();
                        $gen_ofi_mar->id_usuario = $as->id_usuario;
                        $gen_ofi_mar->nombre = $as->apellidos_nombre;
                        $gen_ofi_mar->fecha = $as->fecha_formateada;
                        $gen_ofi_mar->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_mar_list[] = $gen_ofi_mar;
                    }
                    //Abril:
                    if($as->id_categoria === '12' && $as->mes === '04') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_abr = new stdClass();
                        $gen_prov_abr->id_usuario = $as->id_usuario;
                        $gen_prov_abr->nombre = $as->apellidos_nombre;
                        $gen_prov_abr->fecha = $as->fecha_formateada;
                        $gen_prov_abr->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_abr_list[] = $gen_prov_abr;
                    }
                    //Abril:
                    if($as->id_categoria === '13' && $as->mes === '04') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_abr = new stdClass();
                        $gen_ofi_abr->id_usuario = $as->id_usuario;
                        $gen_ofi_abr->nombre = $as->apellidos_nombre;
                        $gen_ofi_abr->fecha = $as->fecha_formateada;
                        $gen_ofi_abr->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_abr_list[] = $gen_ofi_abr;
                    }
                    //Mayo:
                    if($as->id_categoria === '12' && $as->mes === '05') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_prov_mayo = new stdClass();
                        $gen_prov_mayo->id_usuario = $as->id_usuario;
                        $gen_prov_mayo->nombre = $as->apellidos_nombre;
                        $gen_prov_mayo->fecha = $as->fecha_formateada;
                        $gen_prov_mayo->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_prov_mayo_list[] = $gen_prov_mayo;
                    }
                    //Mayo:
                    if($as->id_categoria === '13' && $as->mes === '05') {
                        // Crear un nuevo objeto stdClass para cada coincidencia
                        $gen_ofi_may = new stdClass();
                        $gen_ofi_may->id_usuario = $as->id_usuario;
                        $gen_ofi_may->nombre = $as->apellidos_nombre;
                        $gen_ofi_may->fecha = $as->fecha_formateada;
                        $gen_ofi_may->asiste = $as->asiste;
        
                        // Añadir el objeto al array
                        $gen_ofi_mayo_list[] = $gen_ofi_may;
                    }
                }
            }
        }

        //Septiembre
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_sept_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_sept_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_sept_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_sept_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_sept_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_sept_prov = array_values($total_sept_prov);

        //__Oficiales__
        $total_sept_ofi = array();

        foreach ($gen_ofi_sept_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_sept_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_sept_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_sept_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_sept_ofi = array_values($total_sept_ofi);

        //Octubre
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_oct_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_oct_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_oct_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_oct_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_oct_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_oct_prov = array_values($total_oct_prov);

        //__Oficiales__
        $total_oct_ofi = array();

        foreach ($gen_ofi_oct_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_oct_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_oct_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_oct_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_oct_ofi = array_values($total_oct_ofi);

        //Noviembre
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_nov_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_nov_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_nov_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_nov_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_nov_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_nov_prov = array_values($total_nov_prov);

        //__Oficiales__
        $total_nov_ofi = array();

        foreach ($gen_ofi_nov_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_nov_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_nov_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_nov_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_nov_ofi = array_values($total_nov_ofi);

        //Diciembre
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_dic_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_dic_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_dic_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_dic_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_dic_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_dic_prov = array_values($total_dic_prov);

        //__Oficiales__
        $total_dic_ofi = array();

        foreach ($gen_ofi_dic_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_dic_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_dic_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_dic_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_dic_ofi = array_values($total_dic_ofi);

        //Enero
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_ene_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_ene_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_ene_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_ene_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_ene_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_ene_prov = array_values($total_ene_prov);

        //__Oficiales__
        $total_ene_ofi = array();

        foreach ($gen_ofi_ene_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_ene_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_ene_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_ene_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_ene_ofi = array_values($total_ene_ofi);

        //Febrero
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_feb_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_feb_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_feb_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_feb_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_feb_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_feb_prov = array_values($total_feb_prov);

        //__Oficiales__
        $total_feb_ofi = array();

        foreach ($gen_ofi_feb_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_feb_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_feb_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_feb_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_feb_ofi = array_values($total_feb_ofi);

        //Marzo
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_mar_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_mar_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_mar_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_mar_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_mar_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_mar_prov = array_values($total_mar_prov);

        //__Oficiales__
        $total_mar_ofi = array();

        foreach ($gen_ofi_mar_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_mar_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_mar_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_mar_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_mar_ofi = array_values($total_mar_ofi);

        //Abril__________________________________________________________________________________
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_abr_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_abr_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_abr_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_abr_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_abr_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_abr_prov = array_values($total_abr_prov);

        //__Oficiales__
        $total_abr_ofi = array();

        foreach ($gen_ofi_abr_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_abr_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_abr_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_abr_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_abr_ofi = array_values($total_abr_ofi);

        //Mayo__________________________________________________________________________________
        //__Provinciales__
        //Creo array para contar asistencias totales por meses de cada uno
        $total_may_prov = array();

        // Recorrer cada objeto en el array original
        foreach ($gen_prov_mayo_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_may_prov[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_may_prov[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_may_prov[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_may_prov = array_values($total_may_prov);

        //__Oficiales__
        $total_may_ofi = array();

        foreach ($gen_ofi_mayo_list as $obj) {
            // Obtener el ID de usuario
            $id_usuario = $obj->id_usuario;
            
            // Verificar si el usuario ya está en el array
            if (!isset($total_may_ofi[$id_usuario])) {
                // Inicializar su entrada con un contador de 0
                $total_may_ofi[$id_usuario] = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $obj->nombre,
                    'count' => 0
                ];
            }
            
            // Incrementar el contador si el usuario asiste (1)
            if ($obj->asiste == "1") {
                $total_may_ofi[$id_usuario]['count']++;
            }
        }

        // Convertir el array de asistencias totales a un array indexado
        $total_may_ofi = array_values($total_may_ofi);
        //_____________________________________________________________________________________

        // Gestión para que revise los dos turnos. Provinciales septiembre________________________
        foreach($asistencia as $as) {
            foreach($gen_prov_sept_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales septiembre________________________
        foreach($asistencia as $as) {
            foreach($gen_ofi_sept_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales octubre
        foreach($asistencia as $as) {
            foreach($gen_prov_oct_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales octubre
        foreach($asistencia as $as) {
            foreach($gen_ofi_oct_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales noviembre
        foreach($asistencia as $as) {
            foreach($gen_prov_nov_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales noviembre
        foreach($asistencia as $as) {
            foreach($gen_ofi_nov_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales diciembre
        foreach($asistencia as $as) {
            foreach($gen_prov_dic_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales diciembre
        foreach($asistencia as $as) {
            foreach($gen_ofi_dic_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales enero
        foreach($asistencia as $as) {
            foreach($gen_prov_ene_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales enero
        foreach($asistencia as $as) {
            foreach($gen_ofi_ene_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales febrero
        foreach($asistencia as $as) {
            foreach($gen_prov_feb_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales febrero
        foreach($asistencia as $as) {
            foreach($gen_ofi_feb_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales marzo
        foreach($asistencia as $as) {
            foreach($gen_prov_mar_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales marzo
        foreach($asistencia as $as) {
            foreach($gen_ofi_mar_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales abril
        foreach($asistencia as $as) {
            foreach($gen_prov_abr_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales abril
        foreach($asistencia as $as) {
            foreach($gen_ofi_abr_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Provinciales mayo
        foreach($asistencia as $as) {
            foreach($gen_prov_mayo_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }
        // Gestión para que revise los dos turnos. Oficiales mayo
        foreach($asistencia as $as) {
            foreach($gen_ofi_mayo_list as $x) {
                if($as->id_usuario === $x->id_usuario && $as->fecha_formateada === $x->fecha) {
                    if($x->asiste === "1") {
                        $as->asiste = "1";
                    }
                }
            }
        }

        // debuguear($miembros);

        //Router a la vista
        $router->render('paginas/area_privada-asistencia', [
            'titulo' => 'Asistencia',
            'asistencia' => $asistencia,
            'dias_unicos' => $dias_unicos,
            'nombres_ofi' => $nombres_ofi,
            'nombres_prov' => $nombres_prov,
            'total_sept_prov'=> $total_sept_prov,
            'total_sept_ofi'=> $total_sept_ofi,
            'total_oct_prov'=> $total_oct_prov,
            'total_oct_ofi'=> $total_oct_ofi,
            'total_nov_prov'=> $total_nov_prov,
            'total_nov_ofi'=> $total_nov_ofi,
            'total_dic_prov'=> $total_dic_prov,
            'total_dic_ofi'=> $total_dic_ofi,
            'total_ene_prov'=> $total_ene_prov,
            'total_ene_ofi'=> $total_ene_ofi,
            'total_feb_prov'=> $total_feb_prov,
            'total_feb_ofi'=> $total_feb_ofi,
            'total_mar_prov'=> $total_mar_prov,
            'total_mar_ofi'=> $total_mar_ofi,
            'total_abr_prov'=> $total_abr_prov,
            'total_abr_ofi'=> $total_abr_ofi,
            'total_may_prov'=> $total_may_prov,
            'total_may_ofi'=> $total_may_ofi,
            'miembros' => $miembros
        ]);
    }

    public static function privada_fotos(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
        }
        if(es_directivo()) {
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

        $miembros = Usuario::all_ord();

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

        //Router a la vista
        $router->render('paginas/area_privada-fotos', [
            'titulo' => 'Fotos de entrenamientos',
            'septiembre' => $septiembre,
            'octubre' => $octubre,
            'noviembre' => $noviembre,
            'diciembre' => $diciembre,
            'enero' => $enero,
            'febrero' => $febrero,
            'marzo' =>$marzo,
            'abril' => $abril,
            'mayo' => $mayo,
            'turnos' => $turnos,
            'miembros' => $miembros
        ]);
    }

    public static function mensajes(Router $router) {
        // Verificar autenticación y permisos
        if (!is_auth() || es_directivo()) {
            header('Location: /login');
            exit;
        }
    
        $usuario_id = $_SESSION['id'];
    
        // Obtener todos los mensajes
        $mensajes = Mensajes::all();
    
        // Obtener los mensajes marcados como leídos por el usuario
        $mensajes_leidos_usuario = MensajesLeidos::whereAll_order('usuario_id', $usuario_id);
    
        // Construir un array de IDs de mensajes leídos por el usuario
        $ids_mensajes_leidos = [];
        foreach ($mensajes_leidos_usuario as $mensaje_leido) {
            $ids_mensajes_leidos[] = $mensaje_leido->mensaje_id;
        }
    
        // Combinar mensajes con estado de leído basado en MensajesLeidos
        $mensajes_combinados = [];
        foreach ($mensajes as $mensaje) {
            // Verificar si el mensaje está marcado como leído por el usuario actual
            $mensaje->leido = in_array($mensaje->id, $ids_mensajes_leidos);
            $mensajes_combinados[] = $mensaje;
        }

        // debuguear($mensajes_combinados);
        $mensajes_user = MensajesLeidos::whereAll_order('usuario_id', $usuario_id);
        // debuguear($mensajes_user);

        foreach($mensajes_user as $mu) {
            if($mu->leido === "1") {
                $mu->leido = boolval(true);
            } elseif ($mu->leido === "0") {
                $mu->leido = boolval(false);
            }
            foreach($mensajes_combinados as $mensaje) {
                if($mensaje->id == $mu->mensaje_id) {
                    $mensaje->leido = $mu->leido;
                }
            }
        }
        // debuguear($mensajes_combinados);

        // Renderizar la vista con los mensajes combinados
        $router->render('paginas/area_privada-mensajes', [
            'titulo' => 'Mensajes',
            'mensajes_combinados' => $mensajes_combinados
        ]);
    }

    public static function marcarMensajeLeido() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
            if (!$usuario_id) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado']);
                exit;
            }
    
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
    
            if (!isset($data['mensaje_id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID de mensaje no proporcionado']);
                exit;
            }
    
            $mensaje_id = $data['mensaje_id'];
    
            // Verificar si el mensaje ya está marcado como leído
            $mensajeLeido = MensajesLeidos::whereAll_order('usuario_id', $usuario_id);
    
            // Filtrar para encontrar el mensaje específico
            $mensajeLeido = array_filter($mensajeLeido, function($mensaje) use ($mensaje_id) {
                return $mensaje->mensaje_id == $mensaje_id;
            });
    
            if (empty($mensajeLeido)) {
                try {
                    $nuevoMensajeLeido = new MensajesLeidos([
                        'usuario_id' => $usuario_id,
                        'mensaje_id' => $mensaje_id,
                        'leido' => 1
                    ]);
                    $nuevoMensajeLeido->guardar();
                    echo json_encode(['success' => true]);
                } catch (\Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al marcar como leído: ' . $e->getMessage()]);
                }
            } else {
                // Actualizar el registro existente
                $mensajeLeido = array_values($mensajeLeido)[0];
                $mensajeLeido->leido = 1;
                $mensajeLeido->guardar();
                echo json_encode(['success' => true]); // Ya está marcado como leído
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
    
    

    public static function error(Router $router) {
    
        //Router a la vista
        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);
    }

}