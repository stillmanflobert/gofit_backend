<div class="card">
    <h3>Gofit</h3>
    <p>Jl. Centralpark No. 10 Yogyakarta</p>
    <span></span>
    <h3><strong>Struk Presensi Gym</strong></h3>
    <table>
        <tr>
            <td>
                <p>No Struk </p>
            </td>
            <td>
                <p>: {{ $data->id_presensi_gym }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Tanggal </p>
            </td>
            <td>
                <p>: {{ $data->waktu_presensi_member_gym }}</p>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><strong>Member</strong> </p>
            </td>
            <td>
                <p>: {{ $data->id_member }}/{{ $data->nama_member }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Slot Waktu </p>
            </td>
            <td>
                <p>: {{ $data->sesi_gym }}</p>
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
    }

    .card {
        border: 1px solid #ccc;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        width: 300px;
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
