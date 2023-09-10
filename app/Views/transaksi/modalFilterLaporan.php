<!-- Modal -->
<div class="modal fade" id="modalFilterLaporan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Data Per Tanggal Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tglawal">Tanggal Awal</label>
                    <div class="input-group mb-3">
                        <input type="date" name="tglawal" id="tglawal" class="form-control">
                    </div>
                    <label for="tglakhir">Tanggal Akhir</label>
                    <div class="input-group">
                        <input type="date" name="tglakhir" id="tglakhir" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnFilterLaporan">Filter</button>
            </div>
        </div>
    </div>
</div>


<script>
    function listDataTransaksi() {

        var table = $('#tableTransaksi').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/transaksi/listDataTransaksi",
                "type": "POST",
                "data": {
                    tglawal: $('#tglawal').val(),
                    tglakhir: $('#tglakhir').val()
                }
            },
            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false,
            }, ],
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        })
    }


    $(document).ready(function() {
        $('#btnFilterLaporan').click(function(e) {
            e.preventDefault();
            listDataTransaksi();
            $('#modalFilterLaporan').modal('hide');
        });
    });
</script>