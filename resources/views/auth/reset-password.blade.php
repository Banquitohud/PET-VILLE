@extends('layouts.app')

@section('titulo')
Restablece tu contraseña
@endsection

@section('contenido')
<div class="md:w-4/12 mx-auto bg-white p-6 rounded-lg shadow-xl mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Restablece tu contraseña</h2>

    @if (session('status'))
        <p class="bg-green-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-5">
            <label for="email" class="block uppercase text-gray-500 font-bold mb-2">Correo electrónico</label>
            <input type="email" name="email" required class="border p-3 w-full rounded-lg">
        </div>

        <div class="mb-5">
            <label for="password" class="block uppercase text-gray-500 font-bold mb-2">Nueva contraseña</label>
            <input type="password" name="password" required class="border p-3 w-full rounded-lg">
        </div>

        <div class="mb-5">
            <label for="password_confirmation" class="block uppercase text-gray-500 font-bold mb-2">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" required class="border p-3 w-full rounded-lg">
        </div>

        <input type="submit" value="Restablecer contraseña" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
    </form>
</div>
@endsection
