<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiDepositUang;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use App\Models\Member;

class TransaksiDepositUangController extends Controller
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
            'jumlah_transaksi_deposit_uang' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $id = TransaksiDepositUang::all()->last();
        if ($id == null) {
            $id = date('y') . '.' . date('m') . '.' . '1';
        } else {
            $id = $id['ID_TRANSAKSI_DEPOSIT_UANG'];
            $id = (int)substr($id, 6);
            $id = $id + 1;
            $id = date('y') . '.' . date('m') . '.' . "$id";
        }


        $data = $request->all();
        if ($request->jumlah_transaksi_deposit_uang >= 3000000) {
            $data['bonus_deposit_uang'] = 300000;
            $data['total_transaksi_deposit_uang'] = $request->jumlah_transaksi_deposit_uang + 300000;
        } else {
            $data['bonus_deposit_uang'] = 0;
            $data['total_transaksi_deposit_uang'] = $request->jumlah_transaksi_deposit_uang;
        }
        $data['tgl_transaksi_deposit_uang'] = date('Y-m-d' . ' ' . 'H:i:s');
        $data['id_transaksi_deposit_uang'] = $id;
        TransaksiDepositUang::create($data);
        return response()->json(['data' => $id]);
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

    public function cetakStrukDepositUang($request)
    {
        $data = DB::table('transaksi_deposit_uang')
            ->join('member', 'transaksi_deposit_uang.ID_MEMBER', '=', 'member.ID_MEMBER')
            ->join('pegawai', 'transaksi_deposit_uang.ID_PEGAWAI', '=', 'pegawai.ID_PEGAWAI')
            ->select('transaksi_deposit_uang.*', 'member.NAMA_MEMBER', 'member.JUMLAH_DEPOSIT_UANG', 'pegawai.NAMA_PEGAWAI')
            ->where('transaksi_deposit_uang.ID_TRANSAKSI_DEPOSIT_UANG', '=', $request)
            ->get();
        //buat variabel baru di $data dengan nama sisa_deposit_uang
        $data->first()->SISA_DEPOSIT_UANG = $data->first()->JUMLAH_DEPOSIT_UANG + $data->first()->TOTAL_TRANSAKSI_DEPOSIT_UANG;

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('strukDepositUang', compact('data')));
        $dompdf->render();

        $pdfContent = $dompdf->output();

        Member::where('ID_MEMBER', $data->first()->ID_MEMBER)->update([
            'JUMLAH_DEPOSIT_UANG' => DB::raw('JUMLAH_DEPOSIT_UANG + ' . $data->first()->TOTAL_TRANSAKSI_DEPOSIT_UANG)
        ]);
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="strukAktivasi.pdf"',
            'Cache-Control' => 'public, max-age=0'
        ]);
    }
}
