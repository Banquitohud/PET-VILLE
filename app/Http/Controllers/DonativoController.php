<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonativoController extends Controller
{
    public function create()
    {
        return view('donaciones');
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
            'mensaje' => 'nullable|string|max:255',
            'metodo_pago' => 'required|in:tarjeta,paypal,transferencia',
        ]);

        return redirect()->route('donativos.create')->with('success', '¡Gracias por tu donativo!');
    }
}
