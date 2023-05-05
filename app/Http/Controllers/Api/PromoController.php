<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexData = Promo::all();
        if ($indexData->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Promo is Empty',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Promo List',
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataRequest = $request->all();
        $validate = Validator::make($dataRequest, [
            'nama_promo' => 'required',
            'deskripsi_promo' => 'required',
            'waktu_mulai_promo' => 'required |before:waktu_selesai_promo',
            'waktu_selesai_promo' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        Promo::create($dataRequest);
        return response()->json([
            'success' => true,
            'message' => 'Promo Created',
            'data' => $dataRequest
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
        $showData = Promo::where('id_promo', $id)->first();
        if (is_null($showData)) {
            return response()->json([
                'success' => false,
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Promo Detail',
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
        $dataUpdate = Promo::where('id_promo', $id)->first();
        if (is_null($dataUpdate)) {
            return response()->json([
                'success' => false,
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }
        $dataRequest = $request->all();
        $validate = Validator::make($dataRequest, [
            'nama_promo' => 'required',
            'deskripsi_promo' => 'required',
            'waktu_mulai_promo' => 'required |before:waktu_selesai_promo',
            'waktu_selesai_promo' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        Promo::where('id_promo', $id)->update($dataRequest);
        return response()->json([
            'success' => true,
            'message' => 'Promo Updated',
            'data' => $dataRequest
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
        $dataDelete = Promo::where('id_promo', $id)->first();
        if (is_null($dataDelete)) {
            return response()->json([
                'success' => false,
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }
        Promo::where('id_promo', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Promo Deleted',
            'data' => $dataDelete
        ], 200);
    }
}
