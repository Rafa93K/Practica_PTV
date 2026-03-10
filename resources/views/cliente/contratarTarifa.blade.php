<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contratar Tarifa</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ asset('css/contratarTarifa.css') }}">
    </head>
    <body class="bg-gray-50 flex flex-col min-h-screen">
        @include('layouts.header') {{-- Importacion del componente header --}}

        <main class="flex-1 container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto animate-fade-in-up">

                {{-- Botón para volver al catálogo --}}
                <a href="{{ route('cliente.tarifas') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-6 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver a tarifas
                </a>

                {{-- Cabecera --}}
                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-blue-900">Finalizar Contratación</h2>
                    <p class="text-gray-500 mt-1">Confirma tus datos y facilítanos la dirección de instalación</p>
                </div>

                {{-- Mensajes de error --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-700 font-semibold text-sm">Se encontraron errores:</span>
                        </div>
                        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Tarjeta del formulario --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 transition-all hover:shadow-md">

                    {{-- Resumen de la Tarifa Seleccionada --}}
                    <div class="flex items-center justify-between gap-4 mb-8 pb-6 border-b border-gray-100">
                        <div class="flex items-center gap-4">
                            <div>
                                {{-- Nombre y tipo de la tarifa seleccionada --}}
                                <h3 class="text-xl font-bold text-gray-800">{{ $tarifa->nombre }}</h3>
                                <p class="text-sm text-gray-500">{{ $tarifa->tipo }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            {{-- Precio de la tarifa seleccionada --}}
                            <span class="text-2xl font-black text-blue-900">{{ number_format($tarifa->precio, 2) }}€</span>
                        </div>
                    </div>

                    {{-- Formulario --}}
                    {{-- Nota: El action debe apuntar a la ruta de guardar contrato, la crearé si no existe o dejaré el placeholder --}}
                    <form action="{{ route('cliente.contratarTarifa.store') }}" method="POST">
                        @csrf
                        {{-- ID del cliente --}}
                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                        {{-- ID de la tarifa seleccionada --}}
                        <input type="hidden" name="tarifa_id" value="{{ $tarifa->id }}">

                        <div class="space-y-6">

                            {{-- CAMPOS BLOQUEADOS (DATOS PERSONALES) --}}
                            <div class="space-y-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tus Datos de Titular</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Nombre Completo --}}
                                    <div class="flex flex-col gap-1 text-left">
                                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Nombre Completo</label>
                                        <input type="text" value="{{ $cliente->nombre }} {{ $cliente->apellido }}" disabled class="field-locked w-full px-4 py-3 rounded-xl text-sm font-medium">
                                    </div>

                                    {{-- DNI --}}
                                    <div class="flex flex-col gap-1 text-left">
                                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">DNI</label>
                                        <input type="text" value="{{ $cliente->dni }}" disabled class="field-locked w-full px-4 py-3 rounded-xl text-sm font-medium">
                                    </div>
                                </div>

                                {{-- Correo Electrónico --}}
                                <div class="flex flex-col gap-1 text-left">
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider ml-1">Correo Electrónico</label>
                                    <input type="text" value="{{ $cliente->email }}" disabled class="field-locked w-full px-4 py-3 rounded-xl text-sm font-medium">
                                </div>
                            </div>

                            {{-- Separador visual --}}
                            <div class="border-t border-gray-100 pt-6">
                                <div class="flex items-center gap-2 mb-4 text-left">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-blue-500 uppercase tracking-wider">Dirección de Instalación</span>
                                </div>
                            </div>

                            {{-- CAMPOS EDITABLES (DIRECCIÓN) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Provincia --}}
                                <div class="flex flex-col gap-1 text-left">
                                    <label for="provincia" class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1">Provincia</label>
                                    <input type="text" id="provincia" name="provincia" value="{{ old('provincia') }}" required class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800" placeholder="Ej: Málaga">
                                </div>

                                {{-- Ciudad --}}
                                <div class="flex flex-col gap-1 text-left">
                                    <label for="ciudad" class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1">Ciudad / Localidad</label>
                                    <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad') }}" required class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800" placeholder="Ej: Fuengirola">
                                </div>
                            </div>

                            {{-- Calle --}}
                            <div class="flex flex-col gap-1 text-left">
                                <label for="calle" class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1">Calle / Avenida</label>
                                <input type="text" id="calle" name="calle" value="{{ old('calle') }}" required class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800" placeholder="Nombre de la vía">
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                {{-- Numero --}}
                                <div class="flex flex-col gap-1 text-left">
                                    <label for="numero" class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1">Nº</label>
                                    <input type="text" id="numero" name="numero" value="{{ old('numero') }}" required class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800" placeholder="12">
                                </div>

                                {{-- Puerta --}}
                                <div class="flex flex-col gap-1 text-left">
                                    <label for="puerta" class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1">Piso/Pta</label>
                                    <input type="text" id="puerta" name="puerta" value="{{ old('puerta') }}" class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800" placeholder="2ºB">
                                </div>

                                {{-- CP --}}
                                <div class="flex flex-col gap-1 text-left">
                                    <label for="codigo_postal" class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1">CP</label>
                                    <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" required pattern="[0-9]{5}" maxlength="5" class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800" placeholder="29640">
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex flex-col sm:flex-row gap-3 mt-10">
                            <button type="submit" class="flex-1 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 active:scale-[0.98] transition-all shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Confirmar Contratación
                            </button>
                            <a href="{{ route('cliente.tarifas') }}" class="flex-1 py-4 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Nota informativa --}}
                <div class="mt-6 flex items-start gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-blue-700">
                        Al confirmar, el servicio se activará de forma inmediata en tu cuenta y podrás gestionarlo desde tu panel personal.
                    </p>
                </div>
            </div>
        </main>

        @include('layouts.footer') {{-- Importacion del componente footer --}}
    </body>
</html>
