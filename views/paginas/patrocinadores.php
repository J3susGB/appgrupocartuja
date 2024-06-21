<main class="patrocinadores">
    <h2 class="patrocinadores__heading"><?php echo $titulo; ?></h2>
    <p class="patrocinadores__descripcion">Conoce a nuestros patrocinadores</p>

    <div class="patrocinadores__publi">
        <p class="patrocinadores__texto patrocinadores__texto--publi">
            ¿Cuántas veces has visto una camiseta, mochila o alguna prenda deportiva por la calle del Grupo
            de Árbitros y Árbitras Deportistas de Cartuja?
            <br>Si nuestro equipamiento deportivo se ve, tu publicidad también.
        </p>
        <p class="patrocinadores__texto patrocinadores__texto--publi">
            Si quieres ser nuestro patrocinador, ponte en contacto con nosotros a través de nuestro correo
            electrónico: <a target="_blank" href="mailto:arbitrosdeportistascartuja@gmail.com">arbitrosdeportistascartuja@gmail.com</a>
        </p>
    </div>

    <div class="patrocinadores__grid">
        <div data-aos="zoom-out-right" class="patrocinadores__patrocinador">
            <picture class="grid__icono">
                <source srcset="build/img/refereeland.avif" type="image/avif">
                <img loading="lazy" width="20" height="20" src="build/img/refereeland.png" alt="Imagen del grupo">
            </picture>
            <button id="referee" class="patrocinadores__boton" type="button">Más</button>
        </div>
        <div data-aos="zoom-out-left" class="patrocinadores__patrocinador">
            <picture class="grid__icono">
                <source srcset="build/img/fisionext_2.avif" type="image/avif">
                <source srcset="build/img/fisionext_2.webp" type="image/webp">
                <img loading="lazy" width="20" height="20" src="build/img/fisionext_2.jpg" alt="Imagen del grupo">
            </picture>
            <button id="fisio" class="patrocinadores__boton" type="button">Más</button>
        </div>
    </div> <!--fin grid-->


    <div id="container" class="patrocinadores__container">
        <div class="patrocinadores__contenedor1 ">
            <div id="container1" class="no-visto patrocinadores__box"> <!--Refereeland-->
                <div class="patrocinadores__logo">
                    <picture>
                        <source srcset="build/img/refereeland.avif" type="image/avif">
                        <img loading="lazy" width="20" height="20" src="build/img/refereeland.png" alt="Imagen del grupo">
                    </picture>
                </div>
                <div class="patrocinadores__description">
                    <p class="patrocinadores__texto">
                        Empresa dedicada a la venta de material deportivo arbitral que nació en el año 2013,
                        de la mano de su fundador, <span>D. Juan Andrés Verdugo Dorado</span>, quien afirma que da un servicio
                        al colectivo arbitral ya que conoce de primera mano las necesidades de los árbitros, debido
                        a su vinculación directa con el estamento arbitral, habiendo sido árbitro nacional durante 6 Temporadas.

                        <br>A través de su <a href="https://refereeland.com/es/" target="_blank">web</a>, se pueden
                        realizar los pedidos, y hacen envíos a todo el mundo.
                        <br>Se pueden hacer pagos con tarjeta, transferencia bancaria y bizum.
                        <br>Su sede física está en Avenida Averroes 8 Edif Acrópolis Oficina 402. 41020 Sevilla.
                        <br>Puedes contactar con ellos a través de info@refereeland.com
                    </p>
                </div>
                <div class="patrocinadores__infor">
                    <p class="patrocinadores__informacion">
                        RefereeLand es nuestro proveedor oficial de material deportivo. Colabora con nosotros dejándonos
                        unos precios muy competitivos comparándolos con el precio de mercado de sus productos
                    </p>
                </div>
            </div>
            <div id="container2" class="patrocinadores__box no-visto"> <!--Fisionext-->
                <div class="patrocinadores__logo">
                    <picture>
                        <source srcset="build/img/fisionext_2.avif" type="image/avif">
                        <source srcset="build/img/fisionext_2.webp" type="image/webp">
                        <img loading="lazy" width="20" height="20" src="build/img/fisionext_2.jpg" alt="Imagen del grupo">
                    </picture>
                </div>
                <div class="patrocinadores__description">
                    <p class="patrocinadores__texto">
                        Empresa deportiva fundada por <span>Manuel Jesús Orellana Cid</span> en 2017. Con una línea ascendente
                        en los últimos años se ha convertido en un proyecto que agrupa diferentes servicios que se
                        basan en la calidad e individualización de cada usuario, con el fin de aportar las
                        herramientas para conseguir cada meta, cada objetivo, cada sueño…
                        <br>Ofrecen servicios de entrenamiento, readaptación, nutrición, fisioterapia al Grupo de Árbitros
                        y Árbitras Deportistas de Cartuja para planificar, guiar y mejorar su rendimiento Deportivo.
                        Servicios de calidad enfocados de forma específica para desarrollar y maximizar el rendimiento.
                        <br>A través de su perfil de <a href="https://www.instagram.com/fisionext/" target="_blank">Instagram</a>
                        podrás conocer un poco más todo lo que nos ofrece y contactar con ellos para reservar y disfrutar de
                        todo lo que necesites.
                        <br>También puedes contactar con ellos a través del 633 50 57 32

                    </p>
                </div>
                <div class="patrocinadores__infor">
                    <p class="patrocinadores__informacion">
                        Fisionext es nuestro patrocinador oficial y colabora con nosotros ofreciéndonos
                        descuentos y promociones en sus diferentes servicios dejándonos unos precios muy
                        competitivos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const referee = document.getElementById('referee');
    const fisio = document.getElementById('fisio');

    const container1 = document.getElementById('container1');
    const container2 = document.getElementById('container2');

    referee.addEventListener('click', function() {
        if (container2.classList.contains('visto')) {
            container2.classList.remove('visto');
            container2.classList.add('no-visto');
        }
        mostrarReferee();
        contenidoBoton();
    });

    fisio.addEventListener('click', function() {
        if (container1.classList.contains('visto')) {
            container1.classList.remove('visto');
            container1.classList.add('no-visto');
        }

        mostrarFisio();
        contenidoBoton();
    });

    function mostrarReferee() {
        container1.classList.toggle('no-visto');
        container1.classList.toggle('visto');
    }

    function mostrarFisio() {
        container2.classList.toggle('no-visto');
        container2.classList.toggle('visto');
    }

    function contenidoBoton() {
        if (container1.classList.contains('visto')) {
            referee.textContent = 'Menos';
        } else {
            referee.textContent = 'Mas';
        }

        if (container2.classList.contains('visto')) {
            fisio.textContent = 'Menos';
        } else {
            fisio.textContent = 'Mas';
        }
    }
</script>