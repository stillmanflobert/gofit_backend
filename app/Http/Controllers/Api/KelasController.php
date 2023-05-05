<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\JadwalDefault;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Kelas',
            'data' => $kelas
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
            'nama_kelas' => 'required',
            'harga_kelas' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        Kelas::create($storeData);

        return response()->json([
            'success' => true,
            'message' => 'Kelas Created',
            'data' => $storeData
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::where('id_kelas', $id)->first();
        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas is Not Found',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Kelas',
            'data' => $kelas
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
        $updateData = $request->all();
        if (!Kelas::where('id_kelas', $id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas is Not Found',
            ], 500);
        }

        $validate = Validator::make($updateData, [
            'nama_kelas' => 'required',
            'harga_kelas' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        //update data
        Kelas::where('id_kelas', $id)->update($updateData);
        return response()->json([
            'success' => true,
            'message' => 'Kelas Updated',
            'data' => $updateData
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
        $cek = Kelas::where('id_kelas', $id)->first();
        if (!$cek) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas is Not Found',
            ], 500);
        }
        JadwalDefault::where('ID_KELAS', $cek->ID_KELAS)->delete();
        Kelas::where('id_kelas', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kelas Deleted',
            'data' => $cek
        ], 200);
    }
}
