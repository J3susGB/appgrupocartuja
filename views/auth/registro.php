<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Regístrate</p>

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <form method="POST" action="/registro" class="formulario" enctype="multipart/form-data">
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input 
                type="text"
                class="formulario__input"
                placeholder="Introduce tu nombre"
                id="nombre"
                name="nombre"
                value="<?php echo $usuario->nombre; ?>"
            />
        </div>
        <div class="formulario__campo">
            <label for="apellido1" class="formulario__label">Primer apellido</label>
            <input 
                type="text"
                class="formulario__input"
                placeholder="Introduce primer apellido"
                id="apellido1"
                name="apellido1"
                value="<?php echo $usuario->apellido1; ?>"
            />
        </div>
        <div class="formulario__campo">
            <label for="apellido2" class="formulario__label">Segundo apellido</label>
            <input 
                type="text"
                class="formulario__input"
                placeholder="Introduce segundo apellido"
                id="apellido2"
                name="apellido2"
                value="<?php echo $usuario->apellido2; ?>"
            />
        </div>
        <div class="formulario__campo">
            <label for="categoria" class="formulario__label">Categoría</label>
            <select class="formulario__label--select" name="usuarios[categoria_id]" id="categoria">
                <option selected disabled value="">-- Seleccione --</option>
                <?php foreach($categorias as $categoria) { ?>
                    <option 
                    <?php echo $usuario->categoria_id === $categoria->id ? 'selected' : '' ?>
                    value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre_cat; ?>
                <?php  } ?>
            </select>
        </div>
        <div class="formulario__campo">
            <label for="pack" class="formulario__label">Elige un pack</label>
            <select class="formulario__label--select" name="usuarios[pack_id]" id="pack">
                <option selected disabled value="">-- Seleccione --</option>
                <?php foreach($packs as $pack) { ?>
                    <option 
                    <?php echo $usuario->pack_id === $pack->id ? 'selected' : '' ?>
                    value="<?php echo $pack->id; ?>"><?php echo $pack->nombre_pack . " - " . $pack->precio; ?>
                <?php  } ?>
            </select>
        </div>
        <div class="formulario__campo">
            <label for="telefono" class="formulario__label">Teléfono</label>
            <input 
                type="text"
                class="formulario__input"
                placeholder="Introduce tu Teléfono"
                id="telefono"
                name="telefono"
                value="<?php echo $usuario->telefono; ?>"
            />
        </div>
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email"
                class="formulario__input"
                placeholder="Introduce tu email"
                id="email"
                name="email"
                value="<?php echo $usuario->email; ?>"
            />
        </div>
        <div class="formulario__campo">
            <label for="foto" class="formulario__label">Foto</label>
            <input 
                type="file" 
                class="formulario__input formulario__input--file" 
                id="foto" 
                name="foto" 
                value="<?php echo $usuario->foto; ?>"
            />
        </div>
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
        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir Contraseña</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="Vuelve a introducir tu contraseña"
                id="password2"
                name="password2"
            />
        </div>

        <input type="submit" class="formulario__submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu contraseña?</a>
    </div>
</main>