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
                <input type="date" class="form-control" name="tgl_ambil" id="tgl_ambil" value="<?= date('Y-m-d'); ?>">
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


    });
</script>


<?= $this->endSection(); ?>


<?= $this->section('footer'); ?>

<?= $this->endSection(); ?>