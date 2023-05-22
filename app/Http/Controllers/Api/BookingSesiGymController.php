<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingSesiGym;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use Carbon\Carbon;


class BookingSesiGymController extends Controller
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
        $data = $request->all();
        $validator  = Validator::make($data, [
            'id_member' => 'required',
            'hari_gym' => 'required',
            'sesi_gym' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Fill all data'], 400);
        }

        $dataMember = Member::where('id_member', $request->id_member)->first();
        if ($dataMember->STATUS == 0) {
            return response()->json([
                'message' => 'Member belum aktif'
            ], 400);
        }

        $dataGym = DB::table('gym')->where('hari_gym', $request->hari_gym)->where('sesi_gym', $request->sesi_gym)->first();
        if ($dataGym->SISA_SLOT == 0) {
            return response()->json([
                'message' => 'Slot gym sudah penuh'
            ], 400);
        }
        // $cekWaktu = BookingSesiGym::where('id_member', $request->id_member)->first();
        // if (date('Y-m-d', strtotime($cekWaktu->TGL_BOOKING_GYM)) == date('Y-m-d')) {
        //     return response()->json([
        //         'message' => 'Member sudah booking gym hari ini'
        //     ], 400);
        // }
        $idBaru = BookingSesiGym::all()->last();
        $idBaru = $idBaru['ID_BOOKING_GYM'];
        $idBaru = (int)substr($idBaru, 6);
        $idBaru = $idBaru + 1;
        $idBaru = date('y') . "." . date('m') . "." . "$idBaru";

        $data['id_booking_gym'] = $idBaru;
        $data['status_booking_gym'] = 'on process';
        date_default_timezone_set('Asia/Jakarta');
        $data['tgl_booking_gym'] = date('Y-m-d H:i:s');
        $idGym = DB::table('gym')->where('hari_gym', $request->hari_gym)->where('sesi_gym', $request->sesi_gym)->first();
        $data['id_gym'] = $idGym->ID_GYM;
        DB::table('gym')->where('hari_gym', $request->hari_gym)->where('sesi_gym', $request->sesi_gym)->update([
            'sisa_slot' => $dataGym->SISA_SLOT - 1
        ]);

        BookingSesiGym::create($data);

        return response()->json([
            'message' => 'Berhasil booking gym',
            'data' => $data
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
        $data = DB::table('booking_sesi_gym')
            ->join('gym', 'booking_sesi_gym.id_gym', '=', 'gym.id_gym')
            ->join('member', 'booking_sesi_gym.id_member', '=', 'member.id_member')
            ->select('booking_sesi_gym.*', 'gym.*', 'member.nama_member')
            ->where('booking_sesi_gym.id_member', $id)
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
        return response()->json([
            'message' => 'Berhasil menampilkan data',
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

    public function batalBookingGym(Request $request)
    {
        $data = DB::table('gym')->where('id_gym', $request->id_gym)->first();
        if ($data->HARI_GYM == 'minggu') {
            $dayNumber = 6;
        } else if ($data->HARI_GYM == 'senin') {
            $dayNumber = 0;
        } else if ($data->HARI_GYM == 'selasa') {
            $dayNumber = 1;
        } else if ($data->HARI_GYM == 'rabu') {
            $dayNumber = 2;
        } else if ($data->HARI_GYM == 'kamis') {
            $dayNumber = 3;
        } else if ($data->HARI_GYM == 'jumat') {
            $dayNumber = 4;
        } else if ($data->HARI_GYM == 'sabtu') {
            $dayNumber = 5;
        }
        $firstDayOfWeek = Carbon::now()->startOfWeek();
        $date = $firstDayOfWeek->addDays($dayNumber);
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        if ($now > $date) {
            return response()->json([
                'message' => 'Tidak bisa membatalkan booking gym'
            ], 400);
        }
        $cekStatus = DB::table('booking_sesi_gym')->where('id_booking_gym', $request->id_booking_gym)->first();
        if ($cekStatus->STATUS_BOOKING_GYM == 'batal') {
            return response()->json([
                'message' => 'Booking gym sudah dibatalkan'
            ], 400);
        }
        DB::table('gym')->where('id_gym', $request->id_gym)->update([
            'SISA_SLOT' => $data->SISA_SLOT + 1
        ]);
        DB::table('booking_sesi_gym')->where('id_booking_gym', $request->id_booking_gym)->update([
            'STATUS_BOOKING_GYM' => 'batal'
        ]);
        return response()->json([
            'message' => 'Berhasil membatalkan booking gym'
        ], 200);
    }
}
