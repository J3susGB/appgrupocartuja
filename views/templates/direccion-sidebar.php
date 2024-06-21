<div class="dashboard__sidebar" id="sidebar">
    <nav class="dashboard__menu">
        <a href="/consultas_direccion/informes" class="dashboard__enlace <?php echo pagina_actual('/informes') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span class="dashboard__menu-texto">
                Informes
            </span>
        </a>
        <a href="/consultas_direccion/dashboard" class="dashboard__enlace <?php echo pagina_actual('/dashboard') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-calendar-days dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Asistencia
            </span>
        </a>
        <a href="/consultas_direccion/fotos-direccion" class="dashboard__enlace <?php echo pagina_actual('/fotos') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-photo-film"></i>
            <span class="dashboard__menu-texto">
                Fotos
            </span>
        </a>
    </nav>
</div>