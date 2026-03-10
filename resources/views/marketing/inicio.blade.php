<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Marketing</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

@include('layouts.header')

<!-- NAV DEL MARKETING -->
<nav class="w-full mb-6">
    <div class="bg-white shadow-sm border-b border-gray-100 p-4 px-8 flex items-center justify-between">
        <!-- Botón de acción -->
        <a href="{{route('marketing.mostrarTarifas')}}" 
           class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-sm hover:shadow-md font-semibold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Crear Tarifas
        </a>

        <!-- Estadísticas al extremo derecho -->
        <div class="flex items-center gap-3">
            <div class="hidden sm:block text-right pr-4 border-r border-gray-100">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Global</p>
                <p class="text-xs text-gray-500 font-medium">Contratos activos</p>
            </div>
            <div class="bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-xl flex items-center gap-2">
                <div class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                <span class="text-xl font-bold text-indigo-700">{{ $totalContratos }}</span>
                <span class="text-xs font-bold text-indigo-400 uppercase hidden md:inline">Registrados</span>
            </div>
        </div>
    </div>
</nav>

<main class="flex-1 container mx-auto px-4 py-8 flex flex-col gap-8">

    <!-- GRAFICOS -->
    <div class="grid md:grid-cols-2 gap-8">

        <!-- Grafico de dinero -->
        <div class="bg-white p-6 rounded-xl shadow ">
            <h2 class="text-lg font-bold mb-4 text-center">
                Producción vs Inversión
            </h2>

            <div class="h-72">
                <canvas id="graficoFinanzas"></canvas>
            </div>
        </div>

        <!-- Grafico tarifas -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold mb-4 text-center">
                Tarifas más contratadas
            </h2>

            @if($topTarifa)
                <div class="mb-4 p-3 bg-indigo-50 border border-indigo-100 rounded-lg text-center">
                    <p class="text-sm text-indigo-700 font-medium">Líder indiscutible:</p>
                    <p class="text-xl font-bold text-indigo-900">{{ $topTarifa->nombre }}</p>
                    <p class="text-indigo-600 font-semibold">{{ $topTarifa->total }} contrataciones</p>
                </div>
            @endif

            <div class="h-72">
                <canvas id="graficoTarifas"></canvas>
            </div>
        </div>

    </div>

</main>

    @include('layouts.footer')

    <script>
        //Pasar datos de PHP a JS para los gráficos
        const datosFinanzas = {
            producido: {{ $producido }},
            invertido: {{ $invertido }},
            beneficio: {{ $beneficio }}
        };

        const datosTarifas = {
            labels: {!! json_encode($tarifasLabels) !!},
            data: {!! json_encode($tarifasData) !!}
        };
    </script>
    <script src="{{ asset('js/marketingDatos.js') }}"></script>


</body>
</html>