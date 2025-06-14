<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnggotaNonSiswa>
 */
class AnggotaNonSiswaFactory extends Factory
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
            'NoAnggotaN' => 'N' . str_pad($noAnggota++, 4, '0', STR_PAD_LEFT),
            'NIP' => $this->faker->unique()->numerify('##########'),
            'NamaAnggota' => $this->faker->name(),
            'Jabatan' => $this->faker->jobTitle(),
            'TTL' => $this->faker->dateTimeThisDecade(),
            'Alamat' => $this->faker->address(),
            'KodePos' => $this->faker->postcode(),
            'NoTelpHp' => $this->faker->phoneNumber(),
            'TglDaftar' => now(),
        ];
    }
}
