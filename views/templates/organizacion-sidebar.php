<div class="dashboard__sidebar" id="sidebar">
    <nav class="dashboard__menu">
        <a href="/organizacion/dashboard" class="dashboard__enlace <?php echo pagina_actual('/dashboard') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Inicio
            </span>
        </a>
        <a href="/organizacion/miembros" class="dashboard__enlace <?php echo pagina_actual('/miembros') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Miembros
            </span>
        </a>
        <a href="/organizacion/registrados/lista-organizacion" class="dashboard__enlace <?php echo pagina_actual('/lista') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-clipboard-list dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Lista
            </span>
        </a>
        <a href="/organizacion/registrados/fotos-organizacion" class="dashboard__enlace <?php echo pagina_actual('/fotos') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-photo-film"></i>
            <span class="dashboard__menu-texto">
                Fotos
            </span>
        </a>
        <a href="/organizacion/asistencia" class="dashboard__enlace <?php echo pagina_actual('/asistencia') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-calendar-days dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Asistencia
            </span>
        </a>
    </nav>
</div>