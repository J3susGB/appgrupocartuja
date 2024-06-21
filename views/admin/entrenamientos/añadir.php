<?php if (is_admin()) { ?>
    <h2 class="dashboard__heading"><?php echo $titulo ?></h2>

    <main class="entrenamientos">
        <div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
            <a class="dashboard__boton--panel" href="/admin/entrenamientos">
                <i class="fa-solid fa-circle-arrow-left"></i>
                Volver
            </a>
        </div>

        <div class="entrenamientos__container">
            <form class="dashboard__formulario formulario" novalidate method="post" enctype="multipart/form-data">
                <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
                <div class="formulario__campo">
                    <label for="file" class="formulario__label">Selecciona un archivo PDF:</label>
                    <input class="formulario__input" type="file" id="file" name="file" accept="application/pdf">
                </div>
                <div class="formulario__campo">
                    <label for="numero_plannig" class="formulario__label">Número de semana</label>
                    <input type="text" class="formulario__input" placeholder="Introduce la semana del planning" id="numero_plannig" name="numero_plannig" value="<?php echo $documento->nombre ? $documento->nombre : ''; ?>">
                </div>
                <div class="formulario__campo">
                    <label for="fecha_plannig" class="formulario__label">Fechas que ocupa</label>
                    <input type="text" class="formulario__input" placeholder="Introduce la fecha que ocupa el planning" id="fecha_plannig" name="fecha_plannig" value="<?php echo $documento->fecha ? $documento->fecha : ''; ?>">
                </div>
                <div class="formulario__campo">
                    <label class="formulario__label">Notas</label>
                    <textarea class="formulario__input" id="nota" name="nota" placeholder="Escribe tu nota/obervación" value="<?php echo $documento->notas ? $documento->notas : ''; ?>"></textarea>
                </div>
                <input class="alerta formulario__submit formulario__submit--registrar" type="submit" value="Subir PDF">
            </form>
        </div>
    </main>
<?php } ?>