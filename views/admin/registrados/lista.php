<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor">
    <?php if( !empty($miembros) ) { ?>
        <div class="dashboard__formulario ">
            <form method="POST" action="/admin/registrados/lista" enctype="multipart/form-data">
             <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
                <div class="filtros">
                    <div class="filtros__fecha">
                        <input
                            id="fecha"
                            type="date"  
                            name="dia"    
                        />
                    </div>
                    <div class="filtros__turno">
                        <select name="turno">
                            <?php
                            // Obtiene la hora actual en formato de 24 horas
                            $hora_actual = date('H:i');

                            // $hora_actual = '08:00'; // Simula la hora 08:00 am
                            // $hora_actual = '15:30'; // Simula la hora 15:30 pm

                            // Determina la opción predeterminada según la hora actual
                            $turno_predeterminado = null;
                            // Verificar si la hora actual está en el rango de la mañana o tarde
                            if ($hora_actual >= '08:00' && $hora_actual <= '14:59') {
                                // Si la hora actual está entre las 08:00 y las 14:59, selecciona "mañana"
                                $turno_predeterminado = 'mañana';
                            } else {
                                // Si la hora actual está entre las 15:00 y 07:59, selecciona "tarde"
                                $turno_predeterminado = 'tarde';
                            }

                            // Iterar a través de los turnos y establecer el atributo selected para el turno predeterminado
                            foreach ($turnos as $turno) {
                                // Establece la variable $selected si el turno actual coincide con el turno predeterminado
                                $selected = '';
                                if (($turno_predeterminado === 'mañana' && $turno->id_turno === '1') ||
                                    ($turno_predeterminado === 'tarde' && $turno->id_turno === '2')) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?php echo $turno->id_turno; ?>" <?php echo $selected; ?>>
                                    <?php echo $turno->nombre_turno; ?>
                                </option>
                            <?php } ?>
                        </select>
                    
                </div> 

                </div class="filtros__texto">
                    <input 
                        type="text"
                        id="f_nombre"
                        name="f_nombre"
                        placeholder="Busca por nombre o apellidos"
                        value=""
                    />
                </div>

                <table class="table-lista">
                    <thead class="table-lista__thead">
                        <tr>
                            <th scope="col" class="table-lista__th"></th>
                            <th scope="col" class="table-lista__th">Nombre</th>
                            <th scope="col" class="table-lista__th">Categoría</th>
                            <th scope="col" class="table-lista__th">Día</th>
                            <th scope="col" class="table-lista__th">Turno</th>
                            <th scope="col" class="table-lista__th">¿Asiste?</th>
                        </tr>
                    </thead>
                    <tbody class="table-lista__tbody">
                        <div class="table-lista__tbody--contenedor">
                            <?php foreach ($miembros as $index => $miembro) { ?>
                                <tr class="table-lista__tr">
                                    <div class="table-lista__campo">
                                        <td class="table-lista__td">
                                            <div class="formulario__imagen">
                                                <picture>
                                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.webp" type="image/webp">
                                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.png" type="image/png">
                                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.avif" type="image/avif">
                                                    <img src="<?php echo $_ENV['HOST'] . '/img/miembros/' . $miembro->foto; ?>.png" alt="Imagen del miembro">
                                                </picture>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="table-lista__dato">

                                        <td class="table-lista__td table-lista__td--nombre" data-label="Nombre">
                                            <?php echo $miembro->apellido1 . " " . $miembro->apellido2 . ", " . $miembro->nombre; ?>
                                            <!-- Guarda los datos de nombre, apellido1 y apellido2 en campos ocultos -->
                                            <input type="hidden" name="miembros[<?php echo $index; ?>][nombre]" value="<?php echo $miembro->nombre; ?>">
                                            <input type="hidden" name="miembros[<?php echo $index; ?>][apellido1]" value="<?php echo $miembro->apellido1; ?>">
                                            <input type="hidden" name="miembros[<?php echo $index; ?>][apellido2]" value="<?php echo $miembro->apellido2; ?>">
                                            <input type="hidden" name="miembros[<?php echo $index; ?>][id]" value="<?php echo $miembro->id; ?>">
                                        </td>


                                        <td class="table-lista__td categoria table-lista__td--categoria" data-label="Categoría">
                                            <?php foreach ($categorias as $categoria) {
                                                if ($miembro->categoria_id === $categoria->id) {
                                                    echo $categoria->nombre_cat;
                                                }
                                            } ?>
                                            <!-- Guarda la categoría del miembro en un campo oculto -->
                                            <input type="hidden" name="miembros[<?php echo $index; ?>][categoria_id]" value="<?php echo $miembro->categoria_id; ?>">
                                        </td>  
                                    </div>
                                    <div class="table-lista__acciones">
                                        <td class="table-lista__select" data-label="¿Asiste?">
                                            <?php
                                            // Obtener los valores del controlador
                                            $valor_asiste = $valores['miembros'][$index]['asiste'] ?? 2; // Valor predeterminado es 2 (No)

                                            // Establece la clase `selected` en el botón correspondiente
                                            $clase_si = $valor_asiste == 1 ? 'selected' : '';
                                            $clase_no = $valor_asiste == 2 ? 'selected' : '';
                                            ?>

                                            <input type="hidden" id="asiste_<?php echo $index; ?>" name="miembros[<?php echo $index; ?>][asiste]" value="<?php echo $valor_asiste; ?>">

                                            <button type="button" class="btn-asiste <?php echo $clase_si; ?>" data-value="1" data-index="<?php echo $index; ?>">
                                                Sí
                                            </button>
                                            <button type="button" class="btn-asiste <?php echo $clase_no; ?>" data-value="2" data-index="<?php echo $index; ?>">
                                                No
                                            </button>
                                        </td>


                                    </div>
                                </tr>
                            <?php } ?>
                        </div>
                    </tbody>
                </table>
        <input type="submit" class="alerta formulario__submit formulario__submit--registrar" value="Enviar asistencia">
    </form>
            </div>
        
    <?php } else { ?>
        <p class="text-center">No hay miembros registrados</p>
    <?php } ?>
</div>