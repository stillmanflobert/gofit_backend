<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gofit/title>
</head>

<body>
    <h1>Member Card</h1>
</body>

</html> -->
<div class="card">
    <h3>Gofit</h3>
    <p>Jl. Centralpark No. 10 Yogyakarta</p>
    <h3>Member Card</h3>
    <table>
        <tr>
            <td>
                <p>Member ID </p>
            </td>
            <td>
                <p>: {{$data['ID_MEMBER']}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Nama </p>
            </td>
            <td>
                <p>: {{$data['NAMA_MEMBER']}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Alamat </p>
            </td>
            <td>
                <p>: {{$data['ALAMAT_MEMBER']}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Telepon </p>
            </td>
            <td>
                <p>: {{$data['TELEPON_MEMBER']}}</p>
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
