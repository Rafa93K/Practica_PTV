 <header class="bg-blue-900 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
        <a href="{{ route('inicio') }}" class="flex items-center gap-2 md:gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Telcomanager" class="h-8 md:h-10 w-auto">
            <h1 class="text-2xl md:text-2xl font-bold tracking-wide">Telecomanager</h1>
        </a>
        <span class="text-2xl opacity-80 text-center md:text-right">
            <p class="font-bold text-cyan-300">@if (session('user_name'))Bienvenido/a! {{session('user_name')}}@endif </p>
            Soluciones de Gestión Empresarial
        </span>
    </div>
</header>