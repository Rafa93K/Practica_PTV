/**
 * @author Alonso Coronado Alcalde
 * @description Muestra/oculta los productos asignados a una tarifa al pulsar su tarjeta.
 */
function toggleTarifaDetalles(tarifaId) {
    const detalles = document.getElementById(`detalles-${tarifaId}`);
    if (detalles) {
        detalles.classList.toggle('hidden');
    }
}

/**
 * @author Alonso Coronado Alcalde
 * @description Gestiona la creación dinámica de selects de productos. 
 * Si seleccionas uno, aparece otro para elegir más, evitando duplicados.
 */
function verificarNuevosSelects(selectActual) {
    const container = document.getElementById('productos-container');
    if (!container) return; //Seguridad

    const selects = container.querySelectorAll('.producto-select');
    const ultimoSelect = selects[selects.length - 1];

    //Si se ha seleccionado algo en el último select, creamos uno nuevo
    if (selectActual === ultimoSelect && selectActual.value !== "") {
        const nuevoDiv = document.createElement('div');
        nuevoDiv.className = 'flex gap-2';
        
        const nuevoSelect = selectActual.cloneNode(true);
        nuevoSelect.value = ""; // Reiniciar valor
        
        // Deshabilitar las opciones ya seleccionadas
        const seleccionados = Array.from(selects).map(s => s.value);
        
        const options = nuevoSelect.querySelectorAll('option');
        options.forEach(opt => {
            if (seleccionados.includes(opt.value) && opt.value !== "") {
                opt.disabled = true;
            } else {
                opt.disabled = false;
            }
        });

        nuevoDiv.appendChild(nuevoSelect);
        container.appendChild(nuevoDiv);
    }
    
    //Actualizamos las opciones de todos los selects para evitar duplicados
    actualizarOpcionesDisponibles();
}

/**
 * @author Alonso Coronado Alcalde
 * @description Deshabilita en todos los selects las opciones que ya han sido seleccionadas en otros.
 */
function actualizarOpcionesDisponibles() {
    const selects = document.querySelectorAll('.producto-select');
    const seleccionados = Array.from(selects).map(s => s.value).filter(v => v !== "");

    selects.forEach(select => {
        const options = select.querySelectorAll('option');
        options.forEach(opt => {
            if (opt.value !== "" && opt.value !== select.value && seleccionados.includes(opt.value)) {
                opt.disabled = true;
            } else {
                opt.disabled = false;
            }
        });
    });
}
