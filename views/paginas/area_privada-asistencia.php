<?php
if (!is_auth()) {
    header('Location: /login');
}
?>

<?php foreach ($miembros as $miembro) { ?>
    <?php if ($miembro->categoria_id === "12" || $miembro->categoria_id === "13") { ?>
        <h2 class="privada__heading"><?php echo $titulo; ?></h2>
        <div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas privada__btn">
            <a class="dashboard__boton--panel" href="/area_privada">
                <i class="fa-solid fa-circle-arrow-left"></i>
                Volver
            </a>
        </div>

        <div id="filter_privada_asistencia" class="dashboard__filtros asistencia">
            <div id="vista_asistencia_privada" class="dashboard__campo dashboard__inputs dashboard__inputs--text">
                <h3>Vista:</h3>
                <select class="dashboard__campo" name="categoria_asistencia" id="vista_select_privada">
                    <option selected value="1">General</option>
                    <option value="2">Meses</option>
                </select>
            </div>
        </div>

        
            <!--TABLA GENERAL-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class=" general_privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">General</span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Septiembre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Octubre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Noviembre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Diciembre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Enero
                                    </th>
                                    <th scope="col" class="table__th">
                                        Febrero
                                    </th>
                                    <th scope="col" class="table__th">
                                        Marzo
                                    </th>
                                    <th scope="col" class="table__th">
                                        Abril
                                    </th>
                                    <th scope="col" class="table__th">
                                        Mayo
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Septiembre">
                                            <?php
                                            if (!empty($total_sept_prov)) {
                                                foreach ($total_sept_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Octubre">
                                            <?php
                                            if (!empty($total_oct_prov)) {
                                                foreach ($total_oct_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Noviembre">
                                            <?php
                                            if (!empty($total_nov_prov)) {
                                                foreach ($total_nov_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Diciembre">
                                            <?php
                                            if (!empty($total_dic_prov)) {
                                                foreach ($total_dic_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Enero">
                                            <?php
                                            if (!empty($total_ene_prov)) {
                                                foreach ($total_ene_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Febrero">
                                            <?php
                                            if (!empty($total_feb_prov)) {
                                                foreach ($total_feb_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Marzo">
                                            <?php
                                            if (!empty($total_mar_prov)) {
                                                foreach ($total_mar_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="abril">
                                            <?php
                                            if (!empty($total_abr_prov)) {
                                                foreach ($total_abr_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Mayo">
                                            <?php
                                            if (!empty($total_may_prov)) {
                                                foreach ($total_may_prov as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class=" general_privada_o dashboard__contenedor tabla_asistencia ">
                        <h4><span class="subrayado">General</span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Septiembre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Octubre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Noviembre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Diciembre
                                    </th>
                                    <th scope="col" class="table__th">
                                        Enero
                                    </th>
                                    <th scope="col" class="table__th">
                                        Febrero
                                    </th>
                                    <th scope="col" class="table__th">
                                        Marzo
                                    </th>
                                    <th scope="col" class="table__th">
                                        Abril
                                    </th>
                                    <th scope="col" class="table__th">
                                        Mayo
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Septiembre">
                                            <?php
                                            if (!empty($total_sept_ofi)) {
                                                foreach ($total_sept_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Octubre">
                                            <?php
                                            if (!empty($total_oct_ofi)) {
                                                foreach ($total_oct_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Noviembre">
                                            <?php
                                            if (!empty($total_nov_ofi)) {
                                                foreach ($total_nov_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Diciembre">
                                            <?php
                                            if (!empty($total_dic_ofi)) {
                                                foreach ($total_dic_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Enero">
                                            <?php
                                            if (!empty($total_ene_ofi)) {
                                                foreach ($total_ene_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Febrero">
                                            <?php
                                            if (!empty($total_feb_ofi)) {
                                                foreach ($total_feb_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Marzo">
                                            <?php
                                            if (!empty($total_mar_ofi)) {
                                                foreach ($total_mar_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="abril">
                                            <?php
                                            if (!empty($total_abr_ofi)) {
                                                foreach ($total_abr_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td class="table__td center" data-value="" data-label="Mayo">
                                            <?php
                                            if (!empty($total_may_ofi)) {
                                                foreach ($total_may_ofi as $total) {
                                                    if ($nombre === $total['nombre']) {
                                                        echo $total['count'];
                                                    }
                                                }
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>


            <!--TABLA  SEPTIEMBRE-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto septiembre__privada_p oculto dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Septiembre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '09' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '09' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto septiembre__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Septiembre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '09' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '09' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA  OCTUBRE-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto octubre__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Octubre</span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '10' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '10' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto octubre__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Octubre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '10' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '10' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLAS NOVIEMBRE-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto noviembre__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Noviembre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '11' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '11' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto noviembre__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Noviembre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '11' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '11' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA DICIEMBRE-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto diciembre__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Diciembre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '12' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '12' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto diciembre__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Diciembre </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '12' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '12' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA  ENERO-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto enero__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Enero </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '01' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '01' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto enero__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Enero </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '01' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '01' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA FEBRERO-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto febrero__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Febrero </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '02' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '02' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto febrero__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Febrero </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '02' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '02' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA MARZO-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto marzo__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Marzo </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '03' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '03' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto marzo__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Marzo </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '03' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '03' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA  ABRIL-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto abril__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Abril </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '04' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '04' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto abril__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Abril </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '04' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '04' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>

            <!--TABLA MAYO-->
            <?php foreach ($miembros as $miembro) { ?>
                <?php if ($miembro->categoria_id === "12") { ?>
                    <div class="oculto mayo__privada_p dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Mayo </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '05' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_prov as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '05' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="oculto mayo__privada_o dashboard__contenedor tabla_asistencia">
                        <h4><span class="subrayado">Mayo </span></h4>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">
                                        Nombre
                                    </th>
                                    <?php foreach ($dias_unicos as $dia) { ?>
                                        <?php foreach ($asistencia as $as) { ?>
                                            <?php if ($as->mes === '05' && $dia === $as->fecha) { ?>
                                                <th scope="col" class="table__th">
                                                    <?php echo $dia; ?>
                                                </th>
                                                <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <th scope="col" class="table__th">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody">
                                <?php foreach ($nombres_ofi as $nombre) { ?>
                                    <tr class="table__tr">
                                        <td class="table__td" data-label="Nombre">
                                            <?php echo $nombre; ?>
                                        </td>
                                        <?php
                                        $total_asiste = 0;
                                        foreach ($dias_unicos as $dia) {
                                            $mostrar_dia = false;
                                            $asiste = false;
                                            foreach ($asistencia as $as) {
                                                if ($as->mes === '05' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                                    $mostrar_dia = true;
                                                    if ($as->asiste == 1) {
                                                        $asiste = true;
                                                        $total_asiste++;
                                                    }
                                                    break;
                                                }
                                            }
                                            if ($mostrar_dia) {
                                        ?>
                                                <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                                                    <?php echo $asiste ? 'X' : ''; ?>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <td class="table__td center" data-value="" data-label="Total">
                                            <?php echo $total_asiste; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>
        
        
    <?php } else { ?>
    <?php header('Location: /');
    } ?>
<?php } ?>

<script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            const filtroVista = document.getElementById('vista_asistencia_privada');
            const selectVista = document.getElementById('vista_select_privada');
            const generalPrivada_p = document.querySelectorAll('.general_privada_p');
            const generalPrivada_o = document.querySelectorAll('.general_privada_o');
            const septiembre_p = document.querySelectorAll('.septiembre__privada_p');
            const septiembre_o = document.querySelectorAll('.septiembre__privada_o');
            const octubre_p = document.querySelectorAll('.octubre__privada_p');
            const octubre_o = document.querySelectorAll('.octubre__privada_o');
            const noviembre_p = document.querySelectorAll('.noviembre__privada_p');
            const noviembre_o = document.querySelectorAll('.noviembre__privada_o');
            const diciembre_p = document.querySelectorAll('.diciembre__privada_p');
            const diciembre_o = document.querySelectorAll('.diciembre__privada_o');
            const enero_p = document.querySelectorAll('.enero__privada_p');
            const enero_o = document.querySelectorAll('.enero__privada_o');
            const febrero_p = document.querySelectorAll('.febrero__privada_p');
            const febrero_o = document.querySelectorAll('.febrero__privada_o');
            const marzo_p = document.querySelectorAll('.marzo__privada_p');
            const marzo_o = document.querySelectorAll('.marzo__privada_o');
            const abril_p = document.querySelectorAll('.abril__privada_p');
            const abril_o = document.querySelectorAll('.abril__privada_o');
            const mayo_p = document.querySelectorAll('.mayo__privada_p');
            const mayo_o = document.querySelectorAll('.mayo__privada_o');

            // Agregando evento de clic a selectVista
            selectVista.addEventListener('click', function() {
                manejarVista();

            });

            function manejarVista() {
                if (selectVista.value === "1") {
                    generalPrivada_p.forEach(element => {
                        element.classList.remove('oculto');
                    });
                    generalPrivada_o.forEach(element => {
                        element.classList.remove('oculto');
                    });

                    ocultarTablas();

                } else if (selectVista.value === "2") {
                    generalPrivada_p.forEach(element => {
                        element.classList.add('oculto');
                    });
                    generalPrivada_o.forEach(element => {
                        element.classList.add('oculto');
                    });

                    mostrarTablas();

                }
            }

            function ocultarTablas() {
                septiembre_p.forEach(element => {
                    element.classList.add('oculto');
                });
                septiembre_o.forEach(element => {
                    element.classList.add('oculto');
                });

                octubre_p.forEach(element => {
                    element.classList.add('oculto');
                });
                octubre_o.forEach(element => {
                    element.classList.add('oculto');
                });

                noviembre_p.forEach(element => {
                    element.classList.add('oculto');
                });
                noviembre_o.forEach(element => {
                    element.classList.add('oculto');
                });

                diciembre_p.forEach(element => {
                    element.classList.add('oculto');
                });
                diciembre_o.forEach(element => {
                    element.classList.add('oculto');
                });

                enero_p.forEach(element => {
                    element.classList.add('oculto');
                });
                enero_o.forEach(element => {
                    element.classList.add('oculto');
                });

                febrero_p.forEach(element => {
                    element.classList.add('oculto');
                });
                febrero_o.forEach(element => {
                    element.classList.add('oculto');
                });

                marzo_p.forEach(element => {
                    element.classList.add('oculto');
                });
                marzo_o.forEach(element => {
                    element.classList.add('oculto');
                });

                abril_p.forEach(element => {
                    element.classList.add('oculto');
                });
                abril_o.forEach(element => {
                    element.classList.add('oculto');
                });

                mayo_p.forEach(element => {
                    element.classList.add('oculto');
                });
                mayo_o.forEach(element => {
                    element.classList.add('oculto');
                });
            }

            function mostrarTablas() {
                septiembre_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                septiembre_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                octubre_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                octubre_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                noviembre_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                noviembre_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                diciembre_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                diciembre_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                enero_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                enero_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                febrero_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                febrero_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                marzo_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                marzo_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                abril_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                abril_o.forEach(element => {
                    element.classList.remove('oculto');
                });

                mayo_p.forEach(element => {
                    element.classList.remove('oculto');
                });
                mayo_o.forEach(element => {
                    element.classList.remove('oculto');
                });
            }
        });
    })();
</script>