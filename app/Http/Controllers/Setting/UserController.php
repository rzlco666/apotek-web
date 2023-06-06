<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return view('setting.user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $data = User::all();

        $actions = '
                    <button type="button" class="btn btn-info btn-xs detail-btn me-1" data-id="{{ $id }}" title="Detail">
                        <i class="icon-eye"></i>
                    </button>
                    ';
        if (Auth::user()->can('edit user')) {
            $actions .= '<button class="btn btn-xs btn-warning edit-btn me-1" data-id="{{ $id }}" title="Edit">
                            <i class="icon-pencil"></i>
                        </button>';
        }
        if (Auth::user()->can('delete user')) {
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
            'name' => 'required|string|unique:users,name,NULL,id',
            'email' => 'required|email|max:200|unique:users,email,NULL,id',
            'password' => 'required|min:6|max:20',
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        $user = User::create($params);

        if ($user) {
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
        $data = User::where('id', $id)->first();

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
            'name' => 'required|string|unique:users,name,'.$id.',id',
            'email' => 'required|email|max:200|unique:users,email,'.$id.',id',
            'password' => 'nullable',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $user = User::where('id', $id)->first();

        if (!$user) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        if(empty($request->password)){
            $pass = $user->password;
        }else{
            $pass = bcrypt($request->password);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $pass;

        if ($user->save()) {
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
        $user = User::where('id', $id)->first();

        if (!$user) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        if ($user->delete()) {
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
