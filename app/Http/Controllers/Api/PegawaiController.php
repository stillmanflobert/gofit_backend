<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexData = Pegawai::all();
        if ($indexData->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai is Empty',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Pegawai List',
            'data' => $indexData
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'role' => 'required',
            'no_telp' => 'required|numeric|digits_between:11,13',
            'email' => 'required|email',
            'alamat' => 'required',
            'nama_pegawai' => 'required',
            'tanggal_lahir' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }


        $lastId = Pegawai::all()->last();
        $id = substr($lastId['ID_PEGAWAI'], 1);
        $id = (int)$id;
        $id = $id + 1;
        $id = "P" . $id;
        $storeData['id_pegawai'] = $id;
        Pegawai::create($storeData);
        User::create([
            'id_user' => $storeData['id_pegawai'],
            'password' => $storeData['tanggal_lahir'],
            'role' => $storeData['role'],
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Pegawai Created',
            'data' => $storeData
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showData = Pegawai::where('id_pegawai', $id)->first();
        if ($showData == null) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pegawai Detail',
            'data' => $showData
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $updateData = Pegawai::where('id_pegawai', $id)->first();
        if ($updateData == null) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai not found',
                'data' => null
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nama_pegawai' => 'required',
            'tanggal_lahir' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $userUpdate = [
            'role' => $request['role'],
        ];
        User::where('id_user', $updateData['ID_PEGAWAI'])->update($userUpdate);
        Pegawai::where('id_pegawai', $id)->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Pegawai Updated',
            'data' => $request->all()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroyData = Pegawai::where('id_pegawai', $id)->first();
        if ($destroyData == null) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai not found',
                'data' => null
            ], 404);
        }
        Pegawai::where('id_pegawai', $id)->delete();
        User::where('id_user', $destroyData['ID_PEGAWAI'])->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pegawai Deleted',
            'data' => $destroyData
        ], 200);
    }
}
