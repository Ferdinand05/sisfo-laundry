<!-- Modal -->
<div class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-striped">
                        <?php foreach ($data->getResultArray() as $row) : ?>
                            <tr>
                                <th>
                                    <h5><b>#INVOICE</b></h5>
                                </th>
                                <th>
                                    <h5><b>: <?= $row['invoice']; ?></b></h5>
                                </th>
                            </tr>
                            <tr>
                                <td>Nama Pelanggan</td>
                                <td>: <?= $row['nama_pelanggan']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Order - Selesai</td>
                                <td>: <?= date('d-m-Y', strtotime($row['ts_tgl']))  . ' - ' . date('d-m-Y', strtotime($row['ts_tgl_selesai']))  ?></td>
                            </tr>
                            <tr>
                                <td>Paket/Layanan</td>
                                <td>: <?= $row['paket_nama'] . '(' . number_format($row['paket_harga'], 0, ',', '.') . ')' ?></td>
                            </tr>

                            <tr>
                                <td>Berat</td>
                                <td>: <?= $row['ts_berat'] . ' Kg'; ?></td>
                            </tr>
                            <tr>
                                <td>Total Harga </td>
                                <td>: <?= number_format($row['totalharga'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>: <?= $row['jenis_pakaian']; ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Pakaian</td>
                                <td>: <?= $row['jumlah_pakaian']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>