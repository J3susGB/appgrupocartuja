(function() {
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener referencia al campo de entrada
        var inputNombre = document.getElementById("f_nombre");
        
        // Obtener todas las filas de la tabla
        var filas = document.querySelectorAll(".table-lista__tr");

        function quitarAcentos(texto) {
            return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }
        
        // Agregar un evento de escucha para el evento de entrada en el campo de nombre
        inputNombre.addEventListener("input", function() {
            var filtro = quitarAcentos(inputNombre.value.toLowerCase()); // Convertir a minúsculas y quitar acentos para comparación sin distinción entre mayúsculas y minúsculas y sin acentos
        
            // Iterar sobre cada fila de la tabla
            filas.forEach(function(fila) {
                // Obtener el contenido del nombre en la fila actual y quitar acentos
                var nombreCompleto = quitarAcentos(fila.querySelector(".table-lista__td--nombre").textContent.toLowerCase());
                
                // Comprobar si el nombre coincide con el filtro
                if (nombreCompleto.includes(filtro)) {
                    // Si coincide, mostrar la fila
                    fila.style.display = "";
                } else {
                    // Si no coincide, ocultar la fila
                    fila.style.display = "none";
                }
            });
        });
    });
})();