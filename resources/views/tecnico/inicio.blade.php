<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel Técnico</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 flex flex-col min-h-screen">
        @include('layouts.header') <!-- Importacion del componente header -->

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

                <!-- Total Asignadas -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Asignadas</p>
                        <h2 class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalIncidencias }}</h2>
                    </div>
                </div>

                <!-- Abiertas -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Abiertas</p>
                        <h2 class="text-3xl font-bold text-red-500 mt-2">{{ $abiertoTotal }}</h2>
                    </div>
                </div>

                <!-- En Proceso -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">En Proceso</p>
                        <h2 class="text-3xl font-bold text-amber-500 mt-2">{{ $en_procesoTotal }}</h2>
                    </div>
                </div>

                <!-- Cerradas -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completadas</p>
                        <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $cerradoTotal }}</h2>
                    </div>
                </div>

                <!-- Clientes -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Clientes</p>
                        <h2 class="text-3xl font-bold text-indigo-700 mt-2">{{ $totalClientes }}</h2>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: INCIDENCIAS ASIGNADAS -->
            <div class="mb-12 scroll-mt-24">
                {{-- Contador de incidencias pendientes --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Incidencias Asignadas</h2>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        {{ count($incidenciasAsignadas) }} Tareas
                    </span>
                </div>

                {{-- Tabla de incidencias asignadas --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($incidenciasAsignadas as $incidencia)
                            <tr class="hover:bg-gray-50 transition">
                                {{-- Nombre y apellidos del cliente --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $incidencia->cliente_nombre }} {{ $incidencia->cliente_apellido }}</div>
                                </td>

                                {{-- Descripcion de la incidencia --}}
                                <td class="px-6 py-4">
                                    <p class="text-gray-600 text-sm line-clamp-1">{{ $incidencia->descripcion }}</p>
                                </td>

                                <td class="px-6 py-4">
                                {{-- Estado de la incidencia --}}
                                    @if($incidencia->estado == 'abierto')
                                        <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Abierto</span>
                                    @else
                                        <span class="bg-amber-100 text-amber-600 text-[10px] font-bold px-2 py-1 rounded-md uppercase">En Proceso</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ date('d/m/Y', strtotime($incidencia->fecha)) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('tecnico.incidencia.actualizar', $incidencia->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <select name="estado" onchange="this.form.submit()" 
                                            class="text-xs font-bold bg-white border border-gray-200 rounded-lg px-3 py-2 flex ml-auto focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                                            <option value="abierto" {{ $incidencia->estado == 'abierto' ? 'selected' : '' }}>Abierto</option>
                                            <option value="en_progreso" {{ $incidencia->estado == 'en_progreso' ? 'selected' : '' }}>En Proceso</option>
                                            <option value="cerrado" {{ $incidencia->estado == 'cerrado' ? 'selected' : '' }}>Resuelto</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">No tienes incidencias pendientes.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN UNIFICADA: ANALÍTICA Y HISTORIAL -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 border-b border-gray-100 pb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Historial y Analítica de Resoluciones</h2>
                        <p class="text-gray-500 text-sm">Consulta tu rendimiento detallado y filtra por intervalos.</p>
                    </div>

                    {{-- Formulario para filtrar --}}
                    <form action="{{ route('tecnico.inicio') }}" method="GET" class="flex flex-wrap items-center gap-3 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Desde</label>
                            <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" class="text-xs font-semibold bg-white border border-gray-200 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Hasta</label>
                            <input type="date" name="fecha_fin" value="{{ $fechaFin }}" class="text-xs font-semibold bg-white border border-gray-200 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white text-xs font-bold px-6 py-2 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Aplicar Filtro
                        </button>
                        @if($fechaInicio || $fechaFin)
                            <a href="{{ route('tecnico.inicio') }}" class="text-xs text-gray-400 hover:text-indigo-600 font-bold px-2">Limpiar</a>
                        @endif
                    </form>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-10">
                    {{-- Gráfico circular --}}
                    <div class="lg:col-span-1 border-r border-gray-50 pr-8">
                        <p class="text-sm font-bold text-gray-400 uppercase mb-6 text-center">Distribución en periodo</p>
                        <div class="h-[250px] flex flex-col justify-center items-center">
                            <canvas id="graficoIncidencias"></canvas>
                        </div>
                    </div>

                    {{-- Resumen de datos del periodo --}}
                    <div class="lg:col-span-2 flex flex-col justify-center gap-6">
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-5 rounded-3xl border border-gray-100 text-center">
                                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">Abiertas</p>
                                <p class="text-3xl font-bold text-red-500">{{ $abierto }}</p>
                            </div>
                            <div class="bg-gray-50 p-5 rounded-3xl border border-gray-100 text-center">
                                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">En proceso</p>
                                <p class="text-3xl font-bold text-amber-500">{{ $en_proceso }}</p>
                            </div>
                            <div class="bg-gray-50 p-5 rounded-3xl border border-gray-100 text-center">
                                <p class="text-gray-400 text-[10px] font-bold uppercase mb-2">Resueltas</p>
                                <p class="text-3xl font-bold text-green-600">{{ $cerrado }}</p>
                            </div>
                        </div>
                        
                        <div class="p-5 bg-indigo-50/50 border border-indigo-100 rounded-3xl">
                            <h3 class="text-indigo-900 font-bold text-sm mb-1 uppercase tracking-wider">Resumen Informativo</h3>
                            <p class="text-indigo-700/80 text-sm leading-relaxed">
                                @if($fechaInicio && $fechaFin) {{-- En caso de que no se muestren datos, es porque no hay incidencias en el periodo seleccionado --}}
                                    En el periodo seleccionado ({{ date('d/m/Y', strtotime($fechaInicio)) }} - {{ date('d/m/Y', strtotime($fechaFin)) }}), has gestionado un total de <strong>{{ $abierto + $en_proceso + $cerrado }}</strong> incidencias.
                                @else
                                    Estas viendo el historial acumulado de tu actividad técnica. Usa el filtro para segmentar por fechas.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tabla de historial detallado --}}
                <div class="overflow-hidden border border-gray-100 rounded-3xl">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Resolución</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            {{-- Por cada incidencia resuelta, se muestra una fila --}}
                            @forelse($incidenciasResueltas as $incidencia)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-bold text-gray-800 text-sm">{{ $incidencia->cliente_nombre }} {{ $incidencia->cliente_apellido }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 line-clamp-1 truncate max-w-xs">{{ $incidencia->descripcion }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ date('d/m/Y H:i', strtotime($incidencia->updated_at)) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center text-green-600 font-bold text-[10px] uppercase bg-green-50 px-2 py-1 rounded">
                                        <i class="fas fa-check-circle mr-1"></i> Resuelta
                                    </span>
                                </td>
                            </tr>
                            @empty {{-- Si no hay incidencias resueltas, se muestra un mensaje --}}
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">No hay incidencias resueltas en este periodo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        @include('layouts.footer') <!-- Importacion del componente footer -->

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> {{-- Importamos el grafico --}}
        <script>
            //Pasamos los datos de PHP a variables de JavaScript
            window.datosIncidencias = {
                abierto: {{ $abierto }},
                en_proceso: {{ $en_proceso }},
                cerrado: {{ $cerrado }}
            };
        </script>
        <script src="{{ asset('js/tecnicoDatos.js') }}"></script> {{-- Llamamos al archivo de grafico --}}
    </body>
</html>