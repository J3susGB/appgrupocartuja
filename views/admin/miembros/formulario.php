<div class="formulario__campo">
    <label for="nombre" class="formulario__label">Nombre</label>
    <input 
        type="text" 
        class="formulario__input" 
        placeholder="Introduce nombre" 
        id="nombre" 
        name="nombre" 
        value="<?php echo $miembro->nombre ?? ''; ?>" />
</div>
<div class="formulario__campo">
    <label for="apellido1" class="formulario__label">Primer apellido</label>
    <input 
        type="text" 
        class="formulario__input" 
        placeholder="Introduce primer apellido" 
        id="apellido1" 
        name="apellido1" 
        value="<?php echo $miembro->apellido1 ?? ''; ?>" />
</div>
<div class="formulario__campo">
    <label for="apellido2" class="formulario__label">Segundo apellido</label>
    <input 
        type="text" 
        class="formulario__input" 
        placeholder="Introduce segundo apellido" 
        id="apellido2" 
        name="apellido2" 
        value="<?php echo $miembro->apellido2 ?? ''; ?>" />
</div>
<div class="formulario__campo">
    <label for="categoria" class="formulario__label">Categoría</label>
    <select class="formulario__label--select" name="usuarios[categoria_id]" id="categoria">
        <option selected disabled value="">-- Seleccione --</option>
        <?php foreach($categoria as $cat) { ?>
            <option 
            <?php echo intval($miembro->categoria_id) === intval($cat->id) ? 'selected' : '' ?>
            value="<?php echo $cat->id; ?>"><?php echo $cat->nombre_cat; ?>
        <?php  } ?>
    </select>
</div>

<div class="formulario__campo">
    <label for="pack" class="formulario__label">Elige un pack</label>
    <select class="formulario__label--select" name="usuarios[pack_id]" id="pack">
        <option selected disabled value="">-- Seleccione --</option>
        <?php foreach($packs as $pack) { ?>
            <option 
            <?php echo $miembro->pack_id === $pack->id ? 'selected' : '' ?>
            value="<?php echo $pack->id; ?>"><?php echo $pack->nombre_pack . " - " . $pack->precio . "€"; ?>
        <?php  } ?>
    </select>
</div>

<?php if(isset($miembro->foto_actual)) { ?>
    <?php if( $miembro->pendiente_pagar > 0) { ?>
        <div class="formulario__campo">
            <label for="abona" class="formulario__label">Abona</label>
            <input 
                type="number" 
                class="formulario__input" 
                placeholder="Puede abonar como máximo: <?php echo $miembro->pendiente_pagar; ?> €"
                id="abona" 
                name="abona" 
                value= 0.00
            />
        </div>
    <?php } ?>
<?php } ?>

<div class="formulario__campo">
    <label for="telefono" class="formulario__label">Teléfono</label>
    <input 
        type="text" 
        class="formulario__input" 
        placeholder="Introduce Teléfono" 
        id="telefono" 
        name="telefono" 
        value="<?php echo $miembro->telefono ?? ''; ?>" />
</div>
<div class="formulario__campo">
    <label for="email" class="formulario__label">Email</label>
    <input 
        type="email" 
        class="formulario__input" 
        placeholder="Introduce tu email" 
        id="email" 
        name="email" 
        value="<?php echo $miembro->email ?? ''; ?>" />
</div>
<div class="formulario__campo">
    <label for="foto" class="formulario__label formulario__label--file">Foto</label>
    <div class="formulario__file-container">
        <input 
            type="file" 
            class="formulario__input formulario__input--file" 
            id="foto" 
            name="foto" 
            value="<?php echo $miembro->foto ?? ''; ?>"
        />
    </div>
    
    <?php if(isset($miembro->foto_actual)) { ?>
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

<?php if(!isset($miembro->foto_actual)) { ?>
    <div class="formulario__campo">
        <label for="password" class="formulario__label">Contraseña</label>
        <input 
            type="password" 
            class="formulario__input" 
            placeholder="Introduce tu contraseña" 
            id="password" 
            name="password" />
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
<?php } ?>