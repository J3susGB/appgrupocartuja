<?php 
    if(!is_admin()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/miembros/tallas">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<form method="POST" class="dashboard__formulario formulario" novalidate>
    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Apellidos y nombre</label>
        <input 
            disabled
            type="text" 
            class="formulario__input" 
            id="nombre" 
            name="nombre" 
            value="<?php echo $miembro->apellido1 . " " . $miembro->apellido2 . ", " . $miembro->nombre ?? ''; ?>" />
    </div>
    <div class="formulario__campo">
        <label for="camiseta" class="formulario__label">Camiseta</label>
        <select class="formulario__label--select" name="camiseta" id="camiseta">
            <option selected value="<?php $miembro->camiseta; ?>"><?php $miembro->nombre_talla_camiseta; ?></option>
            <?php foreach($tallas as $talla) { ?>
                <option 
                <?php echo $miembro->camiseta === $talla->id ? 'selected' : '' ?>
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="calzona" class="formulario__label">Calzonas</label>
        <select class="formulario__label--select" name="calzona" id="calzona">
            <option selected value="<?php $miembro->calzona; ?>"><?php $miembro->nombre_talla_calzona; ?></option>
            <?php foreach($tallas as $talla) { ?>
                <option 
                <?php echo $miembro->calzona === $talla->id ? 'selected' : '' ?>
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="chandal" class="formulario__label">Chandal</label>
        <select class="formulario__label--select" name="chandal" id="chandal">
            <option selected value="<?php $miembro->chandal; ?>"><?php $miembro->nombre_talla_chandal; ?></option>
            <?php foreach($tallas as $talla) { ?>
                <option 
                <?php echo $miembro->chandal === $talla->id ? 'selected' : '' ?>
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="cortavientos" class="formulario__label">Cortavientos</label>
        <select class="formulario__label--select" name="cortavientos" id="cortavientos">
            <option selected value="<?php $miembro->Cortavientos; ?>"><?php $miembro->nombre_talla_cortavientos; ?></option>
            <?php foreach($tallas as $talla) { ?>
                <option 
                <?php echo $miembro->Cortavientos === $talla->id ? 'selected' : '' ?>
                value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?>
            <?php  } ?>
        </select>
    </div>
    <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar tallas">
</form>