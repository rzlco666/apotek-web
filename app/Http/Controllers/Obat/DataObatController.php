<?php

namespace App\Http\Controllers\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat\DataObat;
use App\Models\Obat\KategoriObat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DataObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = [
            'category_obat' => KategoriObat::orderBy('nama_kategori', 'asc')->get(),
        ];

        return view('obat.data_obat.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = DataObat::with('category_obat')->get();

        $actions = '
                    <button type="button" class="btn btn-info btn-xs detail-btn me-1" data-id="{{ $id }}" title="Detail">
                        <i class="icon-eye"></i>
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
            'kode_obat' => 'required|string|unique:obat,kode_obat,NULL,id,deleted_at,NULL',
            'nama_obat' => 'required',
            'dosis' => 'required',
            'kategori_obat_id' => 'required',
            'satuan' => 'required',
            'golongan' => 'required',
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
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'dosis' => $request->dosis,
            'kategori_obat_id' => $request->kategori_obat_id,
            'satuan' => $request->satuan,
            'golongan' => $request->golongan,
            'created_by' => Auth::user()->id
        ];

        $ref_kategori = DataObat::create($params);

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
        $data = DataObat::where('id', $id)->with('category_obat')->first();

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
            'kode_obat' => 'required|string|unique:obat,kode_obat,'.$id.',id,deleted_at,NULL',
            'nama_obat' => 'required',
            'dosis' => 'required',
            'kategori_obat_id' => 'required',
            'satuan' => 'required',
            'golongan' => 'required',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $ref_kategori = DataObat::where('id', $id)->first();

        if (!$ref_kategori) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        $ref_kategori->kode_obat = $request->kode_obat;
        $ref_kategori->nama_obat = $request->nama_obat;
        $ref_kategori->dosis = $request->dosis;
        $ref_kategori->kategori_obat_id = $request->kategori_obat_id;
        $ref_kategori->satuan = $request->satuan;
        $ref_kategori->golongan = $request->golongan;
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
        $ref_kategori = DataObat::where('id', $id)->first();

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
