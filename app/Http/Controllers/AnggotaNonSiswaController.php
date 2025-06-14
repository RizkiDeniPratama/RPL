<?php

namespace App\Http\Controllers;

use App\Models\AnggotaNonSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnggotaNonSiswaController extends Controller
{
    public function index()
    {
        $anggota_non_siswa = AnggotaNonSiswa::latest()->paginate(10);
        return view('anggota-non-siswa.index', compact('anggota_non_siswa'));
    }

    public function create()
    {
        return view('anggota-non-siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NoAnggotaN' => 'required|string|unique:anggota_non_siswa,NoAnggotaN',
            'NIP' => 'required|string|max:20',
            'NamaAnggota' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:100',
            'TTL' => 'required|date',
            'Alamat' => 'required|string',
            'KodePos' => 'required|string|max:10',
            'NoTelpHp' => 'required|string|max:15',
        ]);

        $data = $request->all();
        $data['TglDaftar'] = Carbon::now();

        AnggotaNonSiswa::create($data);

        return redirect()->route('anggota-non-siswa.index')
            ->with('success', 'Anggota non siswa berhasil ditambahkan.');
    }

    public function show(AnggotaNonSiswa $anggota_non_siswa)
    {
        return view('anggota-non-siswa.show', ['anggotaNonSiswa' => $anggota_non_siswa]);
    }

    public function edit(AnggotaNonSiswa $anggota_non_siswa)
    {
        return view('anggota-non-siswa.edit', ['anggotaNonSiswa' => $anggota_non_siswa]);
    }

    public function update(Request $request, AnggotaNonSiswa $anggota_non_siswa)
    {

        $request->validate([
            'NIP' => 'required|string|max:20',
            'NamaAnggota' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:100',
            'TTL' => 'required|date',
            'Alamat' => 'required|string',
            'KodePos' => 'required|string|max:10',
            'NoTelpHp' => 'required|string|max:15',
        ]);

        $anggota_non_siswa->update($request->all());

        return redirect()->route('anggota-non-siswa.index')
            ->with('success', 'Anggota non siswa berhasil diperbarui.');
    }

    public function destroy(AnggotaNonSiswa $anggota_non_siswa)
    {
        $anggota_non_siswa->delete();

        return redirect()->route('anggota-non-siswa.index')
            ->with('success', 'Anggota non siswa berhasil dihapus.');
    }
}