<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;
use App\Models\Antrian;

class AdminAntrianController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $poliId = $request->input('poli_id');

        $polis = Poli::orderBy('nama_poli')->get();

        $query = Antrian::with('poli')
            ->whereDate('created_at', $tanggal)
            ->orderBy('poli_id')
            ->orderBy('nomor_antrian');
        if ($poliId) {
            $query->where('poli_id', $poliId);
        }
        $antrians = $query->get();

        $sedangDipanggil = Antrian::select('poli_id', 'nomor_antrian')
        ->whereDate('created_at', $tanggal)
        ->where('status', 'dipanggil')
        ->get()
        ->groupBy('poli_id');

        return view('admin.antrian.index', compact(
            'antrians', 'polis', 'tanggal', 'poliId', 'sedangDipanggil'));
    }
     public function panggil(Antrian $antrian)
    {
        // pastikan hanya antrian hari ini yang dioperasikan
        if (! $antrian->created_at->isToday()) {
            return back()->with('error', 'Hanya antrian hari ini yang dapat dipanggil.');
        }

        // reset antrian lain yang statusnya dipanggil di poli ini (hari ini)
        Antrian::where('poli_id', $antrian->poli_id)
            ->whereDate('created_at', now()->toDateString())
            ->where('status', 'dipanggil')
            ->where('id', '!=', $antrian->id)
            ->update(['status' => 'menunggu']);

        // set antrian ini jadi dipanggil
        $antrian->update([
            'status' => 'dipanggil',
        ]);

        return back()->with('success', 'Nomor antrian '.$antrian->nomor_antrian.' sedang dipanggil.');
    }

    /**
     * Tandai antrian sebagai "selesai".
     */
    public function selesai(Antrian $antrian)
    {
        if (! $antrian->created_at->isToday()) {
            return back()->with('error', 'Hanya antrian hari ini yang dapat diperbarui.');
        }

        $antrian->update([
            'status' => 'selesai',
        ]);

        return back()->with('success', 'Nomor antrian '.$antrian->nomor_antrian.' telah diselesaikan.');
    }
}
