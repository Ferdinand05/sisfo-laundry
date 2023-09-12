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

<h2>Daftar Transaki Masuk</h2>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Invoice</th>
            <th>Nama</th>
            <th>Tanggal Order</th>
            <th>Tanggal Selesai</th>
            <th>Berat</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data as $row) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['invoice']; ?></td>
                <td><?= $row['nama_pelanggan']; ?></td>
                <td><?= $row['ts_tgl']; ?></td>
                <td><?= $row['ts_tgl_selesai']  ?></td>
                <td><?= $row['ts_berat']; ?></td>
                <td><?= $row['totalharga']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>