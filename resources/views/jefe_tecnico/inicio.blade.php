<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Jefe Técnico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layouts.header')  

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
    <main class="flex-1 container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Columna Izquierda: Formulario (Aside) -->
            <aside class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-full">
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
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 min-h-[500px] flex flex-col items-center justify-center text-center space-y-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Asignación de Incidencias</h2>
                    
                    </div>
                   
                </div>
            </section>

        </div>
    </main>
    @include('layouts.footer')
</body>
</html>
