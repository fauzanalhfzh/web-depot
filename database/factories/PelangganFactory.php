<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_pelanggan' => $this->faker->name(),
            'kontak_pelanggan' => '08' . $this->faker->numerify('##########'),
            'email'            => $this->faker->unique()->safeEmail(),
            'password'         => Hash::make('password123'), // default password untuk testing
        ];
    }
}
