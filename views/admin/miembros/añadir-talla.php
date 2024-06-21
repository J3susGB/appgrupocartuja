<?php 
    if(!is_admin()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/miembros/tallas">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<form method="POST" action="/admin/miembros/añadir-talla" class="dashboard__formulario formulario" novalidate>
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
    <div class="formulario__campo">
        <label for="usuario" class="formulario__label">Usuario</label>
        <select class="formulario__label--select" name="usuario" id="usuario">
            <option value="" selected disabled>--Seleccione--</option>
            <?php foreach($miembros_sin_tallas as $miembro) { ?>
                <option value="<?php echo $miembro->id; ?>">
                    <?php echo $miembro->apellido1 . " " . $miembro->apellido2 . ", " . $miembro->nombre; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="calzona" class="formulario__label">Camiseta</label>
        <select class="formulario__label--select" name="camiseta" id="camiseta">
            <option selected disabled value="">--Seleccione--</option>
            <?php foreach($tallas_disponibles as $talla) { ?>
            <option 
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="calzona" class="formulario__label">Calzonas</label>
        <select class="formulario__label--select" name="calzona" id="calzona">
        <option selected disabled value="">--Seleccione--</option>
            <?php foreach($tallas_disponibles as $talla) { ?>
            <option 
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="chandal" class="formulario__label">Chandal</label>
        <select class="formulario__label--select" name="chandal" id="chandal">
        <option selected disabled value="">--Seleccione--</option>
            <?php foreach($tallas_disponibles as $talla) { ?>
            <option 
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="cortavientos" class="formulario__label">Cortavientos</label>
        <select class="formulario__label--select" name="cortavientos" id="cortavientos">
            <option selected disabled value="">--Seleccione--</option>
            <?php foreach($tallas_disponibles as $talla) { ?>
            <option 
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Añadir tallas">
</form>