/**
 * @author Alonso Coronado Alcalde
 * @description Muestra o oculta la lista de productos de una tarifa al hacer clic.
 */
function toggleTarifaDetalles(tarifaId) {
    //Buscamos el div que contiene los productos de esa tarifa
    let detalles = document.getElementById('detalles-' + tarifaId);
    
    if (detalles) {
        //Si el div está oculto, lo mostramos. Si está a la vista, lo ocultamos.
        if (detalles.classList.contains('hidden')) {
            detalles.classList.remove('hidden');
        } else {
            detalles.classList.add('hidden');
        }
    }
}

/**
 * @author Alonso Coronado Alcalde
 * @description Añade un nuevo desplegable de productos cuando seleccionas uno en el anterior.
 */
function verificarNuevosSelects(selectActual) {
    let contenedor = document.getElementById('productos-container');
    let listaSelects = document.getElementsByClassName('producto-select');
    
    //Cogemos el ultimo desplegable que hay en la lista
    let ultimoSelect = listaSelects[listaSelects.length - 1];

    //Si el desplegable que acabamos de cambiar es el ultimo y no esta vacio
    if (selectActual == ultimoSelect && selectActual.value != "") {
        //Creamos una copia del desplegable
        let nuevoSelect = ultimoSelect.cloneNode(true);
        //Lo ponemos en blanco para que el usuario elija otro producto
        nuevoSelect.value = ""; 
        
        //Lo añadimos al formulario
        contenedor.appendChild(nuevoSelect);
    }
    
    //Llamamos a la funcion para que no se puedan repetir productos
    bloquearProductosRepetidos();
}

/**
 * @author Alonso Coronado Alcalde
 * @description Recorre todos los desplegables y desactiva los productos que ya se han elegido.
 */
function bloquearProductosRepetidos() {
    let todosLosSelects = document.getElementsByClassName('producto-select');
    
    //Primero activamos todas las opciones en todos los desplegables para limpiar
    for (let i = 0; i < todosLosSelects.length; i++) {
        let opciones = todosLosSelects[i].options;
        for (let j = 0; j < opciones.length; j++) {
            opciones[j].disabled = false;
        }
    }

    //Miramos que producto hay elegido en cada desplegable
    for (let i = 0; i < todosLosSelects.length; i++) {
        let valorElegido = todosLosSelects[i].value;
        
        //Si hay un producto seleccionado
        if (valorElegido != "") {
            //Buscamos ese producto en los demas desplegables para desactivarlo
            for (let k = 0; k < todosLosSelects.length; k++) {
                //No lo desactivamos en el desplegable donde lo acabamos de elegir
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
