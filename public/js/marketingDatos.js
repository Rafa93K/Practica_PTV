document.addEventListener("DOMContentLoaded", function () {

    // GRAFICO FINANZAS
    const finanzas = document.getElementById('graficoFinanzas');

    if (finanzas) {
        new Chart(finanzas, {
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
    }


    // GRAFICO TARIFAS MAS CONTRATADAS
    const tarifas = document.getElementById('graficoTarifas');

    if (tarifas) {
        new Chart(tarifas, {
            type: 'bar',
            data: {
                labels: datosTarifas.labels,
                datasets: [{
                    label: 'Contratos',
                    data: datosTarifas.data,
                    backgroundColor: '#6366f1'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

});