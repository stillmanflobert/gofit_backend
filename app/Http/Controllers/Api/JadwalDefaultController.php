<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDefault;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JadwalDefaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dataIndex = DB::table('jadwal_default')
        //     ->join('instruktur', 'jadwal_default.id_instruktur', '=', 'instruktur.id_instruktur')
        //     ->join('kelas', 'jadwal_default.id_kelas', '=', 'kelas.id_kelas')
        //     ->select('jadwal_default.*', 'instruktur.nama_instruktur', 'kelas.nama_kelas')
        //     ->get();
        // $jadwals = JadwalDefault::all();
        // if ($dataIndex->isEmpty()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Jadwal Default is Empty',
        //         'data' => null
        //     ], 404);
        // }
        // $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        // $dataIndex = $dataIndex->sortBy(function ($dataIndex) use ($days) {
        //     return array_search($dataIndex->HARI_JADWAL_DEFAULT, $days);
        // });

        // return response()->json([
        //     'success' => true,
        //     'message' => 'All Jadwal Default List',
        //     'data' => $dataIndex
        // ], 200);

        // $hari = [
        //     'Monday' => 'Senin',
        //     'Tuesday' => 'Selasa',
        //     'Wednesday' => 'Rabu',
        //     'Thursday' => 'Kamis',
        //     'Friday' => 'Jumat',
        //     'Saturday' => 'Sabtu',
        //     'Sunday' => 'Minggu'
        // ];

        // $jadwals = $jadwals->sortBy(function ($jadwal) use ($hari) {
        //     return array_search($jadwal->hari, $hari);
        // });

        $jadwal = JadwalDefault::orderByRaw("FIELD(hari_jadwal_default, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu') ASC, sesi_jadwal_default ASC")
            ->join('instruktur', 'jadwal_default.id_instruktur', '=', 'instruktur.id_instruktur')
            ->join('kelas', 'jadwal_default.id_kelas', '=', 'kelas.id_kelas')
            ->select('jadwal_default.*', 'instruktur.nama_instruktur', 'kelas.nama_kelas')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'All Jadwal Default List',
            'data' => $jadwal
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
        $validate = Validator::make($data, [
            'id_instruktur' => 'required',
            'id_kelas' => 'required',
            'sesi_jadwal_default' => 'required',
            'hari_jadwal_default' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }
        $id = JadwalDefault::all()->last();
        $id = $id['ID_JADWAL_DEFAULT'];
        $id = $id + 1;
        $cek = JadwalDefault::where('id_instruktur', $data['id_instruktur'])
            ->where('sesi_jadwal_default', $data['sesi_jadwal_default'])
            ->where('hari_jadwal_default', $data['hari_jadwal_default'])
            ->first();
        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Default Already Exist',
                'data' => null
            ], 409);
        }
        $data['id_jadwal_default'] = $id;
        $jadwalDefault = JadwalDefault::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Jadwal Default Created',
            'data' => $jadwalDefault
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
    // public function update(Request $request, $id)
    // {
    //     $jadwalDefault = JadwalDefault::where('ID_JADWAL_DEFAULT', $id)->first();
    //     if (!$jadwalDefault) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal Default with ID ' . $id . ' not found',
    //             'data' => null
    //         ], 404);
    //     }
    //     $data = $request->all();
    //     $validate = Validator::make($data, [
    //         'id_instruktur' => 'required',
    //         'id_kelas' => 'required',
    //         'sesi_jadwal_default' => 'required',
    //         'hari_jadwal_default' => 'required',
    //     ]);
    //     if ($validate->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation Error',
    //             'data' => $validate->errors()
    //         ], 400);
    //     }
    //     $cek = JadwalDefault::where('id_instruktur', $data['id_instruktur'])
    //         ->where('sesi_jadwal_default', $data['sesi_jadwal_default'])
    //         ->where('hari_jadwal_default', $data['hari_jadwal_default'])
    //         ->first();
    //     if ($cek) {
    //         if ($cek->ID_KELAS != $request['id_kelas'] && $cek->ID_JADWAL_DEFAULT == $id) {
    //             $jadwalDefault->ID_INSTRUKTUR = $data['id_instruktur'];
    //             $jadwalDefault->ID_KELAS = $data['id_kelas'];
    //             $jadwalDefault->SESI_JADWAL_DEFAULT = $data['sesi_jadwal_default'];
    //             $jadwalDefault->HARI_JADWAL_DEFAULT = $data['hari_jadwal_default'];
    //             JadwalDefault::where('ID_JADWAL_DEFAULT', $id)->update($jadwalDefault->toArray());
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Jadwal Default with ID ' . $id . ' successfully updated',
    //                 'data' => $jadwalDefault
    //             ], 200);
    //         }
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal Default Already Exist',
    //             'data' => null
    //         ], 409);
    //     }
    //     $jadwalDefault->ID_INSTRUKTUR = $data['id_instruktur'];
    //     $jadwalDefault->ID_KELAS = $data['id_kelas'];
    //     $jadwalDefault->SESI_JADWAL_DEFAULT = $data['sesi_jadwal_default'];
    //     $jadwalDefault->HARI_JADWAL_DEFAULT = $data['hari_jadwal_default'];
    //     JadwalDefault::where('ID_JADWAL_DEFAULT', $id)->update($jadwalDefault->toArray());
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Jadwal Default with ID ' . $id . ' successfully updated',
    //         'data' => $jadwalDefault
    //     ], 200);
    // }

    public function update(Request $request, $id)
    {
        $jadwalDefault = JadwalDefault::find($id);
        if (!$jadwalDefault) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Default with ID ' . $id . ' not found',
                'data' => null
            ], 404);
        }
        $validate = Validator::make($request->all(), [
            'id_instruktur' => 'required',
            'id_kelas' => 'required',
            'sesi_jadwal_default' => 'required',
            'hari_jadwal_default' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }
        $cek = JadwalDefault::where('id_instruktur', $request->id_instruktur)
            ->where('sesi_jadwal_default', $request->sesi_jadwal_default)
            ->where('hari_jadwal_default', $request->hari_jadwal_default)
            ->where('ID_JADWAL_DEFAULT', '!=', $id)
            ->first();
        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Default Already Exist',
                'data' => null
            ], 409);
        }
        $jadwalDefault->ID_INSTRUKTUR = $request->id_instruktur;
        $jadwalDefault->ID_KELAS = $request->id_kelas;
        $jadwalDefault->SESI_JADWAL_DEFAULT = $request->sesi_jadwal_default;
        $jadwalDefault->HARI_JADWAL_DEFAULT = $request->hari_jadwal_default;
        $jadwalDefault = JadwalDefault::where('ID_JADWAL_DEFAULT', $id)->update($jadwalDefault->toArray());
        return response()->json([
            'success' => true,
            'message' => 'Jadwal Default with ID ' . $id . ' successfully updated',
            'data' => $jadwalDefault
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
        $cek = JadwalDefault::where('ID_JADWAL_DEFAULT', $id)->first();
        if (!$cek) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Default with ID ' . $id . ' not found',
                'data' => null
            ], 404);
        }
        $data = JadwalDefault::where('ID_JADWAL_DEFAULT', $id)->delete();
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal Default with ID ' . $id . ' successfully deleted',
                'data' => $data
            ], 200);
        }
    }


    public function getJadwalByDay(Request $request)
    {
        $hari = $request->hari;
        $waktu = $request->waktu;

        if ($waktu == 'pagi') {
            $data = DB::table('jadwal_default')
                ->join('instruktur', 'instruktur.ID_INSTRUKTUR', '=', 'jadwal_default.ID_INSTRUKTUR')
                ->join('kelas', 'kelas.ID_KELAS', '=', 'jadwal_default.ID_KELAS')
                ->select('jadwal_default.ID_JADWAL_DEFAULT', 'instruktur.NAMA_INSTRUKTUR', 'kelas.NAMA_KELAS', 'jadwal_default.SESI_JADWAL_DEFAULT', 'jadwal_default.HARI_JADWAL_DEFAULT')
                ->where('jadwal_default.HARI_JADWAL_DEFAULT', $hari)
                ->whereTime('jadwal_default.SESI_JADWAL_DEFAULT', '<', '12:00:00')
                ->orderBy('sesi_jadwal_default', 'asc')
                ->get();
        } else if ($waktu == 'sore') {
            $data = DB::table('jadwal_default')
                ->join('instruktur', 'instruktur.ID_INSTRUKTUR', '=', 'jadwal_default.ID_INSTRUKTUR')
                ->join('kelas', 'kelas.ID_KELAS', '=', 'jadwal_default.ID_KELAS')
                ->select('jadwal_default.ID_JADWAL_DEFAULT', 'instruktur.NAMA_INSTRUKTUR', 'kelas.NAMA_KELAS', 'jadwal_default.SESI_JADWAL_DEFAULT', 'jadwal_default.HARI_JADWAL_DEFAULT')
                ->where('jadwal_default.HARI_JADWAL_DEFAULT', $hari)
                ->whereTime('jadwal_default.SESI_JADWAL_DEFAULT', '>', '12:00:00')
                ->orderBy('sesi_jadwal_default', 'asc')
                ->get();
        }

        if (!$data) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal Default List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Empty',
            ], 200);
        }
    }
}
