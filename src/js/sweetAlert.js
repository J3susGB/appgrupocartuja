(function() {
    const registrer_btn = document.querySelector('.alerta');
    registrer_btn.addEventListener('click', function() {
        registrer_btn.classList.add('mostrar_sweet');
        mostrar_alerta();
        setTimeout(function() {
            registrer_btn.classList.remove('mostrar_sweet');
        }, 100)

        
    });

    // const drop_btn = document.querySelectorall('.alerta_eliminar');
    // drop_btn.forEach(function(btn) {
    //     btn.addEventListener('click', function() {
    //         btn.classList.add('mostrar_sweet');
    //         confirmar_eliminar_planning();
    //         setTimeout(function() {
    //             btn.classList.remove('mostrar_sweet');
    //         }, 100)
    //     });
    // });

    function mostrar_alerta() {
        Swal.fire({
            icon: "success",
            title: "¡Hecho!"
          });
    }

    // function confirmar_eliminar_planning() {
    //     Swal.fire({
    //         title: "Vas a eliminar un planning, ¿Estás seguro?",
    //         showCancelButton: true,
    //         confirmButtonText: "Si",
    //         cancelButtonText: "No"
    //     }).then((result) => {
    //         /* Read more about isConfirmed, isDenied below */
    //         if (result.isConfirmed) {
    //             Swal.fire("Saved!", "", "success");
    //         } 
    //     });
    // }

})();