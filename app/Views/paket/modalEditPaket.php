<!-- Modal -->
<div class="modal fade" id="modalEditPaket" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/paket/updatePaket', ['class' => 'formEditPaket']); ?>
                <div class="form-group mb-2">
                    <label for="namaPaket">Nama Paket </label>
                    <input type="text" class="form-control" id="namaPaket" placeholder="Nama Paket" name="namaPaket" value="<?= $dataPaket['paket_nama'] ?>">
                    <input type="hidden" name="paket_id" id="paket_id" value="<?= $dataPaket['paket_id']; ?>">
                    <div class="invalid-feedback errNamaPaket">
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="namaPaket">Harga </label>
                    <input type="number" class="form-control" id="hargaPaket" placeholder="Harga Paket" name="hargaPaket" value="<?= $dataPaket['paket_harga']; ?>">
                    <div class="invalid-feedback errHargaPaket">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-block" id="btnEditPaket">Update</button>
                </div>
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('.formEditPaket').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: "/paket/updatePaket",
            data: {
                paket_id: $('#paket_id').val(),
                paket_nama: $('#namaPaket').val(),
                paket_harga: $('#hargaPaket').val()
            },
            dataType: "json",
            success: function(response) {

                if (response.error) {
                    let e = response.error;

                    if (e.errorNamaPaket) {
                        $('#namaPaket').addClass(' is-invalid');
                        $('.errNamaPaket').html(e.errorNamaPaket);
                    }

                    if (e.errorHargaPaket) {
                        $('#hargaPaket').addClass(' is-invalid');
                        $('.errHargaPaket').html(e.errorHargaPaket);
                    }
                }

                if (response.sukses) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1200
                    });
                    listDataPaket();
                    $('#modalEditPaket').modal('hide');

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    });
</script>