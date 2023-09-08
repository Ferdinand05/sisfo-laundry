<?= $this->extend('template/layout'); ?>


<?= $this->section('header'); ?>
<h5>Daftar Transaksi</h5>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
	<table class="table table-bordered table-hover dataTable" id="tableTransaksi" style="width: 100%;">
		<thead class="bg-info">
			<tr>
				<th>No.</th>
				<th>Invoice</th>
				<th style="width: 10%;">Pelanggan</th>
				<th>Tanggal Order</th>
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





<script>
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
				"targets": [0, 4, 5],
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
			}
		});
	}



	$(document).ready(function() {
		listDataTransaksi();
	});
</script>




<?= $this->endSection(); ?>

<?= $this->section('footer'); ?>
<a href="/transaksi/transaksiKeluar" class="btn btn-danger">Transaksi Keluar</a>
<?= $this->endSection(); ?>