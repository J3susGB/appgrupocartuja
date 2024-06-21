
<h2 class="privada__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas privada__btn">
            <a class="dashboard__boton--panel" href="/area_privada">
            <i class="fa-solid fa-circle-arrow-left"></i>
                Volver
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
                                <p><?php echo ($turno->id_turno === $foto->turno) ?$turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
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
                                <p><?php echo ($turno->id_turno === $foto->turno) ? $turno->nombre_turno : ''; ?></p>
                            <?php } ?>
                        </div>
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