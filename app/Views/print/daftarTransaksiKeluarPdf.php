<style>
    table,
    td,
    th {
        border: 1px solid black;
        border-collapse: collapse;
    }

    thead {
        background-color: lightblue;
    }

    table {
        width: 100%;
    }

    @page {
        margin: 10px;
    }
</style>

<h2>Daftar Transaksi Keluar</h2>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Invoice</th>
            <th>Nama</th>
            <th>Tanggal Order</th>
            <th>Tanggal Selesai</th>
            <th>Nama Pengambil</th>
            <th>Tanggal Ambil</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $totalSeluruh = 0;
        foreach ($data as $row) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['invoice']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['tgl_order']; ?></td>
                <td><?= $row['tgl_selesai']  ?></td>
                <td><?= $row['nama_pengambil']; ?></td>
                <td><?= $row['tgl_ambil']; ?></td>
                <td><?= $row['totalharga']; ?></td>
            </tr>
        <?php endforeach; ?>


        <?php foreach ($data as $harga) {
            $totalSeluruh += $harga['totalharga'];
        } ?>

        <tr>
            <td colspan="7" style="text-align: center;">TOTAL KESELURUHAN</td>
            <td><?= number_format($totalSeluruh, 0, ',', '.') ?></td>
        </tr>

    </tbody>
</table>