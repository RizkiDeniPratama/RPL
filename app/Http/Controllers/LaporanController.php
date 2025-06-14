<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Get student loans
        $peminjamanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get non-student loans
        $peminjamanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');

        return view('laporan.peminjaman.index', compact('peminjaman', 'startDate', 'endDate'));
    }

    public function cetakPeminjaman(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Get student loans
        $peminjamanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get non-student loans
        $peminjamanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');

        $pdf = PDF::loadView('laporan.peminjaman.cetak', compact('peminjaman', 'startDate', 'endDate'));
        return $pdf->stream('laporan-peminjaman.pdf');
    }

    public function keterlambatan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $today = Carbon::now();

        // Get late student loans
        $keterlambatanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get late non-student loans
        $keterlambatanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');

        return view('laporan.keterlambatan.index', compact('keterlambatan', 'startDate', 'endDate'));
    }

    public function cetakKeterlambatan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $today = Carbon::now();

        // Get late student loans
        $keterlambatanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get late non-student loans
        $keterlambatanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');

        $pdf = PDF::loadView('laporan.keterlambatan.cetak', compact('keterlambatan', 'startDate', 'endDate'));
        return $pdf->stream('laporan-keterlambatan.pdf');
    }

    public function bukuPopuler(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $bukuPopuler = Buku::withCount(['detailPeminjamanSiswa as peminjaman_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }, 'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }])
        ->with(['kategori', 'rak'])
        ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
        ->limit(10)
        ->get()
        ->map(function($buku) {
            $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
            return $buku;
        });

        return view('laporan.buku-populer.index', compact('bukuPopuler', 'startDate', 'endDate'));
    }

    public function cetakBukuPopuler(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $bukuPopuler = Buku::withCount(['detailPeminjamanSiswa as peminjaman_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }, 'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }])
        ->with(['kategori', 'rak'])
        ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
        ->limit(10)
        ->get()
        ->map(function($buku) {
            $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
            return $buku;
        });

        $pdf = PDF::loadView('laporan.buku-populer.cetak', compact('bukuPopuler', 'startDate', 'endDate'));
        return $pdf->stream('laporan-buku-populer.pdf');
    }
}
