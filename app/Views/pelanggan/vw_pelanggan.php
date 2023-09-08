<?= $this->extend('template/layout'); ?>


<?= $this->section('header'); ?>
<h5>Pengelolaan Pelanggan</h5>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<button type="button" class="btn btn-success mb-3" id="btnTambahPelanggan">
    <i class="fas fa-user-plus"></i> Tambah Pelanggan
</button>

<div class="container-fluid">
    <table class="table table-striped dataTable table-hover table-bordered" style="width: 100%;" id="tablePelanggan">
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

<div class="viewModalPelanggan">

</div>


<script>
    function listDataPelanggan() {

        $('#tablePelanggan').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/pelanggan/listDataPelanggan",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false,
            }, ],
        })
    }

    function hapusPelanggan(id) {
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
                    url: "/pelanggan/hapusPelanggan",
                    data: {
                        plg_id: id
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
                            listDataPelanggan();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }

    function editPelanggan(id) {
        $.ajax({
            type: "post",
            url: "/pelanggan/editPelanggan",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewModalPelanggan').html(response.data);
                    $('#modalEditPelanggan').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }



    $(document).ready(function() {
        listDataPelanggan();

        $('#btnTambahPelanggan').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/pelanggan/modalTambahPelanggan",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewModalPelanggan').html(response.data);
                        $('#modalPelanggan').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });












    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('footer'); ?>
3
<?= $this->endSection(); ?>