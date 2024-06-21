<?php if (is_admin()) { ?>
    <h2 class="dashboard__heading"><?php echo $titulo ?></h2>

    <main class="entrenamientos">
        <div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
            <a class="dashboard__boton--panel" href="/admin/dashboard/memoria">
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
                    <label for="fecha_memoria" class="formulario__label">Temporada</label>
                    <input type="text" class="formulario__input" placeholder="Introduce la temporada a la que pertecenece la memoria" id="fecha_memoria" name="fecha_memoria" value="<?php echo $documento->fecha ? $documento->fecha : ''; ?>">
                </div>
                <input class="alerta formulario__submit formulario__submit--registrar" type="submit" value="Subir Memoria">
            </form>
        </div>
    </main>
<?php } ?>