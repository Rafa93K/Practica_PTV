<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Telcomanager</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-blue-900 text-white shadow-lg">
        <div class="container mx-auto px-6 py-5 flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-wide">
                Telcomanager
            </h1>
            <span class="text-sm opacity-80">
                Soluciones de Gestión Empresarial
            </span>
            
        </div>
    </header>

        <!-- HERO SECTION -->
        <main class="flex-1 flex items-center justify-center">
            <div class="text-center max-w-3xl px-6">
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-6">
                    Bienvenido a Telcomanager
                </h2>

                <p class="text-gray-600 text-lg mb-10">
                    Plataforma interna de gestión de clientes, trabajadores, contratos, facturación e incidencias.
                </p>

                <!-- BOTONES -->
                <div class="flex flex-col md:flex-row justify-center gap-6">
                    
                    {{-- Al pulsar el boton le pasamos a la vista login que eres un cliente --}}
                    <a href="{{ route('login', 'cliente') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-4 rounded-lg shadow-lg transition transform hover:scale-105">
                        Área Cliente
                    </a>

                <a href="#"
                   class="bg-blue-800 hover:bg-blue-900 text-white font-semibold px-8 py-4 rounded-lg shadow-lg transition transform hover:scale-105">
                    Área Trabajador
                </a>

            </div>

        </div>
    </main>
    <!-- FOOTER llamo aqui al footer de la carperta layouts-->
    @include('layouts.footer')
</body>
</html>