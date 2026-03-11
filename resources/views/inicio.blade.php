<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Telcomanager</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="{{ asset('css/inicio.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex flex-col min-h-screen">
        @include('layouts.header') <!-- HEADER -->

        <main class="flex-1">   

            <!-- SLIDESHOW DE TARIFAS -->
            <section class="max-w-7xl mx-auto px-4 py-24">
                <div class="text-center mb-16">
                    <h3 class="text-xs font-black text-blue-500 uppercase tracking-[0.4em] mb-4">Catálogo de Servicios</h3>
                    <h2 class="text-4xl md:text-5xl font-black text-blue-900">Planes diseñados para ti</h2>
                </div>
                
                <div class="relative group">
                    <!-- Clipping mask para el slideshow -->
                    <div class="overflow-hidden rounded-[2.5rem]">
                        <div id="slideshow-container" class="flex transition-transform duration-1000 cubic-bezier(0.4, 0, 0.2, 1)">
                            <!-- Bucle para mostrar las tarifas -->
                            @forelse($tarifas as $tarifa)
                                <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                                    <div class="bg-white rounded-[2rem] p-10 shadow-2xl shadow-gray-200/40 border border-gray-50 hover:border-blue-100 transition-all duration-500 flex flex-col h-full group/card">
                                        <div class="flex justify-between items-start mb-8">
                                            <div class="p-4 bg-blue-50 rounded-2xl group-hover/card:bg-blue-600 group-hover/card:text-white transition-colors duration-500">
                                                <!-- Icono segun el tipo de tarifa -->
                                                @if($tarifa->tipo == 'internet') <!-- Internet -->
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                                @elseif($tarifa->tipo == 'movil') <!-- Movil -->
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                @else <!-- TV -->
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>

                                            <!-- Precio de la tarifa -->
                                            <div class="text-right">
                                                <span class="block text-4xl font-black text-blue-900">{{ number_format($tarifa->precio, 0) }}<span class="text-xl">.{{ explode('.', number_format($tarifa->precio, 2))[1] }}€</span></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Nombre y descripcion de la tarifa -->
                                        <h4 class="text-2xl font-black text-gray-800 mb-4 line-clamp-1 group-hover/card:text-blue-600 transition-colors">{{ $tarifa->nombre }}</h4>
                                        <p class="text-gray-500 text-sm leading-relaxed mb-10 flex-1 line-clamp-3">{{ $tarifa->descripcion }}</p>
                                        
                                        <!-- Boton que lleva al login del panel cliente -->
                                        <a href="{{ route('cliente.contratarDirecta.show', $tarifa->id) }}" class="w-full inline-flex items-center justify-center px-8 py-5 font-bold text-white transition-all duration-300 bg-gray-900 rounded-2xl hover:bg-blue-600 hover:shadow-xl hover:shadow-blue-200">
                                            Empezar ahora
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/></svg>
                                        </a>
                                    </div>
                                </div>
                            @empty <!-- En caso de que no haya tarifas -->
                                <div class="w-full text-center py-24 bg-white rounded-[2.5rem] border-2 border-dashed border-gray-100">
                                    <p class="text-gray-400 font-bold text-xl uppercase tracking-widest">Próximamente nuevas tarifas</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Indicadores (Dots) -->
                    <div id="slideshow-dots" class="flex justify-center gap-3 mt-12"></div>
                </div>
            </section>
            <!-- HERO SECTION -->
            <section class="min-h-[60vh] flex items-center justify-center bg-gradient-to-b from-blue-50 to-gray-100 border-b border-gray-200">
                <div class="text-center max-w-4xl px-6 py-20 animate-fade-in">
                    <h1 class="text-5xl md:text-7xl font-black text-blue-900 mb-8 tracking-tighter leading-tight">
                        Conectamos tu <span class="text-blue-600">mundo</span> con velocidad real
                    </h1>

                    <p class="text-gray-600 text-xl md:text-2xl mb-12 leading-relaxed max-w-2xl mx-auto">
                        Gestiona todos tus servicios desde una sola plataforma. Fibra, móvil y TV con la máxima transparencia.
                    </p>

                    <!-- BOTONES -->
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <a href="{{ route('login', 'cliente') }}"
                        class="group relative bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-5 rounded-2xl shadow-2xl shadow-blue-200 transition-all hover:-translate-y-1">
                            Acceso Clientes
                            <span class="absolute top-0 right-0 -mr-2 -mt-2 flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-blue-500"></span>
                            </span>
                        </a>

                        <a href="{{ route('login', 'trabajador') }}"
                        class="bg-white hover:bg-gray-50 text-blue-900 font-bold px-10 py-5 rounded-2xl shadow-xl border border-gray-200 transition-all hover:-translate-y-1">
                            Portal Empleados
                        </a>
                    </div>
                </div>
            </section>
        </main>

        @include('layouts.footer') <!-- FOOTER -->

        <script src="{{ asset('js/tarifasSlideshow.js') }}"></script>
    </body>
</html>