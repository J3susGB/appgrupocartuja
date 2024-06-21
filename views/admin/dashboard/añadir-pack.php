<?php 
    if(!is_admin()) {
        header('Location: /login');
        exit; // Añade exit para asegurarte de que el script se detiene después de la redirección
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard/packs">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" action="/admin/dashboard/añadir-pack" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre del pack</label>
            <input 
                type="text" 
                class="formulario__input" 
                id="nombre" 
                name="nombre" 
                placeholder="Introduce el nombre del pack"
                value="<?php echo $pack->nombre_pack ?? ''; ?>" />
        </div>
        <div class="formulario__campo">
            <label for="precio" class="formulario__label">Precio del pack</label>
            <input 
                type="number" 
                class="formulario__input" 
                id="precio" 
                name="precio" 
                placeholder="Introduce el precio del pack"
                value="<?php echo $pack->precio ?? ''; ?>" />
        </div>
        
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Añadir pack">
    </form>
</div>