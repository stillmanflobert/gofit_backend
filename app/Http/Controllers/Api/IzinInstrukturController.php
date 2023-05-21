<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\IzinInstruktur;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\DB;

class IzinInstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('izin_instruktur as ii')
            ->join('instruktur as i', 'i.id_instruktur', '=', 'ii.id_instruktur')
            ->join('instruktur as i2', 'i2.id_instruktur', '=', 'ii.id_instruktur_pengganti')
            ->select('ii.*', 'i.nama_instruktur as nama_instruktur', 'i2.nama_instruktur as nama_instruktur_pengganti')
            ->where('ii.status_izin', '=', 'belum dikonfirmasi')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'all izin data',
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
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_instruktur' => 'required',
            'id_instruktur_pengganti' => 'required',
            'waktu_izin' => 'required',
            'keterangan' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        IzinInstruktur::create($storeData);
        return response()->json([
            'success' => true,
            'message' => 'izin added',
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
        $data = IzinInstruktur::where('id_instruktur', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'all izin data',
            'data' => $data
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
    public function update(Request $request)
    {
        if ($request->id == null || $request->id_jadwal_kelas == null) {
            return response()->json([
                'success' => false,
                'message' => 'id or id_jadwal_kelas is null',
                'data' => null
            ], 400);
        }
        $tanggalKonfirmasi['tgl_konfirmasi'] = date('y-m-d' . ' ' . 'h:i:s');
        $tanggalKonfirmasi['status_izin'] = 'dikonfirmasi';
        $dataUpdate = IzinInstruktur::where('ID_IZIN_INTRUKSTUR', $request->id)->update($tanggalKonfirmasi);
        $stat['status'] = 0;
        JadwalHarian::where('id_jadwal_kelas', $request->id_jadwal_kelas)->update($stat);
        return response()->json([
            'success' => true,
            'message' => 'Jadwal Updated',
            'data' => $dataUpdate
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
        //
    }
}
