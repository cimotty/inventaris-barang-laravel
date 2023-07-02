<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        #catatan {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN INVENTARIS BARANG</h2>
        <h2>BADAN KEPEGAWAIAN DAERAH PROVINSI BENGKULU</h2>
        <p>Tanggal : {{ date('d M Y') }}</p>
    </div>

    <table class="table">
        <tr>
            <th>NO</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Kondisi</th>
        </tr>
        @foreach ($items as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori }}</td>
                <td>Rp {{ number_format($item->harga, 2, ',', '.') }}</td>
                <td>{{ $item->kondisi }}</td>
            </tr>
        @endforeach
    </table>

    <div class="footer">
        <h4>Keterangan :</h4>
        <p>Total asset : <strong>Rp {{ number_format($totalAssets, 2, ',', '.') }}</strong></p>
        <p>Total jumlah barang : <strong>{{ $totalItems }}</strong></p>
        <ul>
            <li>Kondisi <strong>Baik</strong> : <strong>{{ $goodItems }}</strong></li>
            <li>Kondisi <strong>Rusak Ringan</strong> : <strong>{{ $ldItems }}</strong></li>
            <li>Kondisi <strong>Rusak Berat</strong> : <strong>{{ $hdItems }}</strong></li>
        </ul>
        <p>Jumlah barang per kategori :</p>
        <ul>
            <li>Elektronik : <strong>{{ $electronics }}</strong></li>
            <li>Furniture : <strong>{{ $furnitures }}</strong></li>
            <li>Kendaraan : <strong>{{ $vehicles }}</strong></li>
        </ul>
        <p id="catatan">Catatan: Laporan ini berdasarkan data inventaris per tanggal {{ date('d M Y') }} dan dapat
            berubah seiring
            dengan adanya perubahan inventaris barang.</p>
</body>

</html>
