<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- HEADER -->
    @include('layouts.header')

    <main class="flex-1 container mx-auto px-4 py-8 flex flex-col gap-8">
       <a href="{{ route('manager.inicio') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-6 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver al panel
                </a>
        <!-- Notificación temporal -->
        @if(session('successTC'))
            <div id="flash-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg text-center">
                {{ session('successTC') }}
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('flash-message');
                    if(msg) msg.style.display = 'none';
                }, 3000);
            </script>
        @endif

        <!-- LISTADO DE TARIFAS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Por cada tarifa vamos creando tarjetas --}}
                @forelse($tarifas as $tarifa)
                    <div class="bg-emerald-50 rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col transition-all hover:shadow-xl hover:-translate-y-1">
                        <!-- Header de la Tarifa -->
                        <div class="p-6 bg-blue-900 text-white">
                            {{-- Tipo y nombre de la tarifa --}}
                            <span class="text-xs font-bold uppercase tracking-widest text-blue-300">{{ $tarifa->tipo }}</span>
                            <h3 class="text-2xl font-bold mt-1">{{ $tarifa->nombre }}</h3>
                        </div>

                        <!-- Cuerpo de la Tarifa -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="mb-6">
                                {{-- Precio de la tarifa --}}
                                <span class="text-4xl font-extrabold text-gray-900">{{ number_format($tarifa->precio, 2) }}€</span>
                                <span class="text-gray-500">/mes</span>
                            </div>

                            {{-- Descripcion de la tarifa --}}
                            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                                {{ $tarifa->descripcion }}
                            </p>
                        </div>
                    </div>
                @empty {{-- En caso de no haber tarifas creadas --}}
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                        <p class="text-gray-400 text-lg">No hay tarifas disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

            <!-- FORMULARIO PARA CREAR TARIFA -->
        <div class="bg-emerald-50 p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold mb-4">Crear nueva Tarifa</h2>
            <form method="POST" action="{{ route('tarifaSubmit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold mb-1">Nombre</label>
                    <input type="text" name="nombre" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Tipo</label>
                    <select name="tipo" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Selecciona un tipo</option>
                        <option value="Internet">Internet</option>
                        <option value="Móvil">Móvil</option>
                        <option value="TV">TV</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Precio (€)</label>
                    <input type="number" name="precio" required step="0.01" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Descripción</label>
                    <textarea name="descripcion" required rows="4"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                </div>
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition">
                    Crear Tarifa
                </button>
            </form>
        </div>

         
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')
</body>
</html>