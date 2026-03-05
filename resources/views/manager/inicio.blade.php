<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel del Manager</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 flex flex-col min-h-screen">
        <!-- HEADER -->
        @include('layouts.header')
        <!-- NAV DEL MANAGER -->
        <nav class="bg-white shadow rounded-xl p-4 mb-6 flex gap-4 justify-center">
            <a href="{{route('manager.crearTrabajador')}}" 
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-blue-900  transition">
            Crear Usuarios
            </a>
            <a href="#" 
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition">
            Crear Productos
            </a>
            <a href="#" 
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-blue-900  transition">
            Crear Tarifas
            </a>
        </nav>
        <!-- Notificacion temporal confirmación de creacion-->
        <!-- Notificación temporal -->
        @if(session('successTC'))
            <div id="flash-message" class="mb-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg text-center">
                {{ session('successTC') }}
            </div>

            <script>
                // Desaparece después de 3 segundos
                setTimeout(() => {
                    const msg = document.getElementById('flash-message');
                    if(msg) msg.style.display = 'none';
                }, 3000);
            </script>
        @endif
        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 container mx-auto px-4 py-8">
           <div>
            Número Total de Contratos <br>
            Número total de Incidencias<br>
            Cantidad Producida € (sólo la suma de la factura de los contratos)<br>
            Cantidad Invertida € (suma el precio del material usado para el contrato o para una incidencia)<br>
            Beneficio total (Resta de lo Producido y lo Invertido)<br>
            Puede filtrar los datos por fechas<br>
           </div>

        </main>

        <!-- FOOTER -->
        @include('layouts.footer')
    </body>
</html>