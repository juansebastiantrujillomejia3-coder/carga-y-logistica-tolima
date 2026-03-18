<?php

namespace App\Http\Controllers;

use App\Models\Guia;
use App\Models\Planilla;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

/**
 * GuiaController - SCRUM-6
 * Registro de guías de envío vinculadas a planilla 23M&M
 *
 * Criterios de aceptación:
 * CA1 - Registro obligatorio: solo si la planilla es válida
 * CA2 - Validación de datos: campos obligatorios validados
 * CA3 - Asociación a planilla: guía queda ligada a la planilla
 * CA4 - Restricción de duplicados: no se puede registrar la misma guía dos veces
 * CA5 - Restricción por permisos: solo usuarios autorizados
 * CA6 - Confirmación del registro: mensaje de éxito
 * CA7 - Evidencia del estado del paquete: registrar si llegó en buen estado o con novedad
 */
class GuiaController extends Controller
{
    /**
     * Registrar una nueva guía vinculada a una planilla 23M&M
     * CA1, CA2, CA3, CA4, CA6, CA7
     */
    public function store(Request $request): JsonResponse
    {
        // CA2 - Validación de todos los campos obligatorios
        $validated = $request->validate([
            'planilla_id'              => ['required', 'integer', 'exists:planillas,id'],
            'numero_guia'              => ['required', 'string', 'min:5', 'max:20', 'unique:guias,numero_guia'],
            'fecha_admision'           => ['required', 'date'],
            'referencia'               => ['nullable', 'string', 'max:50'],

            // Remitente
            'remitente_nombre'         => ['required', 'string', 'max:150'],
            'remitente_direccion'      => ['required', 'string', 'max:255'],
            'remitente_ciudad'         => ['required', 'string', 'max:100'],
            'remitente_telefono'       => ['nullable', 'string', 'max:20'],
            'remitente_cedula'         => ['nullable', 'string', 'max:20'],
            'remitente_codigo_postal'  => ['nullable', 'string', 'max:10'],

            // Destinatario
            'destinatario_nombre'      => ['required', 'string', 'max:150'],
            'destinatario_direccion'   => ['required', 'string', 'max:255'],
            'destinatario_ciudad'      => ['required', 'string', 'max:100'],
            'destinatario_telefono'    => ['nullable', 'string', 'max:20'],
            'destinatario_cedula'      => ['nullable', 'string', 'max:20'],
            'destinatario_codigo_postal' => ['nullable', 'string', 'max:10'],
            'destinatario_zona'        => ['nullable', 'string', 'max:10'],

            // Contenido
            'descripcion_contenido'    => ['required', 'string', 'max:255'],
            'unidades'                 => ['required', 'integer', 'min:1'],

            // Pesos
            'peso_real_kg'             => ['required', 'numeric', 'min:0.001'],
            'peso_volumetrico_kg'      => ['nullable', 'numeric', 'min:0'],
            'peso_cobrar_kg'           => ['required', 'numeric', 'min:0.001'],

            // Valores
            'valor_declarado'          => ['required', 'numeric', 'min:0'],
            'flete'                    => ['required', 'numeric', 'min:0'],
            'manejo'                   => ['nullable', 'numeric', 'min:0'],
            'otros'                    => ['nullable', 'numeric', 'min:0'],
            'valor_recaudo'            => ['nullable', 'numeric', 'min:0'],

            // CA7 - Estado del paquete
            'estado_paquete'           => ['required', Rule::in(['buen_estado', 'con_novedad'])],
            'novedad_descripcion'      => ['required_if:estado_paquete,con_novedad', 'nullable', 'string', 'max:500'],
        ], [
            'planilla_id.exists'        => 'La planilla seleccionada no existe o no es válida.',
            'numero_guia.unique'        => 'Esta guía ya fue registrada anteriormente en el sistema.',
            'numero_guia.required'      => 'El número de guía es obligatorio.',
            'remitente_nombre.required' => 'El nombre del remitente es obligatorio.',
            'destinatario_nombre.required' => 'El nombre del destinatario es obligatorio.',
            'descripcion_contenido.required' => 'La descripción del contenido es obligatoria.',
            'estado_paquete.required'   => 'Debe indicar el estado del paquete.',
            'novedad_descripcion.required_if' => 'Debe describir la novedad encontrada.',
        ]);

        // CA1 - Verificar que la planilla existe y es válida
        $planilla = Planilla::findOrFail($validated['planilla_id']);

        // Calcular total de fletes automáticamente
        $totalFletes = ($validated['flete'] ?? 0)
                     + ($validated['manejo'] ?? 0)
                     + ($validated['otros'] ?? 0);

        // CA3 - Crear guía asociada a la planilla
        $guia = Guia::create([
            ...$validated,
            'total_fletes'  => $totalFletes,
            'registrado_por' => $request->user()->id,
            'estado'        => 'registrada',
        ]);

        // CA6 - Confirmación del registro exitoso
        return response()->json([
            'success' => true,
            'message' => "✅ Guía {$guia->numero_guia} registrada exitosamente y asociada a la planilla {$planilla->numero_planilla}.",
            'data'    => $guia->load('planilla'),
        ], 201);
    }

    /**
     * Listar guías con filtros opcionales
     */
    public function index(Request $request): JsonResponse
    {
        $query = Guia::with('planilla')
                     ->orderBy('created_at', 'desc');

        if ($request->filled('planilla_id')) {
            $query->where('planilla_id', $request->planilla_id);
        }

        if ($request->filled('numero_guia')) {
            $query->where('numero_guia', 'like', '%' . $request->numero_guia . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $guias = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $guias,
        ]);
    }

    /**
     * Ver detalle de una guía
     */
    public function show(string $numeroGuia): JsonResponse
    {
        $guia = Guia::with('planilla', 'registradoPor')
                    ->where('numero_guia', strtoupper($numeroGuia))
                    ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $guia,
        ]);
    }

    /**
     * Obtener planillas disponibles para el select del formulario
     */
    public function getPlanillas(): JsonResponse
    {
        $planillas = Planilla::select('id', 'numero_planilla', 'descripcion')
                             ->orderBy('numero_planilla')
                             ->get();

        return response()->json([
            'success' => true,
            'data'    => $planillas,
        ]);
    }
}