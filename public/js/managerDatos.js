document.addEventListener("DOMContentLoaded", function () {

    // GRAFICO INCIDENCIAS
    const inc = document.getElementById('graficoIncidencias');

    new Chart(inc, {
        type: 'pie',
        data: {
            labels: ['Abiertas', 'En Proceso', 'Cerradas'],
            datasets: [{
                data: [
                    datosIncidencias.pendiente,
                    datosIncidencias.en_proceso,
                    datosIncidencias.cerrado
                ],
                backgroundColor: [
                    '#FF8A14',
                    '#F0FA19',
                    '#76FF14'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // GRAFICO FINANZAS
    const ctx = document.getElementById('graficoFinanzas');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Producido', 'Invertido', 'Beneficio'],
            datasets: [{
                data: [
                    datosFinanzas.producido,
                    datosFinanzas.invertido,
                    datosFinanzas.beneficio
                ],
                backgroundColor: [
                    '#22c55e',
                    '#ef4444',
                    '#3b82f6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});