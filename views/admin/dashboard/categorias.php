<?php 
    if(!is_admin()) {
        header('Location: /login');
        exit; // Añade exit para asegurarte de que el script se detiene después de la redirección
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/dashboard/añadir-categoria">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
    <a class="dashboard__boton--panel" href="/admin/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if( !empty($categorias) ) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre de la categoría</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($categorias as $categoria) { ?>
                    <tr class="table__tr">
                        <td class="table__td" data-label="Nombre de la categoría">
                            <?php echo $categoria->nombre_cat; ?>
                        </td>
                        
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/dashboard/editar-categoria?id=<?php echo $categoria->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/dashboard/eliminar-categoria" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $categoria->id ?>">
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
        <p class="text-center padding">No hay categorías registradas</p>
    <?php } ?>
</div>