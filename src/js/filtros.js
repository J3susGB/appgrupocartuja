(function () {
    // Consultar la API de miembros en el backend de PHP
    consultarAPI();
    

    async function consultarAPI() {
        try {
            const url = '/api/miembros';
            const resultado = await fetch(url);
            const datos = await resultado.json();
            

            // Obtener un array de objetos a partir de las propiedades del objeto JSON
            const miembros = Object.values(datos);

            // Llamo a la función para mostrar todos los miembros
            mostrarRecuento(miembros)

            // Función para filtrar los miembros según los criterios seleccionados
            function filtrar() {
                const filtroNombre = document.getElementById('nombre').value.toLowerCase();
                const filtroCategoria = document.getElementById('categoria').value;
                const filtroPack = document.getElementById('filtroPack').value;
                const filtroPago = document.getElementById('filtroPago').value;

                // Filtrar por nombre
                let miembrosFiltrados = miembros.filter(miembro => {
                    const nombreCompleto = `${miembro.apellido1} ${miembro.apellido2}, ${miembro.nombre}`; // Formato apellido1 apellido2, nombre
                    return nombreCompleto.toLowerCase().includes(filtroNombre);
                });

                // Filtrar por categoría
                if (filtroCategoria) {
                    miembrosFiltrados = miembrosFiltrados.filter(miembro => miembro.categoria_id === filtroCategoria);
                }

                // Filtrar por pack
                if (filtroPack) {
                    miembrosFiltrados = miembrosFiltrados.filter(miembro => miembro.pack_id === filtroPack);
                }

                // Filtrar por estado de pago
                if (filtroPago) {
                    miembrosFiltrados = miembrosFiltrados.filter(miembro => {
                        if (filtroPago === '6') {
                            return miembro.pendiente_pagar === miembro.total_a_pagar;
                        } else if (filtroPago === '7') {
                            return parseInt(miembro.pendiente_pagar) === miembro.cuota_pendiente_tras_primer_pago;
                        } else if (filtroPago === '8') {
                            return parseInt(miembro.pendiente_pagar) === miembro.cuota_pendiente_tras_segundo_pago;
                        } else {
                            return true;
                        }
                    });
                }

                mostrarRecuento(miembrosFiltrados);

                mostrarResultados(miembrosFiltrados);
            }

            // Agregar event listeners para los cambios en los filtros
            document.getElementById('nombre').addEventListener('input', filtrar);
            document.getElementById('categoria').addEventListener('change', filtrar);
            document.getElementById('filtroPack').addEventListener('change', filtrar);
            document.getElementById('filtroPago').addEventListener('change', filtrar);

            // Función para mostrar los resultados en la interfaz
            function mostrarResultados(miembrosFiltrados) {
                const tbody = document.querySelector('.table__tbody');
                // Limpiar tabla
                tbody.innerHTML = '';

                if (miembrosFiltrados.length > 0) {
                    // Crear filas de la tabla con los miembros filtrados
                    miembrosFiltrados.forEach(miembro => {
                        const tr = document.createElement('tr');
                        tr.classList.add('table__tr');

                        // Crear celdas de la fila con la información del miembro
                        const nombreCompleto = `${miembro.apellido1} ${miembro.apellido2}, ${miembro.nombre}`; // Formato apellido1 apellido2, nombre
                        const tdNombre = document.createElement('td');
                        tdNombre.classList.add('table__td');
                        tdNombre.textContent = nombreCompleto;
                        tdNombre.setAttribute('data-label', 'Nombre:');
                        tr.appendChild(tdNombre);

                        const tdCategoria = document.createElement('td');
                        tdCategoria.classList.add('table__td');
                        tdCategoria.textContent = miembro.nombre_categoria;
                        tdCategoria.setAttribute('data-label', 'Categoría:');
                        tr.appendChild(tdCategoria);

                        const tdEmail = document.createElement('td');
                        tdEmail.classList.add('table__td');
                        tdEmail.textContent = miembro.email;
                        tdEmail.setAttribute('data-label', 'Email:');
                        tr.appendChild(tdEmail);

                        const tdTelefono = document.createElement('td');
                        tdTelefono.classList.add('table__td');
                        tdTelefono.textContent = miembro.telefono;
                        tdTelefono.setAttribute('data-label', 'Teléfono:');
                        tr.appendChild(tdTelefono);

                        const tdPack = document.createElement('td');
                        tdPack.classList.add('table__td');
                        tdPack.textContent = miembro.nombre_pack;
                        tdPack.setAttribute('data-label', 'Pack:');
                        tr.appendChild(tdPack);

                        const tdPendiente = document.createElement('td');
                        tdPendiente.classList.add('table__td');
                        tdPendiente.textContent = `${miembro.pendiente_pagar}.00 €`;
                        tdPendiente.setAttribute('data-label', 'Pendiente:');
                        tr.appendChild(tdPendiente);
                        console.log(isAdmin);

                        if (isAdmin) {
                            const tdAcciones = document.createElement('td');
                            tdAcciones.classList.add('table__td--acciones');

                            const editarLink = document.createElement('a');
                            editarLink.classList.add('table__accion', 'table__accion--editar');
                            editarLink.href = `/admin/miembros/editar?id=${miembro.id}`;
                            editarLink.innerHTML = '<i class="fa-solid fa-user-pen"></i>Editar';
                            tdAcciones.appendChild(editarLink);

                            const formEliminar = document.createElement('form');
                            formEliminar.method = 'POST';
                            formEliminar.action = '/admin/miembros/eliminar';
                            formEliminar.classList.add('table__formulario');
                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'id';
                            inputId.value = miembro.id;
                            formEliminar.appendChild(inputId);
                            const botonEliminar = document.createElement('button');
                            botonEliminar.type = 'submit';
                            botonEliminar.classList.add('table__accion', 'table__accion--eliminar');
                            botonEliminar.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>Eliminar';
                            formEliminar.appendChild(botonEliminar);
                            tdAcciones.appendChild(formEliminar);

                            tr.appendChild(tdAcciones);
                        }

                        tbody.appendChild(tr);
                    });
                } else {
                    // Mostrar mensaje si no hay resultados
                    const tr = document.createElement('tr');
                    const td = document.createElement('td');
                    td.textContent = 'No hay miembros registrados';
                    td.classList.add('text-center', 'padding'); // Agregar la clase "padding"
                    td.setAttribute('colspan', '7');
                    tr.appendChild(td);
                    tbody.appendChild(tr);
                }
            }

            // Mostrar todos los miembros al cargar la página
            mostrarResultados(miembros);

            // Event listener para el botón "Restablecer filtros"
            document.getElementById('restablecerFiltros').addEventListener('click', function() {
                // Restablecer los valores de los selectores de categoría, pack y pago
                document.getElementById('categoria').value = '';
                document.getElementById('filtroPack').value = '';
                document.getElementById('filtroPago').value = '';
                // Filtrar nuevamente los miembros
                filtrar();
            });

            // Event listener para el botón "Copiar Emails"
            document.getElementById('copiarEmails').addEventListener('click', function() {
                const icono = document.querySelector('#copiarEmails');
                icono.classList.add('animate__animated', 'animate__rubberBand');
                icono.classList.remove('animate__rubberBand'); // Eliminar la clase para reiniciar la animación
                void icono.offsetWidth; // Activar un reflow
                icono.classList.add('animate__rubberBand'); // Agregar la clase nuevamente
                
                const miembrosEmails = document.querySelectorAll('.table__tbody .table__td:nth-child(3)'); // Selecciona todas las celdas de correo electrónico en la tabla
                const emails = Array.from(miembrosEmails).map(td => td.textContent.trim()).join('\n'); // Obtiene los textos de las celdas y los une con saltos de línea
                navigator.clipboard.writeText(emails); // Copia los correos electrónicos al portapapeles
                setTimeout(function() {
                    Swal.fire({
                        icon: "success",
                        title: "¡Hecho!",
                        text: "Emails copiados al portapapeles",
                      });
                }, 700); // Mostrar la alerta después de medio segundo
                console.log('Emails copiados al portapapeles');
            });

            // Event listener para el botón "Copiar nombre"
            document.getElementById('copiarNombres').addEventListener('click', function() {
                const icono = document.querySelector('#copiarNombres');
                icono.classList.add('animate__animated', 'animate__rubberBand');
                icono.classList.remove('animate__rubberBand'); // Eliminar la clase para reiniciar la animación
                void icono.offsetWidth; // Activar un reflow
                icono.classList.add('animate__rubberBand'); // Agregar la clase nuevamente

                // Obtener los nombres de los miembros filtrados actualmente
                const nombresFiltrados = Array.from(document.querySelectorAll('.table__tbody .table__td:nth-child(1)'))
                    .map(td => td.textContent.trim())
                    .join('\n');

                // Copiar al portapapeles
                navigator.clipboard.writeText(nombresFiltrados).then(function() {
                    console.log('Nombres copiados al portapapeles');
                    setTimeout(function() {
                        Swal.fire({
                            icon: "success",
                            title: "¡Hecho!",
                            text: "Nombres copiados al portapapeles",
                          });
                    }, 700); // Mostrar la alerta después de medio segundo
                }, function(err) {
                    console.error('Error al copiar nombres: ', err);
                });
            });

        } catch (error) {
            console.error(error);
        }
    }

    function mostrarRecuento(miembrosFiltrados) {
        const recuentoElemento = document.getElementById('recuento-miembros');
        if (miembrosFiltrados.length > 0) {
            recuentoElemento.innerHTML = ''; // Limpiar contenido existente
            const spanTotal = document.createElement('span');
            spanTotal.textContent = 'Total: ';
            spanTotal.style.color = '#principal'; // Utiliza el color definido en tu archivo de estilos
            spanTotal.style.fontWeight = 'bold'; // Utiliza el peso de la fuente definido en tu archivo de estilos
    
            const totalPersonas = miembrosFiltrados.length === 1 ? `${miembrosFiltrados.length} persona` : `${miembrosFiltrados.length} personas`;
    
            recuentoElemento.appendChild(spanTotal);
            recuentoElemento.insertAdjacentText('beforeend', totalPersonas);
            recuentoElemento.style.display = 'block'; // Mostrar la caja de recuento
        } else {
            recuentoElemento.style.display = 'none'; // Ocultar la caja de recuento
        }
    }

})();