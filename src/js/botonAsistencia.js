(function() {
    // Función para seleccionar la opción de asistencia
    function seleccionarAsiste(index, button) {
        // Obtener el campo oculto correspondiente al miembro actual
        const hiddenInput = document.getElementById('asiste_' + index);
        
        // Actualizar el valor del campo oculto según la selección del usuario
        hiddenInput.value = button.getAttribute('data-value');
        
        // Remover la clase 'selected' de todos los botones dentro del mismo contenedor
        let buttons = button.parentNode.querySelectorAll('.btn-asiste');
        buttons.forEach(btn => btn.classList.remove('selected'));
        
        // Añadir la clase 'selected' al botón que fue clicado
        button.classList.add('selected');

        console.log(hiddenInput)
    }

    // Seleccionar todos los botones con la clase 'btn-asiste' y agregarles un evento 'click'
    document.querySelectorAll('.btn-asiste').forEach(button => {
        button.addEventListener('click', function() {
            // Obtener el índice desde el atributo 'data-index' del botón
            const index = button.getAttribute('data-index');
            
            // Llamar a la función 'seleccionarAsiste' pasando el índice y el botón como parámetros
            seleccionarAsiste(index, button);
        });
    });
})();