<?php
    $alertas = $alertas ?? [];
    foreach($alertas as $key => $alerta) {
        foreach($alerta as $mensaje) {
?>
    <div class="alerta alerta__<?php echo $key; ?> animate__animated animate__rubberBand"><?php echo $mensaje; ?></div>
<?php 
        }
    }
?>