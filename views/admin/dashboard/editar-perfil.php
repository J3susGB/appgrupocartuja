<?php 
    if(!is_admin()) {
        header('Location: /login');
        exit; // Añade exit para asegurarte de que el script se detiene después de la redirección
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard/perfiles">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" enctype="multipart/form-data" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input 
                disabled
                type="text" 
                class="formulario__input" 
                id="nombre" 
                name="nombre" 
                value="<?php echo $miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2 ?? ''; ?>" />
        </div>
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                disabled
                type="text" 
                class="formulario__input" 
                id="email" 
                name="email" 
                value="<?php echo $miembro->email ?? ''; ?>" />
        </div>
        <div class="formulario__campo">
            <label for="admin" class="formulario__label">Administrador</label>
            <select class="formulario__label--select" name="admin" id="admin">
                <option value="1" <?php echo $miembro->admin === '1' ? 'selected' : ''; ?>>Sí</option>
                <option value="0" <?php echo $miembro->admin === '0' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <div class="formulario__campo">
            <label for="organizador" class="formulario__label">Organizador</label>
            <select class="formulario__label--select" name="organizador" id="organizador">
                <option value="1" <?php echo $miembro->organizador === '1' ? 'selected' : ''; ?>>Sí</option>
                <option value="0" <?php echo $miembro->organizador === '0' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <div class="formulario__campo">
            <label for="directivo" class="formulario__label">Directivo</label>
            <select class="formulario__label--select" name="directivo" id="directivo">
                <option value="1" <?php echo $miembro->directivo === '1' ? 'selected' : ''; ?>>Sí</option>
                <option value="0" <?php echo $miembro->directivo === '0' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar perfil">
    </form>
</div>