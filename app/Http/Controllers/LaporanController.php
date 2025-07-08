<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\AnggotaNonSiswa;
use App\Models\PengembalianSiswa;
use App\Models\PengembalianNonSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{   
    // Laporan Buku
    // public function laporanBuku(){
    //     $buku = Buku::all();

    //     return view('laporan.laporanBuku.index', compact('buku'));
    // }

    public function laporanBuku(Request $request){
    // Ambil filter tanggal dari request
    $start = $request->start_date
        ? Carbon::parse($request->start_date)->startOfDay()
        : null;

    $end = $request->end_date
        ? Carbon::parse($request->end_date)->endOfDay()
        : null;

    $query = Buku::query();

    // Filter berdasarkan kolom created_at
    if ($start && $end) {
        $query->whereBetween('created_at', [$start, $end]);
    }

    // Urutkan terbaru dan paginasi 10 per halaman
    $buku = $query->orderByDesc('created_at')->paginate(10);

    return view('laporan.laporanBuku.index', compact('buku', 'start', 'end'));
    }

    public function cetakLaporanBuku(Request $request)
    {
    $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
    $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

    $buku = Buku::whereBetween('created_at', [$startDate, $endDate])->get();

    $pdf = PDF::loadView('laporan.laporanBuku.cetak', compact('buku', 'startDate', 'endDate'));
    return $pdf->stream('laporan-buku.pdf');
    }

    public function laporanAnggota(Request $request){
    $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
    $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

    $anggotaSiswa = Anggota::whereBetween('created_at', [$startDate, $endDate])->get();
    $anggotaNonSiswa = AnggotaNonSiswa::whereBetween('created_at', [$startDate, $endDate])->get();

    return view('laporan.laporanAnggota.index', compact('anggotaSiswa', 'anggotaNonSiswa', 'startDate', 'endDate'));
    }

    public function cetakLaporanAnggota(Request $request){
    $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
    $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

    // Ambil anggota siswa dan beri atribut 'jenis'
    $anggotaSiswa = Anggota::whereBetween('created_at', [$startDate, $endDate])
        ->get()
        ->map(function ($item) {
            $item->jenis = 'Siswa';
            return $item;
        });

    // Ambil anggota non siswa dan beri atribut 'jenis'
    $anggotaNonSiswa = AnggotaNonSiswa::whereBetween('created_at', [$startDate, $endDate])
        ->get()
        ->map(function ($item) {
            $item->jenis = 'Non Siswa';
            return $item;
        });

    // Gabungkan semua data anggota
    $anggota = $anggotaSiswa->concat($anggotaNonSiswa)->sortBy('NamaAnggota')->values();

    return PDF::loadView('laporan.laporanAnggota.cetak', compact('anggota', 'startDate', 'endDate'))
        ->stream('laporan-anggota.pdf');
    }

    public function peminjaman(Request $request)
    {
    $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
    $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

    $peminjamanSiswa = PeminjamanSiswa::with([
            'anggota', 
            'petugas',
            'detailPeminjaman.buku',
            'detailPeminjaman.petugas'
        ])
        ->whereBetween('TglPinjam', [$startDate, $endDate])
        ->orderBy('TglPinjam', 'desc')
        ->get();

    $peminjamanNonSiswa = PeminjamanNonSiswa::with([
            'anggota', 
            'petugas',
            'detailPeminjaman.buku',
            'detailPeminjaman.petugas'
        ])
        ->whereBetween('TglPinjam', [$startDate, $endDate])
        ->orderBy('TglPinjam', 'desc')
        ->get();

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

    public function laporanPengembalian(Request $request){
    $start = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
    $end = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

    $kembaliSiswa = PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
        ->whereBetween('TglKembali', [$start, $end])
        ->get();

    $kembaliNonSiswa = PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
        ->whereBetween('TglKembali', [$start, $end])
        ->get();

    return view('laporan.laporanPengembalian.index', compact('kembaliSiswa', 'kembaliNonSiswa', 'start', 'end'));
        
    }

    public function cetakLaporanPengembalian(Request $request){
    $start = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
    $end = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

    $siswa = PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
        ->whereBetween('TglKembali', [$start, $end])
        ->get()
        ->map(function ($item) {
            return [
                'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                'Jenis' => 'Siswa',
                'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                'TglKembali' => $item->TglKembali,
                'Petugas' => $item->petugas->Nama ?? '-',
                'Denda' => $item->Denda,
            ];
        });

    $nonSiswa = PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
        ->whereBetween('TglKembali', [$start, $end])
        ->get()
        ->map(function ($item) {
            return [
                'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                'Jenis' => 'Non Siswa',
                'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                'TglKembali' => $item->TglKembali,
                'Petugas' => $item->petugas->Nama ?? '-',
                'Denda' => $item->Denda,
            ];
        });

    $pengembalian = $siswa->concat($nonSiswa);

    $pdf = PDF::loadView('laporan.laporanPengembalian.cetak', [
        'pengembalian' => $pengembalian,
        'startDate' => $start,
        'endDate' => $end,
    ]);

    return $pdf->stream("laporan-pengembalian-{$start->format('Ymd')}-{$end->format('Ymd')}.pdf");    
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
