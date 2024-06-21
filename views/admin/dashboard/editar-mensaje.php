<?php 
    if(!is_admin()) {
        header('Location: /login');
        exit; // Añade exit para asegurarte de que el script se detiene después de la redirección
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard/mensajes">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="asunto" class="formulario__label">Asunto</label>
            <input 
                type="text" 
                class="formulario__input" 
                id="asunto" 
                name="asunto" 
                placeholder="Introduce asunto"
                value="<?php echo $mensaje->asunto ?? ''; ?>" />
        </div>
        <div class="formulario__campo">
                    <label class="formulario__label">Cuerpo del mensaje</label>
                    <textarea class="formulario__input" 
                        id="cuerpo" 
                        name="cuerpo" 
                        placeholder="Escribe el mensaje"><?php echo $mensaje->cuerpo ?? ''; ?></textarea>
                </div>
        
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar mensaje">
    </form>
</div>