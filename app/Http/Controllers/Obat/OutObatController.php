<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat\DataObat;
use App\Models\Obat\OutObat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OutObatController extends Controller
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

        return view('obat.out_obat.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = OutObat::with('data_obat')->get();

        $actions = '
                    <button type="button" class="btn btn-info btn-sm detail-btn me-1" data-id="{{ $id }}" title="Detail">
                        <i class="icon-eye"></i>
                    </button>
                    ';
        if (Auth::user()->can('edit obat')) {
            $actions .= '<button class="btn btn-sm btn-warning edit-btn me-1" data-id="{{ $id }}" title="Edit">
                            <i class="icon-pencil"></i>
                        </button>';
        }
        if (Auth::user()->can('delete obat')) {
            $actions .= '<button class="btn btn-sm btn-danger delete-btn me-1" data-id="{{ $id }}" title="Delete">
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
            'obat_id' => 'required',
            'tanggal_keluar' => 'required',
            'jumlah_out' => 'required',
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
            'obat_id' => $request->obat_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah_out' => $request->jumlah_out,
            'created_by' => Auth::user()->id
        ];

        $ref_kategori = OutObat::create($params);

        if ($ref_kategori) {
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
        $data = OutObat::where('id', $id)->with('data_obat', 'data_obat.category_obat')->first();

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'obat_id' => 'required',
            'tanggal_keluar' => 'required',
            'jumlah_out' => 'required',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $ref_kategori = OutObat::where('id', $id)->first();

        if (!$ref_kategori) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        $ref_kategori->obat_id = $request->obat_id;
        $ref_kategori->tanggal_keluar = $request->tanggal_keluar;
        $ref_kategori->jumlah_out = $request->jumlah_out;
        $ref_kategori->updated_by = Auth::user()->id;

        if ($ref_kategori->save()) {
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
        $ref_kategori = OutObat::where('id', $id)->first();

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
