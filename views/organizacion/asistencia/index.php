<?php 
    if(!is_admin() && !es_organizador()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div id="filtros" class="dashboard__filtros asistencia">
    <div id="vista_asistencia" class="dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h3>Vista:</h3>
        <select class="dashboard__campo" name="categoria_asistencia" id="vista_select">
            <option selected value="1">General</option>
            <option value="2">Por meses</option>
        </select>
    </div>
    <div id="categoria_asistencia" class="visible oculto--filtro dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h3>Categoría:</h3>
        <select class="dashboard__campo" name="categoria_asistencia" id="categoria_select">
            <option selected value="1">Ver todos</option>
            <option value="2">Provinciales</option>
            <option value="3">Oficiales</option>
        </select>
    </div>
    <div id="mes_asistencia" class="visible oculto--filtro dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h3>Mes:</h3>
        <select class="dashboard__campo" name="mes" id="select_mes">
            <option selected value="">Ver todos</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
        </select>
    </div>
</div>

<!--TABLA GENERAL PARA PROVINCIALES-->
<div id="general_prov" class="dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>General por meses</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Septiembre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Octubre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Noviembre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Diciembre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Enero
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Febrero
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Marzo
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Abril
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Mayo
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $meses = [
                        'Septiembre' => $total_sept_prov,
                        'Octubre' => $total_oct_prov,
                        'Noviembre' => $total_nov_prov,
                        'Diciembre' => $total_dic_prov,
                        'Enero' => $total_ene_prov,
                        'Febrero' => $total_feb_prov,
                        'Marzo' => $total_mar_prov,
                        'Abril' => $total_abr_prov,
                        'Mayo' => $total_may_prov
                    ];

                    foreach ($meses as $mes => $total_mes) { ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $mes; ?>">
                            <?php
                            $encontrado = false;
                            if (!empty($total_mes)) {
                                foreach ($total_mes as $total) {
                                    if ($nombre === $total['nombre']) {
                                        echo $total['count'];
                                        $encontrado = true;
                                        break;
                                    }
                                }
                            }
                            if (!$encontrado) {
                                echo "-";
                            }
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!--TABLA GENERAL PARA OFICIALES-->
<div id="general_ofi" class="dashboard__contenedor tabla_asistencia ">
    <h4><span class="subrayado">Oficiales: </span>General por meses</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Septiembre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Octubre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Noviembre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Diciembre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Enero
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Febrero
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Marzo
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Abril
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Mayo
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $meses = [
                        'Septiembre' => $total_sept_ofi,
                        'Octubre' => $total_oct_ofi,
                        'Noviembre' => $total_nov_ofi,
                        'Diciembre' => $total_dic_ofi,
                        'Enero' => $total_ene_ofi,
                        'Febrero' => $total_feb_ofi,
                        'Marzo' => $total_mar_ofi,
                        'Abril' => $total_abr_ofi,
                        'Mayo' => $total_may_ofi
                    ];

                    foreach ($meses as $mes => $total_mes) { ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $mes; ?>">
                            <?php
                            $encontrado = false;
                            if (!empty($total_mes)) {
                                foreach ($total_mes as $total) {
                                    if ($nombre === $total['nombre']) {
                                        echo $total['count'];
                                        $encontrado = true;
                                        break;
                                    }
                                }
                            }
                            if (!$encontrado) {
                                echo "-";
                            }
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA PROVINCIALES SEPTIEMBRE-->
<div id="sept_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Septiembre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                // Crear un array de días únicos que solo incluye los días de asistencia
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '09' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '09' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!--TABLA OFICIALES SEPTIEMBRE-->
<div id="sept_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Septiembre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                // Crear un array de días únicos que solo incluye los días de asistencia
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '09' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '09' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA PROVINCIALES OCTUBRE-->
<div id="oct_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Octubre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '10' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '10' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!--TABLA OFICIALES OCTUBRE-->
<div id="oct_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Octubre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '10' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '10' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA PROVINCIALES NOVIEMBRE-->
<div id="nov_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Noviembre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '11' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '11' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA OFICIALES NOVIEMBRE-->
<div id="nov_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Noviembre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '11' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '11' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!--TABLA PROVINCIALES DICIEMBRE-->
<div id="dic_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Diciembre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '12' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '12' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA OFICIALES DICIEMBRE-->
<div id="dic_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Diciembre</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '12' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '12' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA PROVINCIALES ENERO-->
<div id="ene_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Enero</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '01' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '01' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!--TABLA OFICIALES ENERO-->
<div id="ene_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Enero</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '01' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '01' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!--TABLA PROVINCIALES FEBRERO-->
<div id="feb_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Febrero</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '02' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '02' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA OFICIALES FEBRERO-->
<div id="feb_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Febrero</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '02' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '02' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!--TABLA PROVINCIALES MARZO-->
<div id="mar_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Marzo</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '03' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '03' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA OFICIALES MARZO-->
<div id="mar_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Marzo</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '03' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '03' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!--TABLA PROVINCIALES ABRIL-->
<div id="abr_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Abril</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '04' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '04' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA OFICIALES ABRIL-->
<div id="abr_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Abril</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '04' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '04' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!--TABLA PROVINCIALES MAYO-->
<div id="may_prov" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Provinciales: </span>Mayo</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '05' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '05' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!--TABLA OFICIALES MAYO-->
<div id="may_ofi" class="oculto dashboard__contenedor tabla_asistencia">
    <h4><span class="subrayado">Oficiales: </span>Mayo</h4>
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i class="fa-solid fa-copy icono-copy"></i>
                </th>
                <?php 
                $dias_asistencia = [];
                foreach ($dias_unicos as $dia) {
                    foreach ($asistencia as $as) {
                        if ($as->mes === '05' && $dia === $as->fecha) {
                            $dias_asistencia[] = $dia;
                            break;
                        }
                    }
                }
                foreach ($dias_asistencia as $dia) { ?>
                    <th scope="col" class="table__th">
                        <?php echo $dia; ?>
                        <i class="fa-solid fa-copy icono-copy"></i>
                    </th>
                <?php } ?>
                <th scope="col" class="table__th">
                    Total
                    <i class="fa-solid fa-copy icono-copy"></i>
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
                    $datos_encontrados = false;
                    foreach ($dias_asistencia as $dia) {
                        $asiste = false;
                        foreach ($asistencia as $as) {
                            if ($as->mes === '05' && $dia === $as->fecha && $nombre === $as->apellidos_nombre) {
                                $datos_encontrados = true;
                                if ($as->asiste == 1) {
                                    $asiste = true;
                                    $total_asiste++;
                                }
                                break;
                            }
                        }
                    ?>
                        <td class="table__td center" data-value="" data-label="<?php echo $dia; ?>">
                            <?php echo $asiste ? 'X' : '-'; ?>
                        </td>
                    <?php } ?>
                    <td class="table__td center" data-value="" data-label="Total">
                        <?php echo $datos_encontrados ? $total_asiste : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>