<main class="packs">
    <h2 class="packs__heading"><?php echo $titulo; ?></h2>
    <p class="packs__descripcion">Información sobre nuestros distintos packs</p>

    <div class="boxesContainer">
        <?php foreach ($packs as $pack) { ?>
            <?php if ($pack->id === "1") { ?>
                <div class="cardBox reflection ">
                    <div class="card">
                        <div class="front">
                            <h3><?php echo $pack->nombre_pack; ?></h3>
                            <strong>&#x21bb;</strong>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                            <p class="packs__info">*Precio por toda la temporada</p>
                        </div>
                        <div class="back reflection ">
                            <p>Incluye:</p>
                            <ul>
                                <li>Planning semanal</li>
                                <li>Entrenador presencial</li>
                                <li>Césped artificial dos veces a la semana</li>
                            </ul>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <?php foreach ($packs as $pack) { ?>
            <?php if ($pack->id === "2") { ?>
                <div class="cardBox reflection ">
                    <div class="card">
                        <div class="front">
                            <h3><?php echo $pack->nombre_pack; ?></h3>
                            <strong>&#x21bb;</strong>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                            <p class="packs__info">*Precio por toda la temporada</p>
                        </div>
                        <div class="back reflection ">
                            <p>Incluye:</p>
                            <ul>
                                <li>Pack entrenos</li>
                                <li>2 cenas</li>
                                <li>Navidad y final de temporada</li>
                            </ul>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <?php foreach ($packs as $pack) { ?>
            <?php if ($pack->id === "3") { ?>
                <div class="cardBox reflection ">
                    <div class="card">
                        <div class="front">
                            <h3><?php echo $pack->nombre_pack; ?></h3>
                            <strong>&#x21bb;</strong>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                            <p class="packs__info">*Precio por toda la temporada</p>
                        </div>
                        <div class="back">
                            <p>Incluye:</p>
                            <ul>
                                <li>Pack entrenos</li>
                                <li>Equipamiento deportivo</li>
                            </ul>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <?php foreach ($packs as $pack) { ?>
            <?php if ($pack->id === "4") { ?>
                <div class="cardBox reflection ">
                    <div class="card">
                        <div class="front">
                            <h3><?php echo $pack->nombre_pack; ?></h3>
                            <strong>&#x21bb;</strong>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                            <p class="packs__info">*Precio por toda la temporada</p>
                        </div>
                        <div class="back">
                            <p>Incluye:</p>
                            <ul>
                                <li>Pack entrenos</li>
                                <li>Pack cenas</li>
                                <li>Pack ropa</li>
                            </ul>
                            <p class="packs__precio"><span><?php echo $pack->precio . " €"; ?></span></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</main>