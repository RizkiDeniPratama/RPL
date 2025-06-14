<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $noAnggota = 1;
        return [
            'NoAnggotaM' => 'M' . str_pad($noAnggota++, 4, '0', STR_PAD_LEFT),
            'NIS' => $this->faker->unique()->numerify('##########'),
            'NamaAnggota' => $this->faker->name(),
            'TTL' => $this->faker->dateTimeThisDecade(),
            'Jenis_Kelamin' => $this->faker->randomElement(['L', 'P']),
            'Alamat' => $this->faker->address(),
            'Kelas' => $this->faker->randomElement(['X', 'XI', 'XII']) . ' ' . $this->faker->randomElement(['IPA', 'IPS']) . ' ' . $this->faker->numberBetween(1, 4),
            'NoTelp' => $this->faker->phoneNumber(),
            'NamaOrtu' => $this->faker->name(),
            'NoTelpOrtu' => $this->faker->phoneNumber(),
        ];
    }
}
