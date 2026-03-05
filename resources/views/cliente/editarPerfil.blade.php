<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Perfil</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ asset('css/editarPerfil.css') }}">
    </head>
    <body class="bg-gray-50 flex flex-col min-h-screen">
        @include('layouts.header')

        <main class="flex-1 container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto animate-fade-in-up">

                {{-- Botón para volver al panel --}}
                <a href="{{ route('cliente.inicio') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-6 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver al panel
                </a>

                {{-- Cabecera --}}
                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-blue-900">Editar Perfil</h2>
                    <p class="text-gray-500 mt-1">Actualiza tu correo electrónico y número de teléfono</p>
                </div>

                {{-- Mensajes de éxito --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-700 font-medium text-sm">{{ session('success') }}</span>
                    </div>
                @endif

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

                    {{-- Avatar y nombre --}}
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-bold">
                            {{ substr($cliente->nombre, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $cliente->nombre }} {{ $cliente->apellido }}</h3>
                            <p class="text-sm text-gray-500">Cliente desde {{ $cliente->created_at->translatedFormat('F Y') }}</p>
                        </div>
                    </div>

                    {{-- Formulario --}}
                    <form action="{{ route('cliente.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">

                            {{-- CAMPOS BLOQUEADOS --}}
                            <div class="space-y-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 lock-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Datos no modificables</span>
                                </div>

                                {{-- Nombre --}}
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nombre</label>
                                    <input
                                        type="text"
                                        value="{{ $cliente->nombre }}"
                                        disabled
                                        class="field-locked w-full px-4 py-3 rounded-xl text-sm font-medium"
                                    >
                                </div>

                                {{-- Apellidos --}}
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Apellidos</label>
                                    <input
                                        type="text"
                                        value="{{ $cliente->apellido }}"
                                        disabled
                                        class="field-locked w-full px-4 py-3 rounded-xl text-sm font-medium"
                                    >
                                </div>

                                {{-- DNI --}}
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">DNI</label>
                                    <input
                                        type="text"
                                        value="{{ $cliente->dni }}"
                                        disabled
                                        class="field-locked w-full px-4 py-3 rounded-xl text-sm font-medium"
                                    >
                                </div>
                            </div>

                            {{-- Separador visual --}}
                            <div class="border-t border-gray-100 pt-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-4 h-4 edit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-blue-500 uppercase tracking-wider">Datos editables</span>
                                </div>
                            </div>

                            {{-- CAMPOS EDITABLES --}}

                            {{-- Correo Electrónico --}}
                            <div class="flex flex-col gap-1">
                                <label for="email" class="text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Correo Electrónico
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $cliente->email) }}"
                                    required
                                    class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800"
                                    placeholder="tu@correo.com"
                                >
                                @error('email')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div class="flex flex-col gap-1">
                                <label for="telefono" class="text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Teléfono de Contacto
                                </label>
                                <input
                                    type="tel"
                                    id="telefono"
                                    name="telefono"
                                    value="{{ old('telefono', $cliente->telefono) }}"
                                    required
                                    maxlength="9"
                                    pattern="[0-9]{9}"
                                    class="field-editable w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-800"
                                    placeholder="612345678"
                                >
                                @error('telefono')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex flex-col sm:flex-row gap-3 mt-10">
                            <button
                                type="submit"
                                class="flex-1 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 active:scale-[0.98] transition-all shadow-lg shadow-blue-200 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                            <a
                                href="{{ route('cliente.inicio') }}"
                                class="flex-1 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors text-center"
                            >
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
                        Para modificar tu nombre, apellidos o DNI, por favor contacta con nuestro servicio de atención al cliente.
                    </p>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </body>
</html>
