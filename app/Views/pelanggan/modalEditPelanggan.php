<!-- Modal -->
<div class="modal fade" id="modalEditPelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal Edit Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/pelanggan/updatePelanggan', ['class' => 'formEditPelanggan']) ?>
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <div class="input-group mb-2">
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="<?= $pelanggan['plg_nama']; ?>">
                        <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $pelanggan['plg_id']; ?>">
                        <div class="invalid-feedback errNamaPelanggan">
                        </div>
                    </div>
                    <label for="hp_pelanggan">Telepon Pelanggan</label>
                    <div class="input-group mb-2">
                        <input type="text" name="hp_pelanggan" id="hp_pelanggan" class="form-control" value="<?= $pelanggan['plg_hp']; ?>">
                        <div class="invalid-feedback errHp">
                        </div>
                    </div>
                    <label for="alamat_pelanggan">Alamat Pelanggan</label>
                    <div class="input-group mb-2">
                        <textarea name="alamat_pelanggan" id="alamat_pelanggan" cols="10" rows="4" class="form-control"><?= $pelanggan['plg_alamat']; ?></textarea>
                        <div class="invalid-feedback errAlamat">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning btn-block" id="btnUpdatePelanggan">Update</button>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('.formEditPelanggan').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/pelanggan/updatePelanggan",
            data: {
                nama: $('#nama_pelanggan').val(),
                hp: $('#hp_pelanggan').val(),
                alamat: $('#alamat_pelanggan').val(),
                id: $('#id_pelanggan').val()
            },
            dataType: "json",
            success: function(response) {

                if (response.error) {
                    let e = response.error;

                    if (e.errorNamaPelanggan) {
                        $('#nama_pelanggan').addClass('is-invalid');
                        $('.errNamaPelanggan').html(e.errorNamaPelanggan);
                    }

                    if (e.errorHpPelanggan) {
                        $('#hp_pelanggan').addClass('is-invalid');
                        $('.errHp').html(e.errorHpPelanggan);
                    }

                }



                // berahasil diupdate
                if (response.sukses) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1200
                    });
                    $('#modalEditPelanggan').modal('hide');
                    listDataPelanggan();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
</script>