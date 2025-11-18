<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;
use App\Models\Antrian;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    public function create()
    {
        $polis = Poli::orderBy('nama_poli')->get();

        return view('antrian.form', [
            'polis' => $polis,
        ]);
    }


    public function store(Request $request)
    {
        $data = $request ->validate([
       'nama_pasien'      => ['required', 'string', 'max:255'],
        'nik'              => ['required', 'string', 'max:20'],
        'jenis_kelamin'    => ['required', 'in:L,P'],
        'no_hp'            => ['required', 'string', 'max:20'],
        'alamat'           => ['required', 'string', 'max:500'],
        'tanggal_lahir'    => ['nullable', 'date'],
        'poli_id'          => ['required', 'exists:polis,id'],
        'keluhan'          => ['nullable', 'string'],
        'jenis_pembayaran' => ['required', 'in:bpjs,umum'],

        ]);
         $antrian = DB::transaction(function () use ($data) {

            // cari nomor antrian berikutnya untuk poli ini, hari ini
            $today = now()->toDateString();

            $lastNumber = Antrian::where('poli_id', $data['poli_id'])
                ->whereDate('created_at', $today)
                ->max('nomor_antrian');

            $nextNumber = ($lastNumber ?? 0) + 1;

            // aturan: 1 pasien = 5 menit (bisa kamu ubah)
            $menitPerPasien = 5;

            // estimasi: sekarang + (nextNumber - 1) * 5 menit
            // atau bebas mau pakai logika lain
            $estimasi = now()->addMinutes(($nextNumber - 1) * $menitPerPasien);

            return Antrian::create([
            'nama_pasien'      => $data['nama_pasien'],
            'nik'              => $data['nik'],
            'jenis_kelamin'    => $data['jenis_kelamin'],
            'no_hp'            => $data['no_hp'],
            'alamat'           => $data['alamat'],
            'tanggal_lahir'    => $data['tanggal_lahir'] ?? null,
            'poli_id'          => $data['poli_id'],
            'keluhan'          => $data['keluhan'] ?? null,
            'jenis_pembayaran' => $data['jenis_pembayaran'],
            'nomor_antrian'    => $nextNumber,
            'estimasi_waktu'   => $estimasi,
            'status'           => 'menunggu',
            ]);
        });
        $nomorSedangDipanggil = Antrian::where('poli_id', $antrian->poli_id)
            ->whereDate('created_at', now()->toDateString())
            ->where('status', 'dipanggil')
            ->max('nomor_antrian') ?? 0;

        $jumlahMenungguDiDepan = Antrian::where('poli_id', $antrian->poli_id)
            ->whereDate('created_at', now()->toDateString())
            ->where('status', 'menunggu')
            ->where('nomor_antrian', '<', $antrian->nomor_antrian)
            ->count();

        return view('antrian.tiket', [
            'antrian'              => $antrian->load('poli'),
            'nomorSedangDipanggil' => $nomorSedangDipanggil,
            'jumlahMenungguDiDepan'=> $jumlahMenungguDiDepan,
        ]);


    }
     public function cekForm()
    {
        $polis = Poli::orderBy('nama_poli')->get();
        return view('antrian.cek', compact('polis'));
    }

    /**
     * Proses cek antrian berdasarkan nomor.
     */
 public function cek(Request $request)
{
    $mode = $request->input('mode', 'nomor');

    $rules = [
        'poli_id' => ['required', 'exists:polis,id'],
        'nomor_antrian' => ['nullable', 'integer', 'min:1'],
        'nik' => ['nullable', 'string', 'max:20'],
    ];

    if ($mode === 'nomor') {
        $rules['nomor_antrian'][] = 'required';
    } else {
        $rules['nik'][] = 'required';
    }

    $data = $request->validate($rules, [
        'nomor_antrian.required' => 'Silakan isi nomor antrian.',
        'nik.required' => 'Silakan isi NIK.',
    ]);

    $query = Antrian::with('poli')
        ->where('poli_id', $data['poli_id'])
        ->whereDate('created_at', now()->toDateString());

    if ($mode === 'nomor') {
        $query->where('nomor_antrian', $data['nomor_antrian']);
    } else {
        $query->where('nik', $data['nik']);
    }

    $antrian = $query->first();

    if (! $antrian) {
        return back()
            ->withInput()
            ->with('error', 'Data antrian dengan data tersebut tidak ditemukan untuk hari ini.');
    }

    $nomorSedangDipanggil = Antrian::where('poli_id', $antrian->poli_id)
        ->whereDate('created_at', now()->toDateString())
        ->where('status', 'dipanggil')
        ->max('nomor_antrian') ?? 0;

    $jumlahMenungguDiDepan = Antrian::where('poli_id', $antrian->poli_id)
        ->whereDate('created_at', now()->toDateString())
        ->where('status', 'menunggu')
        ->where('nomor_antrian', '<', $antrian->nomor_antrian)
        ->count();

    return view('antrian.hasil_cek', [
        'antrian'               => $antrian,
        'nomorSedangDipanggil'  => $nomorSedangDipanggil,
        'jumlahMenungguDiDepan' => $jumlahMenungguDiDepan,
    ]);
}

}



