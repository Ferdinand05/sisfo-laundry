<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelPelanggan;
use App\Models\ModelTransaksi;
use App\Models\ModelTransaksiKeluar;

class Main extends BaseController
{
    public function index()
    {
        $modelDetailTransaksi = new ModelDetailTransaksi();
        $modelTransaksi = new ModelTransaksi();
        $modelPelanggan = new ModelPelanggan();
        $modelTransaksiKeluar = new ModelTransaksiKeluar();
        $tgl = date('Y-m-d');
        $dataTransaksi = $modelTransaksi->where('ts_tgl', $tgl)->join('detail_transaksi', 'ts_id=dettransaksi_id')->get()->getResultArray();

        $belumbayar = $modelTransaksi->where('ts_status', 'Belum Bayar')->countAllResults();
        $menunggu = $modelTransaksi->where('ts_status_cucian', 'Menunggu Diambil')->countAllResults();
        $proses = $modelTransaksi->where('ts_status_cucian', 'Proses')->countAllResults();
        $data = [
            'dataTransaksi' => $dataTransaksi,
            'belumbayar' => $belumbayar,
            'menunggu' => $menunggu,
            'proses' => $proses,
            'pelanggan' => $modelPelanggan->countAllResults()
        ];


        return view('main/index', $data);
    }
}
