<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat\DataObat;
use App\Models\Obat\StokObat;
use App\Models\Supplier\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StokObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return view('obat.stok_obat.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = StokObat::with('category_obat', 'exp_obat', 'in_obat', 'out_obat')->get();

        $actions = '
        <button type="button" class="btn btn-info btn-xs detail-btn me-1" data-id="{{ $id }}" title="Detail">
            <i class="icon-eye"></i>
        </button>
    ';

        $datatable = DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('action', $actions)
            ->addColumn('sisa_stok', function ($row) {
                $total_jumlah_in = $row->in_obat->total_jumlah_in ?? 0;
                $total_jumlah_out = $row->out_obat->total_jumlah_out ?? 0;
                $sisa_stok = $total_jumlah_in - $total_jumlah_out;

                return $sisa_stok;
            })
            ->addColumn('total_jumlah_in', function ($row) {
                return $row->in_obat->total_jumlah_in ?? '-';
            })
            ->addColumn('total_jumlah_out', function ($row) {
                return $row->out_obat->total_jumlah_out ?? '-';
            })
            ->editColumn('exp_obat.tanggal_kadaluwarsa', function ($row) {
                return $row->exp_obat->tanggal_kadaluwarsa ?? '-';
            })
            ->rawColumns(['action'])
            ->toJson();

        return $datatable;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = StokObat::where('id', $id)->with('category_obat', 'exp_obat', 'in_obat', 'out_obat')->first();

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

}
