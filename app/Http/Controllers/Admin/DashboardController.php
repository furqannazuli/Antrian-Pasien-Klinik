<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tanggal yang ditampilkan di dashboard (bisa diganti via query string kalau mau)
        $tanggal = $request->input('tanggal', now()->toDateString());

        // Statistik global antrian hari itu
        $totalHariIni    = Antrian::whereDate('created_at', $tanggal)->count();
        $menungguHariIni = Antrian::whereDate('created_at', $tanggal)->where('status', 'menunggu')->count();
        $dipanggilHariIni= Antrian::whereDate('created_at', $tanggal)->where('status', 'dipanggil')->count();
        $selesaiHariIni  = Antrian::whereDate('created_at', $tanggal)->where('status', 'selesai')->count();

        // Statistik per poli (jumlah total + menunggu)
        $statsByPoli = Antrian::with('poli')
            ->selectRaw('poli_id,
                COUNT(*) as total,
                SUM(CASE WHEN status = "menunggu" THEN 1 ELSE 0 END) as menunggu,
                SUM(CASE WHEN status = "dipanggil" THEN 1 ELSE 0 END) as dipanggil,
                SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as selesai')
            ->whereDate('created_at', $tanggal)
            ->groupBy('poli_id')
            ->get();

        $tanggalHuman = Carbon::parse($tanggal)->translatedFormat('d F Y');

        return view('admin.dashboard.index', compact(
            'tanggal',
            'tanggalHuman',
            'totalHariIni',
            'menungguHariIni',
            'dipanggilHariIni',
            'selesaiHariIni',
            'statsByPoli',
        ));
    }
}
