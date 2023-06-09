<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Models\Obat\DataObat;
use App\Models\Pesanan\SuratPesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SuratPesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = [
            'data_obat' => DataObat::orderBy('nama_obat', 'asc')->get(),
        ];

        return view('pesanan.surat_pesanan.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = SuratPesanan::with('data_obat')->get();

        $actions = '
                    <button type="button" class="btn btn-info btn-xs detail-btn me-1" data-id="{{ $id }}" title="Detail">
                        <i class="icon-eye"></i>
                    </button>

                    <button type="button" class="btn btn-primary btn-xs print-btn me-1" data-id="{{ $id }}" title="Print">
                        <i class="icon-printer"></i>
                    </button>
                    ';
        if (Auth::user()->can('edit obat')) {
            $actions .= '<button class="btn btn-xs btn-warning edit-btn me-1" data-id="{{ $id }}" title="Edit">
                            <i class="icon-pencil"></i>
                        </button>';
        }
        if (Auth::user()->can('delete obat')) {
            $actions .= '<button class="btn btn-xs btn-danger delete-btn me-1" data-id="{{ $id }}" title="Delete">
                            <i class="icon-trash"></i>
                        </button>';
        }
        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn(
                'action',
                $actions
            )
            ->addColumn('last_modified', function ($item) {
                return $item->last_modified;
            })
            ->rawColumns(['last_modified', 'action'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required',
            'tanggal_pesanan' => 'required',
            'obat_id.*' => 'required',
            'jumlah_out.*' => 'required',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $params = [
            'nama_perusahaan' => $request->nama_perusahaan,
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'created_by' => Auth::user()->id
        ];

        $suratPesanan = SuratPesanan::create($params);

        if ($suratPesanan) {
            $obatData = [];
            foreach ($request->obat_id as $index => $obatId) {
                $obatArr = explode('-', $obatId);
                $obatData[] = [
                    'obat_id' => $obatArr[0],
                    'nama_obat' => $obatArr[1],
                    'jumlah_out' => $request->jumlah_out[$index]
                ];
            }
            $suratPesanan->obat = $obatData;
            $suratPesanan->save();

            $result = [
                'code' => 200,
                'status' => true,
                'message' => 'Save data success'
            ];
        } else {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => 'Save data failed'
            ];
        }

        return response()->json($result, $result['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SuratPesanan::where('id', $id)->with('data_obat', 'data_obat.category_obat')->first();

        if ($data) {
            $result = [
                'code' => 200,
                'status' => true,
                'message' => 'Get data success',
                'data' => $data
            ];
        } else {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
        }

        return response()->json($result, $result['code']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function pdf($id)
    {
        $data = SuratPesanan::where('id', $id)->with('data_obat', 'data_obat.category_obat')->first();

        return view('pesanan.surat_pesanan.pdf', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required',
            'tanggal_pesanan' => 'required',
            'obat_id.*' => 'required',
            'jumlah_out.*' => 'required',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $suratPesanan = SuratPesanan::find($id);

        if (!$suratPesanan) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        $suratPesanan->nama_perusahaan = $request->nama_perusahaan;
        $suratPesanan->tanggal_pesanan = $request->tanggal_pesanan;

        if ($suratPesanan) {
            $obatData = [];
            foreach ($request->obat_id as $index => $obatId) {
                $obatArr = explode('-', $obatId);
                $obatData[] = [
                    'obat_id' => $obatArr[0],
                    'nama_obat' => $obatArr[1],
                    'jumlah_out' => $request->jumlah_out[$index]
                ];
            }
            $suratPesanan->obat = $obatData;
            $suratPesanan->save();

            $result = [
                'code' => 200,
                'status' => true,
                'message' => 'Save data success'
            ];
        } else {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => 'Save data failed'
            ];
        }

        return response()->json($result, $result['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref_kategori = SuratPesanan::where('id', $id)->first();

        if (!$ref_kategori) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        if ($ref_kategori->delete()) {
            $result = [
                'code' => 200,
                'status' => true,
                'message' => 'Delete data success'
            ];
        } else {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => 'Delete data failed'
            ];
        }
        return response()->json($result, $result['code']);
    }

}
