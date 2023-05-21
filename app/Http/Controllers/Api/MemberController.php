<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Dompdf\Dompdf;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataIndex = Member::all();
        if ($dataIndex->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Member is Empty',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Member List',
            'data' => $dataIndex
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
            'nama_member' => 'required',
            'alamat_member' => 'required',
            'telepon_member' => 'required|numeric|digits_between:11,13',
            'email' => 'required|email',
            'tanggal_lahir' => 'required|date',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $idBaru = Member::all()->last();
        $idBaru = $idBaru['ID_MEMBER'];
        $idBaru = (int)substr($idBaru, 6);
        $idBaru = $idBaru + 1;
        $idBaru = date('y') . "." . date('m') . "." . "$idBaru";
        $data['waktu_daftar_member'] = date('Y-m-d H:i:s');
        $data['id_member'] = $idBaru;
        $data['jumlah_deposit_uang'] = 0;
        $data['status'] = 1;
        Member::create($data);
        User::create([
            'id_user' => $data['id_member'],
            'password' => $data['tanggal_lahir'],
            'role' => 'member',
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Member Created',
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
        $data = Member::where('id_member', $id)->first();
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Member',
                'data' => $data
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Member Not Found',
            'data' => null
        ], 404);
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
        $data  = Member::where('id_member', $id)->first();
        if ($data == null) {
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
                'data' => null
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            'alamat_member' => 'required',
            'telepon_member' => 'required|numeric|digits_between:11,13',
            'email' => 'required|email',
            'tanggal_lahir' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        Member::where('id_member', $id)->update($request->all());
        $dataUpdate = Member::where('id_member', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Member Updated',
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
        $data = Member::where('id_member', $id)->first();
        if ($data == null) {
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
                'data' => null
            ], 404);
        }
        Member::where('id_member', $id)->update(['status' => 0]);
        // User::where('id_user', $data['username_member'])->delete();
        $dataDelete = Member::where('id_member', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Member Deleted',
            'data' => $dataDelete
        ], 200);
    }

    public function printMemnberCard($id)
    {
        $data = Member::where('id_member', $id)->first();
        if ($data == null) {
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
                'data' => null
            ], 404);
        }
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('memberCard', compact('data')));
        $dompdf->render();
        $dompdf->stream('memberCard.pdf', array('Attachment' => false));
    }

    public function aktivasiMember($id)
    {
        $data = Member::where('id_member', $id)->first();
        if ($data == null) {
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
                'data' => null
            ], 404);
        }
        $aktivasi['waktu_mulai_aktivasi'] = date('Y-m-d H:i:s');
        $aktivasi['waktu_aktivasi_ekspired'] = date('Y-m-d H:i:s', strtotime('+1 year'));
        $aktivasi['status'] = 1;

        Member::where('id_member', $id)->update($aktivasi);
        $dataUpdate = Member::where('id_member', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Member Activated',
            'data' => $dataUpdate
        ], 200);
    }

    public function resetPasswordMember($id)
    {
        $cek = Member::where('id_member', $id)->first();
        if ($cek == null) {
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
                'data' => null
            ], 404);
        }
        $data['password'] = $cek['TANGGAL_LAHIR'];
        User::where('id_user', $id)->update($data);
        $dataUpdate = User::where('id_user', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Password Reseted',
            'data' => $dataUpdate
        ], 200);
    }

    public function memberKadaluarsa()
    {
        $data = Member::where('status', 1)->where('waktu_aktivasi_ekspired', '<', date('Y-m-d '))->get();
        if ($data == null) {
            return response()->json([
                'success' => false,
                'message' => 'Member Not Found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Member Kadaluarsa',
            'data' => $data
        ], 200);
    }

    public function deaktivasiMember()
    {
        $data = Member::where('waktu_aktivasi_ekspired', '<', date('Y-m-d H:i:s'))->update(['status' => 0]);
        return response()->json([
            'success' => true,
            'message' => 'Member Deactivated',
            'data' => $data
        ], 200);
    }
}
