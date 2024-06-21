<?php 
    if(!is_admin()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if( !empty($miembros) ) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Email</th>
                    <th scope="col" class="table__th">Administrador</th>
                    <th scope="col" class="table__th">Organizador</th>
                    <th scope="col" class="table__th">Directivo</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($miembros as $miembro) { ?>
                    <tr class="table__tr">
                        <td class="table__td" data-label="Nombre">
                            <?php echo $miembro->apellido1 . " " . $miembro->apellido2 . ", " . $miembro->nombre; ?>
                        </td>
                        <td class="table__td" data-label="Email">
                            <?php echo $miembro->email; ?>
                        </td>
                        <td class="table__td" data-label="Administrador">
                            <?php 
                                if($miembro->admin === '1') {
                                    echo 'Si'; 
                                } else {
                                    echo 'No';
                                }
                            ?>
                        </td>
                        <td class="table__td" data-label="Organizador">
                            <?php 
                                if($miembro->organizador === '1') {
                                    echo 'Si'; 
                                } else {
                                    echo 'No';
                                }
                            ?>
                        </td>
                        <td class="table__td" data-label="Directivo">
                            <?php 
                                if($miembro->directivo === '1') {
                                    echo 'Si'; 
                                } else {
                                    echo 'No';
                                }
                            ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/dashboard/editar-perfil?id=<?php echo $miembro->id; ?>">
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