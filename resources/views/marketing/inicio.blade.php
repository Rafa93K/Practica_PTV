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
<nav class="bg-white shadow rounded-xl p-4 mb-6 flex gap-4 justify-center">       
    <a href="{{route('marketing.mostrarTarifas')}}" 
       class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        Crear Tarifas
    </a>
</nav>

<main class="flex-1 container mx-auto px-4 py-8 flex flex-col gap-8">

    <!-- GRAFICOS -->
    <div class="grid md:grid-cols-2 gap-8">

        <!-- Grafico de dinero -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold mb-4 text-center">
                Producción vs Inversión
            </h2>

            <canvas id="graficoFinanzas"></canvas>
        </div>

        <!-- Grafico tarifas -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold mb-4 text-center">
                Tarifas más contratadas
            </h2>

            <canvas id="graficoTarifas"></canvas>
        </div>

    </div>

</main>

@include('layouts.footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script><!--importar Grafico-->


</body>
</html>