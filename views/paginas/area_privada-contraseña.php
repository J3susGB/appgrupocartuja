<?php 
    if(!is_auth()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton privada__btn">
    <a class="dashboard__boton--panel" href="/area_privada">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form method="POST" class="formulario">
<?php echo csrf_field(); ?>
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Contraseña actual</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="Introduce tu contraseña actual"
                id="password"
                name="password"
            />
        </div>
        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Nueva contraseña</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="Introduce la nueva contraseña"
                id="password2"
                name="password2"
            />
        </div>
        
        <input type="submit" class="formulario__submit" value="Guardar">
    </form>
</div>