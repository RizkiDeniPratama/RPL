<?php
namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $dataBuku = [
        [
            'KodeBuku' => 'B0001',
            'NoUDC' => 'UDC510',
            'Judul' => 'Matematika Kelas VII',
            'Penerbit' => 'Erlangga',
            'Pengarang' => 'Sutrisno',
            'TahunTerbit' => 2021,
            'Deskripsi' => 'Buku pelajaran matematika untuk siswa SMP kelas 7.',
            'ISBN' => '9786020000011',
            'Stok' => 10,
        ],
        [
            'KodeBuku' => 'B0002',
            'NoUDC' => 'UDC500',
            'Judul' => 'IPA Terpadu Kelas VIII',
            'Penerbit' => 'Yudhistira',
            'Pengarang' => 'Rina Lestari',
            'TahunTerbit' => 2020,
            'Deskripsi' => 'Buku pelajaran IPA mencakup fisika, kimia, dan biologi.',
            'ISBN' => '9786020000022',
            'Stok' => 12,
        ],
        [
            'KodeBuku' => 'B0003',
            'NoUDC' => 'UDC300',
            'Judul' => 'IPS Kelas IX',
            'Penerbit' => 'Intan Pariwara',
            'Pengarang' => 'Slamet Widodo',
            'TahunTerbit' => 2021,
            'Deskripsi' => 'Ilmu Pengetahuan Sosial untuk kelas 9 SMP.',
            'ISBN' => '9786020000033',
            'Stok' => 11,
        ],
        [
            'KodeBuku' => 'B0004',
            'NoUDC' => 'UDC800',
            'Judul' => 'Bahasa Indonesia Kelas VII',
            'Penerbit' => 'Balai Pustaka',
            'Pengarang' => 'Rudi Hartanto',
            'TahunTerbit' => 2022,
            'Deskripsi' => 'Buku Bahasa Indonesia untuk siswa SMP.',
            'ISBN' => '9786020000044',
            'Stok' => 9,
        ],
        [
            'KodeBuku' => 'B0005',
            'NoUDC' => 'UDC800',
            'Judul' => 'Bahasa Inggris Kelas VIII',
            'Penerbit' => 'CV Andi',
            'Pengarang' => 'John Hartanto',
            'TahunTerbit' => 2019,
            'Deskripsi' => 'Materi Bahasa Inggris tingkat menengah.',
            'ISBN' => '9786020000055',
            'Stok' => 10,
        ],
        [
            'KodeBuku' => 'B0006',
            'NoUDC' => 'UDC700',
            'Judul' => 'Seni Budaya Kelas IX',
            'Penerbit' => 'Tiga Serangkai',
            'Pengarang' => 'Dewi Artina',
            'TahunTerbit' => 2020,
            'Deskripsi' => 'Buku Seni Budaya untuk SMP kelas 9.',
            'ISBN' => '9786020000066',
            'Stok' => 7,
        ],
        [
            'KodeBuku' => 'B0007',
            'NoUDC' => 'UDC600',
            'Judul' => 'Prakarya dan Kewirausahaan',
            'Penerbit' => 'Gramedia',
            'Pengarang' => 'Rina Kurniawati',
            'TahunTerbit' => 2021,
            'Deskripsi' => 'Buku prakarya dan kewirausahaan untuk siswa SMP.',
            'ISBN' => '9786020000077',
            'Stok' => 8,
        ],
        [
            'KodeBuku' => 'B0008',
            'NoUDC' => 'UDC200',
            'Judul' => 'Pendidikan Agama Islam Kelas VIII',
            'Penerbit' => 'Erlangga',
            'Pengarang' => 'Ahmad Nur',
            'TahunTerbit' => 2022,
            'Deskripsi' => 'Buku Pendidikan Agama Islam untuk siswa SMP.',
            'ISBN' => '9786020000088',
            'Stok' => 10,
        ],
        [
            'KodeBuku' => 'B0009',
            'NoUDC' => 'UDC100',
            'Judul' => 'Pendidikan Karakter',
            'Penerbit' => 'Bumi Aksara',
            'Pengarang' => 'Dwi Santosa',
            'TahunTerbit' => 2018,
            'Deskripsi' => 'Penguatan karakter siswa melalui nilai-nilai moral.',
            'ISBN' => '9786020000099',
            'Stok' => 6,
        ],
        [
            'KodeBuku' => 'B0010',
            'NoUDC' => 'UDC370',
            'Judul' => 'Metode Belajar Efektif',
            'Penerbit' => 'Yrama Widya',
            'Pengarang' => 'Dian Prasetyo',
            'TahunTerbit' => 2019,
            'Deskripsi' => 'Tips belajar mandiri dan aktif untuk siswa SMP.',
            'ISBN' => '9786020000100',
            'Stok' => 10,
        ],
        ];

        foreach ($dataBuku as $buku) {
            Buku::create($buku);
        }
    }
}