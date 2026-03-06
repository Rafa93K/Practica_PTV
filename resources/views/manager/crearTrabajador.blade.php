<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Trabajador</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-200 flex items-center justify-center min-h-screen p-4">
    
    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-xl border border-white/50 backdrop-blur-sm">
        <!-- Encabezado -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Registro de Trabajador</h2>
            <p class="text-gray-500 mt-2">Completa los datos para crear un nuevo trabajador</p>
        </div>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('manager.trabajadorSubmit') }}" class="space-y-8">
            @csrf

            <!-- INFORMACION PERSONAL -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 border-b border-indigo-100 pb-2">
                    <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider">Datos Personales</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Nombre</label>
                        <input type="text" required name="nombre" placeholder="Ej: Alonso"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Apellidos</label>
                        <input type="text" required name="apellido" placeholder="Ej: Coronado Alcalde"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700 ml-1">DNI / NIE</label>
                    <input type="text" required name="dni" placeholder="12345678X" maxlength="9"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300 uppercase">
                </div>
            </div>

            <!-- CONTACTO Y SEGURIDAD -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 border-b border-indigo-100 pb-2">
                    <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider">Contacto y Acceso</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Email</label>
                        <input type="email" required name="email" placeholder="usuario@ejemplo.com"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Teléfono</label>
                        <input type="tel" required name="telefono" placeholder="600 000 000" maxlength="9"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Contraseña</label>
                    <input type="password" required name="contraseña" placeholder="••••••••"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    <p class="text-[11px] text-gray-400 mt-1 ml-1 font-light italic">
                        * Mínimo 8 caracteres, incluye una mayúscula y un número.
                    </p>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Rol</label>
                    <select name="rol" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                        <option value="">-- Selecciona un rol --</option>
                        <option value="manager">Manager</option>
                        <option value="marketing">Marketing</option>
                        <option value="jefe_tecnico">Jefe Técnico</option>
                        <option value="tecnico">Técnico</option>
                    </select>
                </div>
            </div>

            <!-- Crear cuenta -->
            <div class="pt-4">
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-indigo-100 transform hover:-translate-y-1 transition-all active:scale-95 duration-200">
                    Crear Trabajador
                </button>
            </div>
        </form>

        <!-- Pie -->
        <div class="mt-8 pt-8 border-t border-gray-100 text-center">
            <a href="{{ route('manager.inicio') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors underline underline-offset-4 decoration-indigo-200">
                Volver al panel del Manager
            </a>
        </div>
    </div>
</body>
</html>