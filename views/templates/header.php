<?php is_auth(); ?>
<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if(is_admin()) { ?>
                <a class="header__enlace" href="/admin/dashboard">Administración</a>
            <?php } else if(es_organizador()) { ?>
                <a class="header__enlace" href="/organizacion/dashboard">Organización</a>
            <?php } ?>

            <?php if(!is_auth()) { ?>
                <a class="header__enlace" href="/login">Iniciar sesión</a>
            <?php } else { ?>
                <form  method="POST" action="/logout">
                    <input class="header__enlace cerrar_sesion" type="submit" value="Cerrar Cesión">
                </form>
            <?php } ?>
            
        </nav>

        <div class="header__top">
            <picture class="header__logo2">
                <source srcset="build/img/logo.avif" type="image/avif">
                <source srcset="build/img/logo.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/logo.png" alt="Logo identificativo del grupo">
            </picture>
            <a href="/">
                <h1 class="header__logo">
                    Árbitros y Árbitras Deportistas de Cartuja
                </h1>
            </a>
        </div>
    </div>

    <div class="header__boton" id="boton">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" focusable="false" x="0px" y="0px"  viewBox="0 0 612 792" enable-background="new 0 0 612 792" xml:space="preserve">
            <path d="M21.857,226.607h568.286c12.072,0,21.857-9.785,21.857-21.857v-54.643c0-12.072-9.785-21.857-21.857-21.857  H21.857C9.785,128.25,0,138.035,0,150.107v54.643C0,216.822,9.785,226.607,21.857,226.607z M21.857,445.179h568.286  c12.072,0,21.857-9.785,21.857-21.857v-54.643c0-12.072-9.785-21.857-21.857-21.857H21.857C9.785,346.821,0,356.606,0,368.679  v54.643C0,435.394,9.785,445.179,21.857,445.179z M21.857,663.75h568.286c12.072,0,21.857-9.785,21.857-21.857V587.25  c0-12.072-9.785-21.857-21.857-21.857H21.857C9.785,565.393,0,575.178,0,587.25v54.643C0,653.965,9.785,663.75,21.857,663.75z"/>
        </svg>
    </div>
    
    <?php if(is_auth()) { ?>
        <p class="header__bienvenida">
            Sesión: <span><?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido1']; ?></span> 
            <?php if(!is_admin() && !es_directivo()) { ?>
                <a href="/area_privada-mensajes?id=<?php echo $_SESSION['id']; ?>" class="mensajes-icono">
                    <i class="fa-solid fa-message"></i>
                    <span class="mensaje-count" style="display: none;"></span>
                </a>
            <?php } ?>
        </p>  
    <?php } else {?>
        <p class="header__bienvenida--oculto"></p> 
    <?php } ?>

    <div class="barra">
        <nav class="navegacion">
            <a href="/nosotros" class="<?php echo pagina_actual('nosotros') ? 'navegacion__enlace--actual' : ''; ?>">Nosotros</a>
            <a href="/packs" class="<?php echo pagina_actual('/packs') ? 'navegacion__enlace--actual' : ''; ?>">Packs</a>
            <a href="/patrocinadores" class="<?php echo pagina_actual('/patrocinadores') ? 'navegacion__enlace--actual' : ''; ?>">Patrocinadores</a>
            <?php if(is_auth() && is_admin()) { ?>
                <a href="/admin/entrenamientos" class="<?php echo pagina_actual('/entrenamientos') ? 'navegacion__enlace--actual' : ''; ?>">Entrenamientos</a>
            <?php } else if(is_auth() && es_directivo()) { ?>
                <a href="/consultas_direccion/informes" class="<?php echo pagina_actual('/consultas_direccion/informes') ? 'navegacion__enlace--actual' : ''; ?>">Informes</a>
            <?php }else if (!is_auth()) { ?>
                <a href="/login" class="<?php echo pagina_actual('/area_privada') ? 'navegacion__enlace--actual' : ''; ?>">Área privada</a>
            <?php } else  { ?>
                <a href="/area_privada" class="<?php echo pagina_actual('/area_privada') ? 'navegacion__enlace--actual' : ''; ?>">Área privada</a>
            <?php } ?>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (<?php echo is_auth() ? 'true' : 'false'; ?>) {
            fetch('/api/mensajes')
                .then(response => response.json())
                .then(data => {
                    // Filtra los mensajes no leídos
                    const mensajesNoLeidos = data.filter(mensaje => mensaje.leido === "0");
                    
                    if (mensajesNoLeidos.length > 0) {
                        // Selecciona el elemento del icono de mensajes
                        const mensajeCountElement = document.querySelector('.mensajes-icono .mensaje-count');
                        const mensajesIconoElement = document.querySelector('.mensajes-icono');
                        
                        // Actualiza el contador y muestra el número de mensajes no leídos
                        mensajeCountElement.textContent = mensajesNoLeidos.length;
                        mensajeCountElement.style.display = 'inline';

                        // Añade las clases de animación
                        mensajesIconoElement.classList.add('animate__animated', 'animate__bounce');
                        mensajeCountElement.classList.add('animate__animated', 'animate__bounce');
                    }
                })
                .catch(error => console.error('Error fetching messages:', error));
        }
    });
</script>