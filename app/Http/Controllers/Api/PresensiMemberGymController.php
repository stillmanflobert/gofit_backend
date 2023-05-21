<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\PresensiMemberGym;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Member;

class PresensiMemberGymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table(
            'presensi_member_gym'
        )
            ->join('member', 'member.id_member', '=', 'presensi_member_gym.id_member')
            ->join('gym', 'gym.id_gym', '=', 'presensi_member_gym.id_gym')
            ->select(
                'presensi_member_gym.id_presensi_gym',
                'presensi_member_gym.id_member',
                'member.nama_member',
                'presensi_member_gym.id_gym',
                'gym.hari_gym',
                'gym.sesi_gym',
                'presensi_member_gym.waktu_presensi_member_gym'
            )
            ->get();
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi Member Gym is Empty',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Presensi Member Gym List',
            'data' => $data
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
        $data = $request->all();
        $validator  = Validator::make($data, [
            'id_member' => 'required',
            'hari_gym' => 'required',
            'sesi_gym' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cek = DB::table('gym')
            ->where('hari_gym', $data['hari_gym'])
            ->where('sesi_gym', $data['sesi_gym'])
            ->first();

        if ($cek->SISA_SLOT == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Gym session is Full',
                'data' => null
            ], 401);
        }

        DB::table('gym')
            ->where('hari_gym', $data['hari_gym'])
            ->where('sesi_gym', $data['sesi_gym'])
            ->decrement('SISA_SLOT', 1);

        $dataGym = DB::table('gym')
            ->where('hari_gym', $data['hari_gym'])
            ->where('sesi_gym', $data['sesi_gym'])
            ->select('id_gym')
            ->first();
        $idBaru = PresensiMemberGym::all()->last();
        $idBaru = $idBaru['ID_PRESENSI_GYM'];
        $idBaru = (int)substr($idBaru, 6);
        $idBaru = $idBaru + 1;
        $idBaru = date('y') . "." . date('m') . "." . "$idBaru";
        $inputData = [
            'id_gym' => $dataGym->id_gym,
            'waktu_presensi_member_gym' => date('Y-m-d H:i:s'),
            'id_member' => $data['id_member'],
            'id_presensi_gym' => $idBaru
        ];

        PresensiMemberGym::create($inputData);
        return response()->json([
            'success' => true,
            'message' => 'add presensi member gym success',
            'data' => $inputData
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


    public function cetakStrukPresensiGym($id)
    {
        $data = DB::table('presensi_member_gym')
            ->join('member', 'member.id_member', '=', 'presensi_member_gym.id_member')
            ->join('gym', 'gym.id_gym', '=', 'presensi_member_gym.id_gym')
            ->select(
                'presensi_member_gym.id_presensi_gym',
                'presensi_member_gym.id_member',
                'member.nama_member',
                'presensi_member_gym.id_gym',
                'gym.hari_gym',
                'gym.sesi_gym',
                'presensi_member_gym.waktu_presensi_member_gym'
            )
            ->where('presensi_member_gym.id_presensi_gym', $id)
            ->first();

        if ($data->sesi_gym == 1) {
            $data->sesi_gym = '7-9';
        } else if ($data->sesi_gym == 2) {
            $data->sesi_gym = '9-11';
        } else if ($data->sesi_gym == 3) {
            $data->sesi_gym = '11-13';
        } else if ($data->sesi_gym == 4) {
            $data->sesi_gym = '13-15';
        } else if ($data->sesi_gym == 5) {
            $data->sesi_gym = '15-17';
        } else if ($data->sesi_gym == 6) {
            $data->sesi_gym = '17-19';
        } else {
            $data->sesi_gym = '19-21';
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('strukPresensiGym', compact('data')));
        $dompdf->render();

        $pdfContent = $dompdf->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="strukPresensiGym.pdf"',
            'Cache-Control' => 'public, max-age=0'
        ]);
    }
}
