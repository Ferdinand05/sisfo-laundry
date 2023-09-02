<?= $this->extend('template/layout'); ?>


<?= $this->section('header'); ?>
<h5>Pengelolaan Jenis Paket/Layanan</h5>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<button type="button" class="btn btn-success mb-3" id="btnTambahPaket">
    <i class="fa fa-plus"></i> Tambah Paket/Layanan
</button>

<div class="container-fluid">
    <table class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;" id="tablePaket">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="viewModal"></div>

<script>
    function listDataPaket() {

        $('#tablePaket').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/paket/listDataPaket",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 3],
                "orderable": false,
            }, ],
        })
    }


    $(document).ready(function() {
        listDataPaket();

        $('#btnTambahPaket').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "/paket/modalTambahPaket",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewModal').html(response.data);
                        $('#modalPaket').modal('show');
                    }
                }
            });

        });

    });
</script>


<?= $this->endSection(); ?>

<?= $this->section('footer'); ?>
<p>Hanya boleh diakses oleh Admin</p>
<?= $this->endSection(); ?>