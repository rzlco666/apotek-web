<?php

namespace App\Http\Controllers\Faktur;

use App\Http\Controllers\Controller;
use App\Models\Faktur\DataFaktur;
use App\Models\Pesanan\SuratPesanan;
use App\Models\Obat\DataObat;
use App\Models\Obat\InObat;
use App\Models\Obat\ExpObat;
use App\Models\Supplier\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DataFakturController extends Controller
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
            'data_supplier' => Supplier::orderBy('nama_perusahaan', 'asc')->get(),
            'data_surat_pesanan' => SuratPesanan::orderBy('id', 'asc')->get(),
        ];

        return view('faktur.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = DataFaktur::with('data_obat', 'data_supplier', 'data_surat_pesanan')->get();

        $actions = '<button type="button" class="btn btn-info btn-xs detail-btn me-1" data-id="{{ $id }}" title="Detail">
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
            ->addColumn('bukti_path', function ($item) {
                return $item->bukti_path;
            })
            ->addColumn('bukti', function ($item) {
                return $item->bukti;
            })
            ->rawColumns(['last_modified', 'action', 'bukti_path', 'bukti'])
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
            'obat_id.*' => 'required',
            'jumlah.*' => 'required',
            'jumlah_pesan.*' => 'required',
            'harga_jual.*' => 'required',
            'harga_beli.*' => 'required',
            'tanggal_kadaluwarsa.*' => 'required',
            'tanggal_faktur' => 'required',
            'total_obat' => 'required',
            'total_bayar' => 'required',
            'supplier_id' => 'required',
            'id_surat_pesanan' => 'required',
            'bukti' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:2048',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $total_bayar = str_replace(['Rp. ', '.'], '', $request->total_bayar);

        $params = [
            'tanggal_faktur' => $request->tanggal_faktur,
            'total_obat' => $request->total_obat,
            'total_bayar' => $total_bayar,
            'supplier_id' => $request->supplier_id,
            'id_surat_pesanan' => $request->id_surat_pesanan,
            'created_by' => Auth::user()->id
        ];

        $ref_kategori = DataFaktur::create($params);
        if ($ref_kategori) {
            $obatData = [];
            foreach ($request->obat_id as $index => $obatId) {
                $obatArr = explode('-', $obatId);
                $obatData[] = [
                    'obat_id' => $obatArr[0],
                    'nama_obat' => $this->getNameObat($obatArr[0]),
                    'jumlah' => $request->jumlah[$index],
                    'jumlah_pesan' => $request->jumlah_pesan[$index],
                    'harga_jual' => $request->harga_jual[$index],
                    'harga_beli' => $request->harga_beli[$index],
                    'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa[$index],
                ];

                $dataObatIn['obat_id'] = $obatArr[0];
                $dataObatIn['tanggal_masuk'] = Carbon::now();
                $dataObatIn['jumlah_in'] = $request->jumlah[$index];
                $dataObatIn['harga_beli'] = $request->harga_beli[$index];
                $dataObatIn['harga_jual'] = $request->harga_jual[$index];
                $dataObatIn['supplier_id'] = $request->supplier_id;
                $dataObatIn['created_by'] = Auth::user()->id;
                InObat::create($dataObatIn);

                $dataObatExp['obat_id'] = $obatArr[0];
                $dataObatExp['tanggal_kadaluwarsa'] = $request->tanggal_kadaluwarsa[$index];
                $dataObatExp['created_by'] = Auth::user()->id;
                ExpObat::create($dataObatExp);
            }
            $ref_kategori->obat = $obatData;
            $ref_kategori->save();

            if ($request->hasFile('bukti')) {
                $bukti = $request->file('bukti');
                $bukti_name = $bukti->hashName();
                $bukti_origin = $bukti->getClientOriginalName();
                $bukti_type = $bukti->extension();
                $bukti_size = $bukti->getSize();

                $upload_bukti = $request->file('bukti')->storeAs(
                    'faktur/bukti',
                    $bukti_name,
                    'public'
                );

                if ($upload_bukti) {
                    $ref_kategori->bukti = $bukti_name;
                    $ref_kategori->bukti_origin = $bukti_origin;
                    $ref_kategori->bukti_path = 'storage/faktur/bukti';
                    $ref_kategori->bukti_type = $bukti_type;
                    $ref_kategori->bukti_size = $bukti_size;
                    $ref_kategori->save();
                }
            }


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
        $data = DataFaktur::where('id', $id)->with('data_obat', 'data_obat.category_obat', 'data_supplier', 'data_surat_pesanan')->first();

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
            'obat_id.*' => 'required',
            'jumlah.*' => 'required',
            'jumlah_pesan.*' => 'required',
            'harga_jual.*' => 'required',
            'harga_beli.*' => 'required',
            'tanggal_kadaluwarsa.*' => 'required',
            'tanggal_faktur' => 'required',
            'total_obat' => 'required',
            'total_bayar' => 'required',
            'supplier_id' => 'required',
            'id_surat_pesanan' => 'required',
            'bukti' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:2048',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $ref_kategori = DataFaktur::where('id', $id)->first();

        if (!$ref_kategori) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        $total_bayar = str_replace(['Rp. ', '.'], '', $request->total_bayar);

        $ref_kategori->tanggal_faktur = $request->tanggal_faktur;
        $ref_kategori->total_obat = $request->total_obat;
        $ref_kategori->total_bayar = $total_bayar;
        $ref_kategori->supplier_id = $request->supplier_id;
        $ref_kategori->id_surat_pesanan = $request->id_surat_pesanan;
        $ref_kategori->updated_by = Auth::user()->id;

        if ($ref_kategori) {
            $obatData = [];
            foreach ($request->obat_id as $index => $obatId) {
                $obatArr = explode('-', $obatId);
                $obatData[] = [
                    'obat_id' => $obatArr[0],
                    'nama_obat' => $this->getNameObat($obatArr[0]),
                    'jumlah' => $request->jumlah[$index],
                    'jumlah_pesan' => $request->jumlah_pesan[$index],
                    'harga_jual' => $request->harga_jual[$index],
                    'harga_beli' => $request->harga_beli[$index],
                    'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa[$index],
                ];

                $dataObatIn['obat_id'] = $obatArr[0];
                $dataObatIn['tanggal_masuk'] = Carbon::now();
                $dataObatIn['jumlah_in'] = $request->jumlah[$index];
                $dataObatIn['harga_beli'] = $request->harga_beli[$index];
                $dataObatIn['harga_jual'] = $request->harga_jual[$index];
                $dataObatIn['supplier_id'] = $request->supplier_id;
                $dataObatIn['created_by'] = Auth::user()->id;
                InObat::create($dataObatIn);

                $dataObatExp['obat_id'] = $obatArr[0];
                $dataObatExp['tanggal_kadaluwarsa'] = $request->tanggal_kadaluwarsa[$index];
                $dataObatExp['created_by'] = Auth::user()->id;
                ExpObat::create($dataObatExp);
            }
            $ref_kategori->obat = $obatData;
            $ref_kategori->save();

            if ($request->hasFile('bukti')) {
                $bukti = $request->file('bukti');
                $bukti_name = $bukti->hashName();
                $bukti_origin = $bukti->getClientOriginalName();
                $bukti_type = $bukti->extension();
                $bukti_size = $bukti->getSize();

                $upload_bukti = $request->file('bukti')->storeAs(
                    'faktur/bukti',
                    $bukti_name,
                    'public'
                );

                if ($upload_bukti) {
                    if ($ref_kategori->bukti) {
                        try {
                            Storage::disk('public')->delete(str_replace('storage/', '', $ref_kategori->bukti_path).'/'.$ref_kategori->bukti);
                        } catch (Exception $e) {
                            $result = [
                                'code' => 400,
                                'status' => false,
                                'message' => $e->getMessage()
                            ];
                            return response()->json($result, $result['code']);
                        }
                    }

                    $ref_kategori->bukti = $bukti_name;
                    $ref_kategori->bukti_origin = $bukti_origin;
                    $ref_kategori->bukti_path = 'storage/faktur/bukti';
                    $ref_kategori->bukti_type = $bukti_type;
                    $ref_kategori->bukti_size = $bukti_size;
                    $ref_kategori->save();
                }
            }

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
        $ref_kategori = DataFaktur::where('id', $id)->first();

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

    private function getNameObat($id)
    {
        return DataObat::select('nama_obat')
        ->where('id','=',$id)
        ->first()
        ->nama_obat;
    }
}
