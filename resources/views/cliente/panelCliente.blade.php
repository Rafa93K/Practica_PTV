<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel de Cliente</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 flex flex-col min-h-screen">
        @include('layouts.header') {{-- Importacion del componente header --}}

        <main class="flex-1 container mx-auto px-4 py-8">
            <header class="mb-8">
                <h2 class="text-3xl font-extrabold text-blue-900">Bienvenido de nuevo, {{ $cliente->nombre }}</h2> {{-- Leemos el nombre del cliente que ha iniciado sesion --}}
            </header>

            {{-- Mensajes de éxito --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-700 font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- PERFIL Y DATOS -->
                <div class="flex-1 flex flex-col gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-bold">
                                {{ substr($cliente->nombre, 0, 1) }} {{-- Coje la primera letra del nombre y se crea una foto de perfil --}}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Mi Perfil</h3>
                                <p class="text-sm text-gray-500">Información personal</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nombre Completo</span>
                                <span class="text-gray-700 font-medium">{{ $cliente->nombre }} {{ $cliente->apellido }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">DNI</span>
                                <span class="text-gray-700 font-medium">{{ $cliente->dni }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Correo Electrónico</span>
                                <span class="text-gray-700 font-medium">{{ $cliente->email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Teléfono de contacto</span>
                                <span class="text-gray-700 font-medium">{{ $cliente->telefono }}</span>
                            </div>
                        </div>

                        <a href="{{ route('cliente.editar') }}" class="mt-8 w-full py-3 bg-blue-50 text-blue-600 font-semibold rounded-xl hover:bg-blue-100 transition-colors block text-center">
                            Editar Perfil
                        </a>
                    </div>
                </div>

                <!-- SERVICIOS Y CONTRATOS -->
                <div class="flex-1 flex flex-col gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            Tus Servicios Activos
                        </h3>

                        <div class="space-y-4 overflow-y-scroll h-[320px] pr-2"> {{-- Aumentado un poco el alto para el menu --}}
                            {{-- Cojemos las facturas que tiene el cliente a través de sus contratos activos --}}
                            @forelse($cliente->contratos as $contrato)
                                @foreach($contrato->tarifas as $tarifa)
                                    <div class="relative group">
                                        <div 
                                            onclick="toggleServiceMenu('menu-{{ $contrato->id }}-{{ $tarifa->id }}')" 
                                            class="p-4 bg-green-50 rounded-xl border border-green-100 flex justify-between items-center cursor-pointer hover:bg-green-100 transition-all hover:shadow-sm"
                                        >
                                            <div>
                                                <h4 class="font-bold text-green-900 text-sm">{{ $tarifa->nombre }}</h4>
                                                <p class="text-xs text-green-700 italic">{{ $tarifa->tipo }}</p>
                                            </div>
                                            <div class="text-right flex items-center gap-3">
                                                <div>
                                                    <span class="text-xl font-bold text-green-900">{{ number_format($tarifa->precio, 2) }}€<span class="text-xs">/mes</span></span>
                                                    @if(!$contrato->aprobado)
                                                        <p class="text-[10px] text-orange-600 font-bold uppercase">Pendiente</p>
                                                    @endif
                                                </div>
                                                <svg class="w-4 h-4 text-green-600 transform group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Menu Desplegable --}}
                                        <div id="menu-{{ $contrato->id }}-{{ $tarifa->id }}" class="hidden absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden animate-fade-in-up">
                                            <div class="flex flex-col">
                                                <a href="{{ route('cliente.cambiarServicio', [$tarifa->id, $contrato->id]) }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                                    Cambiar servicio
                                                </a>
                                                <form action="{{ route('cliente.cancelarServicio', [$contrato->id, $tarifa->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar este servicio? Esta acción no se puede deshacer.')">
                                                    @csrf
                                                    @method('DELETE') {{-- Metodo para borrar el servicio --}}
                                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                        Cancelar servicio
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- En caso de no tener ningun servicio todavía --}}
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-400">No tienes servicios contratados todavía.</p>
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('cliente.tarifas') }}" class="mt-8 block text-center py-3 border-2 border-dashed border-gray-200 text-gray-400 font-medium rounded-xl hover:border-blue-300 hover:text-blue-500 transition-all">
                            + Contratar nuevo servicio
                        </a>
                    </div>
                </div>

                <!-- FACTURACIÓN E INCIDENCIAS -->
                <div class="flex-1 flex flex-col gap-6">
                    <!-- Facturación -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            Últimas Facturas
                        </h3>
                        
                        <div class="divide-y divide-gray-50 overflow-y-scroll h-[150px]">
                            {{-- Por cada factura que tenga el cliente lo vamos mostrando, estando ordenadas en orden descendiente --}}
                            @forelse($cliente->facturas->sortByDesc('fecha_inicio') as $factura)
                                <div class="py-3 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">{{ \Carbon\Carbon::parse($factura->fecha_inicio)->translatedFormat('F Y') }}</span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-bold text-gray-800">{{ number_format($factura->precio, 2) }} €</span>

                                        {{-- Botón de descargar --}}
                                        <a href="{{ route('cliente.generarFactura', $factura->id) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                            {{-- Icono del botón de descargar --}}
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                {{-- En caso de no tener ninguna factura --}}
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-400 text-sm">No tienes facturas disponibles.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Incidencias -->
                    <div class="bg-blue-900 rounded-2xl shadow-lg p-6 text-white">
                        <h3 class="text-xl font-bold mb-4">¿Algún problema?</h3>
                        <p class="text-blue-200 text-sm mb-6">Si tienes alguna duda o incidencia con tus servicios, nuestro equipo técnico está disponible 24/7.</p>
                        
                        {{-- Botón para abrir el formulario de incidencias --}}
                        <a href="{{ route('cliente.incidencia.create') }}" class="w-full py-3 bg-white text-blue-900 font-bold rounded-xl shadow-lg hover:bg-gray-100 transition-all flex items-center justify-center gap-2">
                            {{-- Icono del botón de crear incidencias --}}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Abrir Ticket Soporte
                        </a>

                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer') {{-- Importacion del componente footer --}}

        <script>
            function toggleServiceMenu(id) {
                const menu = document.getElementById(id);
                const allMenus = document.querySelectorAll('[id^="menu-"]');
                
                // Cerrar otros menús abiertos
                allMenus.forEach(m => {
                    if (m.id !== id) m.classList.add('hidden');
                });
                
                // Alternar el menú actual
                menu.classList.toggle('hidden');
            }

            // Cerrar menú si se hace clic fuera
            document.addEventListener('click', function(event) {
                const isClickInside = event.target.closest('.relative.group');
                if (!isClickInside) {
                    const allMenus = document.querySelectorAll('[id^="menu-"]');
                    allMenus.forEach(m => m.classList.add('hidden'));
                }
            });
        </script>

        <style>
            .animate-fade-in-up {
                animation: fadeInUp 0.3s ease-out;
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </body>
</html>