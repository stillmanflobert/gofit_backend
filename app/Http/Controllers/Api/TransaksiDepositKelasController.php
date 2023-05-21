<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiDepositKelas;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class TransaksiDepositKelasController extends Controller
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
        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required',
            'id_member' => 'required',
            'jumlah_kelas' => 'required|numeric',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cekData = DB::table('kelas_member')
            ->where('ID_MEMBER', $request->id_member)
            ->where('ID_KELAS', $request->id_kelas)
            ->first();
        if ($cekData) {
            return response()->json([
                'message' => 'Member sudah terdaftar di kelas ini'
            ], 400);
        }

        $id = TransaksiDepositKelas::all()->last();
        if ($id == null) {
            $id = date('y') . '.' . date('m') . '.' . '1';
        } else {
            $id = $id['ID_TRANSAKSI_DEPOSIT_KELAS'];
            $id = (int)substr($id, 6);
            $id = $id + 1;
            $id = date('y') . '.' . date('m') . '.' . "$id";
        }

        $data['ID_TRANSAKSI_DEPOSIT_KELAS'] = $id;
        $data['ID_PEGAWAI'] = $request->id_pegawai;
        $data['ID_MEMBER'] = $request->id_member;
        $data['ID_KELAS'] = $request->id_kelas;
        if ($request->jumlah_kelas >= 5 && $request->jumlah_kelas <= 9) {
            $data['JUMLAH_KELAS'] = $request->jumlah_kelas + 1;
            $data['BONUS_DEPOSIT_KELAS'] = 1;
            $data['MASA_BERLAKU'] = date('Y-m-d' . ' ' . 'h:i:s', strtotime('+1 month'));
        } else if ($request->jumlah_kelas >= 10) {
            $data['JUMLAH_KELAS'] = $request->jumlah_kelas + 3;
            $data['BONUS_DEPOSIT_KELAS'] = 3;
            $data['MASA_BERLAKU'] = date('Y-m-d' . ' ' . 'h:i:s', strtotime('+2 month'));
        } else {
            $data['JUMLAH_KELAS'] = $request->jumlah_kelas;
            $data['BONUS_DEPOSIT_KELAS'] = 0;
            $data['MASA_BERLAKU'] = date('Y-m-d' . ' ' . 'h:i:s', strtotime('+1 month'));
        }
        $data['TGL_TRANSAKSI_DEPOSIT_KELAS'] = date('Y-m-d' . ' ' . 'h:i:s');

        $kelas = Kelas::where('ID_KELAS', $request->id_kelas)->first();
        $data['TOTAL_PEMBAYARAN'] = $kelas->HARGA_KELAS * $request->jumlah_kelas;
        // return response()->json([
        //     'data' => $data
        // ], 201);

        DB::table('transaksi_deposit_kelas')->insert(
            $data
        );
        return response()->json([
            'data' => $id
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
    public function cetakStrukDepositKelas($request)
    {
        $data = DB::table('transaksi_deposit_kelas')
            ->join('member', 'transaksi_deposit_kelas.ID_MEMBER', '=', 'member.ID_MEMBER')
            ->join('pegawai', 'transaksi_deposit_kelas.ID_PEGAWAI', '=', 'pegawai.ID_PEGAWAI')
            ->join('kelas', 'transaksi_deposit_kelas.ID_KELAS', '=', 'kelas.ID_KELAS')
            ->select('transaksi_deposit_kelas.*', 'member.NAMA_MEMBER', 'pegawai.NAMA_PEGAWAI', 'kelas.NAMA_KELAS', 'kelas.HARGA_KELAS')
            ->where('transaksi_deposit_kelas.ID_TRANSAKSI_DEPOSIT_KELAS', $request)
            ->first();

        $updateData = DB::table('kelas_member')->where('ID_MEMBER', $data->ID_MEMBER)->where('ID_KELAS', $data->ID_KELAS)->first();
        if ($updateData == null) {
            DB::table('kelas_member')->insert([
                'ID_MEMBER' => $data->ID_MEMBER,
                'ID_KELAS' => $data->ID_KELAS,
                'JUMLAH_KELAS' => $data->JUMLAH_KELAS,
                'MASA_BERLAKU' => $data->MASA_BERLAKU
            ]);
        } else {
            DB::table('kelas_member')->where('ID_MEMBER', $data->ID_MEMBER)->where('ID_KELAS', $data->ID_KELAS)->update([
                'JUMLAH_KELAS' => $data->JUMLAH_KELAS + $updateData->JUMLAH_KELAS,
                'MASA_BERLAKU' => $data->MASA_BERLAKU
            ]);
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('StrukDepositKelas', compact('data')));
        $dompdf->render();
        $dompdf->stream('StrukDepositKelas.pdf', array('Attachment' => false));
        $pdfContent = $dompdf->output();
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="strukKelas.pdf"',
            'Cache-Control' => 'public, max-age=0'
        ]);
    }
}
