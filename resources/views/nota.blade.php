<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>
<body style="color:black;">
    <div class="w-25 mx-3 my-2 ">
        <h3 class="text-center">Nota Pembelian</h3>
        <p class="text-center">Jalan Perum Ratna sari no 112 aksmjehnhj k</p>
    </br>
        <div class="row">
            <div class="col">Tanggal</div>
            <div class="col-auto">:</div>
            <div class="col">12 Januari 2023</div>
        </div>
        <div class="row">
            <div class="col">Nama Pelanggan</div>
            <div class="col-auto">:</div>
            <div class="col">Asep</div>
        </div>
        <div class="row">
            <div class="col">Total</div>
            <div class="col-auto">:</div>
            <div class="col">12023</div>
        </div>
    </br>
        <table class="table">
            <thead>
                <th class="w-50">Produk</th>
                <th class="w-25">Jumlah</th>
                <th class="w-25">Total</th>
            </thead>
            <tbody>
                <--foreach>
                <tr>
                    <td>Apem</td>
                    <td class="text-right">1</td>
                    <td class="text-right">500</td>
                </tr>
                <--endforeach>
            </tbody>
            <tfoot>
                <th class="text-center" colspan="2">Total</th>
                <th class="text-right">200000</th>
            </tfoot>
        </table>
    </br>
    <h5 class="text-center">:::  Terima Kasih  :::</h5>

    </div>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>