@extends('layouts.app')

@section('titulo')
    Porque las mejores historias no solo se cuentan, sino que también se comparten. ¡Bienvenidos a Pet Ville! 🐾✨
@endsection
@section('contenido')

    <div class="md:flex md:justify-center md:gap-10 md:items-center">

        <!-- Sección de Bienvenida -->
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <article>
                <p class="text-lg font-semibold text-center">
                    Nos alegra darte la bienvenida a <span class="text-blue-500 font-bold">Pet Ville</span>,
                    la primera red social diseñada especialmente para amantes de las mascotas.
                </p>

                <p class="mt-4 text-center">
                    Aquí, tu mejor amigo <span class="font-bold">peludo, emplumado o escamoso</span> es el protagonista.
                    🐶🐱🐰🐦🐠
                </p>

                <div class="mt-6 space-y-3">
                    <p class="font-semibold text-xl text-center text-blue-600">🌟 En Pet Ville, podrás:</p>
                    <ul class="list-none space-y-2">
                        <li class="flex items-center"><span class="text-green-500">✅</span> Compartir fotos, videos y
                            anécdotas inolvidables de tu mascota.</li>
                        <li class="flex items-center"><span class="text-green-500">✅</span> Conectar con otros amantes de
                            los animales y hacer nuevos amigos.</li>
                        <li class="flex items-center"><span class="text-green-500">✅</span> Comentar, dar "me gusta" y
                            compartir publicaciones dentro de nuestra comunidad.</li>
                        <li class="flex items-center"><span class="text-green-500">✅</span> Explorar servicios y productos
                            diseñados para el bienestar de tu mascota.</li>
                        <li class="flex items-center"><span class="text-green-500">✅</span> Descubrir eventos, consejos y
                            noticias sobre el mundo animal.</li>
                    </ul>
                </div>

                <p class="mt-6 text-center text-gray-700">
                    🐾 <span class="font-semibold">Nuestra misión</span> es crear un espacio donde los dueños de mascotas
                    puedan encontrar apoyo, información y entretenimiento,
                    mientras fortalecen el vínculo con sus compañeros de vida.
                </p>

                <p class="mt-6 text-center text-blue-600 font-bold text-xl">💙 Gracias por ser parte de esta increíble
                    comunidad.</p>

                <p class="mt-4 text-center text-xl text-gray-900 font-semibold">🐾 ¡Juntos, hagamos de Pet Ville el mejor
                    lugar para nuestras mascotas! 🐾</p>
            </article>
        </div>

        <!-- Imagen Principal -->
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/principal.jpg') }}" alt="Imagen login de usuarios" class="md:rounded-lg shadow-lg">
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                @if(session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="email" name="email" id="email" placeholder="Tu Email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password de registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5 text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                <div class="mb-5">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="text-gray-500">Recuérdame</label>
                </div>

                <input type="submit" value="Iniciar sesión"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>

    </div>
@endsection
