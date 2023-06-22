<?php

namespace App\Http\Controllers;

use App\Models\Obat\ExpObat;
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
        return view('home');
    }

    public function notification(Request $request)
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $data = ExpObat::with('data_obat')
            ->whereDate('tanggal_kadaluwarsa', $today)
            ->orWhereDate('tanggal_kadaluwarsa', $tomorrow)
            ->orderBy('tanggal_kadaluwarsa', 'asc')
            ->limit(5)
            ->get();

        return response()->json($data);
    }

}
