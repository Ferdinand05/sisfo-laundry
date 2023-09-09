<?= $this->extend('template/layout'); ?>



<?= $this->section('header'); ?>
<h5>Transaksi Keluar</h5>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <label for="invoice">Invoice</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Masukkan Invoice" id="invoice" name="invoice">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="btnCariTransaksi"><i class="fas fa-search-dollar"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <label for="tgl">Tanggal Order</label>
            <div class="input-group">
                <input type="date" class="form-control" id="tgl_order" name="tgl_order" disabled>
            </div>
        </div>
        <div class="col-md-2">
            <label for="tgl_selesai">Tanggal Selesai</label>
            <div class="input-group">
                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" disabled>
            </div>
        </div>
        <div class="col-md-1">
            <label for="berat">Berat</label>
            <div class="input-group">
                <input type="text" class="form-control" disabled id="berat">
            </div>
        </div>
        <div class="col-md-2">
            <label for="berat">Total Harga</label>
            <div class="input-group">
                <input type="text" class="form-control" disabled id="totalharga">
            </div>
        </div>
        <div class="col-md">
            <label for="nama">Nama Pelanggan</label>
            <input type="text" class="form-control" disabled id="nama_pelanggan">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="nama_pengambil">Nama</label>
            <div class="input-group">
                <input type="text" class="form-control" id="nama_pengambil" placeholder="Nama Pengambil Barang">
            </div>
        </div>
        <div class="col-md-3">
            <label for="tgl_ambil">Tanggal Pengambilan</label>
            <div class="input-group">
                <input type="date" class="form-control" name="tgl_ambil" id="tgl_ambil">
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Pembayaran</label>
            <div class="input-group">
                <button type="button" class="btn btn-success btn-block" id="btnTransaksiKeluar">Selesaikan Transaksi</button>
            </div>
        </div>
        <div class="col-md-1">
            <label for="">Reset</label>
            <div class="input-group">
                <button type="reset" class="btn btn-dark" id="btnResetTransaksi"><i class="fa fa-sync-alt"></i></button>
            </div>
        </div>
    </div>

    <div class="viewModalTransaksi">

    </div>

</div>



<script>
    function resetTransaksi() {
        $('#invoice').val('');
        $('#tgl_order').val('');
        $('#tgl_selesai').val('');
        $('#berat').val('');
        $('#totalharga').val('');
        $('#nama_pelanggan').val('');
        $('#nama_pengambil').val('');
        $('#tgl_ambil').val('');
    }

    function ambilDataInvoice() {
        let invoice = $('#invoice').val()
        $.ajax({
            type: "post",
            url: "/transaksi/ambilDataInvoice",
            data: {
                invoice: invoice
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    let data = response.sukses;
                    $('#tgl_order').val(data.tgl_order);
                    $('#tgl_selesai').val(data.tgl_selesai);
                    $('#berat').val(data.berat);
                    $('#totalharga').val(data.totalharga);
                    $('#nama_pelanggan').val(data.nama_pelanggan);
                }

                if (response.error) {
                    Swal.fire(
                        'Data Kosong',
                        response.error,
                        'question'
                    )
                }

            }
        });
    }

    function insertTransaksiKeluar() {
        $.ajax({
            type: "post",
            url: "/transaksi/insertTransaksiKeluar",
            data: {
                invoice: $('#invoice').val(),
                tgl_order: $('#tgl_order').val(),
                tgl_selesai: $('#tgl_selesai').val(),
                berat: $('#berat').val(),
                totalharga: $('#totalharga').val(),
                nama: $('#nama_pelanggan').val(),
                nama_ambil: $('#nama_pengambil').val(),
                tgl_ambil: $('#tgl_ambil').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire(
                        'Good job!',
                        response.sukses,
                        'success'
                    );
                }
            }
        });
    }


    $(document).ready(function() {

        $('#invoice').keydown(function(e) {
            if (e.keyCode == 13) {
                ambilDataInvoice();
            }
        });

        $('#btnResetTransaksi').click(function(e) {
            e.preventDefault();
            resetTransaksi();
        });

        $('#btnCariTransaksi').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/transaksi/modalCariTransaksi",
                dataType: "json",
                success: function(response) {
                    $('.viewModalTransaksi').html(response.data);
                    $('#modalCariTransaksi').modal('show');
                }
            });
        });


        $('#btnTransaksiKeluar').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Transaksi akan diselesaikan, dan status Pembayaran akan berubah",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tambahkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    insertTransaksiKeluar();
                    resetTransaksi();
                    listDataTransaksiKeluar();
                }


            })
        });


    });
</script>


<?= $this->endSection(); ?>


<?= $this->section('footer'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <table class="table dataTable table-sm table-hover table-bordered" id="tableTransaksiKeluar" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Invoice</th>
                        <th>Nama</th>
                        <th>Tanggal Order</th>
                        <th>Nama Pengambil</th>
                        <th>Tanggal Diambil</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function listDataTransaksiKeluar() {

        $('#tableTransaksiKeluar').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/transaksi/listDataTransaksiKeluar",
                "type": "POST",
            },
            "columnDefs": [{
                "targets": [0, 1, 7],
                "orderable": false,
            }, ],
        })
    }

    function hapusTransaksiKeluar(invoice) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/transaksi/hapusTransaksiKeluar",
                    data: {
                        invoice: invoice
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
                            });
                            listDataTransaksiKeluar();
                        }
                    }
                });
            }
        })
    }



    $(document).ready(function() {
        listDataTransaksiKeluar();
    });
</script>


<?= $this->endSection(); ?>