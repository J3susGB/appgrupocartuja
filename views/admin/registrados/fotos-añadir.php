<?php
    if(!is_admin()) {
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

    <form method="POST" action="/admin/registrados/fotos-añadir" enctype="multipart/form-data" class="formulario">
        
        <div class="filtros__fecha">
            <input
                id="fecha"
                type="date"  
                name="dia"    
            />
        </div>

        <div class="formulario__campo">
            <label for="turno" class="formulario__label">Turno</label>
            <select 
                class="formulario__label--select" 
                name="turno" 
                id="turno">
                <option selected disabled value="">-- Seleccione --</option>
                <?php foreach ($turnos as $turno) { ?>
                    <option value="<?php echo $turno->id_turno; ?>"><?php echo $turno->nombre_turno; ?>
                <?php  } ?>
            </select>
        </div>

        <div class="formulario__campo">
            <label for="foto" class="formulario__label formulario__label--file">Foto</label>
            <input 
                type="file" 
                class="formulario__input formulario__input--file" 
                id="foto"
                name="foto"; ?
                value="<?php echo $fotos->nombre_foto ?? ''; ?>"
            />
        </div>

        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Subir foto">
    </form>
</div>