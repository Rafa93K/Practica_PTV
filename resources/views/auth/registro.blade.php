<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Cliente</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gradient-to-br from-slate-100 via-indigo-50 to-blue-100 flex items-center justify-center min-h-screen p-4">
        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-xl border border-white/50 backdrop-blur-sm">
            <!-- Encabezado -->
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Registro de Cliente</h2>
                <p class="text-gray-500 mt-2">Completa tus datos para empezar</p>
            </div>

            <form method="POST" action="#" class="space-y-8">
                @csrf

                <!-- SECCIÓN 1: INFORMACIÓN PERSONAL -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-indigo-100 pb-2">
                        <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider">01. Datos Personales</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Nombre</label>
                            <input type="text" required name="nombre" placeholder="Ej: Juan"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                        </div>
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Apellidos</label>
                            <input type="text" required name="apellidos" placeholder="Ej: García López"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">DNI / NIE</label>
                        <input type="text" required name="dni" placeholder="12345678X" maxlength="9"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300 uppercase">
                    </div>
                </div>

                <!-- SECCIÓN 2: CONTACTO Y SEGURIDAD -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-indigo-100 pb-2">
                        <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider">02. Contacto y Acceso</span>
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
                        <input type="password" required name="password" placeholder="••••••••••••"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                        <p class="text-[11px] text-gray-400 mt-1 ml-1 font-light italic">* Mínimo 8 caracteres, incluye una mayúscula y un número.</p>
                    </div>
                </div>

                <!-- Botón de Acción -->
                <div class="pt-4">
                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-indigo-100 transform hover:-translate-y-1 transition-all active:scale-95 duration-200">
                        Crear mi cuenta
                    </button>
                </div>
            </form>

            <!-- Pie de página -->
            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-gray-600 text-sm">
                    ¿Ya eres cliente? 
                    <a href="{{ route('login', 'cliente') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors underline underline-offset-4 decoration-indigo-200">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </body>
</html>