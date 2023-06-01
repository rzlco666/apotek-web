<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return view('supplier.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = Supplier::all();

        $actions = '
                    <button type="button" class="btn btn-info btn-xs detail-btn me-1" data-id="{{ $id }}" title="Detail">
                        <i class="icon-eye"></i>
                    </button>
                    ';
        if (Auth::user()->can('edit kategori obat')) {
            $actions .= '<button class="btn btn-xs btn-warning edit-btn me-1" data-id="{{ $id }}" title="Edit">
                            <i class="icon-pencil"></i>
                        </button>';
        }
        if (Auth::user()->can('delete kategori obat')) {
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
            'nama_perusahaan' => 'required|string|unique:supplier,nama_perusahaan,NULL,id,deleted_at,NULL',
            'alamat' => 'required',
            'telepon' => 'required',
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
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'created_by' => Auth::user()->id
        ];

        $ref_kategori = Supplier::create($params);

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
        $data = Supplier::where('id', $id)->first();

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
            'nama_perusahaan' => 'required|string|unique:supplier,nama_perusahaan,'.$id.',id,deleted_at,NULL',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $ref_kategori = Supplier::where('id', $id)->first();

        if (!$ref_kategori) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        $ref_kategori->nama_perusahaan = $request->nama_perusahaan;
        $ref_kategori->alamat = $request->alamat;
        $ref_kategori->telepon = $request->telepon;
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
        $ref_kategori = Supplier::where('id', $id)->first();

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
