<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Transaksi</title>

    <style>
        table {
            border-collapse: collapse;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        th,
        td {
            padding: 5px;

        }

        th {
            font-size: 14px;
        }

        @media print {
            #faktur {
                margin-top: 150px;
            }
        }
    </style>


</head>

<body onload="window.print()">

    <table border="0" style="width: 100%; margin-bottom:10px">
        <tr>
            <td colspan="3" style="font-size: 32px; font-weight:bold">FEAR LAUNDRY</td>
        </tr>
        <tr>
            <td>📌 Jl.H.Holil Kreo Larangan</td>
        </tr>
        <tr>
            <td>📞 098123124</td>
        </tr>
    </table>
    <hr style="margin-bottom: 15px;">
    <table border="1" style="width: 100%;">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal Order</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Pakaian</th>
                <th>Jenis Pakaian</th>
                <th>Paket Layanan</th>
                <th>Berat</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data  as $row) : ?>
                <caption style="font-weight: bold;font-size:20px"># <?= $row['invoice']; ?></caption>
                <tr>
                    <td style="text-align: center;font-size:13px"><?= $row['nama_pelanggan']; ?></td>
                    <td style="text-align: center;font-size:13px"><?= $row['ts_tgl']; ?></td>
                    <td style="text-align: center;font-size:13px"><?= $row['ts_tgl_selesai']; ?></td>
                    <td style="text-align: center;font-size:13px"><?= $row['jumlah_pakaian']; ?></td>
                    <td style="text-align: center;font-size:13px"><?= $row['jenis_pakaian']; ?></td>
                    <td style="text-align: center;font-size:13px"><?= $row['paket_nama'] .  " ("  . $row['paket_harga'] . ")" ?></td>
                    <td style="text-align: center;font-size:13px"><?= $row['ts_berat']; ?></td>
                    <td style="text-align: center;font-size:13px"><?= number_format($row['totalharga'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



</body>

</html>