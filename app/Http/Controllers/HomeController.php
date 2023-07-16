<?php

namespace App\Http\Controllers;

use App\Models\Faktur\DataFaktur;
use App\Models\Obat\DataObat;
use App\Models\Obat\ExpObat;
use App\Models\Obat\StokObat;
use App\Models\Pesanan\SuratPesanan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+31 day'));

        $totalFaktur = DataFaktur::count();
        $totalObat = DataObat::count();
        $totalSuratPesanan = SuratPesanan::count();
        $expiredMedicines = ExpObat::with('data_obat')
            ->whereBetween('tanggal_kadaluwarsa', [$today, $tomorrow])
            ->orderBy('tanggal_kadaluwarsa', 'asc')
            ->take(10)
            ->get();
        $stokObat = StokObat::with('category_obat', 'exp_obat', 'in_obat', 'out_obat')->get();

        return view('home', compact('totalFaktur', 'totalObat', 'totalSuratPesanan', 'expiredMedicines', 'stokObat'));
    }

    public function notification(Request $request)
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $data = ExpObat::with('data_obat')
            ->whereBetween('tanggal_kadaluwarsa', [$today, $tomorrow])
            ->orderBy('tanggal_kadaluwarsa', 'asc')
            ->limit(5)
            ->get();

        return response()->json($data);
    }

}
