<!-- Modal -->
<div class="modal fade" id="modalCariTransaksi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Daftar Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-bordered table-sm table-hover dataTable" id="tableCariTransaksi" style="width: 100%;">
                        <thead class="bg-info">
                            <tr>
                                <th>No.</th>
                                <th>Invoice</th>
                                <th style="width: 10%;">Pelanggan</th>
                                <th>Tanggal Selesai</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        <tbody>

                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function listCariDataTransaksi() {
        $('#tableCariTransaksi').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/transaksi/listCariDataTransaksi",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, ],
        })
    }

    function pilihTransaksi(ts_id, detail_id) {
        $.ajax({
            type: "post",
            url: "/transaksi/ambilDataTransaksi",
            data: {
                ts_id: ts_id,
                detail_id: detail_id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    let data = response.data;
                    $('#invoice').val(data.invoice);
                    $('#tgl_order').val(data.tgl_order);
                    $('#tgl_selesai').val(data.tgl_selesai);
                    $('#berat').val(data.berat);
                    $('#totalharga').val(data.totalharga);
                    $('#nama_pelanggan').val(data.nama_pelanggan);
                }

                $('#modalCariTransaksi').modal('hide');

            }
        });
    }


    $(document).ready(function() {
        listCariDataTransaksi();
    });
</script>