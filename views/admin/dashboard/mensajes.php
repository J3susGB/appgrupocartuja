<?php if (!is_admin()) {
    header('Location: /login');
}
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/dashboard/añadir-mensaje">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
    <a class="dashboard__boton--panel" href="/admin/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor entrenamientos">
    <?php if (!empty($mensajes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">
                        Mensajes
                    </th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($mensajes as $plan) { ?>
                    <tr class="table__tr">
                        <td class="table__td td__planning" data-label="Mensaje">
                            <?php echo $plan->asunto; ?>
                            <i class="download fa-solid fa-eye" data-nombre="<?php echo $plan->asunto; ?>" data-fecha="<?php echo $plan->cuerpo; ?>"></i>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/dashboard/editar-mensaje?id=<?php echo $plan->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/dashboard/eliminar-mensaje" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $plan->id; ?>">
                                <button class="alerta_eliminar table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center padding">No hay mensajes almacenados</p>
    <?php } ?>

</div>

<script>
    (function() {
        const btn_descargar = document.querySelectorAll('.download');

        btn_descargar.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const nombre = btn.getAttribute('data-nombre');
                const fecha = btn.getAttribute('data-fecha');
                generarModal(nombre, fecha);
            });
        });

        function generarModal(nombre, fecha) {
            const modal = document.createElement('DIV');
            modal.classList.add('modal');
            modal.classList.add('modal2');
            modal.onclick = cerrarModal;

            const cerrarModalBtn = document.createElement('BUTTON');
            cerrarModalBtn.textContent = 'X';
            cerrarModalBtn.classList.add('btn-cerrar');
            cerrarModalBtn.onclick = cerrarModal;

            const box_cards = document.createElement('DIV');
            box_cards.classList.add('entrenamientos__card');

            const texto = document.createElement('DIV');
            texto.classList.add('entrenamientos__texto');

            const nombreElem = document.createElement('H4');
            nombreElem.classList.add('entrenamientos__texto--titulo', 'mensaje', 'mensaje--asunto');
            nombreElem.textContent = nombre;

            const fechaElem = document.createElement('P');
            fechaElem.classList.add('entrenamientos__texto--fecha', 'mensaje', 'mensaje--cuerpo');
            fechaElem.textContent = fecha;

            

            texto.appendChild(nombreElem);
            texto.appendChild(fechaElem);

            box_cards.appendChild(texto);
            modal.appendChild(box_cards);
            modal.appendChild(cerrarModalBtn);

            document.body.appendChild(modal);
        }

        function cerrarModal() {
            const modal = document.querySelector('.modal');
            if (modal) {
                modal.remove();
            }
        }
    })();
</script>
