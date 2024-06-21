<?php if (!is_admin()) {
    header('Location: /login');
}
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>
<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/entrenamientos/añadir">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
</div>

<div class="dashboard__contenedor entrenamientos">
    <?php if (!empty($plannings)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">
                        Planning de entrenamientos
                    </th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($plannings as $plan) { ?>
                    <tr class="table__tr">
                        <td class="table__td td__planning" data-label="Planning">
                            <?php echo $plan->documento; ?>
                            <i class="download fa-solid fa-download" data-nombre="<?php echo $plan->nombre; ?>" data-fecha="<?php echo $plan->fecha; ?>" data-notas="<?php echo $plan->notas; ?>" data-documento="<?php echo $_ENV['HOST'] . '/entrenamientos/' . $plan->documento . '.pdf'; ?>"></i>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/entrenamientos/editar?id=<?php echo $plan->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/entrenamientos/eliminar" class="table__formulario">
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
        <p class="text-center padding">No hay plannings de entrenamientos subidos en este momento</p>
    <?php } ?>

</div>

<script>
    (function() {
        const btn_descargar = document.querySelectorAll('.download');

        btn_descargar.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const nombre = btn.getAttribute('data-nombre');
                const fecha = btn.getAttribute('data-fecha');
                const notas = btn.getAttribute('data-notas');
                const documento = btn.getAttribute('data-documento');
                generarModal(nombre, fecha, notas, documento);
            });
        });

        function generarModal(nombre, fecha, notas, documento) {
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

            const nombreElem = document.createElement('H3');
            nombreElem.classList.add('entrenamientos__texto--titulo');
            nombreElem.textContent = nombre;

            const fechaElem = document.createElement('H4');
            fechaElem.classList.add('entrenamientos__texto--fecha');
            fechaElem.textContent = fecha;

            const notasElem = document.createElement('P');
            notasElem.classList.add('entrenamientos__texto--notas');
            notasElem.textContent = notas;

            const documentoElem = document.createElement('DIV');
            documentoElem.classList.add('entrenamientos__documento');
            documentoElem.innerHTML = `<embed src="${documento}" type="application/pdf" width="100%" height="600px" />`;

            const descargarBtn = document.createElement('A');
            descargarBtn.href = documento;
            descargarBtn.download = documento.split('/').pop();
            descargarBtn.classList.add('alerta', 'formulario__submit', 'formulario__submit--registrar', 'descargar_planning');
            descargarBtn.textContent = 'Descargar PDF';

            texto.appendChild(nombreElem);
            texto.appendChild(fechaElem);
            texto.appendChild(notasElem);

            box_cards.appendChild(texto);
            box_cards.appendChild(documentoElem);
            box_cards.appendChild(descargarBtn);
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