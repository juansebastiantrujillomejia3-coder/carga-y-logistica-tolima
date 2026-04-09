<?php

namespace Tests\Feature;

use App\Models\Envio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Tests de la Historia de Usuario SCRUM-65
 * "Como administrador quiero consultar los envíos registrados en el sistema
 *  para realizar seguimiento y control del proceso logístico."
 */
class ConsultaEnvioTest extends TestCase
{
    use RefreshDatabase;

    // ────────────────────────────────────────────────────────────
    // [HU-65-1] Consulta exitosa por número de guía
    // ────────────────────────────────────────────────────────────

    /** @test */
    public function usuario_autenticado_puede_consultar_envio_existente(): void
    {
        // Arrange
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        $envio = Envio::factory()->create([
            'numero_guia'     => 'GU-2024-00100',
            'estado'          => 'en_transito',
            'remitente'       => 'Empresa ABC',
            'destinatario'    => 'Juan Pérez',
            'ciudad_origen'   => 'Bogotá',
            'ciudad_destino'  => 'Medellín',
        ]);

        // Act
        $response = $this->getJson('/api/envios/buscar?numero_guia=GU-2024-00100');

        // Assert
        $response->assertOk()
                 ->assertJson([
                     'success' => true,
                     'data'    => [
                         'numero_guia'    => 'GU-2024-00100',
                         'estado'         => 'en_transito',
                         'remitente'      => 'Empresa ABC',
                         'destinatario'   => 'Juan Pérez',
                         'ciudad_origen'  => 'Bogotá',
                         'ciudad_destino' => 'Medellín',
                     ],
                 ]);
    }

    /** @test */
    public function la_busqueda_no_distingue_mayusculas_o_minusculas(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        Envio::factory()->create(['numero_guia' => 'GU-2024-00200']);

        // Enviar en minúsculas → debe encontrar igual
        $response = $this->getJson('/api/envios/buscar?numero_guia=gu-2024-00200');

        $response->assertOk()->assertJsonPath('data.numero_guia', 'GU-2024-00200');
    }

    // ────────────────────────────────────────────────────────────
    // [HU-65-2] Envío no encontrado
    // ────────────────────────────────────────────────────────────

    /** @test */
    public function retorna_404_cuando_el_numero_de_guia_no_existe(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        $response = $this->getJson('/api/envios/buscar?numero_guia=GU-9999-XXXXX');

        $response->assertNotFound()
                 ->assertJson([
                     'success' => false,
                 ])
                 ->assertJsonPath('data', null);

        // El mensaje debe ser informativo (no técnico)
        $this->assertStringContainsString(
            'GU-9999-XXXXX',
            $response->json('message')
        );
    }

    /** @test */
    public function el_mensaje_de_no_encontrado_incluye_el_numero_de_guia_buscado(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        $response = $this->getJson('/api/envios/buscar?numero_guia=GU-0000-00000');

        $response->assertNotFound();
        $this->assertStringContainsString('GU-0000-00000', $response->json('message'));
    }

    // ────────────────────────────────────────────────────────────
    // [HU-65-3] Acceso sin autenticación
    // ────────────────────────────────────────────────────────────

    /** @test */
    public function usuario_no_autenticado_recibe_401_al_consultar_envios(): void
    {
        Envio::factory()->create(['numero_guia' => 'GU-2024-00300']);

        // Sin token → debe ser bloqueado
        $response = $this->getJson('/api/envios/buscar?numero_guia=GU-2024-00300');

        $response->assertUnauthorized();
    }

    /** @test */
    public function token_invalido_recibe_401(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer token_invalido_123',
        ])->getJson('/api/envios/buscar?numero_guia=GU-2024-00300');

        $response->assertUnauthorized();
    }

    // ────────────────────────────────────────────────────────────
    // Validaciones del campo numero_guia
    // ────────────────────────────────────────────────────────────

    /** @test */
    public function retorna_422_cuando_numero_guia_esta_vacio(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        $response = $this->getJson('/api/envios/buscar?numero_guia=');

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['numero_guia']);
    }

    /** @test */
    public function retorna_422_cuando_numero_guia_es_demasiado_corto(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        $response = $this->getJson('/api/envios/buscar?numero_guia=AB');

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['numero_guia']);
    }

    /** @test */
    public function retorna_422_cuando_falta_el_parametro_numero_guia(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        $response = $this->getJson('/api/envios/buscar');

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['numero_guia']);
    }

    // ────────────────────────────────────────────────────────────
    // Estructura de la respuesta
    // ────────────────────────────────────────────────────────────

    /** @test */
    public function la_respuesta_contiene_todos_los_campos_esperados(): void
    {
        $usuario = User::factory()->create();
        Sanctum::actingAs($usuario);

        Envio::factory()->create(['numero_guia' => 'GU-2024-00400']);

        $response = $this->getJson('/api/envios/buscar?numero_guia=GU-2024-00400');

        $response->assertOk()
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'numero_guia',
                         'estado',
                         'remitente',
                         'destinatario',
                         'ciudad_origen',
                         'ciudad_destino',
                         'direccion_destino',
                         'fecha_registro',
                         'fecha_entrega_est',
                         'peso_kg',
                         'descripcion',
                     ],
                 ]);
    }
}
