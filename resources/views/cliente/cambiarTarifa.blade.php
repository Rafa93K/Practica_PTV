<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cambiar Servicio</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 flex flex-col min-h-screen">
        @include('layouts.header') {{-- Importacion del componente header --}}

        <main class="flex-1 container mx-auto px-4 py-8">
            <header class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-blue-900 border-b-4 border-blue-600 inline-block pb-1">Cambiar Plan: {{ $tarifaActual->tipo }}</h2>
                    <p class="text-gray-500 mt-2">Selecciona la nueva tarifa que deseas aplicar a tu contrato actual</p>
                </div>
                {{-- Boton para volver al panel --}}
                <a href="{{ route('cliente.inicio') }}" class="flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Panel
                </a>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Recorremos las tarifas disponibles --}}
                @forelse($tarifas as $tarifa)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col transition-all hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6 bg-blue-900 text-white">
                            {{-- Tipo y nombre de la tarifa --}}
                            <span class="text-xs font-bold uppercase tracking-widest text-blue-300">{{ $tarifa->tipo }}</span>
                            <h3 class="text-2xl font-bold mt-1">{{ $tarifa->nombre }}</h3>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            {{-- Precio de la tarifa --}}
                            <div class="mb-6">
                                <span class="text-4xl font-extrabold text-gray-900">{{ number_format($tarifa->precio, 2) }}€</span>
                                <span class="text-gray-500">/mes</span>
                            </div>

                            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                                {{ $tarifa->descripcion }} {{-- Descripcion de la tarifa --}}
                            </p>

                            <form action="{{ route('cliente.procesarCambio') }}" method="POST" class="mt-auto">
                                @csrf
                                
                                {{-- Datos que se envian al controlador --}}
                                <input type="hidden" name="contrato_id" value="{{ $contrato_id }}">
                                <input type="hidden" name="tarifa_actual_id" value="{{ $tarifaActual->id }}">
                                <input type="hidden" name="nueva_tarifa_id" value="{{ $tarifa->id }}">
                                <button type="submit" class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md active:scale-95 text-center">
                                    Aplicar este cambio
                                </button>
                            </form>
                        </div>
                    </div>
                @empty {{-- Si no hay tarifas disponibles --}}
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                        <p class="text-gray-400 text-lg">No hay otras tarifas de este tipo disponibles para el cambio.</p>
                    </div>
                @endforelse
            </div>
        </main>

        @include('layouts.footer') {{-- Importacion del componente footer --}}
    </body>
</html>
