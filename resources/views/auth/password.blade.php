@extends('layouts.app')

@section('titulo')
Recupera tu contraseña - Pet Ville
@endsection

@section('contenido')
<div class="w-full max-w-md mx-auto mt-16 bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-extrabold text-center text-sky-700 mb-2">
        ¿Olvidaste tu contraseña?
    </h2>
    <p class="text-center text-gray-500 mb-6 text-sm">
        Ingresa tu correo y te enviaremos un enlace para recuperarla.
    </p>

    @if (session('status'))
        <div class="bg-green-100 text-green-700 text-sm p-3 rounded-lg text-center mb-4 border border-green-300">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm p-3 rounded-lg text-center mb-4 border border-red-300">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-5">
            <label for="email" class="block text-center text-sm font-semibold text-gray-600 mb-2">
                Correo electrónico
            </label>
            <input
                type="email"
                name="email"
                id="email"
                required
                placeholder="tucorreo@ejemplo.com"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
            >
        </div>

        <button
            type="submit"
            class="w-full bg-sky-600 hover:bg-sky-700 transition-colors text-white font-semibold py-3 px-4 rounded-lg shadow-md"
        >
            Enviar enlace de recuperación
        </button>
    </form>
</div>
@endsection
