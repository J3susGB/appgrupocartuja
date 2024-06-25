<?php 
    if(!is_auth()) {
        header('Location: /');
    }
?>
<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton privada__btn">
    <a class="dashboard__boton--panel" href="/area_privada-editar?id=<?php echo $_SESSION['id']; ?>">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php foreach ($miembros as $miembro) { ?>
        <form method="POST" enctype="multipart/form-data" class="formulario" novalidate>

            <fieldset>
                <legend class="privada__legend">Información de tallas</legend>
                <div class="formulario__campo">
                    <label for="talla_camiseta" class="formulario__label">Camiseta</label>
                    <select class="formulario__label--select" name="talla_camiseta" id="talla_camiseta">
                        <option selected disabled value="">-- Seleccione --</option>
                        <?php foreach ($tallas as $talla) { ?>
                            <option <?php echo isset($miembro->idCamiseta) && $miembro->idCamiseta === $talla->id ? 'selected' : '' ?> value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="formulario__campo">
                    <label for="talla_calzona" class="formulario__label">Calzona</label>
                    <select class="formulario__label--select" name="talla_calzona" id="talla_calzona">
                        <option selected disabled value="">-- Seleccione --</option>
                        <?php foreach ($tallas as $talla) { ?>
                            <option <?php echo isset($miembro->idCalzona) && $miembro->idCalzona === $talla->id ? 'selected' : '' ?> value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="formulario__campo">
                    <label for="talla_chandal" class="formulario__label">Chandal</label>
                    <select class="formulario__label--select" name="talla_chandal" id="talla_chandal">
                        <option selected disabled value="">-- Seleccione --</option>
                        <?php foreach ($tallas as $talla) { ?>
                            <option <?php echo isset($miembro->idChandal) && $miembro->idChandal === $talla->id ? 'selected' : '' ?> value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="formulario__campo">
                    <label for="talla_cortavientos" class="formulario__label">Cortavientos</label>
                    <select class="formulario__label--select" name="talla_cortavientos" id="talla_cortavientos">
                        <option selected disabled value="">-- Seleccione --</option>
                        <?php foreach ($tallas as $talla) { ?>
                            <option <?php echo isset($miembro->idCortaviento) && $miembro->idCortaviento === $talla->id ? 'selected' : '' ?> value="<?php echo $talla->id; ?>"><?php echo strtoupper($talla->nombre_talla); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </fieldset>
        <?php } ?>
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar tallas">
        </form>
</div>