<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso {{ ucfirst($tipo) }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-indigo-200 flex items-center justify-center min-h-screen p-4">
        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-md border border-white/50 backdrop-blur-sm">
            <!-- Encabezado -->
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Acceso {{ ucfirst($tipo) }}</h2>
                <p class="text-gray-500 mt-2">Completa los campos para iniciar sesión</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl animate-fade-in">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="#" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-indigo-100 pb-2">
                        <span class="text-indigo-600 font-bold text-sm uppercase tracking-wider">Identificación</span>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Correo Electrónico</label>
                        <input type="email" required name="email" placeholder="usuario@ejemplo.com"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Contraseña</label>
                        <input type="password" required name="password" placeholder="••••••••••••"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <!-- Iniciar sesion -->
                <div class="pt-2">
                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-indigo-100 transform hover:-translate-y-1 transition-all active:scale-95 duration-200">
                        Entrar al panel
                    </button>
                </div>
            </form>

            <!-- Pie -->
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                @if($tipo === 'cliente') {{-- Si eres cliente muestra el enlace para el registro --}}
                    <p class="text-gray-600 text-sm">
                        ¿Aún no tienes cuenta? 
                        <a href="{{ route('registro') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors underline underline-offset-4 decoration-indigo-200">
                            Regístrate aquí
                        </a>
                    </p>
                 @else {{-- En caso contrario, no lo mostramos --}}
                    <p class="text-gray-500 text-xs italic">
                        Área restringida para personal autorizado.
                    </p>
                @endif
            </div>

            <div class="pt-8 border-t border-gray-100 text-center">
                <a href="/" class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors underline underline-offset-4 decoration-indigo-200">
                    Volver al inicio
                </a>
            </div>
        </div>
    </body>
</html>