<?php 
    if(!is_auth()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<?php foreach($miembros as $miembro) { ?>
    <div class="dashboard__contenedor-boton privada__btn dashboard__contenedor-boton-tallas">
        <?php if($miembro->pack_id !== "1" && $miembro->pack_id !== "2") { ?>
            <a class="dashboard__boton--panel" href="/area_privada-editar_tallas?id=<?php echo $_SESSION['id']; ?>">
                <i class="fa-solid fa-shirt"></i>
                Editar tallas
            </a>
        <?php } ?>
        <a class="dashboard__boton--panel" href="/area_privada">
            <i class="fa-solid fa-circle-arrow-left"></i>
            Volver
        </a>
    </div>
<?php } ?>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php foreach($miembros as $miembro) { ?>
    <form method="POST" enctype="multipart/form-data" class="formulario" novalidate>
        <fieldset>
            <legend class="privada__legend">Datos personales</legend>
            <div class="formulario__campo">
                <label for="nombre" class="formulario__label">Nombre</label>
                <input type="text" class="formulario__input" placeholder="Introduce nombre" id="nombre" name="nombre" value="<?php echo $miembro->nombre ?? ''; ?>" />
            </div>
            <div class="formulario__campo">
                <label for="apellido1" class="formulario__label">Primer apellido</label>
                <input type="text" class="formulario__input" placeholder="Introduce primer apellido" id="apellido1" name="apellido1" value="<?php echo $miembro->apellido1 ?? ''; ?>" />
            </div>
            <div class="formulario__campo">
                <label for="apellido2" class="formulario__label">Segundo apellido</label>
                <input type="text" class="formulario__input" placeholder="Introduce segundo apellido" id="apellido2" name="apellido2" value="<?php echo $miembro->apellido2 ?? ''; ?>" />
            </div>
            <div class="formulario__campo">
                <label for="email" class="formulario__label">Email</label>
                <input type="email" class="formulario__input" placeholder="Introduce tu email" id="email" name="email" value="<?php echo $miembro->email ?? ''; ?>" />
            </div>
            <div class="formulario__campo">
                <label for="telefono" class="formulario__label">Teléfono</label>
                <input type="text" class="formulario__input" placeholder="Introduce Teléfono" id="telefono" name="telefono" value="<?php echo $miembro->telefono ?? ''; ?>" />
            </div>
            <div class="formulario__campo">
                <label for="categoria" class="formulario__label">Categoría</label>
                <select disabled class="formulario__label--select" name="categoria" id="categoria">
                    <option selected disabled value="">-- Seleccione --</option>
                    <?php foreach($categorias as $cat) { ?>
                        <option <?php echo $miembro->categoria_id === $cat->id ? 'selected' : '' ?> value="<?php echo $cat->id; ?>"><?php echo $cat->nombre_cat; ?>
                    <?php  } ?>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend class="privada__legend">Información de pack</legend>
            <div class="formulario__campo">
                <label for="pack" class="formulario__label">Pack</label>
                <select disabled class="formulario__label--select" name="usuarios[pack_id]" id="pack">
                    <option selected disabled value="">-- Seleccione --</option>
                    <?php foreach ($packs as $pack) { ?>
                        <option <?php echo $miembro->pack_id === $pack->id ? 'selected' : '' ?> value="<?php echo $pack->id; ?>"><?php echo $pack->nombre_pack . " - " . $pack->precio . "€"; ?>
                        <?php  } ?>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend class="privada__legend">Foto de perfil</legend>
            <div class="formulario__campo">
                <label for="foto" class="formulario__label formulario__label--file">Foto</label>
                <input type="file" class="formulario__input formulario__input--file" id="foto" name="foto" value="<?php echo $miembro->foto ?? ''; ?>" />

                <?php if (isset($miembro->foto_actual)) { ?>
                    <p class="formulario__texto">Foto actual</p>
                    <div class="formulario__imagen">
                        <picture>
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.webp" type="image/webp">
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.png" type="image/png">
                            <source srcset="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.avif" type="image/avif">
                            <img src="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.png" alt="Imagen del miembro">
                        </picture>
                    </div>
                <?php } ?>
            </div>
        </fieldset>
    <?php } ?>
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Editar">
    </form>
</div>