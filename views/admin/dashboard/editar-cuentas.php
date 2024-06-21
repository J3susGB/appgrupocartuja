<!-- <?php 
    if(!is_admin()) {
        header('Location: /login');
    }

    // debuguear($cuentas);
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard/cuentas">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
    
    <form method="POST" class="formulario" novalidate>
        <div class="formulario--cuentas dashboard__recuento--grid dashboard__recuento--grid--balance--cuentas">
            <div class="formulario__campo dashboard__recuento--grid--balance dashboard__recuento--grid--texto">
                <label for="concepto" class="formulario__label">Concepto</label>
                <input 
                    type="text" 
                    class="formulario__input" 
                    placeholder="Indica el concepto del movimiento"
                    id="concepto" 
                    name="concepto" 
                    value="<?php echo $cuentas->concepto; ?>"
                />
            </div>
            <div class="formulario__campo">
                <label for="ingreso" class="formulario__label">Ingreso</label>
                <input 
                    type="number" 
                    class="formulario__input" 
                    placeholder="Anota un ingreso"
                    id="ingreso" 
                    name="ingreso" 
                    value="<?php echo $cuentas->ingreso; ?>"
                />
            </div>
            <div class="formulario__campo">
                <label for="gasto" class="formulario__label">Gasto</label>
                <input 
                    type="number" 
                    class="formulario__input" 
                    placeholder="Anota un gasto"
                    id="gasto" 
                    name="gasto" 
                    value="<?php echo $cuentas->gasto; ?>"
                />
            </div>
        </div>
        <input id="registrar" type="submit" class="formulario__submit formulario__submit--registrar alerta" value="Registrar">
    </form>
</div> -->