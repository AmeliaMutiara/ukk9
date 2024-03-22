<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

</head>
<body style="color:black;">
    <div class="w-25 mx-3 my-2 ">
        <h2 class="text-center">Nota Pembelian</h2>
        <p class="text-center">Toko Swalayan BetaMidi</p>
    </br>
        <div class="row">
            <div class="col">Tanggal</div>
            <div class="col-auto">:</div>
            <div class="col">{{ $penjualan->tglPenjualan }}</div>
        </div>
        <div class="row">
            <div class="col">Nama Pelanggan</div>
            <div class="col-auto">:</div>
            <div class="col">{{ $penjualan->pelanggan->namaPelanggan ?? '-' }}</div>
        </div>
    </br>
        <table  border="0" cellpading="5">
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
            @foreach ($penjualan->detail as $value)
                <tr>
                    <td>{{ $value->produk->namaProduk }}</td>
                    <td>{{ number_format($value->produk->harga,2) }}</td>
                    <td class="text-center">{{ $value->jmlProduk }}</td>
                    <td>{{ number_format($value->subtotal,2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" align="right"><strong>Total</strong></td>
                <td colspan="2" align="right">{{ number_format($penjualan->totalHarga,2) }}</td>
            </tr>
            <tr>
                <td colspan="2" align="right"><strong>Bayar</strong></td>
                <td colspan="2" align="right">{{ number_format($penjualan->bayar,2) }}</td>
            </tr>
            <tr>
                <td colspan="2" align="right"><strong>Kembalian</strong></td>
                <td colspan="2" align="right">{{ number_format($penjualan->bayar-$penjualan->totalHarga,2) }}</td>
            </tr>
        </table>
    </br>
    <br>
    <h5 class="text-center">:::  Terima Kasih  :::</h5>

    </div>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>