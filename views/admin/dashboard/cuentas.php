<?php 
    if(!is_admin()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton--panel" href="/admin/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__recuento dashboard__recuento--cuentas">
    <h3>Resumen</h3>
    <div class="dashboard__recuento--grid">
        <div class="dashboard__recuento--grid--ingreso">
            <p><span>Total ingresos: </span>
                <?php 
                    $total_ingresos = 0.00;
                    foreach($cuentas as $cuenta) {
                        $total_ingresos += $cuenta->ingreso;
                    } 
                    echo $total_ingresos . " €";
                ?>    
            </p>
        </div>
        <div class="dashboard__recuento--grid--gasto">
            <p><span>Total gastos: </span>
                <?php 
                    $total_gastos = 0.00;
                    foreach($cuentas as $cuenta) {
                        $total_gastos += $cuenta->gasto;
                    } 
                    echo $total_gastos . " €";
                ?>
            </p>
        </div>
        <div class="dashboard__recuento--grid--balance <?php echo $total_ingresos < $total_gastos ? 'negativo' : 'positivo'; ?>">
            <p><span>Balance: </span>
                <?php 
                    $total = $total_ingresos - $total_gastos; 
                    if($total > 0.00) {
                        echo " +" . $total . " €";
                    } else {
                        echo " " .  $total . " €";
                    }
                ?>
            </p>
        </div>
    </div>
</div>

<div class="dashboard__formulario">
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
    
    <form method="POST" action="/admin/dashboard/cuentas" class="formulario" novalidate>
        <h4 id="ingresosGastos">Anota los ingresos y gastos</h4>
        <div class="formulario--cuentas dashboard__recuento--grid dashboard__recuento--grid--balance--cuentas">
            <div class="formulario__campo">
                <label for="ingreso" class="formulario__label">Ingreso</label>
                <input 
                    type="number" 
                    class="formulario__input" 
                    placeholder="Anota un ingreso"
                    id="ingreso" 
                    name="ingreso" 
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
                />
            </div>
            <div class="formulario__campo dashboard__recuento--grid--balance dashboard__recuento--grid--texto">
                <label for="concepto" class="formulario__label">Concepto</label>
                <input 
                    type="text" 
                    class="formulario__input" 
                    placeholder="Indica el concepto del movimiento"
                    id="concepto" 
                    name="concepto" 
                />
            </div>
        </div>
        <input id="registrar" type="submit" class="formulario__submit formulario__submit--registrar alerta" value="Registrar">
    </form>
</div>

<div id="contenedor-tabla-cuentas" class="dashboard__contenedor ">
    <?php if( !empty($cuentas) ) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Concepto</th>
                    <th scope="col" class="table__th">Ingresos</th>
                    <th scope="col" class="table__th">Gastos</th>
                    <th scope="col" class="table__th">Balance</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($cuentas as $cuenta) { ?>
                    <tr class="table__tr">
                        <td id="conc" class="table__td" data-label="Concepto">
                            <?php echo $cuenta->concepto; ?>
                        </td>
                        <td id="ingr" class="table__td" data-label="Ingreso" >
                            <?php echo $cuenta->ingreso !== '0.00' ? "+ " . $cuenta->ingreso . " €" : ''; ?>

                        </td>
                        <td id="gast" class="table__td" data-label="Gasto">
                            <?php echo $cuenta->gasto !== '0.00' ? "- " . $cuenta->gasto . " €" : ''; ?>
                        </td>
                        <td id="bal" class="table__td" data-label="Balance">
                            <?php echo $cuenta->balance. " €"; ?>
                        </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center padding">No hay movimientos registrados</p>
    <?php } ?>
</div>