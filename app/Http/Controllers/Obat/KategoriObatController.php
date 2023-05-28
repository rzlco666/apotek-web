<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat\KategoriObat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KategoriObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(KategoriObat::select('*'))
                ->addColumn('action', 'obat.kategori_obat.kategori_obat_action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('obat.kategori_obat.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $kategoriObatId = $request->id;

        $kategoriObat = KategoriObat::updateOrCreate(
            [
                'id' => $kategoriObatId
            ],
            [
                'nama_kategori' => $request->nama_kategori,
            ]);

        return Response()->json($kategoriObat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $kategoriObat = KategoriObat::findOrFail($request->id);

        return Response()->json($kategoriObat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $kategoriObat = KategoriObat::where('id', $request->id)->delete();

        return Response()->json($kategoriObat);
    }
}
