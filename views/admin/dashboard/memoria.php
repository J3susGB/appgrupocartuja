<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="/admin/dashboard/añadir-memoria">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir
    </a>
    <a class="dashboard__boton--panel" href="/admin/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor entrenamientos">
    <?php if (!empty($memorias) || !isset($memorias)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">
                        Memoria Económica
                    </th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($memorias as $plan) { ?>
                    <tr class="table__tr">
                        <td class="table__td td__planning" data-label="Memoria Económica">
                            <?php echo $plan->documento; ?>
                            <i class="download fa-solid fa-download" data-fecha="<?php echo $plan->fecha; ?>" data-documento="<?php echo $_ENV['HOST'] . '/memorias_economicas/' . $plan->documento . '.pdf'; ?>"></i>
                        </td>
                        <td class="table__td--acciones">
                            <form method="POST" action="/admin/dashboard/eliminar-memoria" class="table__formulario">
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
        <p class="text-center padding">No existen documentos en este momento</p>
    <?php } ?>
</div>

<script>
    (function() {
        const btn_descargar = document.querySelectorAll('.download');

        btn_descargar.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const fecha = btn.getAttribute('data-fecha');
                const documento = btn.getAttribute('data-documento');
                generarModal(fecha, documento);
            });
        });

        function generarModal(fecha, documento) {
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

            const titEle = document.createElement('H3');
            titEle.classList.add('entrenamientos__texto--titulo');
            titEle.textContent = "Memoria Económica";

            const nombreElem = document.createElement('H4');
            nombreElem.classList.add('entrenamientos__texto--fecha');
            nombreElem.textContent = 'Temporada ' + fecha;

            const documentoElem = document.createElement('DIV');
            documentoElem.classList.add('entrenamientos__documento');
            documentoElem.innerHTML = `<embed src="${documento}" type="application/pdf" width="100%" height="600px" />`;

            const descargarBtn = document.createElement('A');
            descargarBtn.href = documento;
            descargarBtn.download = documento.split('/').pop();
            descargarBtn.classList.add('alerta', 'formulario__submit', 'formulario__submit--registrar', 'descargar_planning');
            descargarBtn.textContent = 'Descargar PDF';

            texto.appendChild(titEle);
            texto.appendChild(nombreElem);

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
