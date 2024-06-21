<?php 
    if(!is_admin()) {
        header('Location: /login');
        exit; // Añade exit para asegurarte de que el script se detiene después de la redirección
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard/categorias">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="nombre_cat" class="formulario__label">Nombre de la categoría</label>
            <input 
                type="text" 
                class="formulario__input" 
                id="nombre_cat" 
                name="nombre_cat" 
                value="<?php echo $categoria->nombre_cat; ?>" />
        </div>
        
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar categoría">
    </form>
</div>