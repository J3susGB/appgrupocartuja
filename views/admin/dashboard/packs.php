<?php 
    if(!is_admin()) {
        header('Location: /login');
        exit; // Añade exit para asegurarte de que el script se detiene después de la redirección
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/dashboard/añadir-pack">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
    <a class="dashboard__boton--panel" href="/admin/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if( !empty($packs) ) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre del Pack</th>
                    <th scope="col" class="table__th">Precio del Pack</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($packs as $pack) { ?>
                    <tr class="table__tr">
                        <td class="table__td" data-label="Nombre del pack">
                            <?php echo $pack->nombre_pack; ?>
                        </td>
                        <td class="table__td" data-label="Precio del pack">
                            <?php echo $pack->precio . " €"; ?>
                        </td>
                        
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/dashboard/editar-pack?id=<?php echo $pack->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/dashboard/eliminar-pack" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $pack->id ?>">
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
        <p class="text-center padding">No hay packs registrados</p>
    <?php } ?>
</div>