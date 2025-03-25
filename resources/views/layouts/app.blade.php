<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetVille - @yield('titulo')</title>
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireStyles
</head>

<body class="bg-gray-100">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}">
                <h1 class="text-3xl font-black">Pet ville</h1>
            </a>
            @auth
                <form action="{{ route('posts.index', '') }}" method="GET" class="d-flex">
                    <input type="text" id="search" name="user" class="form-control me-2" placeholder="Buscar usuario..."
                        required>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <script>
                    document.querySelector('form').addEventListener('submit', function (event) {
                        event.preventDefault();
                        let username = document.getElementById('search').value.trim();
                        if (username) {
                            window.location.href = "{{ url('/') }}/" + encodeURIComponent(username);
                        }
                    });
                </script>
            @endauth

            <nav class="flex gap-2 items-center">
                @auth


                    <a href="{{ route('map') }}"
                        class="flex items-center gap-4 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3l8 2 5-2v16l-5 2-8-2-5 2V5l5-2z" />
                            <line x1="8" y1="3" x2="8" y2="21" />
                            <line x1="16" y1="5" x2="16" y2="21" />
                        </svg>
                    </a>

                    <a href="{{ route('messages.index') }}"
                        class="flex items-center gap-4 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H8l-5 5V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    </a>

                    <a href="{{ route('posts.create') }}"
                        class="flex items-center gap-4 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Crear
                    </a>

                    <a class="font-bold text-gray-600 text-sm border p-2 text-gray-600 rounded text-sm uppercase font-bold mr-2"
                        href="{{ route('posts.index', ['user' => auth()->user()]) }}">
                        {{ '@' . auth()->user()->username }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-600 text-sm">Cerrar sesión</button>
                    </form>
                @endauth

                @guest
                    <a class="font-bold uppercase text-gray-600 text-sm mr-2" href="{{ route('login') }}">Login</a>
                    <a class="font-bold uppercase text-gray-600 text-sm mr-2" href="{{ route('register.index') }}">Crear
                        cuenta</a>
                @endguest
            </nav>
        </div>
            
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="font-black text-center text-3xl mb-10">@yield('titulo')</h2>
        @yield('contenido')
    </main>

    <footer class="text-center p-5 text-gray-600 font-bold uppercase mt-10">
        Petville - Todos los derechos reservados {{ now()->year }}
    </footer>
    @livewireScripts
</body>

</html>
