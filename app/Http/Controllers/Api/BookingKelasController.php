<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\JadwalHarian;


class BookingKelasController extends Controller
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
        $validate = Validator::make($data, [
            'id_jadwal_kelas' => 'required',
            'id_member' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);
        $cekAktiv = Member::where('id_member', $data['id_member'])->first();

        if (!$cekAktiv) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found',
                'data' => null
            ], 401);
        }
        if ($cekAktiv->STATUS == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Member is not active',
                'data' => null
            ], 401);
        }
        $cekKelas = JadwalHarian::where('id_jadwal_kelas', $data['id_jadwal_kelas'])->first();
        if ($cekKelas->SISA_MEMBER_KELAS == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas is full',
                'data' => null
            ], 401);
        }

        $id = BookingKelas::all()->last();
        if ($id == null) {
            $id = date('y') . '.' . date('m') . '.' . '1';
        } else {
            $id = $id['ID_TRANSAKSI_AKTIVASI'];
            $id = (int)substr($id, 6);
            $id = $id + 1;
            $id = date('y') . '.' . date('m') . '.' . "$id";
        }

        $data['id_booking_kelas'] = $id;
        $data['status_booking_kelas'] = 'on process';
        $data['tgl_booking_kelas'] = date('Y-m-d h:i:s');
        $data['id_member'] = $data['id_member'];

        BookingKelas::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Booking Kelas Berhasil',
            'data' => $data
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

    public function cekBatalBooking(Request $request)
    {
        $data = DB::table('booking_kelas')
            ->join('jadwal_harian', 'jadwal_harian.id_jadwal_kelas', '=', 'booking_kelas.id_jadwal_kelas')
            ->where('id_booking_kelas', $request->id)
            ->select('booking_kelas.*', 'jadwal_harian.tanggal')
            ->first();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => null
            ], 401);
        }
        $tgl = $data->tanggal;
        if ($tgl == date('Y-m-d')) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak dapat dibatalkan',
                'data' => null
            ], 401);
        } else {
            BookingKelas::where('id_booking_kelas', $request->id)->update(['status_booking_kelas' => 'batal']);
            $data = BookingKelas::where('id_booking_kelas', $request->id)->first();
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil dibatalkan',
                'data' => $data
            ], 201);
        }
    }
}
