<!-- Modal -->
<div class="modal fade" id="modalPelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/pelanggan/simpanPelanggan', ['class' => 'formPelanggan']) ?>
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <div class="input-group mb-2">
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control">
                        <div class="invalid-feedback errNamaPelanggan">
                        </div>
                    </div>
                    <label for="hp_pelanggan">Telepon Pelanggan</label>
                    <div class="input-group mb-2">
                        <input type="text" name="hp_pelanggan" id="hp_pelanggan" class="form-control">
                        <div class="invalid-feedback errHp">
                        </div>
                    </div>
                    <label for="alamat_pelanggan">Alamat Pelanggan</label>
                    <div class="input-group mb-2">
                        <textarea name="alamat_pelanggan" id="alamat_pelanggan" cols="10" rows="4" class="form-control"></textarea>
                        <div class="invalid-feedback errAlamat">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning btn-block" id="btnSimpanPelanggan">Simpan</button>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.formPelanggan').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/pelanggan/simpanPelanggan",
            data: {
                nama: $('#nama_pelanggan').val(),
                hp: $('#hp_pelanggan').val(),
                alamat: $('#alamat_pelanggan').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('#btnSimpanPelanggan').prop('disabled', true);
                $('#btnSimpanPelanggan').html('<i class="fa fa-spinner fa-pulse fa-lg"></i>');
            },
            complete: function() {
                $('#btnSimpanPelanggan').prop('disabled', false);
                $('#btnSimpanPelanggan').html('Simpan');
            },
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

                if (response.sukses) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#modalPelanggan').modal('hide');
                }

            }
        });
    });
</script>