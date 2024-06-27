<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso</p>

    <?php
        require_once __DIR__ . '/../templates/alertas.php';

        // var_dump($_ENV);
    ?>

    <form method="POST" action="/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email"
                class="formulario__input"
                placeholder="Introduce tu email"
                id="email"
                name="email"
            />
        </div>

        <input type="submit" class="formulario__submit" value="Enviar Instrucciones">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Recordaste la contraseña? Iniciar Sesión</a>
        <!--<a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Crear cuenta</a>-->
    </div>
</main>