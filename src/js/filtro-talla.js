(function() {
    // Obtener referencia a los elementos del DOM
    const inputNombre = document.getElementById('t_nombrus_filtrus');
    const selectCamiseta = document.getElementById('camiseta');
    const selectCalzona = document.getElementById('calzona');
    const selectChandal = document.getElementById('chandal');
    const selectCviento = document.getElementById('cviento');
    const tablaUsuarios = document.querySelectorAll('.table__tr');
    const restableceFiltrusBtn = document.getElementById('restableceFiltrus');
    const copiarNombrusIcon = document.getElementById('copiarNombrus');
    const copiarCamisetusIcon = document.getElementById('copiarCamisetus');
    const copiarCalzonusIcon = document.getElementById('copiarCalzonus');
    const copiarChandalusIcon = document.getElementById('copiarChandalus');
    const copiarCortavientusIcon = document.getElementById('copiarCortavientus');

    if (!inputNombre || !selectCamiseta || !selectCalzona || !selectChandal || !selectCviento || tablaUsuarios.length === 0) {
        console.error("¡Alguno de los elementos no se ha encontrado!");
        return;
    }

    // Función para restablecer los filtros a sus valores por defecto
    function restablecerFiltros() {
        inputNombre.value = ''; // Limpiar el valor del input de nombre
        selectCamiseta.selectedIndex = 0; // Restablecer el select de camiseta al primer elemento (opción "Ver todos")
        selectCalzona.selectedIndex = 0; // Restablecer el select de calzona al primer elemento (opción "Ver todos")
        selectChandal.selectedIndex = 0; // Restablecer el select de chandal al primer elemento (opción "Ver todos")
        selectCviento.selectedIndex = 0; // Restablecer el select de cviento al primer elemento (opción "Ver todos")
        // Mostrar todos los usuarios en la tabla
        tablaUsuarios.forEach(usuario => {
            usuario.style.display = '';
        });
    }

    // Función para copiar el contenido de una columna al portapapeles
    function copiarContenidoColumna(columnaIndex) {
        let contenidoColumna = '';
        tablaUsuarios.forEach(usuario => {
            if (usuario.style.display !== 'none') { // Verificar si el usuario está visible
                const columnasUsuario = usuario.querySelectorAll('.table__td');
                contenidoColumna += columnasUsuario[columnaIndex].textContent.trim() + '\n';
            }
        });

        // Copiar contenido al portapapeles
        navigator.clipboard.writeText(contenidoColumna).then(function() {
            setTimeout(function() {
                Swal.fire({
                    icon: "success",
                    title: "¡Hecho!",
                    text: "Copiado al portapapeles",
                  });
            }, 700); // Mostrar la alerta después de medio segundo
        }, function(err) {
            console.error('Error al copiar contenido al portapapeles:', err);
        });
    }

    // Agregar event listener al botón "restableceFiltrus"
    restableceFiltrusBtn.addEventListener('click', restablecerFiltros);

    // Agregar event listeners a los iconos de copia
    function agregarEventListenerCopia(icono, columnaIndex) {
        icono.addEventListener('click', function() {
            copiarContenidoColumna(columnaIndex); // Copiar el contenido de la columna correspondiente
            icono.classList.add('animate__animated', 'animate__rubberBand'); // Agregar clase de animación al icono
            icono.classList.remove('animate__rubberBand'); // Eliminar la clase para reiniciar la animación
            void icono.offsetWidth; // Activar un reflow
            icono.classList.add('animate__rubberBand');
        });
    }

    agregarEventListenerCopia(copiarNombrusIcon, 0); // 0 es el índice de la columna "Nombre"
    agregarEventListenerCopia(copiarCamisetusIcon, 1); // 1 es el índice de la columna "Camiseta"
    agregarEventListenerCopia(copiarCalzonusIcon, 2); // 2 es el índice de la columna "Calzonas"
    agregarEventListenerCopia(copiarChandalusIcon, 3); // 3 es el índice de la columna "Chandal"
    agregarEventListenerCopia(copiarCortavientusIcon, 4); // 4 es el índice de la columna "Cortavientos"

    function quitarAcentos(texto) {
        return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    inputNombre.addEventListener('input', function() {
        const filtroNombre = quitarAcentos(this.value.trim().toLowerCase()); // Obtener el valor del input y convertirlo a minúsculas sin acentos
        tablaUsuarios.forEach(usuario => {
            const nombreElemento = usuario.querySelector('#td_nombre');
            if (nombreElemento) {
                const nombreCompleto = quitarAcentos(nombreElemento.textContent.trim().toLowerCase()); // Obtener el nombre completo del usuario de la tabla y convertirlo a minúsculas sin acentos
                if (nombreCompleto.includes(filtroNombre)) {
                    usuario.style.display = ''; // Mostrar el usuario si coincide con el filtro
                } else {
                    usuario.style.display = 'none'; // Ocultar el usuario si no coincide con el filtro
                }
            }
        });
    });

    // Función para filtrar por talla en los select
    function filtrarPorTalla(select, columna) {
        select.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            tablaUsuarios.forEach(usuario => {
                const valorUsuario = usuario.querySelector(columna).getAttribute('data-value');
                if (valorUsuario === valorSeleccionado || valorSeleccionado === '') {
                    usuario.style.display = ''; // Mostrar el usuario si coincide con el filtro o si no se ha seleccionado ninguna talla
                } else {
                    usuario.style.display = 'none'; // Ocultar el usuario si no coincide con el filtro
                }
            });
        });
    }

    // Aplicar filtros por talla para cada select
    filtrarPorTalla(selectCamiseta, '#td_camiseta');
    filtrarPorTalla(selectCalzona, '#td_calzonas');
    filtrarPorTalla(selectChandal, '#td_chandal');
    filtrarPorTalla(selectCviento, '#td_chubasquero');
})();