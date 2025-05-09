<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CODEHUB - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tiny.cloud/1/1csuc860hs4x2d18jswsccr71lu5rueiuazb2t7um6g2e23q/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
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
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900 dark:bg-neutral-900 dark:text-white">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 dark:bg-neutral-950 dark:border-neutral-800">
    <div class="max-w-7xl mx-auto px-6 py-2 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0">
        <div class="w-[100px] h-[65px]">
            <a href="{{ route('home') }}" class="flex items-center justify-center md:justify-start">
                <img src="{{ asset('images/codehub-logo.svg') }}" class="w-full h-full object-contain" alt="CODEHUB">
            </a>
        </div>

        <nav class="w-full md:w-auto flex flex-col md:flex-row items-center justify-center md:justify-end gap-4 text-sm font-medium">
            @livewire('search')

            <button id="dark-mode-toggle">
                <i class="fa-solid fa-circle-half-stroke text-indigo-700 dark:text-amber-300"></i>
            </button>

            @can('view', Auth::user())
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ !Auth::user()->cover_path ? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=009966&color=fff' : asset('storage/' . Auth::user()->cover_path)  }}" alt="Avatar"
                            class="w-10 h-10 rounded-full object-cover">
                        <span class="text-sm font-medium text-gray-700 dark:text-white">
                            {{ Auth::user()->name }}
                        </span>
                        <svg class="w-4 h-4 text-gray-500 dark:text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 
                            1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="overflow-hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-neutral-800 dark:border-neutral-700">
                        <a href="{{ route("post.create") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-950">Criar Post</a>
                        <a href="{{ route("profile.index") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-950">Perfil</a>
                        <a href="{{ route("profile.savedPosts") }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-950">Salvos</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-950">Sair</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 items-center">
                    <a href="{{ route("login.form") }}" class="text-gray-700 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-600">Entrar</a>
                    <a href="{{ route("register.form") }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">Registrar</a>
                </div>
            @endcan
        </nav>
    </div>
</header>


    @yield('content')

    <!-- Footer -->
    <footer class="mt-auto py-4 bg-white border-t border-gray-200 dark:bg-neutral-950 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-500">
            <p class="mb-4">© 2025 CODEHUB • Feito por ☠️ Gean Bressan.</p>
            <div class="text-gray-400 text-[20px] flex justify-center gap-x-4">
                <a href="https://www.instagram.com/geanbressan/" target="_blank" class="hover:text-emerald-600"><i class="fab fa-instagram"></i></a>
                <a href="https://github.com/GeanBressan" target="_blank" class="hover:text-emerald-600"><i class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/gean-bressan/" target="_blank" class="hover:text-emerald-600"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    @livewireScripts
    @yield('scripts')
    <script>
        // Dark mode toggle
        const darkModeToggle = document.querySelector('#dark-mode-toggle');
        const darkMode = localStorage.getItem('dark-mode');
        if (darkMode === 'enabled') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        darkModeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('dark-mode', 'enabled');
            } else {
                localStorage.setItem('dark-mode', 'disabled');
            }
        });
    </script>
</body>

</html>