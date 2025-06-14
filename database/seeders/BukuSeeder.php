<?php
namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 50; $i++) {
            Buku::create([
                'KodeBuku' => sprintf('B%04d', $i),
                'NoUDC' => 'UDC' . $faker->numberBetween(100, 999),
                'Judul' => $faker->sentence(3),
                'Penerbit' => $faker->company,
                'Pengarang' => $faker->name,
                'TahunTerbit' => $faker->numberBetween(1950, 2024), // Tetap numberBetween untuk kompatibilitas dengan year()
                'Deskripsi' => $faker->paragraph,
                'ISBN' => $faker->isbn13,
                'Stok' => $faker->numberBetween(10, 50),
            ]);
        }
    }
}