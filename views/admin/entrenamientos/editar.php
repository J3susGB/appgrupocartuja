<?php
if (!is_admin()) {
    header('Location: /login');
}
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/entrenamientos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" enctype="multipart/form-data" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="file" class="formulario__label">Selecciona un archivo PDF:</label>
            <input class="formulario__input" type="file" id="file" name="file" accept="application/pdf" value="<?php echo $planning->documento ? $planning->documento : ''; ?>">
        </div>

        <?php if ($planning->documento) : ?>
            <div class="formulario__campo">
                <label  for="planing_doc" class="formulario__label">Archivo subido</label>
                <input disabled type="text" class="formulario__input" id="planing_doc" name="planing_doc" value="<?php echo $planning->documento; ?>">
            </div>
        <?php endif; ?>

        <div class="formulario__campo">
            <label for="numero_plannig" class="formulario__label">Número de semana</label>
            <input type="text" class="formulario__input" placeholder="Introduce la semana del planning" id="numero_plannig" name="numero_plannig" value="<?php echo $planning->nombre ? $planning->nombre : ''; ?>">
        </div>
        <div class="formulario__campo">
            <label for="fecha_plannig" class="formulario__label">Fechas que ocupa</label>
            <input type="text" class="formulario__input" placeholder="Introduce la fecha que ocupa el planning" id="fecha_plannig" name="fecha_plannig" value="<?php echo $planning->fecha ? $planning->fecha : ''; ?>">
        </div>
        <div class="formulario__campo">
            <label class="formulario__label">Notas</label>
            <textarea class="formulario__input" id="nota" name="nota" placeholder="Escribe tu nota/observación"><?php echo htmlspecialchars($planning->notas); ?></textarea>
        </div>
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar planning">
    </form>


</div>