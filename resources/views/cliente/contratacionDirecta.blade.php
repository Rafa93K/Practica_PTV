<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contratar {{ $tarifa->nombre }} - Telcomanager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layouts.header')

    <main class="flex-1 container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-black text-blue-900 mb-4">Estás a un paso de tu nueva conexión</h2>
                <p class="text-gray-500 text-lg">Completa tus datos para crear tu cuenta y contratar la tarifa <strong>{{ $tarifa->nombre }}</strong></p>
            </div>

            @if($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-red-800 font-bold">Por favor, revisa los siguientes errores:</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cliente.contratarDirecta.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf
                <input type="hidden" name="tarifa_id" value="{{ $tarifa->id }}">

                <!-- DATOS PERSONALES -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="p-2 bg-blue-50 rounded-xl text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Datos del Titular</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" required 
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Tu nombre">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Apellidos</label>
                                <input type="text" name="apellido" value="{{ old('apellido') }}" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Tus apellidos">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">DNI</label>
                                <input type="text" name="dni" value="{{ old('dni') }}" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="12345678X">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Teléfono</label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="600 000 000">
                            </div>
                        </div>

                        <div class="mt-6 space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="ejemplo@email.com">
                        </div>

                        <div class="mt-6 space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Crea tu contraseña</label>
                            <input type="password" name="contraseña" required
                                   class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Mínimo 8 caracteres">
                            <p class="text-xs text-gray-400 ml-1">La usarás para acceder a tu panel de cliente más tarde.</p>
                        </div>
                    </div>

                    <!-- DATOS DE INSTALACIÓN -->
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Dirección de Instalación</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Provincia</label>
                                <input type="text" name="provincia" value="{{ old('provincia') }}" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Málaga">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Ciudad</label>
                                <input type="text" name="ciudad" value="{{ old('ciudad') }}" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Málaga">
                            </div>
                        </div>

                        <div class="mt-6 space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Calle / Avenida</label>
                            <input type="text" name="calle" value="{{ old('calle') }}" required
                                   class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="Nombre de la vía">
                        </div>

                        <div class="grid grid-cols-3 gap-6 mt-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Número</label>
                                <input type="text" name="numero" value="{{ old('numero') }}" required
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="12">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Piso/Pta</label>
                                <input type="text" name="puerta" value="{{ old('puerta') }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="2ºB">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">C. Postal</label>
                                <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}" required maxlength="5"
                                       class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none" placeholder="29000">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RESUMEN Y BOTÓN -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        <div class="bg-blue-900 text-white p-8 rounded-[2rem] shadow-xl">
                            <h4 class="text-blue-300 uppercase tracking-widest text-xs font-black mb-6">Resumen del pedido</h4>
                            
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="text-xl font-bold">{{ $tarifa->nombre }}</div>

                                    {{-- En caso de que tenga permanencia aparece un texto indicandolo --}}
                                    <p class="text-yellow-600 font-bold italic">{{ $tarifa->permanencia == 1 ? "PERMANENCIA DE 1 AÑO" : "" }}</p>
                                    <div class="text-blue-400 text-sm italic">{{ $tarifa->tipo }}</div>
                                </div>
                                <div class="text-2xl font-black">{{ number_format($tarifa->precio, 2) }}€</div>
                            </div>

                            <p class="text-blue-100/60 text-xs leading-relaxed mb-8">
                                {{ $tarifa->descripcion }}
                            </p>

                            <div class="border-t border-blue-800 pt-6 mb-8">
                                <div class="flex justify-between items-center text-lg font-bold">
                                    <span>Total hoy</span>
                                    <span>0.00€</span>
                                </div>
                                <p class="text-[10px] text-blue-400 mt-2">Pagarás tu primera factura a final de mes.</p>
                            </div>

                            <button type="submit" class="w-full py-5 bg-white text-blue-900 font-black rounded-2xl hover:bg-blue-50 transition-all active:scale-[0.98] shadow-lg">
                                CONTRATAR AHORA
                            </button>
                        </div>

                        <div class="p-6 bg-white rounded-2xl border border-gray-100 text-center">
                            <p class="text-gray-400 text-xs font-medium">¿Ya tienes cuenta? <a href="{{ route('login', 'cliente') }}" class="text-blue-600 font-bold hover:underline">Inicia sesión</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>
