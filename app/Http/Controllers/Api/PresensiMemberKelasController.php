<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PresensiMemberKelas;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PresensiMemberKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('presensi_member_kelas')
            ->join('member', 'member.id_member', '=', 'presensi_member_kelas.id_member')
            ->join('jadwal_harian', 'jadwal_harian.id_jadwal_kelas', '=', 'presensi_member_kelas.id_jadwal_kelas')
            ->join('jadwal_default', 'jadwal_default.id_jadwal_default', '=', 'jadwal_harian.id_jadwal_default')
            ->join('kelas', 'kelas.id_kelas', '=', 'jadwal_default.id_kelas')
            ->select(
                'presensi_member_kelas.id_presensi_kelas',
                'presensi_member_kelas.id_member',
                'member.nama_member',
                'presensi_member_kelas.id_jadwal_kelas',
                'jadwal_default.hari_jadwal_default',
                'jadwal_default.sesi_jadwal_default',
                'kelas.nama_kelas',
                'presensi_member_kelas.waktu_presensi_member_kelas'
            )
            ->get();
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi Member Kelas is Empty',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Presensi Member Kelas List',
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

    public function cetakStrukPresensiKelas($id)
    {
        $data = DB::table('presensi_member_kelas')
            ->join('member', 'member.id_member', '=', 'presensi_member_kelas.id_member')
            ->join('jadwal_harian', 'jadwal_harian.id_jadwal_kelas', '=', 'presensi_member_kelas.id_jadwal_kelas')
            ->join('jadwal_default', 'jadwal_default.id_jadwal_default', '=', 'jadwal_harian.id_jadwal_default')
            ->join('instruktur', 'instruktur.id_instruktur', '=', 'jadwal_default.id_instruktur')
            ->join('kelas', 'kelas.id_kelas', '=', 'jadwal_default.id_kelas')
            ->where('presensi_member_kelas.id_presensi_kelas', '=', $id)
            ->select(
                'presensi_member_kelas.id_presensi_kelas',
                'presensi_member_kelas.id_member',
                'member.nama_member',
                'presensi_member_kelas.id_jadwal_kelas',
                'jadwal_default.hari_jadwal_default',
                'jadwal_default.sesi_jadwal_default',
                'kelas.nama_kelas',
                'presensi_member_kelas.waktu_presensi_member_kelas',
                'kelas.harga_kelas',
                'member.jumlah_deposit_uang',
                'instruktur.nama_instruktur'
            )
            ->first();
        // return response()->json(['data' => $data], 200);
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('strukPresensiKelas', compact('data')));
        $dompdf->render();


        $pdfContent = $dompdf->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="strukPresensiKelas.pdf"',
            'Cache-Control' => 'public, max-age=0'
        ]);
    }
}
