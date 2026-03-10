document.addEventListener('DOMContentLoaded', function() {
    //Cogemos el contenedor de las tarifas y los puntos
    const container = document.getElementById('slideshow-container');
    const dotsContainer = document.getElementById('slideshow-dots');
    
    //Si no hay contenedor o puntos, no se ejecuta el slideshow
    if (!container || !dotsContainer) return;
    
    //Cogemos todas las tarifas
    const slides = container.children;
    const totalSlides = slides.length;
    
    //Si no hay tarifas, no se ejecuta el slideshow
    if (totalSlides === 0) return;

    let currentIndex = 0;
    let itemsPerView = window.innerWidth >= 768 ? 3 : 1;

    function createDots() {
        dotsContainer.innerHTML = ''; //Vaciamos el contenedor
        const totalDots = Math.max(0, totalSlides - itemsPerView + 1); //Calculamos el número de puntos
        
        //Creamos los puntos
        for (let i = 0; i < (window.innerWidth >= 768 ? Math.ceil(totalSlides / 3) : totalSlides); i++) {
            const dot = document.createElement('button');
            dot.className = `w-2 h-2 rounded-full transition-all duration-300 ${i === 0 ? 'bg-blue-600 w-6' : 'bg-gray-300 hover:bg-gray-400'}`;
            dot.addEventListener('click', () => {
                currentIndex = i;
                updateSlideshow();
                resetInterval();
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateSlideshow() {
        itemsPerView = window.innerWidth >= 768 ? 3 : 1; //Si el ancho es mayor o igual a 768, se muestran 3 tarifas, si no, 1
        const totalGroups = window.innerWidth >= 768 ? Math.ceil(totalSlides / 3) : totalSlides; //Calculamos el número de grupos
        
        if (currentIndex >= totalGroups) currentIndex = 0; //Si el índice es mayor o igual al número de grupos, se reinicia

        const offset = currentIndex * 100; //Calculamos el desplazamiento
        container.style.transform = `translateX(-${offset}%)`;
        
        //Actualizar puntos
        const dots = dotsContainer.children;
        Array.from(dots).forEach((dot, idx) => {
            if (idx === currentIndex) { //Si el índice es igual al índice actual
                dot.classList.add('bg-blue-600', 'w-6'); //Añadimos la clase bg-blue-600 y w-6
                dot.classList.remove('bg-gray-300', 'hover:bg-gray-400'); //Removemos la clase bg-gray-300 y hover:bg-gray-400
            } else { //Si el índice no es igual al índice actual
                dot.classList.remove('bg-blue-600', 'w-6'); //Removemos la clase bg-blue-600 y w-6
                dot.classList.add('bg-gray-300', 'hover:bg-gray-400'); //Añadimos la clase bg-gray-300 y hover:bg-gray-400
            }
        });
    }

    function nextSlide() {
        const totalGroups = window.innerWidth >= 768 ? Math.ceil(totalSlides / 3) : totalSlides; //Calculamos el número de grupos
        currentIndex = (currentIndex + 1) % totalGroups; //Si el índice es mayor o igual al número de grupos, se reinicia
        updateSlideshow(); //Actualizamos el slideshow
    }

    let interval = setInterval(nextSlide, 5000); //Reiniciamos el intervalo cada 5 segundos

    function resetInterval() { //Reiniciamos el intervalo
        clearInterval(interval); //Limpiamos el intervalo
        interval = setInterval(nextSlide, 5000); //Reiniciamos el intervalo
    }

    window.addEventListener('resize', () => { //Reiniciamos el intervalo cada vez que se redimensiona la ventana
        createDots(); //Creamos los puntos
        updateSlideshow(); //Actualizamos el slideshow
    });

    createDots(); //Creamos los puntos
    updateSlideshow(); //Actualizamos el slideshow
});
