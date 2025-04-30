<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CODEHUB - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-2 flex items-center justify-between">
            <div class="w-[120px] h-[75px]">
                <img src="{{ asset('images/codehub-logo.svg') }}" class="w-full h-full object-contain" alt="CODEHUB">
            </div>
            <nav class="flex justify-between items-center space-x-6 text-sm font-medium">
                <a href="#" class="text-gray-700 hover:text-emerald-600">Início</a>
                <button onclick="document.documentElement.classList.toggle('dark')">🌙</button>
                @if (Auth::check())
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ Auth::user()->cover_path ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff'  }}" alt="Avatar"
                                class="w-10 h-10 rounded-full object-cover">
                            <span class="text-sm font-medium text-gray-700">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 
                                1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <a href="/perfil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                            <a href="/configuracoes" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configurações</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Sair</button>
                            </form>
                        </div>
                    </div>

                @else
                    <a href="{{ route("login.form") }}" class="text-gray-700 hover:text-emerald-600">Entrar</a>
                    <a href="{{ route("register.form") }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">Registrar</a>
                
                @endif
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="mt-16 py-4 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-500">
            <p class="mb-4">© 2025 CODEHUB • Feito por ☠️ HEISENDEV.</p>
            <div class="space-x-4 text-gray-400 text-[20px]">
                <a href="#" class="hover:text-emerald-600"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-emerald-600"><i class="fab fa-github"></i></a>
                <a href="#" class="hover:text-emerald-600"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>
</body>

</html>