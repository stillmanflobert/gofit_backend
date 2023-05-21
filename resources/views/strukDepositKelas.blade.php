<div class="card">
    <table>
        <tr>
            <td>
                <p><b>Gofit</b></p>
            </td>
            <td></td>
            <td style="padding-left: 50px;">
                <p>No Struk </p>
            </td>
            <td>
                <p>: {{$data->ID_TRANSAKSI_DEPOSIT_KELAS}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Jl. Centralpark No. 10 Yogyakarta</p>
            </td>
            <td></td>
            <td style="padding-left: 50px;">
                <p>Tanggal</p>
            </td>
            <td>
                <p>: {{$data->TGL_TRANSAKSI_DEPOSIT_KELAS}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Member</p>
            </td>
            <td>
                <p>: {{$data->ID_MEMBER}} /{{$data->NAMA_MEMBER}} </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Deposit </p>
            </td>
            <td>
                <p>: Rp.{{$data->TOTAL_PEMBAYARAN}},- ({{$data->JUMLAH_KELAS - $data->BONUS_DEPOSIT_KELAS}} x Rp.{{$data->HARGA_KELAS}})</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Jenis Kelas</p>
            </td>
            <td>
                <p>: {{$data->NAMA_KELAS}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Total Deposit {{$data->NAMA_KELAS}}</p>
            </td>
            <td>
                <p>: {{$data->JUMLAH_KELAS}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Berlaku Sampai Dengan</p>
            </td>
            <td>
                <p>: {{$data->MASA_BERLAKU}}</p>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <p>Kasir: {{$data->ID_PEGAWAI}} / {{$data->NAMA_PEGAWAI}}</p>
            </td>
        </tr>
    </table>
</div>

<style>
    p {
        line-height: 0%;
    }

    td,
    th {
        line-height: 0%;
        word-wrap: break-word;
    }

    .card {
        border: 1px solid #ccc;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        width: 700px;
    }

    .card h3 {
        margin-top: 10px;
        font-size: 20px;
    }

    .card p {
        margin-top: 5px;
        font-size: 16px;
    }

    .card a {
        display: block;
        margin-top: 10px;
        font-size: 16px;
        text-align: right;
        color: blue;
    }
</style>
