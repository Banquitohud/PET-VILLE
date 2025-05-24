@extends('layouts.app')

@section('titulo')
Haz un Donativo
@endsection

@section('contenido')
<div class="md:flex md:justify-center">
    <div class="md:w-1/2 bg-white shadow p-6">

        @if(session('success'))
            <div class="bg-green-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('donativos.store') }}" enctype="multipart/form-data" class="mt-10 md:mt-0">
            @csrf

            <div class="mb-5">
                <label for="monto" class="mb-2 block uppercase text-gray-500 font-bold">
                    Monto del Donativo ($)
                </label>
                <input type="number" name="monto" id="monto" placeholder="Ingresa el monto"
                    class="border p-3 w-full rounded-lg @error('monto') border-red-500 @enderror" step="0.01" min="1">
                @error('monto')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="mensaje" class="mb-2 block uppercase text-gray-500 font-bold">
                    Mensaje (opcional)
                </label>
                <textarea name="mensaje" id="mensaje" rows="3" placeholder="Escribe un mensaje..."
                    class="border p-3 w-full rounded-lg @error('mensaje') border-red-500 @enderror"></textarea>
                @error('mensaje')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="metodo_pago" class="mb-2 block uppercase text-gray-500 font-bold">
                    Método de Pago
                </label>
                <select name="metodo_pago" id="metodo_pago"
                    class="border p-3 w-full rounded-lg @error('metodo_pago') border-red-500 @enderror">
                    <option value="">Selecciona una opción</option>
                    <option value="tarjeta">Tarjeta de crédito</option>
                    <option value="paypal">PayPal</option>
                    <option value="transferencia">Transferencia bancaria</option>
                </select>
                @error('metodo_pago')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <input type="submit" value="Donar"
                class="bg-blue-600 hover:bg-blue-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
        </form>
    </div>
</div>
@endsection
