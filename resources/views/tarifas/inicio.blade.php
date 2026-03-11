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
            @php //Para redirigir al panel correspondiente
                $rutaPanel = session('user_role') . '.inicio';    
            @endphp
            <a href="{{ route($rutaPanel) }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-6 group">
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
            @if(session('errorTC'))
                <div id="flash-message" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg text-center">
                    {{ session('errorTC') }}
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
                    <div class="bg-emerald-50 rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col transition-all hover:shadow-xl hover:-translate-y-1 cursor-pointer" 
                         onclick="toggleTarifaDetalles({{ $tarifa->id }})">
                        <!-- Header de la Tarifa -->
                        <div class="p-6 bg-blue-900 text-white relative">
                            {{-- Tipo y nombre de la tarifa --}}
                            <span class="text-xs font-bold uppercase tracking-widest text-blue-300">{{ $tarifa->tipo }}</span>
                            <h3 class="text-2xl font-bold mt-1 text-emerald-400">{{ $tarifa->nombre }}</h3>
                            
                            @if($tarifa->permanencia) {{-- Si la tarifa es de permanencia --}}
                                <span class="text-yellow-300 py-1 rounded-full font-bold text-xl">PERMANENCIA DE 1 AÑO</span>
                            @endif
                            
                            {{-- Si el usuario es manager o marketing se muestra el boton de eliminar --}}
                            @if(session('user_role') === 'manager' || session('user_role') === 'marketing')
                                <div class="absolute top-4 right-4">
                                    <form action="{{ route('tarifaDelete', $tarifa->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tarifa? Los clientes asociados serán notificados.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-200 p-2" title="Eliminar tarifa">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
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

                            {{-- SECCIÓN DE PRODUCTOS ASIGNADOS (Se muestra al pulsar) --}}
                            <div id="detalles-{{ $tarifa->id }}" class="hidden mt-4 pt-4 border-t border-emerald-200">
                                <h4 class="font-bold text-blue-900 mb-2">Productos asignados:</h4>
                                <ul class="space-y-1">
                                    @forelse($tarifa->productos as $producto)
                                        <li class="flex items-center gap-2 text-sm text-gray-700">
                                            {{ $producto->nombre }}
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-400 italic">No hay productos asignados</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty {{-- En caso de no haber tarifas creadas --}}
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                        <p class="text-gray-400 text-lg">No hay tarifas disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

            @if(session('user_role') === 'manager' || session('user_role') === 'marketing')
                <!-- FORMULARIO PARA CREAR TARIFA (Solo visible para manager/marketing) -->
                <div class="bg-emerald-50 p-8 rounded-2xl shadow-lg border border-emerald-100 mt-12">
                    <h2 class="text-2xl font-bold mb-6 text-blue-900 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Crear nueva Tarifa
                    </h2>
                    <form method="POST" action="{{ route('tarifaSubmit') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        {{-- Grupo de datos básicos --}}
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de la Tarifa</label>
                                <input type="text" name="nombre" required placeholder="Ej: Super Fibra 1Gb"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Tipo</label>
                                <select name="tipo" required
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                                    <option value="">Selecciona un tipo</option>
                                    <option value="internet">Internet</option>
                                    <option value="movil">Móvil</option>
                                    <option value="tv">TV</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Precio (€)</label>
                                <input type="number" name="precio" required step="0.01" min="0" placeholder="0.00"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            </div>
                            {{-- Botón de permanencia --}}
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1">Permanencia</label>
                                <input type="checkbox" name="permanencia"
                                        class="border border-gray-200 w-4 h-4 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            </div>
                        </div>

                        {{-- Grupo de descripción y productos --}}
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Descripción</label>
                                <textarea name="descripcion" required rows="3" placeholder="Detalles de la tarifa..."
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
                            </div>

                            {{-- ASIGNAR PRODUCTOS --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Asignar Productos</label>
                                <div id="productos-container" class="space-y-2">
                                    <div class="flex gap-2">
                                        <select name="productos[]" class="producto-select w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition-all" onchange="verificarNuevosSelects(this)">
                                            <option value="">Selecciona un producto...</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Se habilitará un nuevo campo al seleccionar un producto.</p>
                            </div>
                        </div>

                        

                        <div class="md:col-span-2 pt-4">
                            <button type="submit"
                                    class="w-full bg-blue-900 text-white font-bold py-4 rounded-xl hover:bg-blue-800 transform hover:scale-[1.01] transition-all shadow-md">
                                Crear Tarifa
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </main>

        <!-- SCRIPTS -->
        <script src="{{ asset('js/tarifas.js') }}"></script>

        <!-- FOOTER -->
        @include('layouts.footer')
    </body>
</html>