<?= $this->extend('template/layout'); ?>


<?= $this->section('header'); ?>
<h5>Transaksi Order</h5>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <?= form_open('/transaksi/tambahTransaksi', ['class' => 'formTransaksi']) ?>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="tgl_transaksi">Tanggal</label>
                <div class="input-group">
                    <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="pelanggan_transaksi">Pelanggan</label>
                <div class="input-group">
                    <input type="text" name="pelanggan_transaksi" id="pelanggan_transaksi" class="form-control" placeholder="Pelanggan" required>
                    <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="btnCariPelanggan"><i class="fa fa-users"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="paket_transaksi">Paket/Layanan</label>
                <div class="input-group">
                    <select name="paket_transaksi" id="paket_transaksi" class="form-control">
                        <?php foreach ($dataPaket as $row) : ?>
                            <option value="<?= $row['paket_id']; ?>"><?= $row['paket_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="berat_transaksi">Berat(kg)</label>
                <div class="input-group">
                    <input type="number" name="berat_transaksi" id="berat_transaksi" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="jumlah_pakaian">Jumlah Pakaian</label>
                <div class="input-group">
                    <input type="number" name="jumlah_pakaian" id="jumlah_pakaian" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="jenis_pakaian">Jenis Pakaian</label>
                <div class="input-group">
                    <input type="text" name="jenis_pakaian" id="jenis_pakaian" placeholder="Jenis Pakaian" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="tgl_selesai">Tanggal Selesai</label>
                <div class="input-group">
                    <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="status">Status Transaksi</label>
                <div class="input-group">
                    <select name="status_transaksi" id="status_transaksi" class="form-control">
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="Sudah Bayar">Sudah Bayar</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <label for="btnTambahTransaksi">Tambah Orderan</label>
            <div class="input-group">
                <button type="submit" class="btn btn-success btn-block" id="btnTambahTransaksi"><i class="fa fa-cash-register"></i> Tambah Transaksi</button>
            </div>
        </div>
        <div class="col-md-2">
            <label for="">Reset</label>
            <div class="input-group">
                <button type="reset" class="btn btn-dark" title="Reset Inputan"><i class="fas fa-sync-alt"></i></button>
            </div>
        </div>
    </div>
    <?= form_close() ?>

    <div class="viewModalCariPelanggan"></div>
</div>



<script>
    function kosong() {
        $('#id_pelanggan').val('');
        $('#berat_transaksi').val('');
        $('#jumlah_pakaian').val('');
        $('#jenis_pakaian').val('');
        $('#pelanggan_transaksi').val('');
    }

    $(document).ready(function() {
        $('.formTransaksi').submit(function(e) {
            e.preventDefault();
            let tgl_pesan = $('#tgl_transaksi').val();
            let nama_pelanggan = $('#id_pelanggan').val();
            let paket = $('#paket_transaksi').val();
            let berat = $('#berat_transaksi').val();
            let jumlah_pakaian = $('#jumlah_pakaian').val();
            let jenis_pakaian = $('#jenis_pakaian').val();
            let tgl_selesai = $('#tgl_selesai').val();
            let status_transaksi = $('#status_transaksi').val();
            let pelanggan = $('#pelanggan_transaksi').val();
            if (berat.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Berat Pakaian tidak boleh Kosong',
                })
            } else {

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Transaksi atas nama " + pelanggan + " Akan ditambahkan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Tambah Order'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "/transaksi/tambahTransaksi",
                            data: {
                                tgl_pesan: tgl_pesan,
                                nama_pelanggan: pelanggan,
                                id_pelanggan: nama_pelanggan,
                                paket: paket,
                                berat: berat,
                                jumlah_pakaian: jumlah_pakaian,
                                jenis_pakaian: jenis_pakaian,
                                tgl_selesai: tgl_selesai,
                                status_transaksi: status_transaksi
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: response.sukses,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    kosong();
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + '\n' + thrownError);
                            }
                        });
                    }
                })

            }
        });




    });



    $('#btnCariPelanggan').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/transaksi/modalCariPelanggan",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewModalCariPelanggan').html(response.data);
                    $('#modalCariPelanggan').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
</script>

<?= $this->endSection(); ?>

<?= $this->section('footer'); ?>
<a href="/transaksi/daftarTransaksi" class="btn btn-danger">Lihat Daftar Transaksi</a>


<div class="card-deck mt-2">
    <a href="/pelanggan" class="card text-white bg-primary mb-3  " style="max-width: 18rem;">
        <div class="card-header text-center"> Jumlah Pelanggan</div>
        <div class="card-body  ">
            <h4 class="text-center"><?= $jumlahPelanggan; ?> Pelanggan</h4>
        </div>
    </a>
    <a href="/paket" class="card text-white bg-info mb-3" style="max-width: 18rem;">
        <div class="card-header text-center">Jumlah Paket/Layanan</div>
        <div class="card-body  ">
            <h4 class="text-center"><?= $jumlahPaket; ?> Paket</h4>
        </div>
    </a>
</div>



<?= $this->endSection(); ?>