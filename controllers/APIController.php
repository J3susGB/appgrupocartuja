<?php

namespace Controllers;

use Model\Pack;
use Model\Tallas;
use Model\Cuentas;
use Model\Usuario;
use Model\Mensajes;
use Model\Categoria;
use Model\Asistencia;
use Model\MensajesLeidos;
use Model\Tallasusuarios;

class APIController {
    public static function index() {

        session_start();

        //Traigo todos los usuarios excepto los administradores, ordenados por apellidos y nombre
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== "1";
        });

        //Traigo todas las categorías
        $categorias = Categoria::all('ASC');

        //Sincronizo miembros y categorías y añado nombre_categoria a miembros
        foreach($categorias as $categoria) {
            foreach($miembros as $miembro) {
                if($categoria->id == $miembro->categoria_id){
                    $miembro->nombre_categoria = $categoria->nombre_cat;
                }
            }
        }

        //Traigo todos los packs
        $packs = Pack::all();

        //Sincronizo miembros y packs y añado nombre_pack a miembros
        foreach($packs as $pack) {
            foreach($miembros as $miembro) {
                if($pack->id == $miembro->pack_id){
                    $miembro->nombre_pack = $pack->nombre_pack;
                }
            }
        }

        //Cálculo para el filtro de pagos
        foreach($miembros as $miembro) {
            foreach( $packs as $pack) {
                if( $miembro->pack_id === $pack->id ) {
                    $total_a_pagar = $pack->precio;
                    $cuota = ($total_a_pagar / 2) ;
                    $miembro->total_a_pagar  = $pack->precio;
                    $miembro->cuota  = $cuota;
                    $miembro->cuota_pendiente_tras_primer_pago = $total_a_pagar - $cuota;
                    $miembro->cuota_pendiente_tras_segundo_pago = $miembro->cuota_pendiente_tras_primer_pago - $cuota;
                }
            }
        }

        echo json_encode($miembros);
    }  

    public static function tallas() {

        //Me traigo todos los registros de tallas
        $tallas = Tallas::all('ASC');

        //Me traigo todos los registros de tallas de usuarios
        $tallasUser = Tallasusuarios::all('ASC');

        //Sincronizo tallasUser y tallas
        foreach($tallas as $talla) {
            foreach($tallasUser as $t) {
                if($t->camiseta === $talla->id) {
                    $t->n_camiseta = $talla->nombre_talla;
                }
                if($t->calzona === $talla->id) {
                    $t->n_calzona = $talla->nombre_talla;
                }
                if($t->chandal === $talla->id) {
                    $t->n_chandal = $talla->nombre_talla;
                }
                if($t->Cortavientos === $talla->id) {
                    $t->n_Cortavientos = $talla->nombre_talla;
                }
            }
        }

        //Me traigo todos los registros de usuarios
        $miembros = Usuario::all_ord();
        $miembros = array_filter($miembros, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1";
        });

        //Sincronizo miembros y tallasUser y añado nombre_usuario a tallas
        foreach($tallasUser as $t) {
            foreach($miembros as $miembro) {
                if($t->id_usuario === $miembro->id){
                    $t->nombre_usuario = $miembro->apellido1 . " " . $miembro->apellido2 . ", " . $miembro->nombre;
                    $t->apellido1 = $miembro->apellido1;
                    $t->apellido2 = $miembro->apellido2;
                    $t->nombre = $miembro->nombre;
                }
            }
        }

        // debuguear($tallas);

        echo json_encode($tallasUser);
    }

    public static function asistencia() {

        //Traigo todos los registros de asistencia
        $asistencia = Asistencia::all('ASC');

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

        foreach($asistencia as $as) {
            if($as) {
                $dia = isset($as);
                $mes = date('m', strtotime($dia));
                $as->mes = $mes;
            }
        }
         
        


        echo json_encode($asistencia);
    }

    public static function categorias() {

        //Me traigo todos los registros de categorias
        $packs = Pack::all('ASC');
        // debuguear($packs);

        //Me traigo todos los registros por packs
        //1- Pack completo
        $completo = Usuario::whereAll('pack_id', "4");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $completo = array_filter($completo, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_completo = count($completo);
        $n_completo= strval($n_completo);

        //2- Pack cenas
        $cenas = Usuario::whereAll('pack_id', "2");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $cenas = array_filter($cenas, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_cenas = count($cenas);
        $n_cenas= strval($n_cenas);

        //3- Pack ropa
        $ropa = Usuario::whereAll('pack_id', "3");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $ropa = array_filter($ropa, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_ropa = count($ropa);
        $n_ropa= strval($n_ropa);

        //4- Pack entrenos
        $entrenos = Usuario::whereAll('pack_id', "1");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $entrenos = array_filter($entrenos, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_entrenos = count($entrenos);
        $n_entrenos= strval($n_entrenos);

        //4- Pack especial solo ropa
        $especial = Usuario::whereAll('pack_id', "5");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $especial = array_filter($especial, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_especial = count($especial);
        $n_especial= strval($n_especial);

        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->total = $n_entrenos;
            }
            if($pack->id === "2") {
                $pack->total = $n_cenas;
            }
            if($pack->id === "3") {
                $pack->total = $n_ropa;
            }
            if($pack->id === "4") {
                $pack->total = $n_completo;
            }
            if($pack->id === "5") {
                $pack->total = $n_especial;
            }
        }

        // debuguear($packs);

        echo json_encode($packs);
    }

    public static function categorias_packs() {

        //Me traigo todos los registros de packs
        $packs = Pack::all('ASC');
        // debuguear($packs);

        //Me traigo todos los registros por categorías

        //1- Arbitro primera división
        $primera_division = Usuario::whereAll('categoria_id', "1");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $primera_division = array_filter($primera_division, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_primera_division = count($primera_division);
        $n_primera_division= strval($n_primera_division);
        // debuguear($primera_division);

        $a_prim_div = [];
        foreach($primera_division as $p) {
            if($p->pack_id === "1") {
                $a_prim_div['entrenos']++;
            }
            if($p->pack_id === "2") {
                $a_prim_div['cenas']++;
            }
            if($p->pack_id === "3") {
                $a_prim_div['ropa']++;
            }
            if($p->pack_id === "4") {
                $a_prim_div['completo']++;
            }
            if($p->pack_id === "5") {
                $a_prim_div['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //2- Asistente primera división
        $aprimera_division = Usuario::whereAll('categoria_id', "2");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $aprimera_division = array_filter($aprimera_division, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_aprimera_division = count($aprimera_division);
        $n_aprimera_division= strval($n_aprimera_division);
        // debuguear($aprimera_division);

        $aa_prim_div = [];
        foreach($aprimera_division as $p) {
            if($p->pack_id === "1") {
                $aa_prim_div['entrenos']++;
            }
            if($p->pack_id === "2") {
                $aa_prim_div['cenas']++;
            }
            if($p->pack_id === "3") {
                $aa_prim_div['ropa']++;
            }
            if($p->pack_id === "4") {
                $aa_prim_div['completo']++;
            }
            if($p->pack_id === "5") {
                $aa_prim_div['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //3- Árbitro segunda división
        $segunda_division = Usuario::whereAll('categoria_id', "3");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $segunda_division = array_filter($segunda_division, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_segunda_division = count($segunda_division);
        $n_segunda_division= strval($n_segunda_division);
        // debuguear($aprimera_division);

        $a_seg_div = [];
        foreach($segunda_division as $p) {
            if($p->pack_id === "1") {
                $a_seg_div['entrenos']++;
            }
            if($p->pack_id === "2") {
                $a_seg_div['cenas']++;
            }
            if($p->pack_id === "3") {
                $a_seg_div['ropa']++;
            }
            if($p->pack_id === "4") {
                $a_seg_div['completo']++;
            }
            if($p->pack_id === "5") {
                $a_seg_div['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //4- Asistente segunda división
        $asegunda_division = Usuario::whereAll('categoria_id', "4");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $asegunda_division = array_filter($asegunda_division, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_asegunda_division = count($asegunda_division);
        $n_asegunda_division= strval($n_asegunda_division);
        // debuguear($aprimera_division);

        $aa_seg_div = [];
        foreach($asegunda_division as $p) {
            if($p->pack_id === "1") {
                $aa_seg_div['entrenos']++;
            }
            if($p->pack_id === "2") {
                $aa_seg_div['cenas']++;
            }
            if($p->pack_id === "3") {
                $aa_seg_div['ropa']++;
            }
            if($p->pack_id === "4") {
                $aa_seg_div['completo']++;
            }
            if($p->pack_id === "5") {
                $aa_seg_div['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //5- Árbitro primera RFEF
        $primera_RFEF = Usuario::whereAll('categoria_id', "5");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $primera_RFEF = array_filter($primera_RFEF, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_primera_RFEF = count($primera_RFEF);
        $n_primera_RFEF= strval($n_primera_RFEF);
        // debuguear($aprimera_division);

        $a_primera_rfef = [];
        foreach($primera_RFEF as $p) {
            if($p->pack_id === "1") {
                $a_primera_rfef['entrenos']++;
            }
            if($p->pack_id === "2") {
                $a_primera_rfef['cenas']++;
            }
            if($p->pack_id === "3") {
                $a_primera_rfef['ropa']++;
            }
            if($p->pack_id === "4") {
                $a_primera_rfef['completo']++;
            }
            if($p->pack_id === "5") {
                $a_primera_rfef['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //6- Asistente primera RFEF
        $aprimera_RFEF = Usuario::whereAll('categoria_id', "6");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $aprimera_RFEF = array_filter($aprimera_RFEF, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_aprimera_RFEF = count($aprimera_RFEF);
        $n_aprimera_RFEF= strval($n_aprimera_RFEF);
        // debuguear($aprimera_division);

        $aa_primera_rfef = [];
        foreach($aprimera_RFEF as $p) {
            if($p->pack_id === "1") {
                $aa_primera_rfef['entrenos']++;
            }
            if($p->pack_id === "2") {
                $aa_primera_rfef['cenas']++;
            }
            if($p->pack_id === "3") {
                $aa_primera_rfef['ropa']++;
            }
            if($p->pack_id === "4") {
                $aa_primera_rfef['completo']++;
            }
            if($p->pack_id === "5") {
                $aa_primera_rfef['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //7- Árbitro segunda RFEF
        $segunda_RFEF = Usuario::whereAll('categoria_id', "7");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $segunda_RFEF = array_filter($segunda_RFEF, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_segunda_RFEF = count($segunda_RFEF);
        $n_segunda_RFEF= strval($n_segunda_RFEF);
        // debuguear($aprimera_division);

        $a_segunda_rfef = [];
        foreach($segunda_RFEF as $p) {
            if($p->pack_id === "1") {
                $a_segunda_rfef['entrenos']++;
            }
            if($p->pack_id === "2") {
                $a_segunda_rfef['cenas']++;
            }
            if($p->pack_id === "3") {
                $a_segunda_rfef['ropa']++;
            }
            if($p->pack_id === "4") {
                $a_segunda_rfef['completo']++;
            }
            if($p->pack_id === "5") {
                $a_segunda_rfef['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //8- Asistente segunda RFEF
        $asegunda_RFEF = Usuario::whereAll('categoria_id', "8");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $asegunda_RFEF = array_filter($asegunda_RFEF, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_asegunda_RFEF = count($asegunda_RFEF);
        $n_asegunda_RFEF= strval($n_asegunda_RFEF);
        // debuguear($aprimera_division);

        $aa_segunda_rfef = [];
        foreach($asegunda_RFEF as $p) {
            if($p->pack_id === "1") {
                $aa_segunda_rfef['entrenos']++;
            }
            if($p->pack_id === "2") {
                $aa_segunda_rfef['cenas']++;
            }
            if($p->pack_id === "3") {
                $aa_segunda_rfef['ropa']++;
            }
            if($p->pack_id === "4") {
                $aa_segunda_rfef['completo']++;
            }
            if($p->pack_id === "5") {
                $aa_segunda_rfef['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //9- Árbitro tercera RFEF
        $tercera_RFEF = Usuario::whereAll('categoria_id', "9");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $tercera_RFEF = array_filter($tercera_RFEF, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_tercera_RFEF = count($tercera_RFEF);
        $n_tercera_RFEF= strval($n_tercera_RFEF);
        // debuguear($aprimera_division);

        $a_tercera_rfef = [];
        foreach($tercera_RFEF as $p) {
            if($p->pack_id === "1") {
                $a_tercera_rfef['entrenos']++;
            }
            if($p->pack_id === "2") {
                $a_tercera_rfef['cenas']++;
            }
            if($p->pack_id === "3") {
                $a_tercera_rfef['ropa']++;
            }
            if($p->pack_id === "4") {
                $a_tercera_rfef['completo']++;
            }
            if($p->pack_id === "5") {
                $a_tercera_rfef['especial']++;
            }
        }
        // debuguear($a_prim_div);

        //10- Asistente tercera RFEF
        $atercera_RFEF = Usuario::whereAll('categoria_id', "10");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $atercera_RFEF = array_filter($atercera_RFEF, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_atercera_RFEF = count($atercera_RFEF);
        $n_atercera_RFEF= strval($n_atercera_RFEF);
        // debuguear($aprimera_division);

        $as_tercera_rfef = [];
        foreach($atercera_RFEF as $p) {
            if($p->pack_id === "1") {
                $as_tercera_rfef['entrenos']++;
            }
            if($p->pack_id === "2") {
                $as_tercera_rfef['cenas']++;
            }
            if($p->pack_id === "3") {
                $as_tercera_rfef['ropa']++;
            }
            if($p->pack_id === "4") {
                $as_tercera_rfef['completo']++;
            }
            if($p->pack_id === "5") {
                $as_tercera_rfef['especial']++;
            }
        }
        // debuguear($a_prim_div);
        
        //11- Árbitro DH
        $division_honor = Usuario::whereAll('categoria_id', "11");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $division_honor = array_filter($division_honor, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_division_honor = count($division_honor);
        $n_division_honor= strval($n_division_honor);
        // debuguear($division_honor);

        $dh = [];
        foreach($division_honor as $p) {
            if($p->pack_id === "1") {
                $dh['entrenos']++;
            }
            if($p->pack_id === "2") {
                $dh['cenas']++;
            }
            if($p->pack_id === "3") {
                $dh['ropa']++;
            }
            if($p->pack_id === "4") {
                $dh['completo']++;
            }
            if($p->pack_id === "5") {
                $dh['especial']++;
            }
        }
        // debuguear($dh);

        //12- Provincial
        $provincial = Usuario::whereAll('categoria_id', "12");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $provincial = array_filter($provincial, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_provincial = count($provincial);
        $n_provincial= strval($n_provincial);

        // debuguear($provincial);
        

        $provinciales = [];
        foreach($provincial as $p) {
            if($p->pack_id === "1") {
                $provinciales['entrenos']++;
            }
            if($p->pack_id === "2") {
                $provinciales['cenas']++;
            }
            if($p->pack_id === "3") {
                $provinciales['ropa']++;
            }
            if($p->pack_id === "4") {
                $provinciales['completo']++;
            }
            if($p->pack_id === "5") {
                $provinciales['especial']++;
            }
        }
        // debuguear($provinciales);

        //13- Oficial
        $oficial = Usuario::whereAll('categoria_id', "13");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $oficial = array_filter($oficial, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_oficial = count($oficial);
        $n_oficial= strval($n_oficial);
        // debuguear($aprimera_division);

        $oficiales = [];
        foreach($oficial as $p) {
            if($p->pack_id === "1") {
                $oficiales['entrenos']++;
            }
            if($p->pack_id === "2") {
                $oficiales['cenas']++;
            }
            if($p->pack_id === "3") {
                $oficiales['ropa']++;
            }
            if($p->pack_id === "4") {
                $oficiales['completo']++;
            }
            if($p->pack_id === "5") {
                $oficiales['especial']++;
            }
        }
        // debuguear($oficiales);

        //14- Auxiliar
        $auxiliar = Usuario::whereAll('categoria_id', "14");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $auxiliar = array_filter($auxiliar, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_auxiliar = count($auxiliar);
        $n_auxiliar= strval($n_auxiliar);
        // debuguear($aprimera_division);

        $auxiliares = [];
        foreach($auxiliar as $p) {
            if($p->pack_id === "1") {
                $auxiliares['entrenos']++;
            }
            if($p->pack_id === "2") {
                $auxiliares['cenas']++;
            }
            if($p->pack_id === "3") {
                $auxiliares['ropa']++;
            }
            if($p->pack_id === "4") {
                $auxiliares['completo']++;
            }
            if($p->pack_id === "5") {
                $auxiliares['especial']++;
            }
        }
        // debuguear($auxiliares);

        //15- FB
        $base = Usuario::whereAll('categoria_id', "15");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $base = array_filter($base, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_base = count($base);
        $n_base= strval($n_base);
        // debuguear($aprimera_division);

        $fb = [];
        foreach($base as $p) {
            if($p->pack_id === "1") {
                $fb['entrenos']++;
            }
            if($p->pack_id === "2") {
                $fb['cenas']++;
            }
            if($p->pack_id === "3") {
                $fb['ropa']++;
            }
            if($p->pack_id === "4") {
                $fb['completo']++;
            }
            if($p->pack_id === "5") {
                $fb['especial']++;
            }
        }
        // debuguear($fb);

        //16- Rugby
        $rugby = Usuario::whereAll('categoria_id', "16");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $rugby = array_filter($rugby, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_rugby = count($rugby);
        $n_rugby= strval($n_rugby);
        // debuguear($aprimera_division);

        $rgb = [];
        foreach($rugby as $p) {
            if($p->pack_id === "1") {
                $rgb['entrenos']++;
            }
            if($p->pack_id === "2") {
                $rgb['cenas']++;
            }
            if($p->pack_id === "3") {
                $rgb['ropa']++;
            }
            if($p->pack_id === "4") {
                $rgb['completo']++;
            }
            if($p->pack_id === "5") {
                $rgb['especial']++;
            }
        }
        // debuguear($rgb);

        //17- Retirado
        $retirado = Usuario::whereAll('categoria_id', "17");
        // Filtra miembros para eliminar aquellos que sean admin y directivos
        $retirado = array_filter($retirado, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });
        $n_retirado = count($retirado);
        $n_retirado= strval($n_retirado);
        // debuguear($aprimera_division);

        $reti = [];
        foreach($retirado as $p) {
            if($p->pack_id === "1") {
                $reti['entrenos']++;
            }
            if($p->pack_id === "2") {
                $reti['cenas']++;
            }
            if($p->pack_id === "3") {
                $reti['ropa']++;
            }
            if($p->pack_id === "4") {
                $reti['completo']++;
            }
            if($p->pack_id === "5") {
                $reti['especial']++;
            }
        }
        // debuguear($reti);

        //Cruzo los datos de distintas categorías con packs
        //Árbitro primera división:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->primera_div = $a_prim_div['entrenos'];
            }
            if($pack->id === "2") {
                $pack->primera_div = $a_prim_div['cenas'];
            }
            if($pack->id === "3") {
                $pack->primera_div = $a_prim_div['ropa'];
            }
            if($pack->id === "4") {
                $pack->primera_div = $a_prim_div['completo'];
            }
            if($pack->id === "5") {
                $pack->primera_div = $a_prim_div['especial'];
            }
        }
        //Asistente primera división:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->aa_primera_div = $aa_prim_div['entrenos'];
            }
            if($pack->id === "2") {
                $pack->aa_primera_div = $aa_prim_div['cenas'];
            }
            if($pack->id === "3") {
                $pack->aa_primera_div = $aa_prim_div['ropa'];
            }
            if($pack->id === "4") {
                $pack->aa_primera_div = $aa_prim_div['completo'];
            }
            if($pack->id === "5") {
                $pack->aa_primera_div = $aa_prim_div['especial'];
            }
        }
        //Árbitro segunda división:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->segunda_div = $a_seg_div['entrenos'];
            }
            if($pack->id === "2") {
                $pack->segunda_div = $a_seg_div['cenas'];
            }
            if($pack->id === "3") {
                $pack->segunda_div = $a_seg_div['ropa'];
            }
            if($pack->id === "4") {
                $pack->segunda_div = $a_seg_div['completo'];
            }
            if($pack->id === "5") {
                $pack->segunda_div = $a_seg_div['especial'];
            }
        }
        //Asistente segunda división:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->aa_segunda_div = $aa_seg_div['entrenos'];
            }
            if($pack->id === "2") {
                $pack->aa_segunda_div = $aa_seg_div['cenas'];
            }
            if($pack->id === "3") {
                $pack->aa_segunda_div = $aa_seg_div['ropa'];
            }
            if($pack->id === "4") {
                $pack->aa_segunda_div = $aa_seg_div['completo'];
            }
            if($pack->id === "5") {
                $pack->aa_segunda_div = $aa_seg_div['especial'];
            }
        }
        //Árbitro primera RFEF:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->primera_rfef = $a_primera_rfef['entrenos'];
            }
            if($pack->id === "2") {
                $pack->primera_rfef = $a_primera_rfef['cenas'];
            }
            if($pack->id === "3") {
                $pack->primera_rfef = $a_primera_rfef['ropa'];
            }
            if($pack->id === "4") {
                $pack->primera_rfef = $a_primera_rfef['completo'];
            }
            if($pack->id === "5") {
                $pack->primera_rfef = $a_primera_rfef['especial'];
            }
        }
        //Asistente primera RFEF:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->aa_primera_rfef = $aa_primera_rfef['entrenos'];
            }
            if($pack->id === "2") {
                $pack->aa_primera_rfef = $aa_primera_rfef['cenas'];
            }
            if($pack->id === "3") {
                $pack->aa_primera_rfef = $aa_primera_rfef['ropa'];
            }
            if($pack->id === "4") {
                $pack->aa_primera_rfef = $aa_primera_rfef['completo'];
            }
            if($pack->id === "5") {
                $pack->aa_primera_rfef = $aa_primera_rfef['especial'];
            }
        }
        //Árbitro segunda RFEF:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->segunda_rfef = $a_segunda_rfef['entrenos'];
            }
            if($pack->id === "2") {
                $pack->segunda_rfef = $a_segunda_rfef['cenas'];
            }
            if($pack->id === "3") {
                $pack->segunda_rfef = $a_segunda_rfef['ropa'];
            }
            if($pack->id === "4") {
                $pack->segunda_rfef = $a_segunda_rfef['completo'];
            }
            if($pack->id === "5") {
                $pack->segunda_rfef = $a_segunda_rfef['especial'];
            }
        }
        //Asistente segunda RFEF:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->aa_segunda_rfef = $aa_segunda_rfef['entrenos'];
            }
            if($pack->id === "2") {
                $pack->aa_segunda_rfef = $aa_segunda_rfef['cenas'];
            }
            if($pack->id === "3") {
                $pack->aa_segunda_rfef = $aa_segunda_rfef['ropa'];
            }
            if($pack->id === "4") {
                $pack->aa_segunda_rfef = $aa_segunda_rfef['completo'];
            }
            if($pack->id === "5") {
                $pack->aa_segunda_rfef = $aa_segunda_rfef['especial'];
            }
        }
        //Tercera:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->tercera = $a_tercera_rfef['entrenos'];
            }
            if($pack->id === "2") {
                $pack->tercera = $a_tercera_rfef['cenas'];
            }
            if($pack->id === "3") {
                $pack->tercera = $a_tercera_rfef['ropa'];
            }
            if($pack->id === "4") {
                $pack->tercera = $a_tercera_rfef['completo'];
            }
            if($pack->id === "5") {
                $pack->tercera = $a_tercera_rfef['especial'];
            }
        }
        //Asistente Tercera:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->aa_tercera = $as_tercera_rfef['entrenos'];
            }
            if($pack->id === "2") {
                $pack->aa_tercera = $as_tercera_rfef['cenas'];
            }
            if($pack->id === "3") {
                $pack->aa_tercera = $as_tercera_rfef['ropa'];
            }
            if($pack->id === "4") {
                $pack->aa_tercera = $as_tercera_rfef['completo'];
            }
            if($pack->id === "5") {
                $pack->aa_tercera = $as_tercera_rfef['especial'];
            }
        }
        //División de honor:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->division_honor = $dh['entrenos'];
            }
            if($pack->id === "2") {
                $pack->division_honor = $dh['cenas'];
            }
            if($pack->id === "3") {
                $pack->division_honor = $dh['ropa'];
            }
            if($pack->id === "4") {
                $pack->division_honor = $dh['completo'];
            }
            if($pack->id === "5") {
                $pack->division_honor = $dh['especial'];
            }
        }
        //Provinciales:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->provinciales = $provinciales['entrenos'];
            }
            if($pack->id === "2") {
                $pack->provinciales = $provinciales['cenas'];
            }
            if($pack->id === "3") {
                $pack->provinciales = $provinciales['ropa'];
            }
            if($pack->id === "4") {
                $pack->provinciales = $provinciales['completo'];
            }
            if($pack->id === "5") {
                $pack->provinciales = $provinciales['especial'];
            }
        }
        //Oficiales:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->oficiales = $oficiales['entrenos'];
            }
            if($pack->id === "2") {
                $pack->oficiales = $oficiales['cenas'];
            }
            if($pack->id === "3") {
                $pack->oficiales = $oficiales['ropa'];
            }
            if($pack->id === "4") {
                $pack->oficiales = $oficiales['completo'];
            }
            if($pack->id === "5") {
                $pack->oficiales = $oficiales['especial'];
            }
        }
        //Auxiliares:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->auxiliares = $auxiliares['entrenos'];
            }
            if($pack->id === "2") {
                $pack->auxiliares = $auxiliares['cenas'];
            }
            if($pack->id === "3") {
                $pack->auxiliares = $auxiliares['ropa'];
            }
            if($pack->id === "4") {
                $pack->auxiliares = $auxiliares['completo'];
            }
            if($pack->id === "5") {
                $pack->auxiliares = $auxiliares['especial'];
            }
        }
        //Fútbol Base:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->futbol_base = $fb['entrenos'];
            }
            if($pack->id === "2") {
                $pack->futbol_base = $fb['cenas'];
            }
            if($pack->id === "3") {
                $pack->futbol_base = $fb['ropa'];
            }
            if($pack->id === "4") {
                $pack->futbol_base = $fb['completo'];
            }
            if($pack->id === "5") {
                $pack->futbol_base = $fb['especial'];
            }
        }
        //Rugby:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->rugby = $rgb['entrenos'];
            }
            if($pack->id === "2") {
                $pack->rugby = $rgb['cenas'];
            }
            if($pack->id === "3") {
                $pack->rugby = $rgb['ropa'];
            }
            if($pack->id === "4") {
                $pack->rugby = $rgb['completo'];
            }
            if($pack->id === "5") {
                $pack->rugby = $rgb['especial'];
            }
        }
        //Retirado:
        foreach($packs as $pack) {
            if($pack->id === "1") {
                $pack->retirado = $reti['entrenos'];
            }
            if($pack->id === "2") {
                $pack->retirado = $reti['cenas'];
            }
            if($pack->id === "3") {
                $pack->retirado = $reti['ropa'];
            }
            if($pack->id === "4") {
                $pack->retirado = $reti['completo'];
            }
            if($pack->id === "5") {
                $pack->retirado = $reti['especial'];
            }
        }

        //Quito los nulos y pongo 0
        foreach($packs as $pack) {
            if(!$pack->primera_div) {
                $pack->primera_div = strval(0);
            } else {
                $pack->primera_div = strval($pack->aa_primera_div);
            }

            if(!$pack->aa_primera_div) {
                $pack->aa_primera_div = strval(0);
            } else {
                $pack->aa_primera_div = strval($pack->aa_primera_div);
            }

            if(!$pack->segunda_div) {
                $pack->segunda_div = strval(0);
            } else {
                $pack->segunda_div = strval($pack->segunda_div);
            }

            if(!$pack->aa_segunda_div) {
                $pack->aa_segunda_div = strval(0);
            } else {
                $pack->aa_segunda_div = strval($pack->aa_segunda_div);
            }

            if(!$pack->primera_rfef) {
                $pack->primera_rfef = strval(0);
            } else {
                $pack->primera_rfef = strval($pack->primera_rfef);
            }

            if(!$pack->aa_primera_rfef) {
                $pack->aa_primera_rfef = strval(0);
            } else {
                $pack->aa_primera_rfef = strval($pack->aa_primera_rfef);
            }

            if(!$pack->segunda_rfef) {
                $pack->segunda_rfef = strval(0);
            } else {
                $pack->segunda_rfef = strval($pack->segunda_rfef);
            }

            if(!$pack->aa_segunda_rfef) {
                $pack->aa_segunda_rfef = strval(0);
            } else {
                $pack->aa_segunda_rfef = strval($pack->aa_segunda_rfef);
            }

            if(!$pack->tercera) {
                $pack->tercera = strval(0);
            } else {
                $pack->tercera = strval($pack->tercera);
            }

            if(!$pack->aa_tercera) {
                $pack->aa_tercera = strval(0);
            } else {
                $pack->aa_tercera = strval($pack->aa_tercera);
            }

            if(!$pack->division_honor) {
                $pack->division_honor = strval(0);
            } else {
                $pack->division_honor = strval($pack->division_honor);
            }

            if(!$pack->provinciales) {
                $pack->provinciales = strval(0);
            } else {
                $pack->provinciales = strval($pack->provinciales);
            }

            if(!$pack->oficiales) {
                $pack->oficiales = strval(0);
            } else {
                $pack->oficiales = strval($pack->oficiales);
            }

            if(!$pack->auxiliares) {
                $pack->auxiliares = strval(0);
            } else {
                $pack->auxiliares = strval($pack->auxiliares);
            }

            if(!$pack->futbol_base) {
                $pack->futbol_base = strval(0);
            } else {
                $pack->futbol_base = strval($pack->futbol_base);
            }

            if(!$pack->rugby) {
                $pack->rugby = strval(0);
            } else {
                $pack->rugby = strval($pack->rugby);
            }

            if(!$pack->retirado) {
                $pack->retirado = strval(0);
            } else {
                $pack->retirado = strval($pack->retirado);
            }
        }

        // debuguear($packs);

        echo json_encode($packs);
    }

    public static function ingresos_packs() {

        // Creo array para ir almacenando los ingresos
        $ingresos_por_pack = [];

        //Creo una variable para cada packs
        $entreno = 0;
        $cenas = 0;
        $ropa = 0;
        $completo = 0;
        $especial = 0;

        //Me traigo todos los registros de usuarios
        $usuarios = Usuario::all();
        // debuguear($usuarios);

        //Me traigo todos los registros de packs
        $packs = Pack::all();
        // debuguear($packs);

        // Filtro los usuarios para eliminar al administrador y directivos
        $usuarios = array_filter($usuarios, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });

        // Cruzo los datos de usuarios y packs para añadir a usuarios el precio del pack y que sea dinámico
        foreach($usuarios as $user) {
            foreach ($packs as $pack) {
                if($user->pack_id === $pack->id) {
                    $user->nombre_pack = $pack->nombre_pack;
                    $user->precio_pack = $pack->precio;
                }
            }
        }
        // debuguear($usuarios);

        // Recorro objeto de usuarios para ir filtrando la información
        foreach($usuarios as $user) {
            if($user->pack_id === "1") {
                $entreno++;
            }
            if($user->pack_id === "2") {
                $cenas++;
            }
            if($user->pack_id === "3") {
                $ropa++;
            }
            if($user->pack_id === "4") {
                $completo++;
            }
            if($user->pack_id === "5") {
                $especial++;
            }
        }
        // debuguear($ropa);

        // Creo variables para el precio del pack y almaceno valores
        $precio_entreno = 0;
        $precio_cenas = 0;
        $precio_ropa = 0;
        $precio_completo = 0;
        $precio_especial = 0;

        foreach($usuarios as $user) {
            if($user->pack_id === "1") {
                $precio_entreno = intval($user->precio_pack);
            }
            if($user->pack_id === "2") {
                $precio_cenas = intval($user->precio_pack);
            }
            if($user->pack_id === "3") {
                $precio_ropa = intval($user->precio_pack);
            }
            if($user->pack_id === "4") {
                $precio_completo = intval($user->precio_pack);
            }
            if($user->pack_id === "5") {
                $precio_especial = intval($user->precio_pack);
            }
        }
        // debuguear($precio_especial);

        //Relleno array ingresos por packs con valores de los precios
        $pack_solo_entrenos = $entreno * $precio_entreno;
        $pack_entrenos_cenas = $cenas * $precio_cenas;
        $pack_entrenos_ropa = $ropa * $precio_ropa;
        $pack_completo = $completo * $precio_completo;
        $pack_especial_solo_ropa = $especial * $precio_especial;

        $ingresos_por_pack['Solo_entrenos'] = $pack_solo_entrenos;
        $ingresos_por_pack['Entrenos_cenas'] = $pack_entrenos_cenas;
        $ingresos_por_pack['Entrenos_ropa'] = $pack_entrenos_ropa;
        $ingresos_por_pack['Completo'] = $pack_completo;
        $ingresos_por_pack['Especial_ropa'] = $pack_especial_solo_ropa;
        $ingresos_por_pack['ingresos_totales_packs'] = $pack_solo_entrenos + $pack_entrenos_cenas + $pack_entrenos_ropa + $pack_completo + $pack_especial_solo_ropa;

        // debuguear($ingresos_por_pack);

        echo json_encode($ingresos_por_pack);
    }

    public static function ingresos_categorias() {

        // Creo variable para ir almacenando los ingresos
        $ingresos_primera_div = 0;
        $ingresos_aaprimera_div = 0;
        $ingresos_segunda_div = 0;
        $ingresos_aasegunda_div = 0;
        $ingresos_primera_rfef = 0;
        $ingresos_aaprimera_rfef = 0;
        $ingresos_segunda_rfef = 0;
        $ingresos_aasegunda_rfef = 0;
        $ingresos_tercera_rfef = 0;
        $ingresos_aatercera_rfef = 0;
        $ingresos_dh = 0;
        $ingresos_provinciales = 0;
        $ingresos_oficiales = 0;
        $ingresos_auxiliares = 0;
        $ingresos_fb = 0;
        $ingresos_retirado = 0;
        $ingresos_rugby = 0;

        //Me traigo todos los registros de usuarios
        $usuarios = Usuario::all();
        // debuguear($usuarios);

        //Me traigo todos los registros de packs
        $packs = Pack::all();
        // debuguear($packs);

        // Filtro los usuarios para eliminar al administrador y directivos
        $usuarios = array_filter($usuarios, function($tot) {
            // Devuelve true para conservar el elemento, false para eliminarlo
            return $tot->admin !== "1" && $tot->directivo !== '1';
        });

        // Cruzo los datos de usuarios y packs para añadir a usuarios el precio del pack y que sea dinámico
        foreach($usuarios as $user) {
            foreach ($packs as $pack) {
                if($user->pack_id === $pack->id) {
                    $user->nombre_pack = $pack->nombre_pack;
                    $user->precio_pack = $pack->precio;
                }
            }
        }
        // debuguear($usuarios);

        // Recorro objeto de usuarios para ir filtrando la información
        foreach($usuarios as $user) {
            if($user->categoria_id === "1") {
                $ingresos_primera_div = $ingresos_primera_div + intval($user->precio_pack);
            }
            if($user->categoria_id === "2") {
                $ingresos_aaprimera_div = $ingresos_aaprimera_div + intval($user->precio_pack);
            }
            if($user->categoria_id === "3") {
                $ingresos_segunda_div = $ingresos_segunda_div + intval($user->precio_pack);
            }
            if($user->categoria_id === "4") {
                $ingresos_aasegunda_div = $ingresos_aasegunda_div + intval($user->precio_pack);
            }
            if($user->categoria_id === "5") {
                $ingresos_primera_rfef = $ingresos_primera_rfef + intval($user->precio_pack);
            }
            if($user->categoria_id === "6") {
                $ingresos_aaprimera_rfef = $ingresos_aaprimera_rfef + intval($user->precio_pack);
            }
            if($user->categoria_id === "7") {
                $ingresos_segunda_rfef = $ingresos_segunda_rfef + intval($user->precio_pack);
            }
            if($user->categoria_id === "8") {
                $ingresos_aasegunda_rfef = $ingresos_aasegunda_rfef + intval($user->precio_pack);
            }
            if($user->categoria_id === "9") {
                $ingresos_tercera_rfef = $ingresos_tercera_rfef + intval($user->precio_pack);
            }
            if($user->categoria_id === "10") {
                $ingresos_aatercera_rfef = $ingresos_aatercera_rfef + intval($user->precio_pack);
            }
            if($user->categoria_id === "11") {
                $ingresos_dh = $ingresos_dh + intval($user->precio_pack);
            }
            if($user->categoria_id === "12") {
                $ingresos_provinciales = $ingresos_provinciales + intval($user->precio_pack);
            }
            if($user->categoria_id === "13") {
                $ingresos_oficiales = $ingresos_oficiales + intval($user->precio_pack);
            }
            if($user->categoria_id === "14") {
                $ingresos_auxiliares = $ingresos_auxiliares + intval($user->precio_pack);
            }
            if($user->categoria_id === "15") {
                $ingresos_fb = $ingresos_fb + intval($user->precio_pack);
            }
            if($user->categoria_id === "17") {
                $ingresos_retirado = $ingresos_retirado + intval($user->precio_pack);
            }
            if($user->categoria_id === "16") {
                $ingresos_rugby = $ingresos_rugby + intval($user->precio_pack);
            }
        }
        // debuguear($ingresos_provinciales);

        //Creo array y la relleno con valores de las categorías
        $ingresos_por_categoria = [];

        $ingresos_por_categoria['Primera_división'] = $ingresos_primera_div;
        $ingresos_por_categoria['Asistente_Primera_división'] = $ingresos_aaprimera_div;
        $ingresos_por_categoria['Segunda_división'] = $ingresos_segunda_div;
        $ingresos_por_categoria['Asistente_Segunda_división'] = $ingresos_aasegunda_div;
        $ingresos_por_categoria['Primera_RFEF'] = $ingresos_primera_rfef;
        $ingresos_por_categoria['Asistente_Primera_RFEF'] = $ingresos_aaprimera_rfef;
        $ingresos_por_categoria['Segunda_RFEF'] = $ingresos_segunda_rfef;
        $ingresos_por_categoria['Asistente_Segunda_RFEF'] = $ingresos_aasegunda_rfef;
        $ingresos_por_categoria['Tercera_RFEF'] = $ingresos_tercera_rfef;
        $ingresos_por_categoria['Asistente_Tercera_RFEF'] = $ingresos_aatercera_rfef;
        $ingresos_por_categoria['Division_honor'] = $ingresos_dh;
        $ingresos_por_categoria['Provincial'] = $ingresos_provinciales;
        $ingresos_por_categoria['Oficial'] = $ingresos_oficiales;
        $ingresos_por_categoria['Auxiliar'] = $ingresos_auxiliares;
        $ingresos_por_categoria['Futbol_base'] = $ingresos_fb;
        $ingresos_por_categoria['Retirado'] = $ingresos_retirado;
        $ingresos_por_categoria['Rugby'] = $ingresos_rugby;


        // debuguear($ingresos_por_categoria);

        echo json_encode($ingresos_por_categoria);
    }

    public static function cuentas() {

        $cuentas = [
            "ingresos" => [
                "acumulado" => 0,
                "cuotas" => 0,
                "patrocinio" => 0,
                "otros" => 0,
                "total_ingresos" => 0
            ],
            "gastos" => [
                "equipamiento_deportivo" => 0,
                "cenas" => 0,
                "entrenador" => 0,
                "material" => 0,
                "otros" => 0,
                "total_gastos" => 0
            ]
        ];

        $ingresos = Cuentas::whereAll_unorder('gasto', "0.00");
        // debuguear($ingresos);

        $gastos = Cuentas::whereAll_unorder('ingreso', "0.00");
        // debuguear($gastos);

        //Filtrado de los ingresos:
        foreach($ingresos as $ingreso) {
            // Convertir el concepto a minúsculas
            $concepto_lower = strtolower($ingreso->concepto);
        
            if (strpos($concepto_lower, 'acumulado') !== false) {
                // Agregar el objeto al array de cuentas en su correspondiente lugar:
                $cuentas['ingresos']['acumulado'] += (float)$ingreso->ingreso;
            } elseif (strpos($concepto_lower, 'cuota') !== false) {
                // Agregar el objeto al array de cuentas en su correspondiente lugar:
                $cuentas['ingresos']['cuotas'] += (float)$ingreso->ingreso;
            } elseif (strpos($concepto_lower, 'patrocinio') !== false) {
                // Agregar el objeto al array de cuentas en su correspondiente lugar:
                $cuentas['ingresos']['patrocinio'] += (float)$ingreso->ingreso;
            } else {
                // Para todos los otros casos
                $cuentas['ingresos']['otros'] += (float)$ingreso->ingreso;
            }

            //Calculo del total de ingresos:
            $cuentas['ingresos']['total_ingresos'] += (float)$ingreso->ingreso;
        }

        // Redondear los valores a dos decimales después de la suma
        foreach ($cuentas['ingresos'] as $key => $value) {
            $cuentas['ingresos'][$key] = round($value, 2);
        }


        //Filtrado de los gastos:
        foreach($gastos as $gasto) {
            // Convertir el concepto a minúsculas
            $concepto_lower = strtolower($gasto->concepto);
        
            if (strpos($concepto_lower, 'equipamiento') !== false) {
                // Agregar el objeto al array de cuentas en su correspondiente lugar:
                $cuentas['gastos']['equipamiento_deportivo'] += (float)$gasto->gasto;
            } elseif (strpos($concepto_lower, 'cena') !== false) {
                // Agregar el objeto al array de cuentas en su correspondiente lugar:
                $cuentas['gastos']['cenas'] += (float)$gasto->gasto;
            } elseif (strpos($concepto_lower, 'entrenador') !== false) {
                // Agregar el objeto al array de cuentas en su correspondiente lugar:
                $cuentas['gastos']['entrenador'] += (float)$gasto->gasto;
            } elseif (strpos($concepto_lower, 'material') !== false) {
                $cuentas['gastos']['material'] += (float)$gasto->gasto;
            } else {
                // Para todos los otros casos
                $cuentas['gastos']['otros'] += (float)$gasto->gasto;
            }

            //Calculo del total de gastos:
            $cuentas['gastos']['total_gastos'] += (float)$gasto->gasto;
        }

        // Redondear los valores a dos decimales después de la suma
        foreach ($cuentas['gastos'] as $key => $value) {
            $cuentas['gastos'][$key] = round($value, 2);
        }

        echo json_encode($cuentas);
    }  

    public static function mensajes() {
        session_start();
    
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['id'])) {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Usuario no autenticado']);
            exit;
        }
    
        $usuario_id = $_SESSION['id'];
    
        // Obtener todos los mensajes desde la API externa
        // // Obtener el esquema (http o https)
        // $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

        // // Obtener el nombre del host
        // $host = $_SERVER['HTTP_HOST'];

        // // Construir la URL de origen
        // $origin = $scheme . '://' . $host;

        // $url = $origin . '/api/mensajes';
        $url = '/api/mensajes';
        $mensajes_api = json_decode(file_get_contents($url));
    
        // Obtener todos los mensajes locales (ejemplo con Mensajes::all())
        $mensajes_locales = Mensajes::all();
    
        // Obtener los mensajes marcados como leídos por el usuario actual usando el nuevo método (ejemplo con MensajesLeidos::whereAll_order())
        $mensaje_miembro = MensajesLeidos::whereAll_order('usuario_id', $usuario_id);
    
        // Cruzar los datos para construir el JSON final
        foreach ($mensajes_api as $mensaje_api) {
            foreach ($mensaje_miembro as $mm) {
                if ($mensaje_api->id === $mm->mensaje_id) {
                    $mm->asunto = $mensaje_api->asunto;
                    $mm->cuerpo = $mensaje_api->cuerpo;
                }
            }
        }
    
        // Convertir $mensaje_miembro a un array para evitar problemas con la serialización JSON
        $mensaje_miembro_array = [];
        foreach ($mensaje_miembro as $mm) {
            $mensaje_miembro_array[] = $mm;
        }
    
        // Combinar los mensajes locales con los datos de la API
        $mensajes_combinados = array_merge($mensajes_locales, $mensaje_miembro_array);
    
        // Devolver los mensajes combinados en formato JSON
        header('Content-Type: application/json');
        echo json_encode($mensajes_combinados);
    
        // Marcar mensaje como leído si se recibió mensaje_id en la solicitud
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            if (isset($data->mensaje_id)) {
                // Aquí deberías implementar la lógica para marcar el mensaje como leído en tu base de datos
                // Ejemplo hipotético:
                foreach ($mensaje_miembro as $mm) {
                    if ($mm->mensaje_id == $data->mensaje_id) {
                        // Supongamos que aquí actualizamos el estado leído en el objeto $mm
                        $mm->leido = true;
    
                        // Aquí deberías actualizar la base de datos o realizar las acciones necesarias
                        // Simularemos la actualización enviando una respuesta JSON (simulado)
                        echo json_encode(['success' => 'Mensaje marcado como leído correctamente']);
                        exit;
                    }
                }
                echo json_encode(['error' => 'Mensaje no encontrado']);
                exit;
            } else {
                echo json_encode(['error' => 'Identificador de mensaje no proporcionado']);
                exit;
            }
        }
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
        
                try {
                    $mensajeLeido = new MensajesLeidos([
                        'usuario_id' => $usuario_id,
                        'mensaje_id' => $mensaje_id,
                        'leido' => 1
                    ]);
                    $mensajeLeido->guardar();
        
                    echo json_encode(['success' => true]);
                } catch (\Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al marcar como leído: ' . $e->getMessage()]);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
        }
    }