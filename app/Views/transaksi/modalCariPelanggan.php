<!-- Modal -->
<div class="modal fade" id="modalCariPelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-striped dataTable table-hover table-bordered" style="width: 100%;" id="tableCariPelanggan">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="/pelanggan" class="btn btn-primary">Tambah Pelanggan</a>
            </div>
        </div>
    </div>
</div>


<script>
    function listCariDataPelanggan() {

        $('#tableCariPelanggan').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/transaksi/listCariDataPelanggan",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false,
            }, ],
        })
    }

    function pilihPelanggan(id, nama) {
        $('#pelanggan_transaksi').val(nama);
        $('#id_pelanggan').val(id);
        $('#modalCariPelanggan').modal('hide');
    }

    $(document).ready(function() {
        listCariDataPelanggan();
    });
</script>