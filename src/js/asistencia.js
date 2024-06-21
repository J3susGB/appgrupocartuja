(function () {
    document.addEventListener('DOMContentLoaded', function() {
        // Div de los filtros de asistencia:
        const filtroCategoria = document.getElementById('categoria_asistencia');
        const filtroMes = document.getElementById('mes_asistencia');
        
        // Select de cada filtro:
        const selectVista = document.getElementById('vista_select');
        const selectCategoria = document.getElementById('categoria_select');
        const selectMes = document.getElementById('select_mes');

        // Selecciona tablas generales
        const generalProv = document.getElementById('general_prov');
        const generalOfi = document.getElementById('general_ofi');

        // Selecciona todas las tablas por meses y categorías:
        const tables = {
            prov: {
                '9': document.getElementById('sept_prov'),
                '10': document.getElementById('oct_prov'),
                '11': document.getElementById('nov_prov'),
                '12': document.getElementById('dic_prov'),
                '1': document.getElementById('ene_prov'),
                '2': document.getElementById('feb_prov'),
                '3': document.getElementById('mar_prov'),
                '4': document.getElementById('abr_prov'),
                '5': document.getElementById('may_prov')
            },
            ofi: {
                '9': document.getElementById('sept_ofi'),
                '10': document.getElementById('oct_ofi'),
                '11': document.getElementById('nov_ofi'),
                '12': document.getElementById('dic_ofi'),
                '1': document.getElementById('ene_ofi'),
                '2': document.getElementById('feb_ofi'),
                '3': document.getElementById('mar_ofi'),
                '4': document.getElementById('abr_ofi'),
                '5': document.getElementById('may_ofi')
            }
        };

        function ocultarTablas() {
            for (let key in tables.prov) {
                tables.prov[key].classList.add('oculto');
                tables.ofi[key].classList.add('oculto');
            }
        }

        function mostrarTablas(tipo) {
            for (let key in tables[tipo]) {
                tables[tipo][key].classList.remove('oculto');
            }
        }

        function manejarVista() {
            const vistaSeleccionada = selectVista.value;

            if (vistaSeleccionada === '1') {
                filtroCategoria.classList.add('oculto--filtro');
                filtroMes.classList.add('oculto--filtro');
                generalProv.classList.remove('oculto');
                generalOfi.classList.remove('oculto');
                ocultarTablas();
            } else if (vistaSeleccionada === '2') {
                filtroCategoria.classList.remove('oculto--filtro');
                filtroMes.classList.remove('oculto--filtro');
                generalProv.classList.add('oculto');
                generalOfi.classList.add('oculto');
                actualizarFiltrado();
            }
            actualizarEventListenersCopia(); // Asegurarse de actualizar los event listeners
        }

        function actualizarFiltrado() {
            ocultarTablas();

            const categoriaSeleccionada = selectCategoria.value;
            const mesSeleccionado = selectMes.value;

            if (categoriaSeleccionada === '1') {
                if (mesSeleccionado === '') {
                    mostrarTablas('prov');
                    mostrarTablas('ofi');
                } else {
                    tables.prov[mesSeleccionado].classList.remove('oculto');
                    tables.ofi[mesSeleccionado].classList.remove('oculto');
                }
            } else if (categoriaSeleccionada === '2') {
                if (mesSeleccionado === '') {
                    mostrarTablas('prov');
                } else {
                    tables.prov[mesSeleccionado].classList.remove('oculto');
                }
            } else if (categoriaSeleccionada === '3') {
                if (mesSeleccionado === '') {
                    mostrarTablas('ofi');
                } else {
                    tables.ofi[mesSeleccionado].classList.remove('oculto');
                }
            }
            actualizarEventListenersCopia();
        }

        function copiarContenidoColumna(table, columnaIndex) {
            let contenido = '';
            table.querySelectorAll('tbody tr').forEach(row => {
                const cell = row.cells[columnaIndex];
                if (cell && !row.classList.contains('oculto')) {
                    contenido += cell.textContent.trim() + '\n';
                }
            });
            navigator.clipboard.writeText(contenido).then(() => {
                setTimeout(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Copiado al portapapeles!"
                    });
                }, 700); // Agregar un retraso de 500 ms
            }, err => {
                console.error('Error al copiar al portapapeles: ', err);
            });
        }

        function agregarEventListenerCopia(icono, table, columnaIndex) {
            icono.addEventListener('click', function(event) {
                event.stopPropagation(); // Asegurarse de que el evento no se propague
                copiarContenidoColumna(table, columnaIndex); // Copiar el contenido de la columna correspondiente de la tabla
                
                icono.classList.add('animate__animated', 'animate__rubberBand');
                // Reiniciar la animación:
                icono.classList.remove('animate__rubberBand'); // Eliminar la clase para reiniciar la animación
                void icono.offsetWidth; // Forzar el reflow
                icono.classList.add('animate__rubberBand');
            });
        }

        function actualizarEventListenersCopia() {
            document.querySelectorAll('.icono-copy').forEach(icono => {
                const table = icono.closest('table');
                const columnaIndex = Array.from(icono.parentElement.parentElement.children).indexOf(icono.parentElement);
                const newIcono = icono.cloneNode(true); // Crear un clon del icono
                icono.replaceWith(newIcono); // Remover el icono viejo con event listeners previos
                agregarEventListenerCopia(newIcono, table, columnaIndex); // Agregar el nuevo event listener
            });
        }

        selectVista.addEventListener('change', manejarVista);
        selectCategoria.addEventListener('change', actualizarFiltrado);
        selectMes.addEventListener('change', actualizarFiltrado);

        manejarVista(); // Inicializar la vista con los valores actuales
    });
})();
