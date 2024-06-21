(function() {
    // Selecciona todas las imágenes (<img>) dentro de los elementos <picture>
    const imagenes = document.querySelectorAll('picture img');
    
    document.addEventListener('DOMContentLoaded', function() {
        mostrarImagen();
    });

    function mostrarImagen() {
        // Itera sobre cada imagen
        imagenes.forEach(function(imagen) {
            // Agrega un evento de clic a cada imagen
            imagen.onclick = function() {
                generarModal(imagen);
            }
        });
    }

    function generarModal(imagen) {
        // Crea un elemento div para el modal
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.onclick = cerrarModal;

        //Boton cerrar modal
        const cerrarModalBtn = document.createElement('BUTTON');
        cerrarModalBtn.textContent = 'X';
        cerrarModalBtn.classList.add('btn-cerrar');
        cerrarModalBtn.onclick = cerrarModal;

        // Crear una imagen de copia de la imagen que se hizo clic
        const imagenModal = document.createElement('img');
        imagenModal.src = imagen.src;
        imagenModal.alt = imagen.alt;

        // Añadir la imagen al modal
        modal.appendChild(imagenModal);
        modal.appendChild(cerrarModalBtn);

        // Añadir el modal al cuerpo del documento
        const body = document.querySelector('body');
        body.appendChild(modal);
    }

    function cerrarModal() {
        // Eliminar el modal del DOM
        const modal = document.querySelector('.modal');
        if (modal) {
            modal.classList.add('fade-out');

            setTimeout(() => {
                modal.remove();
            }, 450);
        }
    }

})();
