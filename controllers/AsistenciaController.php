<?php

namespace Controllers;

use stdClass;
use MVC\Router;
use Model\Turnos;
use Model\Usuario;
use Model\Categoria;
use Model\Asistencia;

class AsistenciaController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        //Tabla de asistencia general___________________________________________________________
        
        //Traigo todos los registros de asistencia
        $asistencia = Asistencia::allAsistencia();

        //Traigo todos los miembros diferentes a administradores
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });

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

        // debuguear($asistencia);

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

        // debuguear($gen_prov_sept_list);

        //Añado un dato de mes a cada miembro de asistencia
        foreach($gen_prov_sept_list as $as) {
            if($as->fecha) {
                $mes = date('m', strtotime($as->fecha));
                $as->mes = $mes;
                $as->fecha_formateada = str_replace('-', '/', $as->fecha);
            }
        }

        // debuguear($gen_prov_sept_list);

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

        //_______________________________________________________________________________________________________________

        // debuguear($asistencia);
        // debuguear($gen_prov_sept_list);

        //______________________________________________________________________________________
        // Renderizar la vista
        $router->render('admin/asistencia/index', [
            'titulo' => 'Asistencia',
            'asistencia' => $asistencia,
            'gen_prov_sept_list' => $gen_prov_sept_list,
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
            'total_may_ofi'=> $total_may_ofi

        ]);
    }

    public static function index_org(Router $router) {
        if(!is_admin() && !es_organizador()) {
            header('Location: /login');
        }

        //Tabla de asistencia general___________________________________________________________
        
        //Traigo todos los registros de asistencia
        $asistencia = Asistencia::allAsistencia();

        //Traigo todos los miembros diferentes a administradores
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });

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

        // debuguear($asistencia);

        //______________________________________________________________________________________
        // Renderizar la vista
        $router->render('organizacion/asistencia/index', [
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
            'total_may_ofi'=> $total_may_ofi

        ]);
    }

    public static function index_dir(Router $router) {
        if(!is_admin() && !es_directivo()) {
            header('Location: /login');
        }

        //Tabla de asistencia general___________________________________________________________
        
        //Traigo todos los registros de asistencia
        $asistencia = Asistencia::allAsistencia();

        //Traigo todos los miembros diferentes a administradores
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== "1";
        });

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

        // debuguear($asistencia);

        //______________________________________________________________________________________
        // Renderizar la vista
        $router->render('consultas_direccion/dashboard/index', [
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
            'total_may_ofi'=> $total_may_ofi

        ]);
    }
    
    public static function lista(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
            exit();
        }

        // Inicialización
        $alertas = [];
        $provinciales = Usuario::whereAll('categoria_id', '12');
        $oficiales = Usuario::whereAll('categoria_id', '13');
        $miembros = array_merge($provinciales, $oficiales);
        $categorias = Categoria::all('ASC');
        $turnos = Turnos::allTurnos('ASC');
        $alertas = [];

        // Inicializar una variable para almacenar los valores ingresados por el usuario
        $valores = $_POST;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si el usuario no es administrador, redirige
            if (!is_admin()) {
                header('Location: /login');
            }

            // Recuperar la fecha de la solicitud POST y convertirla
            $fecha = isset($_POST['dia']) ? $_POST['dia'] : null;
            $fecha_convertida = $fecha ? date('d/m/y', strtotime($fecha)) : null;

            // Recuperar el turno de la solicitud POST
            $turno = isset($_POST['turno']) ? (int)$_POST['turno'] : null;
            

            // Recuperar el array de miembros de la solicitud POST
            $miembrosPost = isset($_POST['miembros']) ? $_POST['miembros'] : null;

            // Verificar que el array de miembros sea válido
            if (!is_array($miembrosPost)) {
                // Manejar el error según tus necesidades (por ejemplo, enviar un mensaje de error)
                return;
            }

            // Inicializa un array para almacenar los objetos Asistencia creados
            $lista_asistencia = [];

            // Iterar sobre cada miembro en el array de miembros
            foreach ($miembrosPost as $miembro) {
                // Verifica que cada miembro tenga las claves necesarias
                if (isset($miembro['id'], $miembro['categoria_id'], $miembro['asiste'])) {
                    // Crear una nueva instancia de Asistencia
                    $asistencia = new Asistencia([
                        'id_usuario' => (int)$miembro['id'],
                        'id_categoria' => (int)$miembro['categoria_id'],
                        'asiste' => (int)$miembro['asiste'],
                        'fecha' => $fecha_convertida,
                        'id_turno' => $turno
                    ]);

                    // Añadir la instancia de Asistencia al array
                    $lista_asistencia[] = $asistencia;
                }
            }

            // Ahora, $lista_asistencia contiene todos los objetos Asistencia creados
            // debuguear($lista_asistencia);

            //Validar si hay alertas de error
            $alertas = $asistencia->validarFecha();

            if(empty($alertas)) {
                foreach ($lista_asistencia as $asistencia) {
                    // Guarda el objeto Asistencia en la base de datos
                    $resultado = $asistencia->guardar();
                }

                if( $resultado ) {
                    sleep(1.5);
                    header('Location: /admin/registrados/lista');
                }
            }
        }

        // Renderizar la vista
        $router->render('admin/registrados/lista', [
            'titulo' => 'Miembros con Asistencia',
            'alertas' => $alertas,
            'miembros' => $miembros,
            'categorias' => $categorias,
            'turnos' => $turnos,
            'valores' => $valores ?? []
        ]);
    }

    public static function lista_org(Router $router) {
        if(!is_admin() && !es_organizador()) {
            header('Location: /login');
            exit();
        }

        // Inicialización
        $alertas = [];
        $provinciales = Usuario::whereAll('categoria_id', '12');
        $oficiales = Usuario::whereAll('categoria_id', '13');
        $miembros = array_merge($provinciales, $oficiales);
        $categorias = Categoria::all('ASC');
        $turnos = Turnos::allTurnos('ASC');
        $alertas = [];

        // Inicializar una variable para almacenar los valores ingresados por el usuario
        $valores = $_POST;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si el usuario no es administrador, redirige
            if (!is_admin() && !es_organizador()) {
                header('Location: /login');
            }

            // Recuperar la fecha de la solicitud POST y convertirla
            $fecha = isset($_POST['dia']) ? $_POST['dia'] : null;
            $fecha_convertida = $fecha ? date('d/m/y', strtotime($fecha)) : null;

            // Recuperar el turno de la solicitud POST
            $turno = isset($_POST['turno']) ? (int)$_POST['turno'] : null;
            

            // Recuperar el array de miembros de la solicitud POST
            $miembrosPost = isset($_POST['miembros']) ? $_POST['miembros'] : null;

            // Verificar que el array de miembros sea válido
            if (!is_array($miembrosPost)) {
                // Manejar el error según tus necesidades (por ejemplo, enviar un mensaje de error)
                return;
            }

            // Inicializa un array para almacenar los objetos Asistencia creados
            $lista_asistencia = [];

            // Iterar sobre cada miembro en el array de miembros
            foreach ($miembrosPost as $miembro) {
                // Verifica que cada miembro tenga las claves necesarias
                if (isset($miembro['id'], $miembro['categoria_id'], $miembro['asiste'])) {
                    // Crear una nueva instancia de Asistencia
                    $asistencia = new Asistencia([
                        'id_usuario' => (int)$miembro['id'],
                        'id_categoria' => (int)$miembro['categoria_id'],
                        'asiste' => (int)$miembro['asiste'],
                        'fecha' => $fecha_convertida,
                        'id_turno' => $turno
                    ]);

                    // Añadir la instancia de Asistencia al array
                    $lista_asistencia[] = $asistencia;
                }
            }

            // Ahora, $lista_asistencia contiene todos los objetos Asistencia creados
            // debuguear($lista_asistencia);

            //Validar si hay alertas de error
            $alertas = $asistencia->validarFecha();

            if(empty($alertas)) {
                foreach ($lista_asistencia as $asistencia) {
                    // Guarda el objeto Asistencia en la base de datos
                    $resultado = $asistencia->guardar();
                }
                

                if( $resultado ) {
                    sleep(1.5);
                    header('Location: /organizacion/registrados/lista-organizacion');
                }
            }
        }

        // Renderizar la vista
        $router->render('organizacion/registrados/lista-organizacion', [
            'titulo' => 'Miembros con Asistencia',
            'alertas' => $alertas,
            'miembros' => $miembros,
            'categorias' => $categorias,
            'turnos' => $turnos,
            'valores' => $valores ?? []
        ]);
    }

    
}