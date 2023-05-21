<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\TransaksiAktivasi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Member;

class TransaksiAktivasiController extends Controller
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
            'jumlah_pembayaran_transaksi_aktivasi' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $id = TransaksiAktivasi::all()->last();
        if ($id == null) {
            $id = date('y') . '.' . date('m') . '.' . '1';
        } else {
            $id = $id['ID_TRANSAKSI_AKTIVASI'];
            $id = (int)substr($id, 6);
            $id = $id + 1;
            $id = date('y') . '.' . date('m') . '.' . "$id";
        }

        $data = $request->all();
        $data['id_transaksi_aktivasi'] = $id;
        $data['tgl_transaksi_aktivasi'] = date('Y-m-d');
        $data['masa_berlaku_transaksi_aktivasi'] = date('Y-m-d', strtotime('+1 year'));
        Member::where('ID_MEMBER', $request->id_member)->update(['STATUS' => 1]);
        Member::where('ID_MEMBER', $request->id_member)->update(['WAKTU_AKTIVASI_EKSPIRED' => date('Y-m-d', strtotime('+1 year'))]);
        $data = TransaksiAktivasi::create($data);
        return response()->json([
            'data' => $id
        ]);
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

    public function cetakStrukAktivasi($request)
    {
        $data = DB::table('transaksi_aktivasi')
            ->join('member', 'transaksi_aktivasi.ID_MEMBER', '=', 'member.ID_MEMBER')
            ->join('pegawai', 'transaksi_aktivasi.ID_PEGAWAI', '=', 'pegawai.ID_PEGAWAI')
            ->select('transaksi_aktivasi.*', 'member.NAMA_MEMBER', 'pegawai.NAMA_PEGAWAI')
            ->where('transaksi_aktivasi.ID_TRANSAKSI_AKTIVASI', '=', $request)
            ->get();

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('strukAktivasi', compact('data')));
        $dompdf->render();

        $pdfContent = $dompdf->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="strukAktivasi.pdf"',
            'Cache-Control' => 'public, max-age=0'
        ]);
    }
}
