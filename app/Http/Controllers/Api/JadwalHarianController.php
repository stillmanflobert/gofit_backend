<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalDefault;
use Carbon\Carbon;


class JadwalHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table(DB::raw('jadwal_harian jh'))
            ->join(DB::raw('jadwal_default jd'), 'jd.id_jadwal_default', '=', 'jh.id_jadwal_default')
            ->join(DB::raw('kelas k'), 'k.id_kelas', '=', 'jd.id_kelas')
            ->join(DB::raw('instruktur i'), 'i.id_instruktur', '=', 'jd.id_instruktur')
            ->select('jh.*', 'k.nama_kelas', 'i.nama_instruktur', 'jd.sesi_jadwal_default', 'jd.hari_jadwal_default')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Ini Index Jadwal Harian',
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
    public function update($id)
    {
        $update = JadwalHarian::where('id_jadwal_kelas', $id)->update([
            'status' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Harian Updated',
            'data' => $update
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

    public function createOneWeekSchdule()
    {
        $jadwalDefault = JadwalDefault::orderByRaw("FIELD(hari_jadwal_default, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu') ASC, sesi_jadwal_default ASC")
            ->join('instruktur', 'jadwal_default.id_instruktur', '=', 'instruktur.id_instruktur')
            ->join('kelas', 'jadwal_default.id_kelas', '=', 'kelas.id_kelas')
            ->select('jadwal_default.*', 'instruktur.nama_instruktur', 'kelas.nama_kelas')
            ->get();

        // $cek = JadwalHarian::where('TANGGAL', date('Y-m-d'))->first();
        //cek jadwal dengan tanggal di minggu ini
        $cek = JadwalHarian::where('TANGGAL', Carbon::now()->startOfWeek()->format('Y-m-d'))->first();
        if ($cek != null) {
            return response()->json([
                'message' => 'Jadwal Harian already created'
            ], 400);
        }

        // masukkan $jadwalDefault ke $jadwalHarian berdasarkan hari dengan tanggal yang sesuai dengan hari tersebut
        $jadwalHarian = [];
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        for ($i = 0; $i < 7; $i++) {
            $now = Carbon::now()->startOfWeek()->modify('+' . $i . ' day');
            $jadwalHarianPerHari = $jadwalDefault->filter(function ($jadwal) use ($hari, $i) {
                return $jadwal->HARI_JADWAL_DEFAULT == $hari[$i];
            })->map(function ($jadwal) use ($now) {
                return [
                    'TANGGAL' => $now->format('Y-m-d'),
                    'ID_JADWAL_DEFAULT' => $jadwal->ID_JADWAL_DEFAULT,
                    'SISA_MEMBER_KELAS' => 10,
                    'STATUS' => 1,
                ];
            })->toArray();

            $jadwalHarian = array_merge($jadwalHarian, $jadwalHarianPerHari);
        }

        // masukkan data ke database jadwal_harian
        JadwalHarian::insert($jadwalHarian);

        return response()->json([
            'message' => 'Jadwal Harian created successfully',
            'data' => $jadwalHarian
        ], 200);
    }
}
