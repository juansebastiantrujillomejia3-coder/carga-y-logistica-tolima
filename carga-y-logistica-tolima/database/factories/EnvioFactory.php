<?php

namespace Database\Factories;

use App\Models\Envio;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnvioFactory extends Factory
{
    protected $model = Envio::class;

    public function definition(): array
    {
        $ciudades = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena', 'Bucaramanga', 'Pereira'];

        return [
            'numero_guia'            => strtoupper('GU-' . date('Y') . '-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT)),
            'estado'                 => $this->faker->randomElement(['pendiente', 'en_transito', 'entregado', 'devuelto', 'cancelado']),
            'remitente'              => $this->faker->company(),
            'destinatario'           => $this->faker->name(),
            'ciudad_origen'          => $this->faker->randomElement($ciudades),
            'ciudad_destino'         => $this->faker->randomElement($ciudades),
            'direccion_destino'      => $this->faker->address(),
            'fecha_registro'         => now(),
            'fecha_entrega_estimada' => now()->addDays(rand(2, 10)),
            'peso_kg'                => $this->faker->randomFloat(2, 0.1, 50),
            'descripcion'            => $this->faker->optional()->sentence(),
        ];
    }
}