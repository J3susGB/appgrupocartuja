<?php
    if(!es_directivo() && !is_admin()) {
        header('Location: /login');
    }
?>

<h2 class="dashboard__heading"><?php echo $titulo ?></h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton-tallas">
    <a class="dashboard__boton--panel" href="./informes/memorias">
        <i class="fa-solid fa-sack-dollar"></i>
        Memoria económica
    </a>
</div>


<main class="box_graficas">

    <div class="caja-grafica">
        <div class="caja-grafica__top">
            <p class="grafica__heading">Resumen</p>
            <i id="menos3" class="pulsador3 fa-solid fa-minus "></i>
            <i id="mas3" class="pulsador3 fa-solid fa-plus oculto"></i>
        </div>

        <div id="box_graf3" class="dashboard__contenedor-graficas ">
            <div class="dashboard__grafica">
                <canvas id="regalos-grafica1" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="grafica3" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="grafica4" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="grafica5" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <div class="caja-grafica">
        <div class="caja-grafica__top">
            <p class="grafica__heading">Usuarios por packs y categorías</p>
            <!-- <i id="menos"  class="pulsador fa-sharp fa-regular fa-eye-slash"></i> -->
            <i id="menos" class="pulsador fa-solid fa-minus oculto"></i>
            <!-- <i id="mas" class="pulsador fa-regular fa-eye oculto"></i> -->
            <i id="mas" class="pulsador fa-solid fa-plus "></i>
        </div>

        <div id="box_graf1" class="dashboard__contenedor-graficas ocultalo">
            <!-- <div class="dashboard__grafica">
                <canvas id="regalos-grafica1" width="400" height="400"></canvas>
            </div> -->
            <div class="dashboard__grafica">
                <canvas id="regalos-grafica18" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="regalos-grafica17" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="regalos-grafica16" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="regalos-grafica15" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="regalos-grafica14" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <div class="caja-grafica">
        <div class="caja-grafica__top">
            <p class="grafica__heading">Ingresos por packs y categorías</p>
            <i id="menos2" class="pulsador2 fa-solid fa-minus oculto"></i>
            <i id="mas2" class="pulsador2 fa-solid fa-plus "></i>
        </div>

        <div id="box_graf2" class="dashboard__contenedor-graficas ocultalo">
            <div class="dashboard__grafica">
                <canvas id="grafica1" width="400" height="400"></canvas>
            </div>
            <div class="dashboard__grafica">
                <canvas id="grafica2" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

</main>

<script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Caja de gráficas 1
            const box_graf1 = document.getElementById('box_graf1');
            const pulsadores = document.querySelectorAll('.pulsador');
            const mas = document.getElementById('mas');
            const menos = document.getElementById('menos');

            pulsadores.forEach(function(pulsador) {
                pulsador.addEventListener('click', function() {
                    box_graf1.classList.toggle('ocultalo');

                    if (box_graf1.classList.contains('ocultalo')) {
                        mas.classList.remove('oculto');
                        menos.classList.add('oculto');
                    } else {
                        mas.classList.add('oculto');
                        menos.classList.remove('oculto');
                    }
                });
            });

            // Caja de gráficas 2
            const pulsadores2 = document.querySelectorAll('.pulsador2');
            const mas2 = document.getElementById('mas2');
            const menos2 = document.getElementById('menos2');

            pulsadores2.forEach(function(pulsador) {
                pulsador.addEventListener('click', function() {
                    box_graf2.classList.toggle('ocultalo');

                    if (box_graf2.classList.contains('ocultalo')) {
                        mas2.classList.remove('oculto');
                        menos2.classList.add('oculto');
                    } else {
                        mas2.classList.add('oculto');
                        menos2.classList.remove('oculto');
                    }
                });
            });

            // Caja de gráficas 3
            const pulsadores3 = document.querySelectorAll('.pulsador3');
            const mas3 = document.getElementById('mas3');
            const menos3 = document.getElementById('menos3');

            pulsadores3.forEach(function(pulsador) {
                pulsador.addEventListener('click', function() {
                    box_graf3.classList.toggle('ocultalo');

                    if (box_graf3.classList.contains('ocultalo')) {
                        mas3.classList.remove('oculto');
                        menos3.classList.add('oculto');
                    } else {
                        mas3.classList.add('oculto');
                        menos3.classList.remove('oculto');
                    }
                });
            });
        });
    })();
</script>

<!-- Cajas de Graficas 1.-Resumen -->
<!-- Grafico circular (Pie chart). Totales por packs-->
<script>
    const grafica1 = document.querySelector('#regalos-grafica1');
    let graficaInstance1 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica1) {
        obtenerDatos();

        async function obtenerDatos() {
            const url1 = '/api/categorias';
            const respuesta1 = await fetch(url1);
            const resultado1 = await respuesta1.json();

            console.log(resultado1); // Para verificar el JSON parseado

            // Convertir el objeto en un array
            const resultadoArray1 = Object.values(resultado1);

            // Verificar si `resultadoArray` es un array
            if (!Array.isArray(resultadoArray1)) {
                console.error('La respuesta de la API no se pudo convertir a un array', resultadoArray1);
                return;
            }

            // Resto del código para crear la gráfica...
            const ctx1 = document.getElementById('regalos-grafica1').getContext('2d');
            if (graficaInstance1) {
                graficaInstance1.destroy();
            }
            graficaInstance1 = new Chart(ctx1, {
                type: 'pie', // Cambiar el tipo de gráfico a pie
                data: {
                    labels:resultadoArray1.map(regalo1 => regalo1.nombre_pack),
                    datasets: [{
                        label: 'Nº personas',
                        data: resultadoArray1.map(regalo1 => regalo1.total),
                        backgroundColor: [
                            '#f48d86 ',
                            '#95a8ae',
                            '#deb297',
                            '#407c9e',
                            '#f4ebda'
                        ]
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right', // Posición de la leyenda
                            labels: {
                                boxWidth: 20, // Ancho de los cuadros de color
                                padding: 20 // Espacio alrededor de cada elemento de la leyenda
                            }
                        },
                        title: {
                            display: true,
                            text: 'Personas totales por pack',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            });
        }
    }
</script>

<script>
    // Variables para almacenar las instancias de los gráficos
    let graficaInstance3 = null;
    let graficaInstance4 = null;
    let graficaInstance5 = null;

    document.addEventListener("DOMContentLoaded", function() {
        obtenerDatos();

        async function obtenerDatos() {
            const url = '/api/cuentas'; 
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            console.log(resultado); // Para verificar el JSON parseado

            // Extraer y transformar los datos según tu API
            const data = {
                ingresos: {
                    acumulado: resultado.ingresos.acumulado,
                    cuotas: resultado.ingresos.cuotas,
                    patrocinio: resultado.ingresos.patrocinio,
                    otros: resultado.ingresos.otros,
                    total_ingresos: resultado.ingresos.total_ingresos
                },
                gastos: {
                    equipamiento_deportivo: resultado.gastos.equipamiento_deportivo,
                    cenas: resultado.gastos.cenas,
                    entrenador: resultado.gastos.entrenador,
                    material: resultado.gastos.material,
                    otros: resultado.gastos.otros,
                    total_gastos: resultado.gastos.total_gastos
                }
            };

            const labelsIngresos = Object.keys(data.ingresos).filter(key => key !== 'total_ingresos').map(key => key.charAt(0).toUpperCase() + key.slice(1));
            const valuesIngresos = labelsIngresos.map(key => data.ingresos[key.toLowerCase()]);
            const labelsGastos = ['Equipamiento deportivo', 'Cenas', 'Entrenador', 'Material', 'Otros'];
            const valuesGastos = labelsGastos.map(label => data.gastos[label.replace(/\s+/g, '_').toLowerCase()]);

            const ctx3 = document.getElementById('grafica3').getContext('2d');
            const ctx4 = document.getElementById('grafica4').getContext('2d');
            const ctx5 = document.getElementById('grafica5').getContext('2d');

            // Destruir las instancias anteriores de los gráficos si existen
            if (graficaInstance3) {
                graficaInstance3.destroy();
            }
            if (graficaInstance4) {
                graficaInstance4.destroy();
            }
            if (graficaInstance5) {
                graficaInstance5.destroy();
            }

            // Gráfico de radar para ingresos
            graficaInstance3 = new Chart(ctx3, {
                type: 'radar',
                data: {
                    labels: labelsIngresos,
                    datasets: [{
                        label: 'Ingresos',
                        data: valuesIngresos,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Ingresos',
                            font: {
                                size: 16
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    return label.charAt(0).toUpperCase() + label.slice(1) + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                        }
                    }
                }
            });

            // Gráfico de radar para gastos
            graficaInstance4 = new Chart(ctx4, {
                type: 'radar',
                data: {
                    labels: labelsGastos,
                    datasets: [{
                        label: 'Gastos',
                        data: valuesGastos,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribución de Gastos',
                            font: {
                                size: 16
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    return label.charAt(0).toUpperCase() + label.slice(1) + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                        }
                    }
                }
            });

            // Gráfico de barras apiladas para balance
            graficaInstance5 = new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: ['Total Ingresos', 'Total Gastos', 'Balance'],
                    datasets: [
                        {
                            label: 'Total Ingresos',
                            data: [data.ingresos.total_ingresos, 0, data.ingresos.total_ingresos],
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total Gastos',
                            data: [0, data.gastos.total_gastos, data.gastos.total_gastos],
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Balance',
                            data: [0, 0, data.ingresos.total_ingresos - data.gastos.total_gastos],
                            backgroundColor: 'rgba(222, 178, 151, 0.5)',
                            borderColor: 'rgba(222, 178, 151, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Balance',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            suggestedMax: Math.max(data.ingresos.total_ingresos, data.gastos.total_gastos)
                        }
                    }
                }
            });
        }
    });
</script>


<!-- Cajas de Graficas 2.-Usuarios Por Packs Y Categorías -->
<!-- Grafico barras Totales por categorías solo entrenos -->
<script>
    const grafica18 = document.querySelector('#regalos-grafica18');
    let graficaInstance18 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica18) {
        obtenerDatos18();

        async function obtenerDatos18() {
            const url18 = '/api/categorias-packs';
            const respuesta18 = await fetch(url18);
            const resultado18 = await respuesta18.json();

            console.log(resultado18); // Para verificar el JSON parseado

            // Encontrar el paquete con id "1"
            const soloEntrenos = resultado18.find(pack => pack.id === "1");

            if (!soloEntrenos) {
                console.error('No se encontró el paquete con id "1"');
                return;
            }

            // Definir las categorías y sus correspondientes valores
            const categorias = [
                'primera_div', 'aa_primera_div', 'segunda_div', 'aa_segunda_div',
                'primera_rfef', 'aa_primera_rfef', 'segunda_rfef', 'aa_segunda_rfef',
                'tercera', 'aa_tercera', 'division_honor', 'provinciales',
                'oficiales', 'auxiliares', 'futbol_base', 'rugby', 'retirado'
            ];
            const nombresCategorias = {
                'primera_div': 'Primera División',
                'aa_primera_div': 'AA Primera División',
                'segunda_div': 'Segunda División',
                'aa_segunda_div': 'AA Segunda División',
                'primera_rfef': 'Primera RFEF',
                'aa_primera_rfef': 'AA Primera RFEF',
                'segunda_rfef': 'Segunda RFEF',
                'aa_segunda_rfef': 'AA Segunda RFEF',
                'tercera': 'Tercera División',
                'aa_tercera': 'AA Tercera División',
                'division_honor': 'División de Honor',
                'provinciales': 'Provinciales',
                'oficiales': 'Oficiales',
                'auxiliares': 'Auxiliares',
                'futbol_base': 'Fútbol Base',
                'rugby': 'Rugby',
                'retirado': 'Retirado'
            };
            const coloresCategorias = {
                'primera_div': '#b8d8d8',
                'aa_primera_div': '#f0e1d2',
                'segunda_div': '#f7d9aa',
                'aa_segunda_div': '#c1baaf',
                'primera_rfef': '#a7c4bc',
                'aa_primera_rfef': '#f0efeb',
                'segunda_rfef': '#bfbfbf',
                'aa_segunda_rfef': '#c9ada7',
                'tercera': '#dfc3b6',
                'aa_tercera': '#b0c4b1',
                'division_honor': '#c9b6dd',
                'provinciales': '#c2d5cc',
                'oficiales': '#e8ccb9',
                'auxiliares': '#d4d4aa',
                'futbol_base': '#c3d6c1',
                'rugby': '#e3d2ca',
                'retirado': '#b6c4cb'
            };
            const valores = categorias.map(categoria => parseInt(soloEntrenos[categoria], 10));
            const colores = categorias.map(categoria => coloresCategorias[categoria]);

            // Crear la gráfica
            const ctx18 = document.getElementById('regalos-grafica18').getContext('2d');
            if (graficaInstance18) {
                graficaInstance18.destroy();
            }
            graficaInstance18 = new Chart(ctx18, {
                type: 'bar',
                data: {
                    labels: categorias, // Mantener las categorías para referencia interna
                    datasets: [{
                        label: 'Nº personas',
                        data: valores,
                        backgroundColor: colores
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Ocultar el eje x
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: (tooltipItems) => {
                                    // Retornar el nombre amigable de la categoría
                                    const item = tooltipItems[0];
                                    const categoria = categorias[item.dataIndex];
                                    return nombresCategorias[categoria];
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Solo Entrenos',
                            font: {
                                size: 16
                            },
                            // position: 'bottom',
                            padding: {
                                bottom: 30
                            }
                        }
                    }
                }
            });
        }
    }
</script>

<!-- Grafico barras Totales por categorías entrenos + cenas -->
<script>
    const grafica17 = document.querySelector('#regalos-grafica17');
    let graficaInstance17 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica17) {
        obtenerDatos17();

        async function obtenerDatos17() {
            const url17 = '/api/categorias-packs';
            const respuesta17 = await fetch(url17);
            const resultado17 = await respuesta17.json();

            console.log(resultado17); // Para verificar el JSON parseado

            // Encontrar el paquete con id "1"
            const cenas = resultado17.find(pack => pack.id === "2");

            if (!cenas) {
                console.error('No se encontró el paquete con id "2"');
                return;
            }

            // Definir las categorías y sus correspondientes valores
            const categorias = [
                'primera_div', 'aa_primera_div', 'segunda_div', 'aa_segunda_div',
                'primera_rfef', 'aa_primera_rfef', 'segunda_rfef', 'aa_segunda_rfef',
                'tercera', 'aa_tercera', 'division_honor', 'provinciales',
                'oficiales', 'auxiliares', 'futbol_base', 'rugby', 'retirado'
            ];
            const nombresCategorias = {
                'primera_div': 'Primera División',
                'aa_primera_div': 'AA Primera División',
                'segunda_div': 'Segunda División',
                'aa_segunda_div': 'AA Segunda División',
                'primera_rfef': 'Primera RFEF',
                'aa_primera_rfef': 'AA Primera RFEF',
                'segunda_rfef': 'Segunda RFEF',
                'aa_segunda_rfef': 'AA Segunda RFEF',
                'tercera': 'Tercera División',
                'aa_tercera': 'AA Tercera División',
                'division_honor': 'División de Honor',
                'provinciales': 'Provinciales',
                'oficiales': 'Oficiales',
                'auxiliares': 'Auxiliares',
                'futbol_base': 'Fútbol Base',
                'rugby': 'Rugby',
                'retirado': 'Retirado'
            };
            const coloresCategorias = {
                'primera_div': '#b8d8d8',
                'aa_primera_div': '#f0e1d2',
                'segunda_div': '#f7d9aa',
                'aa_segunda_div': '#c1baaf',
                'primera_rfef': '#a7c4bc',
                'aa_primera_rfef': '#f0efeb',
                'segunda_rfef': '#bfbfbf',
                'aa_segunda_rfef': '#c9ada7',
                'tercera': '#dfc3b6',
                'aa_tercera': '#b0c4b1',
                'division_honor': '#c9b6dd',
                'provinciales': '#c2d5cc',
                'oficiales': '#e8ccb9',
                'auxiliares': '#d4d4aa',
                'futbol_base': '#c3d6c1',
                'rugby': '#e3d2ca',
                'retirado': '#b6c4cb'
            };
            const valores = categorias.map(categoria => parseInt(cenas[categoria], 10));
            const colores = categorias.map(categoria => coloresCategorias[categoria]);

            // Crear la gráfica
            const ctx17 = document.getElementById('regalos-grafica17').getContext('2d');
            if (graficaInstance17) {
                graficaInstance17.destroy();
            }
            graficaInstance17 = new Chart(ctx17, {
                type: 'bar',
                data: {
                    labels: categorias, // Mantener las categorías para referencia interna
                    datasets: [{
                        label: 'Nº personas',
                        data: valores,
                        backgroundColor: colores
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Ocultar el eje x
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: (tooltipItems) => {
                                    // Retornar el nombre amigable de la categoría
                                    const item = tooltipItems[0];
                                    const categoria = categorias[item.dataIndex];
                                    return nombresCategorias[categoria];
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Entreno + Cenas',
                            font: {
                                size: 16
                            },
                            // position: 'bottom',
                            padding: {
                                bottom: 30
                            }
                        }
                    }
                }
            });
        }
    }
</script>

<!-- Grafico barras Totales por categorías entrenos + ropa -->
<script>
    const grafica16 = document.querySelector('#regalos-grafica16');
    let graficaInstance16 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica16) {
        obtenerDatos16();

        async function obtenerDatos16() {
            const url16 = '/api/categorias-packs';
            const respuesta16 = await fetch(url16);
            const resultado16 = await respuesta16.json();

            console.log(resultado16); // Para verificar el JSON parseado

            // Encontrar el paquete con id "1"
            const ropa = resultado16.find(pack => pack.id === "3");

            if (!ropa) {
                console.error('No se encontró el paquete con id "3"');
                return;
            }

            // Definir las categorías y sus correspondientes valores
            const categorias = [
                'primera_div', 'aa_primera_div', 'segunda_div', 'aa_segunda_div',
                'primera_rfef', 'aa_primera_rfef', 'segunda_rfef', 'aa_segunda_rfef',
                'tercera', 'aa_tercera', 'division_honor', 'provinciales',
                'oficiales', 'auxiliares', 'futbol_base', 'rugby', 'retirado'
            ];
            const nombresCategorias = {
                'primera_div': 'Primera División',
                'aa_primera_div': 'AA Primera División',
                'segunda_div': 'Segunda División',
                'aa_segunda_div': 'AA Segunda División',
                'primera_rfef': 'Primera RFEF',
                'aa_primera_rfef': 'AA Primera RFEF',
                'segunda_rfef': 'Segunda RFEF',
                'aa_segunda_rfef': 'AA Segunda RFEF',
                'tercera': 'Tercera División',
                'aa_tercera': 'AA Tercera División',
                'division_honor': 'División de Honor',
                'provinciales': 'Provinciales',
                'oficiales': 'Oficiales',
                'auxiliares': 'Auxiliares',
                'futbol_base': 'Fútbol Base',
                'rugby': 'Rugby',
                'retirado': 'Retirado'
            };
            const coloresCategorias = {
                'primera_div': '#b8d8d8',
                'aa_primera_div': '#f0e1d2',
                'segunda_div': '#f7d9aa',
                'aa_segunda_div': '#c1baaf',
                'primera_rfef': '#a7c4bc',
                'aa_primera_rfef': '#f0efeb',
                'segunda_rfef': '#bfbfbf',
                'aa_segunda_rfef': '#c9ada7',
                'tercera': '#dfc3b6',
                'aa_tercera': '#b0c4b1',
                'division_honor': '#c9b6dd',
                'provinciales': '#c2d5cc',
                'oficiales': '#e8ccb9',
                'auxiliares': '#d4d4aa',
                'futbol_base': '#c3d6c1',
                'rugby': '#e3d2ca',
                'retirado': '#b6c4cb'
            };
            const valores = categorias.map(categoria => parseInt(ropa[categoria], 10));
            const colores = categorias.map(categoria => coloresCategorias[categoria]);

            // Crear la gráfica
            const ctx16 = document.getElementById('regalos-grafica16').getContext('2d');
            if (graficaInstance16) {
                graficaInstance16.destroy();
            }
            graficaInstance16 = new Chart(ctx16, {
                type: 'bar',
                data: {
                    labels: categorias, // Mantener las categorías para referencia interna
                    datasets: [{
                        label: 'Nº personas',
                        data: valores,
                        backgroundColor: colores
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Ocultar el eje x
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: (tooltipItems) => {
                                    // Retornar el nombre amigable de la categoría
                                    const item = tooltipItems[0];
                                    const categoria = categorias[item.dataIndex];
                                    return nombresCategorias[categoria];
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Entreno + Ropa',
                            font: {
                                size: 16
                            },
                            // position: 'bottom',
                            padding: {
                                bottom: 30
                            }
                        }
                    }
                }
            });
        }
    }
</script>

<!-- Grafico barras Totales por categorías completo -->
<script>
    const grafica15 = document.querySelector('#regalos-grafica15');
    let graficaInstance15 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica15) {
        obtenerDatos15();

        async function obtenerDatos15() {
            const url15 = '/api/categorias-packs';
            const respuesta15 = await fetch(url15);
            const resultado15 = await respuesta15.json();

            console.log(resultado15); // Para verificar el JSON parseado

            // Encontrar el paquete con id "1"
            const completo = resultado15.find(pack => pack.id === "4");

            if (!completo) {
                console.error('No se encontró el paquete con id "4"');
                return;
            }

            // Definir las categorías y sus correspondientes valores
            const categorias = [
                'primera_div', 'aa_primera_div', 'segunda_div', 'aa_segunda_div',
                'primera_rfef', 'aa_primera_rfef', 'segunda_rfef', 'aa_segunda_rfef',
                'tercera', 'aa_tercera', 'division_honor', 'provinciales',
                'oficiales', 'auxiliares', 'futbol_base', 'rugby', 'retirado'
            ];
            const nombresCategorias = {
                'primera_div': 'Primera División',
                'aa_primera_div': 'AA Primera División',
                'segunda_div': 'Segunda División',
                'aa_segunda_div': 'AA Segunda División',
                'primera_rfef': 'Primera RFEF',
                'aa_primera_rfef': 'AA Primera RFEF',
                'segunda_rfef': 'Segunda RFEF',
                'aa_segunda_rfef': 'AA Segunda RFEF',
                'tercera': 'Tercera División',
                'aa_tercera': 'AA Tercera División',
                'division_honor': 'División de Honor',
                'provinciales': 'Provinciales',
                'oficiales': 'Oficiales',
                'auxiliares': 'Auxiliares',
                'futbol_base': 'Fútbol Base',
                'rugby': 'Rugby',
                'retirado': 'Retirado'
            };
            const coloresCategorias = {
                'primera_div': '#b8d8d8',
                'aa_primera_div': '#f0e1d2',
                'segunda_div': '#f7d9aa',
                'aa_segunda_div': '#c1baaf',
                'primera_rfef': '#a7c4bc',
                'aa_primera_rfef': '#f0efeb',
                'segunda_rfef': '#bfbfbf',
                'aa_segunda_rfef': '#c9ada7',
                'tercera': '#dfc3b6',
                'aa_tercera': '#b0c4b1',
                'division_honor': '#c9b6dd',
                'provinciales': '#c2d5cc',
                'oficiales': '#e8ccb9',
                'auxiliares': '#d4d4aa',
                'futbol_base': '#c3d6c1',
                'rugby': '#e3d2ca',
                'retirado': '#b6c4cb'
            };
            const valores = categorias.map(categoria => parseInt(completo[categoria], 10));
            const colores = categorias.map(categoria => coloresCategorias[categoria]);

            // Crear la gráfica
            const ctx15 = document.getElementById('regalos-grafica15').getContext('2d');
            if (graficaInstance15) {
                graficaInstance15.destroy();
            }
            graficaInstance15 = new Chart(ctx15, {
                type: 'bar',
                data: {
                    labels: categorias, // Mantener las categorías para referencia interna
                    datasets: [{
                        label: 'Nº personas',
                        data: valores,
                        backgroundColor: colores
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Ocultar el eje x
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: (tooltipItems) => {
                                    // Retornar el nombre amigable de la categoría
                                    const item = tooltipItems[0];
                                    const categoria = categorias[item.dataIndex];
                                    return nombresCategorias[categoria];
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Completo',
                            font: {
                                size: 16
                            },
                            // position: 'bottom',
                            padding: {
                                bottom: 30
                            }
                        }
                    }
                }
            });
        }
    }
</script>

<!-- Grafico barras Totales por categorías completo -->
<script>
    const grafica14 = document.querySelector('#regalos-grafica14');
    let graficaInstance14 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica14) {
        obtenerDatos14();

        async function obtenerDatos14() {
            const url14 = '/api/categorias-packs';
            const respuesta14 = await fetch(url14);
            const resultado14 = await respuesta14.json();

            console.log(resultado14); // Para verificar el JSON parseado

            // Encontrar el paquete con id "1"
            const especial = resultado14.find(pack => pack.id === "5");

            if (!especial) {
                console.error('No se encontró el paquete con id "5"');
                return;
            }

            // Definir las categorías y sus correspondientes valores
            const categorias = [
                'primera_div', 'aa_primera_div', 'segunda_div', 'aa_segunda_div',
                'primera_rfef', 'aa_primera_rfef', 'segunda_rfef', 'aa_segunda_rfef',
                'tercera', 'aa_tercera', 'division_honor', 'provinciales',
                'oficiales', 'auxiliares', 'futbol_base', 'rugby', 'retirado'
            ];
            const nombresCategorias = {
                'primera_div': 'Primera División',
                'aa_primera_div': 'AA Primera División',
                'segunda_div': 'Segunda División',
                'aa_segunda_div': 'AA Segunda División',
                'primera_rfef': 'Primera RFEF',
                'aa_primera_rfef': 'AA Primera RFEF',
                'segunda_rfef': 'Segunda RFEF',
                'aa_segunda_rfef': 'AA Segunda RFEF',
                'tercera': 'Tercera División',
                'aa_tercera': 'AA Tercera División',
                'division_honor': 'División de Honor',
                'provinciales': 'Provinciales',
                'oficiales': 'Oficiales',
                'auxiliares': 'Auxiliares',
                'futbol_base': 'Fútbol Base',
                'rugby': 'Rugby',
                'retirado': 'Retirado'
            };
            const coloresCategorias = {
                'primera_div': '#b8d8d8',
                'aa_primera_div': '#f0e1d2',
                'segunda_div': '#f7d9aa',
                'aa_segunda_div': '#c1baaf',
                'primera_rfef': '#a7c4bc',
                'aa_primera_rfef': '#f0efeb',
                'segunda_rfef': '#bfbfbf',
                'aa_segunda_rfef': '#c9ada7',
                'tercera': '#dfc3b6',
                'aa_tercera': '#b0c4b1',
                'division_honor': '#c9b6dd',
                'provinciales': '#c2d5cc',
                'oficiales': '#e8ccb9',
                'auxiliares': '#d4d4aa',
                'futbol_base': '#c3d6c1',
                'rugby': '#e3d2ca',
                'retirado': '#b6c4cb'
            };
            const valores = categorias.map(categoria => parseInt(especial[categoria], 10));
            const colores = categorias.map(categoria => coloresCategorias[categoria]);

            // Crear la gráfica
            const ctx14 = document.getElementById('regalos-grafica14').getContext('2d');
            if (graficaInstance14) {
                graficaInstance14.destroy();
            }
            graficaInstance14 = new Chart(ctx14, {
                type: 'bar',
                data: {
                    labels: categorias, // Mantener las categorías para referencia interna
                    datasets: [{
                        label: 'Nº personas',
                        data: valores,
                        backgroundColor: colores
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: false // Ocultar el eje x
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: (tooltipItems) => {
                                    // Retornar el nombre amigable de la categoría
                                    const item = tooltipItems[0];
                                    const categoria = categorias[item.dataIndex];
                                    return nombresCategorias[categoria];
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Especial solo ropa',
                            font: {
                                size: 16
                            },
                            // position: 'bottom',
                            padding: {
                                bottom: 30
                            }
                        }
                    }
                }
            });
        }
    }
</script>


<!-- Cajas de Graficas 3.- Ingresos Por Packs Y Categorías -->
<!-- Grafico Doughnut -->
<script>
    const grafica2_1 = document.querySelector('#grafica1');
    let graficaInstance2_1 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica2_1) {
        obtenerDatos2_1();

        async function obtenerDatos2_1() {
            const url2_1 = '/api/ingresos-packs';
            const respuesta2_1 = await fetch(url2_1);
            const resultado2_1 = await respuesta2_1.json();

            console.log(resultado2_1); // Para verificar el JSON parseado

            // Transformar los datos en un formato adecuado para Chart.js
            const etiquetas = [
                'Solo entrenos',
                'Entrenos + cenas',
                'Entrenos + ropa',
                'Completo',
                'Especial solo ropa'
            ];

            const datos = [
                resultado2_1.Solo_entrenos,
                resultado2_1.Entrenos_cenas,
                resultado2_1.Entrenos_ropa,
                resultado2_1.Completo,
                resultado2_1.Especial_ropa
            ];

            const ctx2_1 = document.getElementById('grafica1').getContext('2d');
            if (graficaInstance2_1) {
                graficaInstance2_1.destroy();
            }
            graficaInstance2_1 = new Chart(ctx2_1, {
                type: 'doughnut', // Cambiar a 'doughnut'
                data: {
                    labels: etiquetas,
                    datasets: [{
                        label: 'Ingresos',
                        data: datos,
                        backgroundColor: [
                            '#f48d86 ',
                            '#95a8ae',
                            '#deb297',
                            '#407c9e',
                            '#f4ebda'
                        ]
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true // Los gráficos doughnut generalmente muestran leyendas
                        },
                        title: {
                            display: true,
                            text: 'Ingresos por packs',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            });
        }
    }
</script>

<!-- Grafico burbujas -->
<script>
    const grafica2_2 = document.querySelector('#grafica2');
    let graficaInstance2_2 = null; // Variable para almacenar la instancia de la gráfica

    if (grafica2_2) {
        obtenerDatos2_2();

        async function obtenerDatos2_2() {
            const url2_2 = '/api/ingresos-categorias';
            const respuesta2_2 = await fetch(url2_2);
            const resultado2_2 = await respuesta2_2.json();

            console.log(resultado2_2); // Para verificar el JSON parseado

            // Transformar los datos en un formato adecuado para un Bubble Chart
            const etiquetas = [
                'Primera división',
                'Asistente Primera división',
                'Segunda división',
                'Asistente Segunda división',
                'Primera RFEF',
                'Asistente Primera RFEF',
                'Segunda RFEF',
                'Asistente Segunda RFEF',
                'Tercera RFEF',
                'Asistente Tercera RFEF',
                'División de honor',
                'Provincial',
                'Oficial',
                'Auxiliar',
                'Fútbol base',
                'Rugby',
                'Retirado',
            ];

            const valores = [
                resultado2_2.Primera_división,
                resultado2_2.Asistente_Primera_división,
                resultado2_2.Segunda_división,
                resultado2_2.Asistente_Segunda_división,
                resultado2_2.Primera_RFEF,
                resultado2_2.Asistente_Primera_RFEF,
                resultado2_2.Segunda_RFEF,
                resultado2_2.Asistente_Segunda_RFEF,
                resultado2_2.Tercera_RFEF,
                resultado2_2.Asistente_Tercera_RFEF,
                resultado2_2.Division_honor,
                resultado2_2.Provincial,
                resultado2_2.Oficial,
                resultado2_2.Auxiliar,
                resultado2_2.Futbol_base,
                resultado2_2.Rugby,
                resultado2_2.Retirado
            ];

            // Normalizar los valores de los radios para que las burbujas sean más uniformes
            const maxValor = Math.max(...valores);
            const minValor = Math.min(...valores);
            const radios = valores.map(val => {
                return ((val - minValor) / (maxValor - minValor) * 15) + 5; // Ajustar esta fórmula según sea necesario
            });

            // Colores para las burbujas
            // const colores = [
            //     '#ea580c',
            //     '#84cc16',
            //     '#22d3ee',
            //     '#a855f7',
            //     '#ef4444',
            //     '#14b8a6',
            //     '#db2777',
            //     '#e11d48',
            //     '#7e22ce',
            //     '#ffcc00',
            //     '#cc6699',
            //     '#3399cc',
            //     '#66cc66',
            //     '#ff6666',
            //     '#999966',
            //     '#cc9933',
            //     '#3b82f6'
            // ];

            const colores = [
                '#b8d8d8', // Azul verdoso claro
                '#f0e1d2', // Beige claro
                '#f7d9aa', // Amarillo claro
                '#c1baaf', // Grisáceo
                '#a7c4bc', // Verde grisáceo claro
                '#f0efeb', // Marfil
                '#bfbfbf', // Gris claro
                '#c9ada7', // Rosado claro
                '#dfc3b6', // Beige rosado
                '#b0c4b1', // Verde grisáceo
                '#c9b6dd', // Lila pálido
                '#c2d5cc', // Verde azulado claro
                '#e8ccb9', // Melocotón claro
                '#d4d4aa', // Amarillo verdoso claro
                '#c3d6c1', // Verde claro
                '#e3d2ca', // Rosa palo
                '#b6c4cb', // Azul grisáceo claro
            ];

            const datos = valores.map((valor, index) => {
                return {
                    x: index + 1,
                    y: valor,
                    r: radios[index],
                    backgroundColor: colores[index]
                };
            });

            const ctx2_2 = document.getElementById('grafica2').getContext('2d');
            if (graficaInstance2_2) {
                graficaInstance2_2.destroy();
            }
            graficaInstance2_2 = new Chart(ctx2_2, {
                type: 'bubble',
                data: {
                    datasets: [{
                        label: 'Categorías',
                        data: datos,
                        backgroundColor: datos.map(d => d.backgroundColor),
                        borderColor: datos.map(d => d.backgroundColor),
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false // Los gráficos de burbujas generalmente muestran leyendas
                        },
                        title: {
                            display: true,
                            text: 'Ingresos por categorías',
                            font: {
                                size: 16,
                            },
                            // position: 'bottom',
                            padding: {
                                bottom: 50
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const labelIndex = context.dataIndex;
                                    return `${etiquetas[labelIndex]}: ${context.raw.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: false, // Ocultar los nombres de las categorías en el eje X
                            title: {
                                display: true,
                                text: 'Categorías'
                            },
                            ticks: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Ingresos'
                            }
                            // ticks: {
                            //     stepSize: 200 // Ajustamos el intervalo de los valores en el eje y a 200
                            // }
                        }
                    }
                }
            });
        }
    }
</script>