<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-indigo-200 flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">
                Login {{ ucfirst($tipo) }}
            </h2>

            <form method="POST" action="#">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1">Email</label>
                    <input type="email" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-6">
                    <label class="block mb-1">Contraseña</label>
                    <input type="password" class="w-full border rounded px-3 py-2">
                </div>

                <button class="w-full bg-blue-800 text-white py-2 rounded hover:bg-blue-900">
                    Iniciar sesión
                </button>
            </form>

            {{-- SOLO SI ES CLIENTE --}}
            @if($tipo === 'cliente')
                <div class="mt-4 text-center">
                    <a href="{{ route('registro') }}" class="text-blue-600 hover:underline">
                        ¿No tienes cuenta? Regístrate
                    </a>
                </div>
            @endif
        </div>
    </body>
</html>