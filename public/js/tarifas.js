/**
 * @author Alonso Coronado Alcalde
 * @description Muestra o oculta la lista de productos de una tarifa al hacer clic.
 */
function toggleTarifaDetalles(tarifaId) {
    let detalles = document.getElementById('detalles-' + tarifaId);
    if (detalles) {
        if (detalles.classList.contains('hidden')) {
            detalles.classList.remove('hidden');
        } else {
            detalles.classList.add('hidden');
        }
    }
}

/**
 * @author Alonso Coronado Alcalde
 * @description Envía el formulario de creación por AJAX.
 */
function guardarTarifaAjax(formulario) {
    let formData = new FormData(formulario);

    fetch('/tarifas', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest', //Indica a Laravel que es AJAX
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload(); //Recargamos la pagina para que se muestre la nueva tarifa
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => alert("La tarifa ya existe o hay un error en los datos."));
}

/**
 * @author Alonso Coronado Alcalde
 * @description Elimina la tarifa mediante AJAX y la borra visualmente sin recargar.
 */
function eliminarTarifaAjax(id, url) {
    if (!confirm('¿Estás seguro de eliminar esta tarifa?')) return;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //Borramos la tarjeta del HTML con un efecto suave
            let tarjeta = document.getElementById('tarifa-' + id);
            if (tarjeta) {
                tarjeta.style.transition = "all 0.5s";
                tarjeta.style.opacity = "0";
                tarjeta.style.transform = "scale(0.9)";
                setTimeout(() => tarjeta.remove(), 500);
            }
        }
    })
    .catch(error => alert("No se pudo eliminar la tarifa."));
}

/**
 * @author Alonso Coronado Alcalde
 * @description Añade un nuevo desplegable de productos cuando seleccionas uno en el anterior.
 */
function verificarNuevosSelects(selectActual) {
    let contenedor = document.getElementById('productos-container');
    let listaSelects = document.getElementsByClassName('producto-select');
    let ultimoSelect = listaSelects[listaSelects.length - 1];

    if (selectActual == ultimoSelect && selectActual.value != "") {
        let nuevoSelect = ultimoSelect.cloneNode(true);
        nuevoSelect.value = ""; 
        contenedor.appendChild(nuevoSelect);
    }
    bloquearProductosRepetidos();
}

/**
 * @author Alonso Coronado Alcalde
 * @description Recorre todos los desplegables y desactiva los productos que ya se han elegido.
 */
function bloquearProductosRepetidos() {
    let todosLosSelects = document.getElementsByClassName('producto-select');
    
    for (let i = 0; i < todosLosSelects.length; i++) {
        let opciones = todosLosSelects[i].options;
        for (let j = 0; j < opciones.length; j++) {
            opciones[j].disabled = false;
        }
    }

    for (let i = 0; i < todosLosSelects.length; i++) {
        let valorElegido = todosLosSelects[i].value;
        if (valorElegido != "") {
            for (let k = 0; k < todosLosSelects.length; k++) {
                if (i != k) {
                    let opcionesADesactivar = todosLosSelects[k].options;
                    for (let m = 0; m < opcionesADesactivar.length; m++) {
                        if (opcionesADesactivar[m].value == valorElegido) {
                            opcionesADesactivar[m].disabled = true;
                        }
                    }
                }
            }
        }
    }
}
