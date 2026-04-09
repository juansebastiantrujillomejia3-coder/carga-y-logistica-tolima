<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EnvioController extends Controller
{
    public function buscarPorGuia(Request $request): JsonResponse
    {
        $request->validate([
            'numero_guia' => ['required', 'string', 'min:5', 'max:50'],
        ]);

        $numeroGuia = strtoupper(trim($request->input('numero_guia')));

        $envio = Envio::where('numero_guia', $numeroGuia)->first();

        if (!$envio) {
            return response()->json([
                'success' => false,
                'message' => "No se encontró ningún envío con el número de guía «{$numeroGuia}».",
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Envío encontrado correctamente.',
            'data'    => [
                'numero_guia'       => $envio->numero_guia,
                'estado'            => $envio->estado,
                'remitente'         => $envio->remitente,
                'destinatario'      => $envio->destinatario,
                'ciudad_origen'     => $envio->ciudad_origen,
                'ciudad_destino'    => $envio->ciudad_destino,
                'direccion_destino' => $envio->direccion_destino,
                'fecha_registro'    => $envio->fecha_registro,
                'fecha_entrega_est' => $envio->fecha_entrega_estimada,
                'peso_kg'           => $envio->peso_kg,
                'descripcion'       => $envio->descripcion,
            ],
        ], 200);
    }
}