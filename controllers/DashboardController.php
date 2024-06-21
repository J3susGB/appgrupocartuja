<?php

namespace Controllers;

use Model\Categoria;
use Model\Cuentas;
use Model\Pack;
use MVC\Router;
use Model\Usuario;

class DashboardController {
    public static function index(Router $router) {

        //Calcular los tres últimos registros dados de alta
        $registros = Usuario::get(5);
        // debuguear($registros);

        //Calcular el número total de miembros reales
        $miembros = Usuario::all();
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $usuarios = count($miembros);
        // debuguear($miembros);

        //Miembros con pack solo entrenos
        $entrenos = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "1") {
            $entrenos++;
          }
        }
        // debuguear($entrenos);
        

        //Miembros con pack entrenos + cenas
        $cenas = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "2") {
            $cenas++;
          }
        }
        // debuguear($cenas);

        //Miembros con pack entrenos + ropa
        $con_ropa = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "3") {
            $con_ropa++;
          }
        }
        // debuguear($ropa);

        //Miembros con pack especial solo ropa
        $especial = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "5") {
            $especial++;
          }
        }
        // debuguear($especial);

        $ropa = $con_ropa + $especial;

        //Miembros con pack completo
        $completo = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "4") {
            $completo++;
          }
        }
        // debuguear($completo);

        //Cuentas
        $ingresos = 0;
        $gastos = 0;
        $cuentas = Cuentas::all();
        // debuguear($cuentas);

        foreach($cuentas as $cuenta) {
            $ingresos += $cuenta->ingreso;
            $gastos += $cuenta->gasto;
        }

        $balance = $ingresos - $gastos;

        // debuguear($gastos);

        // Render a la vista 
        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'usuarios' => $usuarios,
            'entrenos' => $entrenos,
            'cenas' => $cenas,
            'ropa' => $ropa,
            'especial' => $especial,
            'completo' => $completo,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'balance' => $balance
        ]);
    }

    public static function index_organizacion(Router $router) {

        //Calcular los tres últimos registros dados de alta
        $registros = Usuario::get(5);
        // debuguear($registros);

        //Calcular el número total de miembros reales
        $miembros = Usuario::all();
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $usuarios = count($miembros);
        // debuguear($miembros);

        //Miembros con pack solo entrenos
        $entrenos = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "1") {
            $entrenos++;
          }
        }
        // debuguear($entrenos);
        

        //Miembros con pack entrenos + cenas
        $cenas = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "2") {
            $cenas++;
          }
        }
        // debuguear($cenas);

        //Miembros con pack entrenos + ropa
        $con_ropa = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "3") {
            $con_ropa++;
          }
        }
        // debuguear($ropa);

        //Miembros con pack especial solo ropa
        $especial = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "5") {
            $especial++;
          }
        }
        // debuguear($especial);

        $ropa = $con_ropa + $especial;

        //Miembros con pack completo
        $completo = 0;
        foreach($miembros as $miembro) {
          if($miembro->pack_id === "4") {
            $completo++;
          }
        }
        // debuguear($completo);

        //Cuentas
        $ingresos = 0;
        $gastos = 0;
        $cuentas = Cuentas::all();
        // debuguear($cuentas);

        foreach($cuentas as $cuenta) {
            $ingresos += $cuenta->ingreso;
            $gastos += $cuenta->gasto;
        }

        $balance = $ingresos - $gastos;

        // debuguear($gastos);

        // Render a la vista 
        $router->render('organizacion/dashboard/index', [
            'titulo' => 'Panel de Organización',
            'registros' => $registros,
            'usuarios' => $usuarios,
            'entrenos' => $entrenos,
            'cenas' => $cenas,
            'ropa' => $ropa,
            'especial' => $especial,
            'completo' => $completo,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'balance' => $balance
        ]);
    }

    public static function cuentas(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $cuentas = Cuentas::all('ASC');
        // debuguear($cuentas);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }

            foreach($cuentas as $cuenta) {
                $_POST['balance'] = $cuenta->balance;
            }
            // debuguear($_POST);  

            //Sincronizar con el post
            $cuentas = new Cuentas($_POST);

            //Cambiar tipos de dato a ingresos, gastos y balance
            $cuentas->ingreso = floatval($cuentas->ingreso);
            $cuentas->gasto = floatval($cuentas->gasto);
            $cuentas->balance = floatval($cuentas->balance);

            $cuentas->balance = $_POST['balance'] + $cuentas->ingreso - $cuentas->gasto;
            // debuguear($cuentas);

            //Asignar a la columna balance el dato
            // if(!$cuentas->ingreso) {
            //     $cuentas->balance = $cuentas->balance - $cuentas->gasto;
            // }

            // if(!$cuentas->gasto) {
            //     $cuentas->balance = $cuentas->balance + $cuentas->ingreso;
            // }
            

            // $cuentas->balance = $cuentas->ingreso - $cuentas->gasto;
            // // debuguear($cuentas);

            
            // debuguear($cuentas);

            //Validar
            $alertas = $cuentas->validar_formulario_cuentas();

            //Guardar el registro
            if(empty($alertas)) {
                //Guardar en la base de datos:
                $resultado = $cuentas->guardar();

                if($resultado) {
                    // Pausar la ejecución por 1 segundo
                    sleep(2);
                    header('Location: /admin/dashboard/cuentas');
                }
            }
        }

        // debuguear($cuentas);

        // Render a la vista 
        $router->render('admin/dashboard/cuentas', [
            'titulo' => 'Cuentas',
            'alertas' => $alertas,
            'cuentas' => $cuentas
        ]);
    }

    // public static function editar_cuentas(Router $router) {

    //     if(!is_admin()) {
    //         header('Location: /login');
    //     }

    //     $cuentas = Cuentas::all('ASC');

    //     //Validar el id:
    //     $id = $_GET['id']; //Leer el id de la url
    //     $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

    //     if( !$id ) {
    //         header('Location: /admin/dashboard/cuentas');
    //     }

    //     //Obtener el miembro a editar:
    //     $cuentas = Cuentas::find($id);
    //     // debuguear($cuentas);
        
    //     if( !$cuentas ) {
    //         header('Location: /admin/dashboard/cuentas');
    //     }

    //     if($_SERVER['REQUEST_METHOD'] === 'POST') {

    //         if(!is_admin()) {
    //             header('Location: /login');
    //         }
    //         // debuguear($_POST);

    //         //Cruzo los datos del post con el objeto cuentas
    //         if($cuentas->concepto !== $_POST['concepto']) {
    //             $cuentas->concepto = $_POST['concepto'];
    //         }
    //         $cuentas->balance = $cuentas->balance - $cuentas->ingreso;
    //         if($cuentas->ingreso !== $_POST['ingreso']) {
    //             $cuentas->ingreso = $_POST['ingreso'];
    //             $cuentas->balance = $cuentas->balance + $cuentas->ingreso;
    //         }
    //         if($cuentas->gasto !== $_POST['gasto']) {
    //             $cuentas->gasto = $_POST['gasto'];
    //             $cuentas->balance = $cuentas->balance - $cuentas->gasto;
    //         }

    //         // debuguear($cuentas);

    //         $cuentas->sincronizar($_POST);
    //         // debuguear($cuentas);

    //         // $alertas = $miembro->validar_edicionPerfil();

    //         // debuguear($alertas);

    //         $resultado = $cuentas->guardar();
    //     }
    //         if( $resultado ) {
    //             sleep(1.5);
    //             header('location: /admin/dashboard/cuentas');
    //         } 


    //     // Render a la vista 
    //     $router->render('admin/dashboard/editar-cuentas', [
    //         'titulo' => 'Editar Movimiento',
    //         'cuentas' => $cuentas
    //     ]);
    // }

    public static function perfil(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $miembros = Usuario::all_ord();

        // debuguear($miembros);

        // Render a la vista 
        $router->render('admin/dashboard/perfiles', [
            'titulo' => 'Editar perfiles de usuarios',
            'miembros' => $miembros
        ]);
    }    

    public static function editar_perfil(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $miembro = new Usuario;

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

        if( !$id ) {
            header('Location: /admin/dashboard/perfiles');
        }

        //Obtener el miembro a editar:
        $miembro = Usuario::find($id);
        // debuguear($miembro);
        
        if( !$miembro ) {
            header('Location: /admin/dashboard/perfiles');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
            // debuguear($_POST);
                
            
            if( intval($miembro->admin) !== intval($_POST['admin']) ) {
                $miembro->admin = intval($_POST['admin']);
            }
            if( $miembro->organizador !== $_POST['organizador'] ) {
                $miembro->organizador = $_POST['organizador'];
            }
            if( $miembro->directivo !== $_POST['directivo'] ) {
                $miembro->directivo = $_POST['directivo'];
            }


            $miembro->sincronizar($_POST);
            // debuguear($miembro);

            // $alertas = $miembro->validar_edicionPerfil();

            // debuguear($alertas);

            $resultado = $miembro->guardar();
        }
            if( $resultado ) {
                sleep(1.5);
                header('location: /admin/dashboard/perfiles');
            } 


        // Render a la vista 
        $router->render('admin/dashboard/editar-perfil', [
            'titulo' => 'Editar Perfil',
            'alertas' => $alertas,
            'miembro' => $miembro
        ]);
    }

    public static function packs(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $packs = Pack::all('ASC');
        // debuguear($packs);

        // Render a la vista 
        $router->render('admin/dashboard/packs', [
            'titulo' => 'Packs',
            'packs' => $packs
        ]);
    }

    public static function añadir_pack(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $pack = new Pack;

        // debuguear($pack);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // debuguear($_POST);

            $pack->nombre_pack = $_POST['nombre'];
            $pack->precio = $_POST['precio'];

            // debuguear($pack);

            $alertas = $pack->validar_edicion_pack();
            // debuguear($alertas);

            if(empty($alertas)) {
                $resultado = $pack->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('location: /admin/dashboard/packs');
                }
            }
        }

        // Render a la vista 
        $router->render('admin/dashboard/añadir-pack', [
            'titulo' => 'Añadir nuevo pack',
            'pack' => $pack,
            'alertas' => $alertas
        ]);
    }

    public static function editar_pack(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $pack = new Pack();

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

        if( !$id ) {
            header('Location: /admin/dashboard/packs');
        }

        //Obtener el miembro a editar:
        $pack = Pack::find($id);
        // debuguear($pack);
        
        if( !$pack ) {
            header('Location: /admin/dashboard/packs');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
            // debuguear($_POST);
                
            if($pack->nombre_pack !== $_POST['nombre']) {
                $pack->nombre_pack = $_POST['nombre'];
            }
            if($pack->precio !== $_POST['precio']) {
                $pack->precio = $_POST['precio'];
            }


            $pack->sincronizar($_POST);
            // debuguear($pack);

            $alertas = $pack->validar_edicion_pack();

            // debuguear($alertas);

            if(empty($alertas)) {
                $resultado = $pack->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('location: /admin/dashboard/packs');
                }
            }
        }

        // Render a la vista 
        $router->render('admin/dashboard/editar-pack', [
            'titulo' => 'Editar Pack',
            'alertas' => $alertas,
            'pack' => $pack
        ]);
    }

    public static function eliminar_pack() {
        if(!is_admin()) {
            header('Location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $pack = Pack::find($id);

            if(!isset($pack)) {
                header('Location: /admin/dashboard/packs');
            }
            
            $resultado = $pack->eliminar();

            if($resultado) {
                sleep(1.5);
                header('Location: /admin/dashboard/packs');
            }
        }
    }

    public static function categorias(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $categorias = Categoria::all('ASC');
        // debuguear($categorias);

        // Render a la vista 
        $router->render('admin/dashboard/categorias', [
            'titulo' => 'Categorías',
            'categorias' => $categorias
        ]);
    }

    public static function añadir_categoria(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categoria = new Categoria();

        // debuguear($pack);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // debuguear($_POST);

            $categoria->nombre_cat = $_POST['nombre_cat'];

            // debuguear($pack);

            $alertas = $categoria->validar_categoria();
            // debuguear($alertas);

            if(empty($alertas)) {
                $resultado = $categoria->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('location: /admin/dashboard/categorias');
                }
            }
        }

        // Render a la vista 
        $router->render('admin/dashboard/añadir-categoria', [
            'titulo' => 'Añadir nueva categoría',
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

    public static function editar_categoria(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categoria = new Categoria();

        //Validar el id:
        $id = $_GET['id']; //Leer el id de la url
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validar que este id siempre sea un número entero

        if( !$id ) {
            header('Location: /admin/dashboard/categorias');
        }

        //Obtener el miembro a editar:
        $categoria = Categoria::find($id);
        // debuguear($pack);
        
        if( !$categoria ) {
            header('Location: /admin/dashboard/categorias');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
            // debuguear($_POST);
                
            if($categoria->nombre_cat !== $_POST['nombre_cat']) {
                $categoria->nombre_cat = $_POST['nombre_cat'];
            }

            $categoria->sincronizar($_POST);
            // debuguear($pack);

            $alertas = $categoria->validar_categoria();

            // debuguear($alertas);

            if(empty($alertas)) {
                $resultado = $categoria->guardar();

                if( $resultado ) {
                    sleep(1.5);
                    header('location: /admin/dashboard/categorias');
                }
            }
        }

        // Render a la vista 
        $router->render('admin/dashboard/editar-categoria', [
            'titulo' => 'Editar Categoría',
            'alertas' => $alertas,
            'categoria' => $categoria
        ]);
    }

    public static function eliminar_categoria() {
        if(!is_admin()) {
            header('Location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $categoria = Categoria::find($id);

            if(!isset($categoria)) {
                header('Location: /admin/dashboard/categorias');
            }
            
            $resultado = $categoria->eliminar();

            if($resultado) {
                sleep(1.5);
                header('Location: /admin/dashboard/categorias');
            }
        }
    }

    public static function informes_direccion(Router $router) {

        // Render a la vista 
        $router->render('consultas_direccion/informes/index', [
            'titulo' => 'Informes'
        ]);
    }
}