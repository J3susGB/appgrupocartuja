<?php
    if(!is_admin()) {
        header('Location: /login');
        exit();
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<?php if(is_admin()) { ?>
    <div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
        <a class="dashboard__boton--panel" href="/admin/miembros/tallas">
            <i class="fa-solid fa-shirt"></i>
            Tallas
        </a>
        <a class="dashboard__boton--panel" href="/admin/miembros/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir
        </a>
    </div>
<?php } ?>


<div id="filtros" class="dashboard__filtros">
    <h3 id="filtro_ppal" class="grid-item-full">Filtros:</h3>
    <div id="b_nombre" class="dashboard__inputs dashboard__inputs--text grid-item-row2-col1">
        <h4>Buscar:</h4>
        <div class="dashboard__campo">
            <input 
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Busca por nombre o apellidos"
                value=""
            />
        </div>
    </div>
    <div id="b_cat" class="dashboard__inputs dashboard__inputs--text grid-item-row2-col2">
        <h4>Categoría:</h4>
        <select class="dashboard__campo" name="categoria" id="categoria">
            <option selected  value="">Ver todos</option>
            <?php foreach($categorias as $cat) { ?>
                <option value="<?php echo $cat->id; ?>"><?php echo $cat->nombre_cat; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="b_pack" class="dashboard__inputs dashboard__inputs--text grid-item-row3-col1">
        <h4>Pack:</h4>
        <div class="dashboard__campo">
            <select class="dashboard__campo" name="filtroPack" id="filtroPack">
                <option selected value="">Ver todos</option>
                <?php foreach($packs as $pack) { ?>
                    <option value="<?php echo $pack->id; ?>"><?php echo $pack->nombre_pack; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div id="b_pago" class="dashboard__inputs dashboard__inputs--text grid-item-row3-col2">
        <h4>Pago:</h4>
        <div class="dashboard__campo">
            <select class="dashboard__campo" name="filtroPago" id="filtroPago">
                <option selected value="">Ver todos</option>
                <option value="6">Pendiente</option>
                <option value="7">Primer pago</option>
                <option value="8">Segundo pago</option>
            </select>
        </div>
    </div>
    <div class="grid-item-full grid-item-full--boton text-center">
        <button id="restablecerFiltros" class="dashboard__boton--panel ">
            <i class="fa-solid fa-refresh"></i>
            Restablecer Filtros
        </button>
    </div>
</div>

<div id="recuento-miembros" class="dashboard__recuento"></div>

<div class="dashboard__contenedor">
    <?php if( !empty($miembros)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">
                        Nombre
                        <i id="copiarNombres" class="fa-solid fa-copy icono-copy"></i>
                    </th>
                    <th scope="col" class="table__th">Categoría</th>
                    <th scope="col" class="table__th">
                        Email
                        <i id="copiarEmails" class="fa-solid fa-copy icono-copy"></i>
                    </th>
                    <th scope="col" class="table__th">Teléfono</th>
                    <th scope="col" class="table__th">Pack</th>
                    <th scope="col" class="table__th">Pendiente</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($miembros as $miembro) { ?>
                    <tr class="table__tr">
                        <td class="table__td" data-label="Nombre">
                            <?php echo $miembro->apellido1 . " " . $miembro->apellido2 . ", " . $miembro->nombre; ?>
                        </td>
                        <td id="cat" class="table__td" data-label="Categoría" >
                            <?php foreach($categorias as $categoria) { ?>
                                <?php if($miembro->categoria_id === $categoria->id) { ?>
                                    <?php echo $categoria->nombre_cat; ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="table__td" data-label="Email">
                            <?php echo $miembro->email; ?>
                        </td>
                        <td class="table__td" data-label="Teléfono">
                            <?php echo $miembro->telefono; ?>
                        </td>
                        <td class="table__td" data-label="Pack">
                            <?php foreach($packs as $pack) { ?>
                                <?php if($miembro->pack_id === $pack->id) { ?>
                                    <?php echo $pack->nombre_pack; ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="table__td" data-label="Pendiente">
                            <?php echo $miembro->pendiente_pagar . ".00 €"; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/miembros/editar?id=<?php echo $miembro->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/miembros/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $miembro->id ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr> 
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center padding">No hay miembros registrados</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>

<?php
$is_admin = is_admin() ? 'true' : 'false';
?>
<script>
    var isAdmin = <?php echo $is_admin; ?>;
</script>