<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/miembros/añadir-talla">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
    <a class="dashboard__boton--panel" href="/admin/miembros">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div id="filtros" class="dashboard__filtros">
    <h3 id="filtro_ppal" class="grid-item-full">Filtros:</h3>
    <div id="t_nombre" class="dashboard__inputs ">
        <h4>Buscar:</h4>
        <div class="dashboard__campo">
            <input 
                type="text"
                id="t_nombrus_filtrus"
                name="t_nombrus_filtrus"
                placeholder="Busca por nombre o apellidos"
                value=""
            />
        </div>
    </div>
    <div id="t_camiseta" class="dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h4>Camiseta:</h4>
        <select class="dashboard__campo" name="camiseta" id="camiseta">
            <option selected  value="">Ver todos</option>
            <?php foreach($tallas as $talla) { ?>
                <option value="<?php echo $talla->id; ?>"><?php echo  strtoupper($talla->nombre_talla); ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="t_calzonas" class="dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h4>Calzona:</h4>
        <select class="dashboard__campo" name="calzona" id="calzona">
            <option selected  value="">Ver todos</option>
            <?php foreach($tallas as $talla) { ?>
                <option value="<?php echo $talla->id; ?>"><?php echo  strtoupper($talla->nombre_talla); ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="t_chandal" class="dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h4>Chandal:</h4>
        <div class="dashboard__campo">
            <select class="dashboard__campo" name="chandal" id="chandal">
                <option selected value="">Ver todos</option>
                <?php foreach($tallas as $talla) { ?>
                    <option value="<?php echo $talla->id; ?>"><?php echo  strtoupper($talla->nombre_talla); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div id="t_cviento" class="dashboard__campo dashboard__inputs dashboard__inputs--text">
        <h4>Cortaviento:</h4>
        <div class="dashboard__campo">
            <select class="dashboard__campo" name="cviento" id="cviento">
                <option selected value="">Ver todos</option>
                <?php foreach($tallas as $talla) { ?>
                    <option value="<?php echo $talla->id; ?>"><?php echo  strtoupper($talla->nombre_talla); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="grid-item-full grid-item-full--boton text-center">
        <button id="restableceFiltrus" class="dashboard__boton--panel ">
            <i class="fa-solid fa-refresh"></i>
            Restablecer Filtros
        </button>
    </div>
</div>

<div class="dashboard__contenedor ">
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">
                    Nombre
                    <i id="copiarNombrus" class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Camiseta
                    <i id="copiarCamisetus" class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Calzonas
                    <i id="copiarCalzonus" class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Chandal
                    <i id="copiarChandalus" class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th">
                    Cortavientos
                    <i id="copiarCortavientus" class="fa-solid fa-copy icono-copy"></i>
                </th>
                <th scope="col" class="table__th"></th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach($tallasUsuarios as $i) { ?>
                <tr class="table__tr">
                    <td id="td_nombre" class="table__td"  data-label="Nombre">
                        <?php echo $i->apellido1 . " " . $i->apellido2 . ", " . $i->nombre; ?>
                    </td>
                    <td id="td_camiseta" class="table__td" data-value="<?php echo $i->camiseta; ?>" data-label="Camiseta" >
                        <?php echo strtoupper($i->nombre_talla_camiseta); ?>
                    </td>
                    <td id="td_calzonas" class="table__td" data-value="<?php echo $i->calzona; ?>" data-label="Calzonas" >
                        <?php echo strtoupper($i->nombre_talla_calzona); ?>
                    </td>
                    <td id="td_chandal" class="table__td" data-value="<?php echo $i->chandal; ?>" data-label="Chandal">
                        <?php echo strtoupper($i->nombre_talla_chandal); ?>
                    </td>
                    <td id="td_chubasquero" class="table__td" data-value="<?php echo $i->Cortavientos; ?>" data-label="Chubasquero">
                        <?php echo strtoupper($i->nombre_talla_cortavientos); ?>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__accion table__accion--editar" href="/admin/miembros/editar-talla?id=<?php echo $i->id_usuario; ?>">
                            <i class="fa-solid fa-user-pen"></i>
                            Editar
                        </a>
                        <form method="POST" action="/admin/miembros/tallas/eliminar" class="table__formulario">
                            <input type="hidden" name="id" value="<?php echo $i->id_usuario ?>">
                            <button class="table__accion table__accion--eliminar" type="submit">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>