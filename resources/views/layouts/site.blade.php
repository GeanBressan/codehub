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
            <nav class="space-x-6 text-sm font-medium">
                <a href="#" class="text-gray-700 hover:text-emerald-600">Início</a>
                <a href="#" class="text-gray-700 hover:text-emerald-600">Categorias</a>
                <a href="#" class="text-gray-700 hover:text-emerald-600">Sobre</a>
                <button onclick="document.documentElement.classList.toggle('dark')">🌙</button>
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