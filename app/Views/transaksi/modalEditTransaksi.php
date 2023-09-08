<!-- Modal -->
<div class="modal fade" id="modalEditTransaksi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/transaksi/updateTransaksi', ['class' => 'formEditTransaksi']) ?>
                <?php foreach ($dataTable as $row) : ?>
                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-md">
                                <input type="text" name="invoice" id="invoice" disabled value="<?= $row['invoice']; ?>" class="form-control">
                                <input type="hidden" id="ts_id" value="<?= $row['ts_id']; ?>">
                                <input type="hidden" id="detail_id" value="<?= $row['detail_id']; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <input type="date" name="tgl_order" id="tgl_order" value="<?= $row['ts_tgl']; ?>" disabled class="form-control">
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="tgl_selesai" id="tgl_selesai" value="<?= $row['ts_tgl_selesai']; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md">
                                <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="<?= $row['nama_pelanggan']; ?>" placeholder="Nama Pelanggan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Status Transaksi</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <select name="status_bayar" id="status_bayar" class="form-control">
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="Sudah Bayar">Sudah Bayar</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="status_cucian" id="status_cucian" class="form-control">
                                    <option value="Proses">Proses</option>
                                    <option value="Dicuci">Dicuci</option>
                                    <option value="Diambil">Diambil</option>
                                    <option value="Menunggu Diambil">Menunggu Diambil</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <button class="btn btn-warning btn-block" name="btnUpdateTransaksi" id="btnUpdateTransaksi">Update</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <p style="font-size: 12px;">*Hanya field yang berwarna Putih yang dapat diubah.</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('.formEditTransaksi').submit(function(e) {
            e.preventDefault();

            let status_bayar = $('#status_bayar').val();
            let status_cucian = $('#status_cucian').val();

            $.ajax({
                type: "post",
                url: "/transaksi/updateTransaksi",
                data: {
                    ts_id: $('#ts_id').val(),
                    detail_id: $('#detail_id').val(),
                    tgl_selesai: $('#tgl_selesai').val(),
                    status_bayar: status_bayar,
                    status_cucian: status_cucian,
                    nama_pelanggan: $('#nama_pelanggan').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.sukses,
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }
                    $('#modalEditTransaksi').modal('hide');
                    listDataTransaksi();



                }
            });
        });
    });
</script>