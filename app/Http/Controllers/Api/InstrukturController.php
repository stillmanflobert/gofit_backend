<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instruktur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\JadwalHarian;
use App\Models\JadwalDefault;

use function PHPUnit\Framework\isNull;

class InstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataIndex = DB::table('instruktur')
            ->select('instruktur.*')
            ->get();
        if ($dataIndex) {
            return response()->json([
                'success' => true,
                'message' => 'All Instruktur',
                'data' => $dataIndex
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Instruktur Not Found',
            'data' => ''
        ], 404);
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
            'nama_instruktur' => 'required',
            'alamat_instruktur' => 'required',
            'telepon_instruktur' => 'required|numeric|digits_between:11,13',
            'tanggal_lahir' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $idInstruktur = Instruktur::all()->last();
        $idInstruktur = $idInstruktur['ID_INSTRUKTUR'];
        $idInstruktur = $idInstruktur + 1;
        $usernameInstruktur = 'INS' . $idInstruktur;
        $dataInputToInstruktur = [
            'id_instruktur' => $idInstruktur,
            'nama_instruktur' => $storeData['nama_instruktur'],
            'alamat_instruktur' => $storeData['alamat_instruktur'],
            'telepon_instruktur' => $storeData['telepon_instruktur'],
            'username_instruktur' => $usernameInstruktur,
            'tanggal_lahir' => $storeData['tanggal_lahir'],
        ];
        $dataInputToUser = [
            'id_user' => $usernameInstruktur,
            'password' => $storeData['tanggal_lahir'],
            'role' => 'instruktur',
        ];
        Instruktur::create($dataInputToInstruktur);
        User::create($dataInputToUser);
        return response()->json([
            'success' => true,
            'message' => 'Instruktur Created',
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
        $dataShow = Instruktur::where('id_instruktur', $id)->first();
        if ($dataShow) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Instruktur',
                'data' => $dataShow
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Instruktur Not Found',
            'data' => ''
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
        $cekEdit = Instruktur::where('id_instruktur', $id)->first();
        if ($cekEdit == null) {
            return response()->json([
                'success' => false,
                'message' => 'Instruktur Not Found',
                'data' => ''
            ], 404);
        }

        $validate = Validator::make($request->all(), [
            'nama_instruktur' => 'required',
            'alamat_instruktur' => 'required',
            'telepon_instruktur' => 'required|numeric|digits_between:11,13',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $dataUpdate = [
            'nama_instruktur' => $request->nama_instruktur,
            'alamat_instruktur' => $request->alamat_instruktur,
            'telepon_instruktur' => $request->telepon_instruktur,
        ];
        Instruktur::where('id_instruktur', $id)->update($dataUpdate);
        return response()->json([
            'success' => true,
            'message' => 'Instruktur Updated',
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
        $cekDelete = Instruktur::where('id_instruktur', $id)->first();
        if ($cekDelete == null) {
            return response()->json([
                'success' => false,
                'message' => 'Instruktur Not Found',
                'data' => ''
            ], 404);
        }
        // return response()->json(['user']);
        Instruktur::where('id_instruktur', $id)->delete();
        User::where('id_user', $cekDelete['USERNAME_INSTRUKTUR'])->delete();
        JadwalHarian::where('id_instruktur', $id)->delete();
        JadwalDefault::where('id_instruktur', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Instruktur Deleted',
            'data' => $cekDelete
        ], 200);
    }
}
