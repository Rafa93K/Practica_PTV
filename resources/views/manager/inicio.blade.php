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
            class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700  transition">
            Crear Usuarios
            </a>
            <a href="{{route('mostrarProducto')}}" 
            class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Crear Productos
            </a>
            <a href="{{route('mostrarTarifas')}}" 
            class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700  transition">
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

        <!-- FILTROS POR FECHA -->
        <section class="container mx-auto px-4 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <form action="{{ route('manager.inicio') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $fechaInicio }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $fechaFin }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                            Filtrar
                        </button>
                        <a href="{{ route('manager.inicio') }}" class="ml-2 text-gray-500 hover:text-indigo-600 text-sm">Limpiar</a>
                    </div>
                </form>
            </div>
        </section>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Contratos -->
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
                    <p class="text-gray-500 text-sm">Número Total de Contratos</p>
                    <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                        {{ $totalContratos }}
                    </h2>
                </div>

                <!-- Incidencias -->
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
                    <p class="text-gray-500 text-sm">Número Total de Incidencias</p>
                    <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                        @if($totalIncidencias == 0)
                            <p class="text-gray-400 font-medium">{{ $totalIncidencias }}</p>
                        @else
                            <p class="text-3xl font-bold text-indigo-600">{{ $totalIncidencias }}</p>
                        @endif
                    </h2>
                </div>

                <!-- Producido -->
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
                    <p class="text-gray-500 text-sm">Cantidad Producida</p>
                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ number_format($producido,2) }} €
                    </h2>
                </div>

                <!-- Invertido -->
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
                    <p class="text-gray-500 text-sm">Cantidad Invertida</p>
                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        {{ number_format($invertido,2) }} €
                    </h2>
                </div>

                <!-- Beneficio -->
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
                    <p class="text-gray-500 text-sm">Beneficio Total</p>
                    <h2 class="text-3xl font-bold text-indigo-700 mt-2">
                        {{ number_format($beneficio,2) }} €
                    </h2>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!--Grafico Indicencias-->                        
                <div class="bg-white rounded-xl shadow-md p-6 mt-8 max-w-md mx-auto">
                    <h2 class="text-lg font-bold mb-4 text-center">Resumen Incidencias</h2>
                    <canvas id="graficoIncidencias"></canvas>
                </div>
                <!-- Gráfico con datos Economicos -->
                <div class="bg-white rounded-xl shadow-md p-6 mt-8 max-w-md mx-auto">
                    <h2 class="text-lg font-bold mb-4 text-center">Resumen económico</h2>
                    <canvas id="graficoFinanzas"></canvas>
                </div>
            </div>
        </main>
        <!-- FOOTER -->
        @include('layouts.footer')
        <script>
            const datosIncidencias = {
                abierto: {{ $abierto }},
                en_proceso: {{ $en_proceso }},
                cerrado: {{ $cerrado }}
            };

            const datosFinanzas = {
                producido: {{ $producido }},
                invertido: {{ $invertido }},
                beneficio: {{ $beneficio }}
            };
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script><!--importar Grafico-->
        <script src="{{ asset('js/managerDatos.js') }}"></script>
    </body>
</html>