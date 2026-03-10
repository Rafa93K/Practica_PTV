document.addEventListener('DOMContentLoaded', function() {
    //Configuracion del grafico de Incidencias
    const ctxIncidencias = document.getElementById('graficoIncidencias').getContext('2d');

    new Chart(ctxIncidencias, {
        type: 'pie',
        data: {
            labels: ['Abierto', 'En Proceso', 'Cerrado'],
            datasets: [{
                data: [ 
                    window.datosIncidencias.abierto, 
                    window.datosIncidencias.en_proceso, 
                    window.datosIncidencias.cerrado 
                ],
                backgroundColor: [
                    '#ef4444',
                    '#f59e0b',
                    '#10b981'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});