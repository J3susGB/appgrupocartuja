<h2 class="privada__heading"><?php echo $titulo; ?></h2>
<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas privada__btn">
    <a class="dashboard__boton--panel" href="/area_privada">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<main class="mensajes">
    <?php if (!empty($mensajes_combinados)) { ?>
        <?php foreach ($mensajes_combinados as $mensaje) { ?>
            <div class="mensajes__card <?php echo $mensaje->leido ? '' : 'no-leido'; ?>" data-id="<?php echo $mensaje->id; ?>">
                <div class="mensajes__texto">
                    <p><?php echo $mensaje->asunto; ?></p>
                    <i class="download fa-solid fa-eye"
                       data-id="<?php echo $mensaje->id; ?>"
                       data-asunto="<?php echo $mensaje->asunto; ?>"
                       data-cuerpo="<?php echo $mensaje->cuerpo; ?>"
                       onclick="abrirModal(this.dataset.id, this.dataset.asunto, this.dataset.cuerpo)">
                    </i>
                </div>
                <div class="mensajes__estado">
                    <p><?php echo $mensaje->leido ? 'Leído' : 'No leído'; ?></p>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-center padding">En este momento no hay mensajes</p>
    <?php } ?>
</main>

<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h2 id="modal-asunto"></h2>
        <p id="modal-cuerpo"></p>
    </div>
</div>

<script>
    // Función para abrir el modal y mostrar el contenido del mensaje
    function abrirModal(id, asunto, cuerpo) {
        document.getElementById('modal-asunto').innerText = asunto;
        document.getElementById('modal-cuerpo').innerText = cuerpo;
        document.getElementById('modal').style.display = 'block';
        marcarLeido(id); // Marcar el mensaje como leído al abrir el modal
    }

    // Función para cerrar el modal
    function cerrarModal() {
        document.getElementById('modal').style.display = 'none';
    }

    // Función para marcar un mensaje como leído
    function marcarLeido(mensaje_id) {
        fetch('http://localhost:3000/marcar_mensaje_leido', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ mensaje_id: mensaje_id }),
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    throw new Error('No autorizado');
                } else if (response.status === 400) {
                    throw new Error('Solicitud incorrecta');
                }
                throw new Error('Error al marcar como leído');
            }
            return response.json();
        })
        .then(data => {
            console.log('Mensaje marcado como leído:', data);

            const mensajeCard = document.querySelector(`.mensajes__card[data-id="${mensaje_id}"]`);
            if (mensajeCard) {
                mensajeCard.classList.remove('no-leido');
                mensajeCard.querySelector('.mensajes__estado p').textContent = 'Leído';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
    }

    // Cerrar el modal al hacer clic fuera de él
    window.onclick = function(event) {
        if (event.target == document.getElementById('modal')) {
            cerrarModal();
        }
    }
</script>

<style>
    /* Estilos para el modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow-y: hidden;
        background-color: rgba(black, 0.8);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        border-radius: 1rem;
    }

    .modal-content h2#modal-asunto {
        color:#319442;
        font-size: 2.5rem;
    }
    @media (min-width: 768px) {
        .modal-content h2#modal-asunto {
        font-size: 3rem;
        }  
    }
    @media (min-width: 1200px) {
        .modal-content h2#modal-asunto {
        font-size: 3.5rem;
        }  
    }
    
    .modal-content #modal-cuerpo {
        font-size: 1.5rem;
    }
    @media (min-width: 600px) {
        .modal-content #modal-cuerpo {
        font-size: 1.8rem;
        }  
    }
    @media (min-width: 768px) {
        .modal-content #modal-cuerpo {
        font-size: 2rem;
        }  
    }
    @media (min-width: 1200px) {
        .modal-content #modal-cuerpo {
        font-size: 2.3rem;
        }  
    }

    .close {
        color: #aaa;
        padding: .1rem 1rem;
        border-radius: 50%;
        float: right;
        font-size: 28px;
        font-weight: bold;
        transition: background-color .3s ease-in-out, color .3s ease-in-out;
    }

    .close:hover,
    .close:focus {
        color: white;
        background-color: red;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .3s ease-in-out, color .3s ease-in-out;
    }
</style>
