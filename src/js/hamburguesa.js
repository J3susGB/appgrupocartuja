//función para menú hamgurguesa:
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const barra = document.querySelector('.barra');
        const nav = document.querySelector('.navegacion');
        const boton = document.querySelector('#boton');
    
        if (boton) {
            boton.addEventListener('click', function() {
                mostrarMenu();
            });
        }
    
        function mostrarMenu() {
            barra.classList.toggle('mostrar');
            nav.classList.toggle('mostrar');
    
            if (nav.classList.contains('mostrar')) {
                boton.classList.add('abierto');

            } else {
                boton.classList.remove('abierto');
            }
        }
        
    });

})();