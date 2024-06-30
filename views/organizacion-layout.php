<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADCS - <?php echo $titulo; ?></title>
    <meta name="keywords" content="Entrenamientos árbitros árbitras pruebas físicas controles físicos">
    <meta name="description" content="Web de gestión del Grupo de Árbitros y Árbitras deportistas de Cartuja. Este Grupo está formado por personas que son árbitros y árbitras, que entrenan a diario con entrenamientos personalizados enfocados 100% en pasar los controles físicos diseñados por el Comité Técnico de Árbitros Español y de Andalucía">
    <meta name="author" content="Jesús Gómez Beltrán">
    <link rel="icon" href="/build/img/logo384.png" type="image/png"> <!--Icono de la pestaña del navegador-->

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Grupo de entrenamiento de Árbitros y Árbitras Deportistas de Cartuja">
    <meta property="og:description" content="Web de gestión del Grupo de Árbitros y Árbitras deportistas de Cartuja. Este Grupo está formado por personas que son árbitros y árbitras, que entrenan a diario con entrenamientos personalizados enfocados 100% en pasar los controles físicos diseñados por el Comité Técnico de Árbitros Español y de Andalucía">
    <meta property="og:image" content="/build/img/logo384.png">
    <meta property="og:url" content="https://adcs.es">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ADCS">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link rel="manifest" href="/manifest.json">
    
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    
</head>
<body class="dashboard">
        <?php 
            include_once __DIR__ .'/templates/admin-header.php';
        ?>
        <div class="dashboard__grid">
            <?php
                include_once __DIR__ .'/templates/organizacion-sidebar.php';  
            ?>

            <main class="dashboard__contenido">
                <?php 
                    echo $contenido; 
                ?> 
            </main>
        </div>

    <!-- <script src="/build/js/bundle.min.js" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.1.2/dist/chart.umd.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d/dist/chartjs-plugin-3d.min.js"></script>
    <script src="/build/js/main.min.js" defer></script>
</body>
</html>