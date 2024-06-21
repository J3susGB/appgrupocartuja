<main class="principal">
    <p class="principal__descripcion">¡Te damos la bienvenida a nuestra web!</p>

    <div class="principal__box">
        <div class="principal__video">
            <video autoplay muted loop>
                <source src="build/videos/video_portada.mp4" type="video/mp4"/>
                <source src="build/videos/video_portada.ogg" type="video/ogg"/>
                <source src="build/videos/video_portada.webm" type="video/webm"/>
            </video>
        </div>

        <section class="resumen">
            <div class="resumen__grid">
                <div class="resumen__bloque">
                    <p data-aos="fade-down" data-aos-duration="1000" class="resumen__texto">Trabajo</p>
                </div>
                <div class="resumen__bloque">
                    <p data-aos="fade-up" data-aos-duration="1000" class="resumen__texto">Sacrificio</p>
                </div>
                <div class="resumen__bloque">
                    <p data-aos="fade-right" data-aos-duration="1000" class="resumen__texto">Mejora</p>
                </div>
                <div class="resumen__bloque">
                    <p data-aos="zoom-in" data-aos-duration="2000" class="resumen__texto">Éxito</p>
                </div>
            </div>
        </section>

        <section>
            <p id="heading_mapa" class="mapa__descripcion">¿Dónde entrenamos?</p>
            <div id="mapa" class="mapa"></div>
        </section>

    </div>
</main>

<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin="" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('#mapa')) {
            const lat = 37.4208143987095;
            const lng = -6.002839039377864;
            const zoom = 14;

            const map = L.map('mapa').setView([lat, lng], zoom);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Agregar marcador al mapa
            const marker = L.marker([lat, lng]).addTo(map)
                .bindPopup(`
                    <h4 class="mapa__heading">Instalaciones Deportivas La Cartuja</h4>
                    <p class="mapa__texto">Isla de la Cartuja, s/n, 41092 Sevilla</p>
                `)
                .openPopup();

            // Función para reestablecer la vista del mapa
            function resetView() {
                map.setView([lat, lng], zoom);
            }

            // Agregar botón de reestablecer vista debajo de los botones de zoom
            const resetButton = L.Control.extend({
                options: {
                    position: 'bottomleft'
                },

                onAdd: function () {
                    const container = L.DomUtil.create('div', 'reset-button-container');
                    const button = L.DomUtil.create('button', 'reset-button', container);
                    button.innerHTML = 'Reestablecer Vista';
                    button.onclick = function () {
                        resetView();
                    };
                    return container;
                }
            });

            map.addControl(new resetButton());
        }
    });
</script>