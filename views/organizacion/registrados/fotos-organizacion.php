<?php
    if(!is_admin() && !es_organizador()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/organizacion/registrados/fotos-organizacion-añadir">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
</div>
<div id="contenedor-meses">
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($septiembre) ) { ?>
            <h4>Septiembre</h4>
            <div class="galeria">
                <?php foreach($septiembre as $foto) { ?>
                        <div class="galeria__container">
                            <div class="galeria__imagen">
                                <picture>
                                    <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                    <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                    <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                                </picture>
                            </div>
                            <div class="galeria__texto">
                                <p><?php echo $foto->fecha; ?></p>
                                <?php foreach($turnos as $turno) { ?>
                                    <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                                <?php } ?>
                            </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Septiembre</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($octubre) ) { ?>
            <h4>Octubre</h4>
            <div class="galeria">
                <?php foreach($octubre as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img class="img_galeria" src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Octubre</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($noviembre) ) { ?>
            <h4>Noviembre</h4>
            <div class="galeria">
                <?php foreach($noviembre as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Noviembre</h4>
                <div class="galeria">
                    <div class="galeria__imagen">
                        <p class="galeria__container2">No existen archivos</p>
                    </div>
                </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($diciembre) ) { ?>
            <h4>Diciembre</h4>
            <div class="galeria">
                <?php foreach($diciembre as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                        <?php if(is_admin() || es_organizador()) {?>
                            <div class="galeria__acciones">
                                <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                    <i class="fa-solid fa-pen"></i>
                                    Editar
                                </a>
                                <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                    <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                    <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Diciembre</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($enero) ) { ?>
            <h4>Enero</h4>
            <div class="galeria">
                <?php foreach($enero as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Enero</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($febrero) ) { ?>
            <h4>Febrero</h4>
            <div class="galeria">
                <?php foreach($febrero as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Febrero</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($marzo) ) { ?>
            <h4>Marzo</h4>
            <div class="galeria">
                <?php foreach($marzo as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture id="imagen">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Marzo</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($abril) ) { ?>
            <h4>Abril</h4>
            <div class="galeria">
                <?php foreach($abril as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ?$turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Abril</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="dashboard__contenedor mes-container">
        <?php if( !empty($mayo) ) { ?>
            <h4>Mayo</h4>
            <div class="galeria">
                <?php foreach($mayo as $foto) { ?>
                    <div class="galeria__container">
                        <div class="galeria__imagen">
                            <picture>
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                                <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                                <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                            </picture>
                        </div>
                        <div class="galeria__texto">
                            <p><?php echo $foto->fecha; ?></p>
                            <?php foreach($turnos as $turno) { ?>
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
                            <?php if(is_admin() || es_organizador()) {?>
                                <div class="galeria__acciones">
                                    <a class="acciones-foto editar-galeria table__accion table__accion--editar" href="/organizacion/registrados/editar-foto_org?id=<?php echo $foto->id; ?>">
                                        <i class="fa-solid fa-pen"></i>
                                        Editar
                                    </a>
                                    <form method="POST" action="/organizacion/registrados/eliminar-foto_org" class="fotos table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $foto->id ?>">
                                        <button class="acciones-foto eliminar-galeria table__accion table__accion--eliminar" type="submit">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h4>Mayo</h4>
            <div class="galeria">
                <div class="galeria__imagen">
                    <p class="galeria__container2">No existen archivos</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>