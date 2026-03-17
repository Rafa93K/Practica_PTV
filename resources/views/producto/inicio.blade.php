<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- HEADER -->
    @include('layouts.header')

    <main class="container mx-auto px-4 py-8 flex flex-col gap-8">
       <a href="{{ route('manager.inicio') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-6 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver al panel
                </a>
        <!-- Notificación temporal -->
        @if(session('successPC'))
            <div id="flash-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg text-center">
                {{ session('successPC') }}
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('flash-message');
                    if(msg) msg.style.display = 'none';
                }, 3000);
            </script>
        @endif

        <!-- LISTADO DE PRODUCTOS -->
        <div class="bg-emerald-50 p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4">Productos existentes</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 px-4">Nombre</th>
                        <th class="py-2 px-4">Cantidad</th>
                        <th class="py-2 px-4">Precio (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr class="border-b hover:bg-emerald-100">
                            <td class="py-2 px-4">{{ $producto->nombre }}</td>
                            <td class="py-2 px-4">{{ $producto->cantidad }}</td>
                            <td class="py-2 px-4">{{ number_format($producto->precio, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA CREAR PRODUCTO -->
        <div class="bg-emerald-50 p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4">Crear nuevo producto</h2>
            <form method="POST" action="{{ route('productoSubmit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold mb-1">Nombre</label>
                    <input type="text" name="nombre" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Cantidad</label>
                    <input type="number" name="cantidad" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Precio (€)</label>
                    <input type="number" name="precio" required step="0.01" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition">
                    Crear Producto
                </button>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')
</body>
</html>