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

    function hapusPaket(id) {
        Swal.fire({
            title: 'Anda Akan menghapus Item',
            text: "Apakah anda Yakin Akan Menghapus Item Ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/paket/hapusPaket",
                    data: {
                        paket_id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                position: 'top',
                                icon: 'success',
                                title: response.sukses,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            listDataPaket();
                        }
                    }
                });
            }
        })
    }


    function editPaket(id) {
        $.ajax({
            type: "post",
            url: "/paket/editPaket",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewModal').html(response.data);
                    $('#modalEditPaket').modal('show');
                }
            }
        });
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