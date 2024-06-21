<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Introduce tu nueva contraseña</p>

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if($token_valido) { ?>

        <form method="POST" class="formulario">
        <div class="formulario__campo">
                <label for="password" class="formulario__label">Contraseña</label>
                <input 
                    type="password"
                    class="formulario__input"
                    placeholder="Introduce tu contraseña"
                    id="password"
                    name="password"
                />
            </div>
            
            <input type="submit" class="formulario__submit" value="Guardar">
        </form>
    <?php } ?>

        <div class="acciones">
            <a href="/login" class="acciones__enlace">¿Recordaste la contraseña? Iniciar Sesión</a>
            <!--<a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Crear cuenta</a>-->
        </div>
</main>