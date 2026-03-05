 <header class="bg-blue-900 text-white shadow-lg">
    <div class="container mx-auto px-6 py-5 flex justify-between items-center">
        <a href="{{ route('inicio') }}" class="flex items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Telcomanager" class="h-10 w-auto">
            <h1 class="text-2xl font-bold tracking-wide">Telcomanager</h1>
        </a>
        <span class="text-sm opacity-80">
            <p class="font-bold text-cyan-300">@if (session('user_name'))Bienvenido/a! {{session('user_name')}}@endif </p>
            Soluciones de Gestión Empresarial
        </span>
    </div>
</header>