<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepositPaketKelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DepositPaketKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function kelasKadaluarsa()
    {
        $kelas = DB::table('deposit_paket_kelas')
            ->join('kelas', 'deposit_paket_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->join('member', 'deposit_paket_kelas.id_member', '=', 'member.id_member')
            ->select('deposit_paket_kelas.*', 'kelas.nama_kelas', 'member.nama_member')
            ->where('tgl_kadaluarsa', '<', date('Y-m-d'))
            ->where('tgl_kadaluarsa', '!=', null)
            ->get();

        // DB::table('deposit_paket_kelas')
        //     ->where('tanggal_kadaluarsa', '<', date('Y-m-d'))
        //     ->update(['deposit_paket_kelas' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Kelas Kadaluarsa',
            'data' => $kelas
        ], 200);
    }

    public function deaktivatedKelas()
    {
        $kelas = DB::table('deposit_paket_kelas')
            ->where('tgl_kadaluarsa', '<', date('Y-m-d'))
            ->where('tgl_kadaluarsa', '!=', null)
            ->update(['tgl_kadaluarsa' => null, 'deposit_paket_kelas' => 0]);

        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Kelas Kadaluarsa',
            'data' => $kelas
        ], 200);
    }
}
