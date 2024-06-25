<?php
if (es_directivo()) {
    header('Location: /');
}
?>

<main class="privada">
    <h2 class="privada__heading"><?php echo $titulo; ?></h2>
    <p class="privada__descripcion">Información de usuario</p>

    <?php foreach ($miembros as $miembro) { ?>
        <?php if ($miembro->categoria_id === "12" || $miembro->categoria_id === "13") { ?>
            <div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas privada__btn">
                <a class="dashboard__boton--panel" href="/area_privada-plannings">
                    <i class="fa-solid fa-calendar-days dashboard__icono"></i>
                    Plannings
                </a>
                <a class="dashboard__boton--panel" href="/area_privada-asistencia">
                    <i class="fa-solid fa-clipboard-list dashboard__icono"></i>
                    Asistencia
                </a>
                <a class="dashboard__boton--panel" href="/area_privada-fotos">
                    <i class="fa-solid fa-photo-film"></i>
                    Fotos
                </a>
                <a class="dashboard__boton--panel" href="/area_privada-mensajes">
                    <i class="fa-solid fa-message"></i>
                    Mensajes
                </a>
            </div>
        <?php } else { ?>
            <div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas privada__btn">
                <a class="dashboard__boton--panel" href="/area_privada-plannings">
                    <i class="fa-solid fa-calendar-days dashboard__icono"></i>
                    Plannings
                </a>
                <a class="dashboard__boton--panel" href="/area_privada-mensajes">
                    <i class="fa-solid fa-message"></i>
                    Mensajes
                </a>
            </div>
        <?php } ?>   
    <?php } ?>

    <div class="privada__box">
        <div class="privada__grid">
            <?php foreach ($miembros as $miembro) { ?>
                <div class="privada__imagen">
                    <div class="privada__boleto 
                        <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'privada__boleto--entrenos' : ''; ?>
                        <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'privada__boleto--cenas' : ''; ?>
                        <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'privada__boleto--ropa' : ''; ?>
                        <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'privada__boleto--ropa' : ''; ?>
                        <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'privada__boleto--completo' : ''; ?>
                    ">
                        <div class="privada__boleto--container">
                            <picture class="privada__boleto-logo loguito">
                                <source srcset="build/img/simple.avif" type="image/avif">
                                <source srcset="build/img/simple.webp" type="image/webp">
                                <source srcset="build/img/simple.webp" type="image/webp">
                                <img loading="lazy" width="200" height="200" src="build/img/simple.png" alt="logo">
                            </picture>
                            <p class="text-shadow privada__boleto-pack"><?php echo $miembro->nombre_pack; ?></p>
                            <p class="text-shadow privada__boleto-precio"><?php echo $miembro->precio_pack . " €"; ?></p>
                        </div>
                    </div>
                    <picture class="privada__imagen--foto">
                        <source srcset="<?php echo 'img/miembros/' . $miembro->foto . '.avif'; ?>" type="image/avif">
                        <source srcset="<?php echo 'img/miembros/' . $miembro->foto . '.webp'; ?>" type="image/webp">
                        <img loading="lazy" width="200" height="200" src="<?php echo 'img/miembros/' . $miembro->foto . '.png'; ?>" alt="Imagen del grupo">
                    </picture>
                </div>
            <?php } ?>

            <?php foreach ($miembros as $miembro) { ?>
                <div class="privada__contenido">
                    <div class="privada__caja-datos">
                        <div class="privada__datos privada__datos--personales">
                            <h4 class="
                                <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'entrenos' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'cenas' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'completo' : ''; ?>
                            ">
                                Datos personales
                            </h4>
                            <p><?php echo $miembro->nombre . " " . $miembro->apellido1 . " " . $miembro->apellido2; ?></p>
                            <p><?php echo $miembro->email ?></p>
                            <p><?php echo $miembro->telefono ?></p>
                            <p><?php echo $miembro->nombre_categoria ?></p>
                        </div>
                        <div class="privada__datos privada__datos--pack">
                            <h4 class="
                                <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'entrenos' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'cenas' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'completo' : ''; ?>
                            ">
                                Pack
                            </h4>
                            <p><?php echo $miembro->nombre_pack ?></p>
                            <p><?php echo 'Pendiente pagar: ' . $miembro->pendiente_pagar . " €"; ?></p>
                        </div>
                        <div class="privada__datos privada__datos--tallas">
                            <h4 class="
                                <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'entrenos' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'cenas' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'completo' : ''; ?>
                            ">
                                Tallas
                            </h4>
                            <p><?php echo 'Camiseta: ' . (isset($miembro->talla_camiseta) ? strtoupper($miembro->talla_camiseta) : '-'); ?></p>
                            <p><?php echo 'Calzona: ' . (isset($miembro->talla_calzona) ? strtoupper($miembro->talla_calzona) : '-'); ?></p>
                            <p><?php echo 'Chandal: ' . (isset($miembro->talla_chandal) ? strtoupper($miembro->talla_chandal) : '-'); ?></p>
                            <p><?php echo 'Cortavientos: ' . (isset($miembro->talla_cortavientos) ? strtoupper($miembro->talla_cortavientos) : '-'); ?></p>
                        </div>
                        <div class="privada__datos privada__datos--tallas">
                            <h4 class="
                                <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'entrenos' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'cenas' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'ropa' : ''; ?>
                                <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'completo' : ''; ?>
                            ">
                                Serigrafía
                            </h4>
                            <?php if($miembro->pack_id == "1" || $miembro->pack_id == "2") { ?>
                                <p>No tienes pack con ropa</p>
                            <?php } else { ?>
                                <p><?php echo mb_strtoupper($miembro->apellido1, 'UTF-8') . " " . mb_strtoupper($miembro->apellido2, 'UTF-8'); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="privada__botones">
                        <a class="privada__boton 
                            <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'enlace_entrenos' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'enlace_cenas' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'enlace_ropa' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'enlace_ropa' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'enlace_completo' : ''; ?>" href="area_privada-editar?id=<?php echo $miembro->id; ?>">
                            <i class="fa-solid fa-user-pen"></i>
                            Editar datos
                        </a>
                        <a class="privada__boton 
                            <?php echo (trim($miembro->nombre_pack) === "Solo Entrenos") ? 'enlace_entrenos' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Entrenos + cenas") ? 'enlace_cenas' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Entrenos + ropa") ? 'enlace_ropa' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Especial solo ropa") ? 'enlace_ropa' : ''; ?>
                            <?php echo (trim($miembro->nombre_pack) === "Completo") ? 'enlace_completo' : ''; ?>" href="area_privada-contraseña?id=<?php echo $miembro->id; ?>">
                            <i class="fa-solid fa-key"></i>
                            Cambiar contraseña
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
