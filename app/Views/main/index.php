<?= $this->extend('template/layout'); ?>


<?= $this->section('header'); ?>
<h4>SELAMAT DATANG</h4>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container">

    <h5 class="mb-3">Ada<strong> <?= $pelanggan; ?> Pelanggan</strong> Yang Terdaftar Di Sistem</h5>

    <caption>
        <h4>Daftar Transaksi Hari Ini - <?= date('d M Y') ?></h4>
    </caption>
    <table class="table">

        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Invoice</th>
                <th>Tanggal Order</th>
                <th>Berat</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($dataTransaksi as $row) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['nama_pelanggan']; ?></td>
                    <td><?= $row['invoice']; ?></td>
                    <td><?= $row['ts_tgl']; ?></td>
                    <td><?= $row['ts_berat']; ?></td>
                    <td><?= number_format($row['totalharga'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>

<?= $this->section('footer'); ?>
<div class="container">
    <div class="d-flex justify-content-around">
        <h4>Belum Bayar <span class="badge badge-success"> <?= $belumbayar; ?> </span></h4>
        <h4>Proses <span class="badge badge-info"> <?= $proses; ?> </span></h4>
        <h4>Menunggu Diambil <span class="badge badge-primary"> <?= $menunggu; ?> </span></h4>
    </div>

</div>
<?= $this->endSection(); ?>