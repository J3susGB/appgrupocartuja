<?php

namespace Controllers;

use Model\Pack;
use MVC\Router;
use Classes\Email;
use Model\Usuario;
use Model\Categoria;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AuthController {
    
    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();
            
            if(empty($alertas)) {
                // Verificar quel el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                if(!$usuario || !$usuario->confirmado ) {
                    Usuario::setAlerta('error', 'El Usuario No Existe o no esta confirmado');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $usuario->password) ) {
                        
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido1'] = $usuario->apellido1;
                        $_SESSION['apellido2'] = $usuario->apellido2;
                        $_SESSION['categoria'] = $usuario->categoria;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        $_SESSION['organizador'] = $usuario->organizador ?? null;
                        $_SESSION['directivo'] = $usuario->directivo ?? null;

                        //Redirección:
                        // if( $usuario->admin ) {
                        //     header('Location: /admin/dashboard');
                        // } elseif ($usuario->organizador) {
                        //     header('Location: /organizacion/dashboard');
                        // } elseif ($usuario->directivo) {
                        //     header('Location: /consultas_direccion/dashboard');
                        // } else {
                        //     header('Location: /');
                        // }

                        if( $usuario->admin ) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /');
                        } 
                        
                    } else {
                        Usuario::setAlerta('error', 'La contraseña no es correcta.');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Render a la vista 
        $router->render('auth/login', [
            'titulo' => 'Iniciar sesión',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
       
    }

    public static function registro(Router $router) {
        $alertas = [];
        $usuario = new Usuario;
        $categorias = Categoria::all('ASC');
        $packs = Pack::all('ASC');

        // Filtra los packs para eliminar aquellos que sean especial solo ropa id 5
        $packs = array_filter($packs, function($pack) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $pack->id !== "5";
        });
        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $categorias = new Categoria($_POST['categoria_id']);
            $categoria_id = intval($_POST['usuarios']['categoria_id']);
            $usuario->categoria_id = $categoria_id;

            $packs = new Pack($_POST['pack_id']);
            $pack_id = intval($_POST['usuarios']['pack_id']);
            $usuario->pack_id = $pack_id;

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
            $usuario->sincronizar($_POST);

            //Validar:
            $alertas = $usuario->validar_cuenta();
            
            //Guardar el registro
            if(empty($alertas)) {
                //Guardar las imágenes:
                $imagen_png->toPng()->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->toWebp()->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                $imagen_avif->toAvif()->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');

                //Comprobar si el usuario ya está registrado:
                $existeUsuario = Usuario::where('email', $usuario->email);

                // $usuario['categoria_id'] = $_POST['categoria'];
                // debuguear($usuario->categoria_id);
                

                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();

                    //Guardar en la base de datos:
                    $resultado = $usuario->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    // debuguear($usuario);

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/registro', [
            'titulo' => 'Crea tu cuenta',
            'usuario' => $usuario, 
            'alertas' => $alertas,
            'categorias' => $categorias,
            'packs' => $packs
        ]);
    }

    public static function olvide(Router $router) {
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado) {

                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token );
                    $email->enviarInstrucciones();


                    // Imprimir la alerta
                    // Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

                    $alertas['exito'][] = 'Hemos enviado las instrucciones a tu email';
                } else {
                 
                    // Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

                    $alertas['error'][] = 'El Usuario no existe o no esta confirmado';
                }
            }
        }

        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvidé mi contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router) {

        $token = s($_GET['token']);

        $token_valido = true;

        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Se ha producido un error inesperado. Por favor, inténtalo de nuevo.');
            $token_valido = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if($resultado) {
                    header('Location: /login');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer contraseña',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ]);
    }

    public static function mensaje(Router $router) {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada con éxito'
        ]);
    }

    public static function confirmar(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // No se encontró un usuario con ese token
            Usuario::setAlerta('error', 'Hubo un error inesperado en la confirmación de tu cuenta. Por favor, vuelve a intentarlo.');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);
            
            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar cuenta',
            'alertas' => Usuario::getAlertas()
        ]);
    }
}