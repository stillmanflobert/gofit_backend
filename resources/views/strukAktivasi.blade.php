<div class="card">
    <table>
        <tr>
            <td>
                <p><b>Gofit</b></p>
            </td>
            <td></td>
            <td style="padding-left: 50px;">
                <p>No Struk</p>
            </td>
            <td>
                <p>: {{$data->first()->ID_TRANSAKSI_AKTIVASI}}</p>
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
                <p>: {{$data->first()->TGL_TRANSAKSI_AKTIVASI}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Member</p>
            </td>
            <td>
                <p>: {{$data->first()->ID_MEMBER}}/{{$data->first()->NAMA_MEMBER}} </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Aktivasi Tahunan</p>
            </td>
            <td>
                <p>: Rp.{{$data->first()->JUMLAH_PEMBAYARAN_TRANSAKSI_AKTIVASI}} ,-</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Masa aktif member</p>
            </td>
            <td>
                <p>: {{$data->first()->MASA_BERLAKU_TRANSAKSI_AKTIVASI}} </p>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <p>Kasir: {{$data->first()->ID_PEGAWAI}}/{{$data->first()->NAMA_PEGAWAI}} </p>
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
