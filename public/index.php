<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\AsistenciaController;
use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\FotosController;
use Controllers\MemoriaController;
use Controllers\MensajesController;
use Controllers\MiembrosController;
use Controllers\PaginasController;
use Controllers\PlanningController;
use Controllers\RegistradosController;
use Controllers\TallasController;

$router = new Router();

//ÁREA DE AUTENTICACIÓN______________________________________________________________________________________
// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//ÁREA DE ADMINISTRACIÓN_____________________________________________________________________________________
$router->get('/admin/dashboard', [DashboardController::class, 'index']);
$router->get('/admin/dashboard/cuentas', [DashboardController::class, 'cuentas']);
$router->post('/admin/dashboard/cuentas', [DashboardController::class, 'cuentas']);
// $router->get('/admin/dashboard/editar-cuentas', [DashboardController::class, 'editar_cuentas']);
// $router->post('/admin/dashboard/editar-cuentas', [DashboardController::class, 'editar_cuentas']);
$router->get('/admin/dashboard/perfiles', [DashboardController::class, 'perfil']);
$router->get('/admin/dashboard/editar-perfil', [DashboardController::class, 'editar_perfil']);
$router->post('/admin/dashboard/editar-perfil', [DashboardController::class, 'editar_perfil']);

$router->get('/admin/dashboard/packs', [DashboardController::class, 'packs']);
$router->post('/admin/dashboard/añadir-pack', [DashboardController::class, 'añadir_pack']);
$router->get('/admin/dashboard/añadir-pack', [DashboardController::class, 'añadir_pack']);
$router->get('/admin/dashboard/editar-pack', [DashboardController::class, 'editar_pack']);
$router->post('/admin/dashboard/editar-pack', [DashboardController::class, 'editar_pack']);
$router->post('/admin/dashboard/eliminar-pack', [DashboardController::class, 'eliminar_pack']);

$router->get('/admin/dashboard/categorias', [DashboardController::class, 'categorias']);
$router->post('/admin/dashboard/añadir-categoria', [DashboardController::class, 'añadir_categoria']);
$router->get('/admin/dashboard/añadir-categoria', [DashboardController::class, 'añadir_categoria']);
$router->get('/admin/dashboard/editar-categoria', [DashboardController::class, 'editar_categoria']);
$router->post('/admin/dashboard/editar-categoria', [DashboardController::class, 'editar_categoria']);
$router->post('/admin/dashboard/eliminar-categoria', [DashboardController::class, 'eliminar_categoria']);

$router->get('/admin/dashboard/memoria', [MemoriaController::class, 'memoria']);
$router->get('/admin/dashboard/añadir-memoria', [MemoriaController::class, 'añadir_memoria']);
$router->post('/admin/dashboard/añadir-memoria', [MemoriaController::class, 'añadir_memoria']);
$router->post('/admin/dashboard/eliminar-memoria', [MemoriaController::class, 'eliminar_memoria']);

$router->get('/admin/dashboard/mensajes', [MensajesController::class, 'index']);
$router->get('/admin/dashboard/añadir-mensaje', [MensajesController::class, 'añadir_mensaje']);
$router->post('/admin/dashboard/añadir-mensaje', [MensajesController::class, 'añadir_mensaje']);
$router->get('/admin/dashboard/editar-mensaje', [MensajesController::class, 'editar_mensaje']);
$router->post('/admin/dashboard/editar-mensaje', [MensajesController::class, 'editar_mensaje']);
$router->post('/admin/dashboard/eliminar-mensaje', [MensajesController::class, 'eliminar_mensaje']);

$router->get('/admin/miembros', [MiembrosController::class, 'index']);
$router->get('/admin/miembros/crear', [MiembrosController::class, 'crear']);
$router->post('/admin/miembros/crear', [MiembrosController::class, 'crear']);
$router->get('/admin/miembros/editar', [MiembrosController::class, 'editar']);
$router->post('/admin/miembros/editar', [MiembrosController::class, 'editar']);
$router->post('/admin/miembros/eliminar', [MiembrosController::class, 'eliminar']);

$router->get('/admin/miembros/tallas', [TallasController::class, 'index']);
$router->get('/admin/miembros/añadir-talla', [TallasController::class, 'añadir']);
$router->post('/admin/miembros/añadir-talla', [TallasController::class, 'añadir']);
$router->get('/admin/miembros/editar-talla', [TallasController::class, 'editar']);
$router->post('/admin/miembros/editar-talla', [TallasController::class, 'editar']);
$router->post('/admin/miembros/tallas/eliminar', [TallasController::class, 'eliminar']);

//Aunque es de área pública, la va a gestionar el administrador, por lo que la pongo dentro de este bloque
$router->get('/admin/entrenamientos', [PlanningController::class, 'index']);
$router->get('/admin/entrenamientos/añadir', [PlanningController::class, 'añadir_entrenamiento']);
$router->post('/admin/entrenamientos/añadir', [PlanningController::class, 'añadir_entrenamiento']);
$router->get('/admin/entrenamientos/editar', [PlanningController::class, 'editar_entrenamiento']);
$router->post('/admin/entrenamientos/editar', [PlanningController::class, 'editar_entrenamiento']);
$router->post('/admin/entrenamientos/eliminar', [PlanningController::class, 'eliminar_entrenamiento']);

//APIS
$router->get('/api/miembros', [APIController::class, 'index']);
$router->get('/api/tallas', [APIController::class, 'tallas']);
$router->get('/api/asistencia', [APIController::class, 'asistencia']);
$router->get('/api/categorias', [APIController::class, 'categorias']);
$router->get('/api/categorias-packs', [APIController::class, 'categorias_packs']);
$router->get('/api/ingresos-packs', [APIController::class, 'ingresos_packs']);
$router->get('/api/ingresos-categorias', [APIController::class, 'ingresos_categorias']);
$router->get('/api/cuentas', [APIController::class, 'cuentas']);
$router->get('/api/mensajes', [APIController::class, 'mensajes']);


$router->get('/admin/asistencia', [AsistenciaController::class, 'index']);
$router->get('/admin/registrados/lista', [AsistenciaController::class, 'lista']);
$router->post('/admin/registrados/lista', [AsistenciaController::class, 'lista']);

$router->get('/admin/registrados/fotos', [FotosController::class, 'index']);
$router->get('/admin/registrados/fotos-añadir', [FotosController::class, 'añadir']);
$router->post('/admin/registrados/fotos-añadir', [FotosController::class, 'añadir']);
$router->get('/admin/registrados/editar-foto', [FotosController::class, 'editar_foto']);
$router->post('/admin/registrados/editar-foto', [FotosController::class, 'editar_foto']);
$router->post('/admin/registrados/eliminar-foto', [FotosController::class, 'eliminar_foto']);

//ÁREA DE ORGANIZACIÓN_________________________________________________________________________________________
$router->get('/organizacion/dashboard', [DashboardController::class, 'index_organizacion']);

$router->get('/organizacion/miembros', [MiembrosController::class, 'index_organizacion']);

$router->get('/organizacion/registrados/lista-organizacion', [AsistenciaController::class, 'lista_org']);
$router->post('/organizacion/registrados/lista-organizacion', [AsistenciaController::class, 'lista_org']);

$router->get('/organizacion/registrados/fotos-organizacion', [FotosController::class, 'index_org']);
$router->get('/organizacion/registrados/fotos-organizacion-añadir', [FotosController::class, 'añadir_org']);
$router->post('/organizacion/registrados/fotos-organizacion-añadir', [FotosController::class, 'añadir_org']);
$router->get('/organizacion/registrados/editar-foto_org', [FotosController::class, 'editar_foto_org']);
$router->post('/organizacion/registrados/editar-foto_org', [FotosController::class, 'editar_foto_org']);
$router->post('/organizacion/registrados/eliminar-foto_org', [FotosController::class, 'eliminar_foto_org']);

$router->get('/organizacion/asistencia', [AsistenciaController::class, 'index_org']);

$router->get('/admin/registrados', [RegistradosController::class, 'index']);

//ÁREA DE DIRECCIÓN_________________________________________________________________________________________
$router->get('/consultas_direccion/dashboard', [AsistenciaController::class, 'index_dir']);
$router->get('/consultas_direccion/fotos-direccion', [FotosController::class, 'fotos_dir']);
$router->get('/consultas_direccion/informes', [DashboardController::class, 'informes_direccion']);
$router->get('/consultas_direccion/informes/memorias', [MemoriaController::class, 'memorias_direccion']);

//ÁREA DE PÚBLICA_________________________________________________________________________________________
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/packs', [PaginasController::class, 'packs']);
$router->get('/patrocinadores', [PaginasController::class, 'patrocinadores']);
$router->get('/404', [PaginasController::class, 'error']);

//ÁREA DE PRIVADA_________________________________________________________________________________________
$router->get('/area_privada', [PaginasController::class, 'area_privada']);
$router->get('/area_privada-editar', [PaginasController::class, 'area_privada_editar']);
$router->post('/area_privada-editar', [PaginasController::class, 'area_privada_editar']);
$router->get('/area_privada-editar_tallas', [PaginasController::class, 'area_privada_editar_talla']);
$router->post('/area_privada-editar_tallas', [PaginasController::class, 'area_privada_editar_talla']);
$router->get('/area_privada-contraseña', [PaginasController::class, 'area_privada_contraseña']);
$router->post('/area_privada-contraseña', [PaginasController::class, 'area_privada_contraseña']);
$router->get('/area_privada-plannings', [PaginasController::class, 'privada_entrenamientos']);
$router->get('/area_privada-asistencia', [PaginasController::class, 'privada_asistencia']);
$router->get('/area_privada-fotos', [PaginasController::class, 'privada_fotos']);
$router->get('/area_privada-mensajes', [PaginasController::class, 'mensajes']);
$router->post('/marcar_mensaje_leido', [PaginasController::class, 'marcarMensajeLeido']);

$router->comprobarRutas();