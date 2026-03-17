<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Jefe Técnico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layouts.header')  

    <!-- Notificación temporal -->
        @if($errors->has('fecha'))
            <div id="error-message" class="mb-6 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg text-center font-bold">
                {{ $errors->first('fecha') }}
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('error-message');
                    if(msg) msg.style.display = 'none';
                }, 4000);
            </script>
        @endif
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
    <main class="flex-1 container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Columna Izquierda: Formulario (Aside) -->
            <aside class="lg:col-span-1 space-y-8">
                <!-- Estadísticas de Intervalo -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 ">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Estadísticas</h3>
                    </div>

                    <form action="{{ route('jefe_tecnico.inicio') }}" method="GET" class="space-y-4 mb-6">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-xs text-gray-400 uppercase font-bold">Inicio</label>
                                <input type="text" name="fecha_inicio" id="fecha_inicio" value="{{ $fechaInicio }}" 
                                       class="w-full px-3 py-2 bg-gray-50 border border-gray-100 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 uppercase font-bold">Fin</label>
                                <input type="text" name="fecha_fin" id="fecha_fin" value="{{ $fechaFin }}"
                                       class="w-full px-3 py-2 bg-gray-50 border border-gray-100 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
                            Filtrar
                        </button>
                    </form>

                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="text-sm text-gray-500 mb-1">Incidencias creadas</div>
                        <div class="text-3xl font-black text-gray-800">{{ $totalIncidenciasIntervalo }}</div>
                    </div>
                </div>

                <!-- Formulario Nuevo Técnico -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-130">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Nuevo Técnico</h3>
                    </div>

                    <form action="{{route('jefe_tecnico.trabajadorSubmit')}}" method="post" class="space-y-4">
                        @csrf
                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Ej. Juan"
                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        </div>

                        <div>
                            <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-1">Apellidos</label>
                            <input type="text" name="apellido" id="apellido" placeholder="Ej. Pérez"
                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="dni" class="block text-sm font-semibold text-gray-700 mb-1">DNI</label>
                                <input type="text" name="dni" id="dni" placeholder="12345678X"
                                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                            <div>
                                <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" placeholder="600000000"
                                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" placeholder="tecnico@empresa.com"
                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        </div>

                        <div>
                            <label for="contraseña" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                            <input type="password" name="contraseña" id="contraseña"
                                   class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        </div>

                        <div>
                            <label for="rol" class="block text-sm font-semibold text-gray-700 mb-1">Rol del Sistema</label>
                            <input type="text" name="rol" id="rol" value="tecnico" readonly
                                   class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 font-medium cursor-not-allowed">
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transform hover:scale-[1.02] transition-all shadow-lg shadow-indigo-100 mt-4">
                            Crear Técnico
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Columna Derecha: Contenido Principal (Section) -->
            <section class="lg:col-span-2">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 min-h-[500px]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Incidencias Sin Asignar</h2>
                    </div>

                    @if($incidenciasSinAsignar->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">No hay incidencias pendientes de asignación</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-100">
                                        <th class="pb-4 font-semibold">Incidencia</th>
                                        <th class="pb-4 font-semibold">Descripción</th>
                                        <th class="pb-4 font-semibold">Asignar Técnico</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($incidenciasSinAsignar as $incidencia)
                                        <tr class="group hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4  pr-4">
                                                <div class="font-bold text-gray-700">#{{ $incidencia->id }}</div>
                                                <div class="text-xs text-gray-400">{{ $incidencia->created_at }}</div>
                                            </td>
                                            <td class="py-4 pr-4">
                                                <p class="text-sm text-gray-600 line-clamp-2">{{ $incidencia->descripcion }}</p>
                                            </td>
                                            <td class="py-4">
                                                <form action="{{ route('jefe_tecnico.asignar') }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="incidencia_id" value="{{ $incidencia->id }}">
                                                    
                                                    <div class="flex flex-col gap-1">
                                                        <select name="trabajador_id" required 
                                                                class="min-w-[150px] px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                                            <option value="" disabled selected>Selecciona Técnico</option>
                                                            @foreach($tecnicos as $tecnico)
                                                                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="flex flex-col gap-1">
                                                        <input type="text" name="fecha" id="fechaTecnico" required
                                                               class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                                               value="{{ date('Y-m-d') }}">
                                                    </div>

                                                    <div class="flex flex-col gap-1">
                                                        <input type="text" name="hora" id="horaTecnico" required
                                                               class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                                                               value="{{ date('H:i') }}">
                                                    </div>

                                                    <button type="submit" 
                                                            class="p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm"
                                                            title="Asignar técnico y fecha">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>


        </div>
    </main>
    @include('layouts.footer')
    <script>
        //Configuración de Flatpickr
        const configFlatpickr = {
            locale: "es", //Idioma español
            dateFormat: "Y-m-d", //Formato de fecha interno
            altInput: true, //Para mostrar una fecha distinta
            altFormat: "d-m-Y", //Formato de fecha externo
            allowInput: true, //Permite escribir la fecha
        };

        //Configuro las fechas
        flatpickr("#fechaTecnico", configFlatpickr);
        flatpickr("#fecha_inicio", configFlatpickr);
        flatpickr("#fecha_fin", configFlatpickr);

        flatpickr("#horaTecnico", {
            locale: "es",
            enableTime: true, //Tiene tiempo
            noCalendar: true, //Desactivamos el calendario
            dateFormat: "H:i", //Formato de hora interno
            altInput: true, //Para mostrar una fecha distinta
            altFormat: "H:i", //Formato de hora externo
            allowInput: true, //Permite escribir la fecha
            time_24hr: true, //Formato de 24 horas
            minuteIncrement: 60, //Incremento de minutos
        })
    </script>
</body>
</html>