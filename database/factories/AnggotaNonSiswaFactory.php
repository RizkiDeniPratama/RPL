<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnggotaNonSiswa>
 */
class AnggotaNonSiswaFactory extends Factory
{
    private static $noAnggota = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaGuru = [
            'Dr. Sri Wahyuni, M.Pd',
            'Ahmad Budiman, S.Kom'
        ];

        $jabatan = [
            'Guru Bahasa Indonesia',
            'Guru Teknologi Informasi'
        ];

        $nip = [
            '196508121990032001',
            '198703152010011004'
        ];

        $index = (self::$noAnggota - 1) % 2;

        $tanggalLahir = $this->faker->dateTimeBetween('-95 years', '-20 years');
        $tempatLahir = $this->faker->randomElement([
            'Tepal', 'Sumbawa', 'Pusu', 'Bao Desa', 'Batu Rotok', 'Kelungkung', 'Tangkam Pulit', 'Mataram',
            'Lombok', 'Sumbawa Barat'
        ]);

        return [
            'NoAnggotaN' => 'N' . str_pad(self::$noAnggota++, 4, '0', STR_PAD_LEFT),
            'NIP' => $nip[$index],
            'NamaAnggota' => $namaGuru[$index],
            'Jabatan' => $jabatan[$index],
            'TTL' => $tempatLahir . ', ' . $tanggalLahir->format('d-m-Y'),
            'Alamat' => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'KodePos' => $this->faker->numerify('#####'), 
            'NoTelpHp' => '08' . $this->faker->numerify('##########'),
        ];
    }
}