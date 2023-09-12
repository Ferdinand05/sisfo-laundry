<?= $this->extend('template/layout'); ?>


<?= $this->section('header'); ?>
<h5>Daftar Transaksi</h5>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
	<div class="row mb-3">
		<div class="col-md-3">
			<button class="btn btn-primary btn-block" id="btnModalFilter"><i class="fas fa-filter"></i> Filter Per Tanggal Order</button>
		</div>
		<div class="col-md-2">
			<div class="input-group mb-3">
				<input type="number" class="form-control" value="10" placeholder="Jumlah Print Data" id="jumlah_print">
				<div class="input-group-append">
					<button class="btn btn-sm btn-primary" type="button" id="btnPrintData" onclick="printPdf()"> <i class="fas fa-lg fa-file-pdf"></i> Laporan PDF</button>
				</div>
			</div>
		</div>
	</div>

	<table class="table table-bordered table-hover dataTable" id="tableTransaksi" style="width: 100%;">
		<thead class="bg-info">
			<tr>
				<th>No.</th>
				<th>Invoice</th>
				<th style="width: 7%;">Pelanggan</th>
				<th style="width: 9%;">Tanggal Order</th>
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

<div class="modalDetailTransaksi"></div>

<div class="ModalfilterLaporan"></div>



<script>
	function modalFilterLaporan() {
		$.ajax({
			type: "post",
			url: "/transaksi/modalFilterLaporan",
			dataType: "json",
			success: function(response) {
				if (response.data) {
					$('.ModalfilterLaporan').html(response.data);
					$('#modalFilterLaporan').modal('show');
				}
			}
		});
	}

	function printPdf() {
		let jumlah_print = $('#jumlah_print').val();

		window.open('/transaksi/printpdf/' + jumlah_print);

	}

	function listDataTransaksi() {

		$('#tableTransaksi').DataTable({
			destroy: true,
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "/transaksi/listDataTransaksi",
				"type": "POST",
			},
			"columnDefs": [{
				"targets": [0, 1, 7],
				"orderable": false,
			}, ],
		})
	}




	function hapusTransaksi(ts_id, det_id) {
		Swal.fire({
			title: 'Apakah Kamu Yakin?',
			text: "Data yang dihapus, tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					url: "/transaksi/hapusTransaksi",
					data: {
						ts_id: ts_id,
						detail_id: det_id
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

							listDataTransaksi();
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(xhr.status + '\n' + thrownError);
					}
				});
			}
		})
	}

	function detailTransaksi(ts_id, det_id) {
		$.ajax({
			type: "post",
			url: "/transaksi/detailTransaksi",
			data: {
				ts_id: ts_id,
				detail_id: det_id
			},
			dataType: "json",
			success: function(response) {
				if (response.sukses) {
					$('.modalDetailTransaksi').html(response.sukses);
					$('#modalDetail').modal('show');
				}
			}
		});
	}


	function editTransaksi(ts_id, det_id) {
		$.ajax({
			type: "post",
			url: "/transaksi/editTransaksi",
			data: {
				ts_id: ts_id,
				detail_id: det_id
			},
			dataType: "json",
			success: function(response) {
				if (response.data) {
					$('.modalDetailTransaksi').html(response.data);
					$('#modalEditTransaksi').modal('show');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.status + '\n' + thrownError);
			}
		});
	}



	$(document).ready(function() {
		listDataTransaksi();

		$('#btnModalFilter').click(function(e) {
			e.preventDefault();
			modalFilterLaporan();
		});





	});
</script>




<?= $this->endSection(); ?>

<?= $this->section('footer'); ?>

<a href="/transaksi/transaksiKeluar" class="m-2 btn btn-danger">Transaksi Keluar</a>



<div class="float-right p-2">
	<button type="button" class=" btn-sm btn-success">
		Belum Bayar <span class="badge badge-light"><?= $belumbayar; ?></span>
	</button>
	<button type="button" class="btn-sm btn-warning">
		Sudah Bayar <span class="badge badge-light"><?= $sudahbayar; ?></span>
	</button>
	<button type="button" class=" btn-sm btn-danger">
		Diambil <span class="badge badge-light"><?= $diambil; ?></span>
	</button>
	<button type="button" class=" btn-sm btn-primary">
		Menunggu Diambil <span class="badge badge-light"><?= $menunggu; ?></span>
	</button>
</div>


<?= $this->endSection(); ?>