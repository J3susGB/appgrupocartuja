<?php
if (!is_admin()) {
    header('Location: /login');
}
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/registrados/fotos">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" enctype="multipart/form-data" class="formulario">

        <div class="filtros__fecha">
            <input id="fecha" type="date" name="dia" value="<?php echo isset($foto->fecha_formateada) ? $foto->fecha_formateada : ''; ?>" />
        </div>

        <div class="formulario__campo">
            <label for="turno" class="formulario__label">Turno</label>
            <select class="formulario__label--select" name="turno" id="turno">
                <?php foreach ($turnos as $turno) { ?>
                    <option value="<?php echo $turno->id_turno; ?>" 
                        <?php echo ($turno->id_turno == $foto->turno) ? 'selected' : ''; ?>>
                        <?php echo $turno->nombre_turno; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php if (isset($foto->foto_actual)) { ?>
            <p class="formulario__label formulario__label--file">Foto actual</p>
            <div class="formulario__imagen">
                <picture>
                    <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.webp" type="image/webp">
                    <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" type="image/png">
                    <source srcset="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.avif" type="image/avif">
                    <img src="<?php echo '/img/entrenamientos/' . $foto->nombre_foto; ?>.png" alt="Imagen del entrenamiento">
                </picture>
            </div>
        <?php } ?>

        <div class="formulario__campo">
            <label for="foto" class="formulario__label formulario__label--file">Foto</label>
            <input 
                type="file" 
                class="formulario__input formulario__input--file" 
                id="foto" 
                name="foto" ; ? value="<?php echo $foto->nombre_foto ?? ''; ?>" 
            />
        </div>

        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar foto">
    </form>
</div>