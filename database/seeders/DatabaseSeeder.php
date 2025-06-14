<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset auto-increment
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Create users
        $this->call([
            PetugasSeeder::class,
            BukuSeeder::class,
            AnggotaSeeder::class,
            DetailPeminjamanSiswaSeeder::class,
            DetailPeminjamanNonSiswaSeeder::class,
            LaporanSeeder::class,
            PeminjamanSiswaSeeder::class,
            PeminjamanNonSiswaSeeder::class,
            PetugasSeeder::class,
            PinjamDetailSeeder::class,
        ]);
    }
}
//         $petugas = Petugas::factory(5)->create();
//         $anggotas = Anggota::factory(20)->create();
//         $anggotaNonSiswa = AnggotaNonSiswa::factory(20)->create();
//         $buku = Buku::factory(20)->create();

//         //Create peminjaman siswa and its details
//         for ($i = 0; $i < 15; $i++) {
//             $anggota = $anggotas->random();
//             $peminjaman = PeminjamanSiswa::create([
//                 'NoPinjamM' => 'PJM-S-' . now()->format('ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
//                 'TglPinjam' => now()->subDays(rand(1, 30)),
//                 'TglJatuhTempo' => now()->addDays(7),
//                 'NoAnggotaM' => $anggota->NoAnggotaM,
//                 'KodePetugas' => $petugas->random()->KodePetugas,
//             ]);

//             // Create 1-3 detail peminjaman
//             $detailCount = rand(1, 3);
//             $bukuList = Buku::inRandomOrder()->limit($detailCount)->get();
            
//             foreach($bukuList as $buku) {
//                 DetailPeminjamanSiswa::create([
//                     'NoPinjamM' => $peminjaman->NoPinjamM,
//                     'KodeBuku' => $buku->KodeBuku,
//                     'KodePetugas' => $petugas->random()->KodePetugas,
//                 ]);
//             }

//             // 70% chance of being returned
//             if (rand(1, 100) <= 70) {
//                 PengembalianSiswa::create([
//                     'NoKembaliM' => 'KBL-S-' . now()->format('ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
//                     'NoPinjamM' => $peminjaman->NoPinjamM,
//                     'TglKembali' => now(),
//                     'Denda' => rand(0, 1) ? rand(1000, 50000) : 0,
//                     'KodePetugas' => $petugas->random()->KodePetugas,
//                 ]);
//             }
//         }

//         // Create peminjaman non siswa and its details
//         for ($i = 0; $i < 10; $i++) {
//             $anggota = $anggotaNonSiswa->random();
//             $peminjaman = PeminjamanNonSiswa::create([
//                 'NoPinjamN' => 'PJM-N-' . now()->format('ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
//                 'TglPinjam' => now()->subDays(rand(1, 30)),
//                 'TglJatuhTempo' => now()->addDays(7),
//                 'NoAnggotaN' => $anggota->NoAnggotaN,
//                 'KodePetugas' => $petugas->random()->KodePetugas,
//             ]);

//             // Create 1-3 detail peminjaman
//             $detailCount = rand(1, 3);
//             $bukuList = Buku::inRandomOrder()->limit($detailCount)->get();
            
//             foreach($bukuList as $buku) {
//                 DetailPeminjamanNonSiswa::create([
//                     'NoPinjamN' => $peminjaman->NoPinjamN,
//                     'KodeBuku' => $buku->KodeBuku,
//                     'KodePetugas' => $petugas->random()->KodePetugas,
//                 ]);
//             }

//             // 70% chance of being returned
//             if (rand(1, 100) <= 70) {
//                 PengembalianNonSiswa::create([
//                     'NoKembaliN' => 'KBL-N-' . now()->format('ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
//                     'NoPinjamN' => $peminjaman->NoPinjamN,
//                     'TglKembali' => now(),
//                     'Denda' => rand(0, 1) ? rand(1000, 50000) : 0,
//                     'KodePetugas' => $petugas->random()->KodePetugas,
//                 ]);
//             }
//         }

//         DB::statement('SET FOREIGN_KEY_CHECKS=1');
//      }
// }
