<!-- Modal -->
<div class="modal fade" id="modalPaket" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Paket/Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/paket/tambahPaket', ['class' => 'formPaket']); ?>
                <div class="form-group mb-2">
                    <label for="namaPaket">Nama Paket </label>
                    <input type="text" class="form-control" id="namaPaket" placeholder="Nama Paket" name="namaPaket">
                    <div class="invalid-feedback errNamaPaket">
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="namaPaket">Harga </label>
                    <input type="number" class="form-control" id="hargaPaket" placeholder="Harga Paket" name="hargaPaket">
                    <div class="invalid-feedback errHargaPaket">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-block" id="btnSubmitPaket">Submit</button>
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
    $(document).ready(function() {


        $('.formPaket').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "/paket/tambahPaket",
                data: {
                    namapaket: $('#namaPaket').val(),
                    hargapaket: $('#hargaPaket').val()
                },
                dataType: "json",
                beforeSend: function() {
                    $('#btnSubmitPaket').prop('disabled', true);
                    $('#btnSubmitPaket').html('<i class="fa fa-spinner fa-pulse fa-lg"></i>');
                },
                complete: function() {
                    $('#btnSubmitPaket').prop('disabled', false);
                    $('#btnSubmitPaket').html('Simpan');
                },
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

                        $('#modalPaket').modal('hide');

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
            // return false;



        });











    });
</script>