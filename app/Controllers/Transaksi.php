<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelDTCariTransaksi;
use App\Models\ModelPaket;
use App\Models\ModelTransaksi;
use App\Models\ModelDTPelanggan;
use App\Models\ModelDTTransaksi;
use App\Models\ModelDTTransaksiKeluar;
use App\Models\ModelPelanggan;
use App\Models\ModelSelesaiTransaksi;
use App\Models\ModelTransaksiKeluar;
use Config\Services;

class Transaksi extends BaseController
{
    protected $tableTransaksi;

    public function __construct()
    {
        $this->tableTransaksi = new ModelTransaksi();
    }
    public function index()
    {

        $tablePaket = new ModelPaket();
        $tablePelanggan = new ModelPelanggan();
        $data = [
            'dataPaket' => $tablePaket->findAll(),
            'jumlahPaket' => $tablePaket->countAll(),
            'jumlahPelanggan' => $tablePelanggan->countAll()
        ];

        return view('transaksi/vw_transaksi', $data);
    }

    public function modalCariPelanggan()
    {

        $data = [
            'data' => view('transaksi/modalCariPelanggan')
        ];

        return $this->response->setJSON($data);
    }

    public function listCariDataPelanggan()
    {
        $request = Services::request();
        $datamodel = new ModelDTPelanggan($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnPilih = '<button type="button" class="btn btn-secondary btn-sm" onclick="pilihPelanggan(\'' . $list->plg_id . '\',\'' . $list->plg_nama . '\')"><i class="fas fa-mouse-pointer" title="Pilih"></i></button>';
                // $btnHapus = '<button type="button" class="btn btn-danger " onclick="hapusPelanggan(\'' . $list->plg_id . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->plg_nama;
                $row[] = $list->plg_hp;
                $row[] = $list->plg_alamat;
                $row[] = $btnPilih;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function tambahTransaksi()
    {
        if ($this->request->isAJAX()) {

            $tgl_pesan = $this->request->getPost('tgl_pesan');
            $nama_pelanggan = $this->request->getPost('nama_pelanggan');
            $idpelanggan = $this->request->getPost('id_pelanggan');
            $paket = $this->request->getPost('paket');
            $berat = $this->request->getPost('berat');
            $jumlah_pakaian = $this->request->getPost('jumlah_pakaian');
            $jenis_pakaian = $this->request->getPost('jenis_pakaian');
            $tgl_selesai = $this->request->getPost('tgl_selesai');
            $status_transaksi = $this->request->getPost('status_transaksi');

            $tablePaket = new ModelPaket();
            $hargaPaket = $tablePaket->find($paket);

            $totalharga = $berat *  intval($hargaPaket['paket_harga']);


            $this->tableTransaksi->insert([
                'ts_tgl' => $tgl_pesan,
                'ts_pelangganid' => $idpelanggan,
                'ts_paketid' => $paket,
                'ts_berat' => $berat,
                'ts_tgl_selesai' => $tgl_selesai,
                'ts_status' => $status_transaksi
            ]);

            $barisAkhir = $this->tableTransaksi->builder('transaksi')->get()->getLastRow('array');
            $id_transaksi = $barisAkhir['ts_id'];
            $modelDetailTransaksi = new ModelDetailTransaksi();
            $modelDetailTransaksi->insert([
                'dettransaksi_id' => $id_transaksi,
                'nama_pelanggan' => $nama_pelanggan,
                'detpaket_id' => $paket,
                'invoice' => 'INV' . date('dmy') . 000 . intval($id_transaksi),
                'jumlah_pakaian' => $jumlah_pakaian,
                'jenis_pakaian' => $jenis_pakaian,
                'totalharga' => $totalharga
            ]);

            $json = [
                'sukses' => 'Transaksi Berhasil Ditambahkan!'
            ];

            return $this->response->setJSON($json);
        } else {

            exit('tidak bisa diakses');
        }
    }






    public function daftarTransaksi()
    {

        $sudahbayar = $this->tableTransaksi->where('ts_status', 'Sudah Bayar')->countAllResults();
        $belumbayar = $this->tableTransaksi->where('ts_status', 'Belum Bayar')->countAllResults();
        $diambil = $this->tableTransaksi->where('ts_status_cucian', 'Diambil')->countAllResults();

        $data = [
            'sudahbayar' => $sudahbayar,
            'belumbayar' => $belumbayar,
            'diambil' => $diambil
        ];


        return view('transaksi/daftarTransaksi', $data);
    }


    public function listDataTransaksi()
    {
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');
        $request = Services::request();
        $datamodel = new ModelDTTransaksi($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnDetail = '<button type="button" class="btn btn-info text-center" onclick="detailTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Detail"><i class="fas fa-info-circle"></i></button>';
                $btnEdit = '<button type="button" class="btn btn-primary text-center" onclick="editTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Edit"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger text-center" onclick="hapusTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Hapus"><i class="fa fa-trash-alt"></i></button>';
                $btnPrint = '<button type="button" class="btn btn-secondary text-center" onclick="printTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Print"><i class="fa fa-print"></i></button>';
                if ($list->ts_status == "Sudah Bayar") {
                    $btnStatus = '<span class="badge badge-warning d-block mb-1">' . $list->ts_status . '</span>';
                } else {
                    $btnStatus = '<span class="badge badge-success d-block mb-1">' . $list->ts_status . '</span>';
                }

                if ($list->ts_status_cucian == "Diambil") {

                    $btnStatusCucian = '<span class="badge badge-danger d-block">' . $list->ts_status_cucian . '</span>';
                } else {
                    $btnStatusCucian = '<span class="badge badge-primary d-block">' . $list->ts_status_cucian . '</span>';
                }

                $row[] = $no;
                $row[] = $list->invoice;
                $row[] = $list->nama_pelanggan;
                $row[] = $list->ts_tgl;
                $row[] = $list->ts_tgl_selesai;
                $row[] =  number_format($list->totalharga, 0, ',', '.');
                $row[] =  $btnStatus . $btnStatusCucian;
                $row[] = $btnDetail . " " . $btnEdit . " " . $btnPrint . " " . $btnHapus;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }


    public function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {
            $ts_id = $this->request->getPost('ts_id');
            $detail_id = $this->request->getPost('detail_id');

            $modelDetailTransaksi = new ModelDetailTransaksi();

            $modelDetailTransaksi->delete($detail_id);
            $this->tableTransaksi->delete($ts_id);

            $json = [
                'sukses' => 'Data Transaksi Berhasil Dihapus!'
            ];

            return $this->response->setJSON($json);
        } else {
            exit('Tidak Bisa Diakses');
        }
    }

    public function detailTransaksi()
    {

        if ($this->request->isAJAX()) {
            $ts_id = $this->request->getPost('ts_id');
            $detail_id = $this->request->getPost('detail_id');

            $data = [
                'data' => $this->tableTransaksi->showJoinData($ts_id),
            ];

            $json = [
                'sukses' => view('transaksi/modalDetail', $data)
            ];
        }

        return $this->response->setJSON($json);
    }

    public function editTransaksi()
    {

        if ($this->request->isAJAX()) {

            $ts_id = $this->request->getPost('ts_id');
            $detail_id = $this->request->getPost('detail_id');

            $joinTable = $this->tableTransaksi->builder('transaksi t')->join('detail_transaksi as d', 't.ts_id=d.dettransaksi_id')
                ->where('ts_id', $ts_id)->where('detail_id', $detail_id)->get();

            $data = [
                'dataTable' => $joinTable->getResultArray()
            ];

            $json = [
                'data' => view('transaksi/modalEditTransaksi', $data)
            ];


            return $this->response->setJSON($json);
        } else {
            exit('tidak bisa diakses');
        }
    }

    public function updateTransaksi()
    {
        if ($this->request->isAJAX()) {

            $ts_id = $this->request->getPost('ts_id');
            $detail_id = $this->request->getPost('detail_id');
            $tgl_selesai = $this->request->getPost('tgl_selesai');
            $status_bayar = $this->request->getPost('status_bayar');
            $status_cucian = $this->request->getPost('status_cucian');
            $nama_pelanggan = $this->request->getPost('nama_pelanggan');

            $tableDetailTransaksi = new ModelDetailTransaksi();
            $tableDetailTransaksi->update($detail_id, [
                'nama_pelanggan' => $nama_pelanggan
            ]);

            $this->tableTransaksi->update($ts_id, [
                'ts_tgl_selesai' => $tgl_selesai,
                'ts_status' => $status_bayar,
                'ts_status_cucian' => $status_cucian
            ]);

            $json = [
                'sukses' => 'Data Transaksi Berhasil Diubah!'
            ];


            return $this->response->setJSON($json);
        } else {
            exit('Tidak bisa Diakses!');
        }
    }




    //# selesai transaksi / transaksi keluar
    public function transaksiKeluar()
    {


        return view('transaksi/transaksiKeluar');
    }

    public function ambilDataInvoice()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getPost('invoice');

            $modelDetailTransaksi = new ModelDetailTransaksi();

            // pengganti Find, jika data bukan Primary Key

            if ($invoice == null) {
                $json = [
                    'error' => ' Data Transaksi Tidak Ditemukan'
                ];
            } else {

                $tableDetailTransaksi = $modelDetailTransaksi->where('invoice', $invoice)->first();
                $tableTransaksi = $this->tableTransaksi->find($tableDetailTransaksi['dettransaksi_id']);

                $data = [
                    'tgl_order' => $tableTransaksi['ts_tgl'],
                    'tgl_selesai' => $tableTransaksi['ts_tgl_selesai'],
                    'berat' => $tableTransaksi['ts_berat'],
                    'totalharga' => $tableDetailTransaksi['totalharga'],
                    'nama_pelanggan' => $tableDetailTransaksi['nama_pelanggan']
                ];

                $json = [
                    'sukses' => $data
                ];
            }

            return $this->response->setJSON($json);
        } else {
            exit('Tidak Bisa Diakses!');
        }
    }

    public function modalCariTransaksi()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('transaksi/modalCariTransaksi')
            ];


            return $this->response->setJSON($json);
        }
    }

    public function listCariDataTransaksi()
    {
        $request = Services::request();
        $datamodel = new ModelDTCariTransaksi($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnSelect = '<button type="button" class="btn btn-dark text-center" onclick="pilihTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Select"><i class="fas fa-hand-pointer"></i></button>';
                // $btnEdit = '<button type="button" class="btn btn-primary text-center" onclick="editTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Edit"><i class="fa fa-edit"></i></button>';
                // $btnHapus = '<button type="button" class="btn btn-danger text-center" onclick="hapusTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Hapus"><i class="fa fa-trash-alt"></i></button>';
                // $btnPrint = '<button type="button" class="btn btn-secondary text-center" onclick="printTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Print"><i class="fa fa-print"></i></button>';
                if ($list->ts_status == "Sudah Bayar") {
                    $btnStatus = '<span class="badge badge-warning d-block mb-1">' . $list->ts_status . '</span>';
                } else {
                    $btnStatus = '<span class="badge badge-success d-block mb-1">' . $list->ts_status . '</span>';
                }

                if ($list->ts_status_cucian == "Diambil") {

                    $btnStatusCucian = '<span class="badge badge-danger d-block">' . $list->ts_status_cucian . '</span>';
                } else {
                    $btnStatusCucian = '<span class="badge badge-primary d-block">' . $list->ts_status_cucian . '</span>';
                }

                $row[] = $no;
                $row[] = $list->invoice;
                $row[] = $list->nama_pelanggan;
                $row[] = $list->ts_tgl_selesai;
                $row[] =  number_format($list->totalharga, 0, ',', '.');
                $row[] =  $btnStatus . $btnStatusCucian;
                $row[] = $btnSelect;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function ambilDataTransaksi()
    {
        if ($this->request->isAJAX()) {
            $ts_id = $this->request->getPost('ts_id');
            $detail_id = $this->request->getPost('detail_id');
            $modelDetailTransaksi = new ModelDetailTransaksi();

            $tableDetailTransaksi = $modelDetailTransaksi->find($detail_id);
            $tableTransaksi = $this->tableTransaksi->find($ts_id);

            $data = [
                'invoice' => $tableDetailTransaksi['invoice'],
                'tgl_order' => $tableTransaksi['ts_tgl'],
                'tgl_selesai' => $tableTransaksi['ts_tgl_selesai'],
                'berat' => $tableTransaksi['ts_berat'],
                'totalharga' => $tableDetailTransaksi['totalharga'],
                'nama_pelanggan' => $tableDetailTransaksi['nama_pelanggan']
            ];

            $json = [
                'data' => $data
            ];

            return $this->response->setJSON($json);
        }
    }


    public function insertTransaksiKeluar()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getPost('invoice');
            $tgl_order = $this->request->getPost('tgl_order');
            $tgl_selesai = $this->request->getPost('tgl_selesai');
            $berat = $this->request->getPost('berat');
            $totalharga = $this->request->getPost('totalharga');
            $nama = $this->request->getPost('nama');
            $nama_pengambil = $this->request->getPost('nama_ambil');
            $tgl_ambil = $this->request->getPost('tgl_ambil');

            $modelDetailTransaksi = new ModelDetailTransaksi();
            $tableDetailTransaksi = $modelDetailTransaksi->where('invoice', $invoice)->first();
            $transaksiId = $tableDetailTransaksi['dettransaksi_id'];
            // update status bayar
            $this->tableTransaksi->update($transaksiId, [
                'ts_status' => 'Sudah Bayar'
            ]);

            $modelTransaksiKeluar = new ModelTransaksiKeluar();

            $modelTransaksiKeluar->insert([
                'invoice' => $invoice,
                'berat' => $berat,
                'tgl_order' => $tgl_order,
                'tgl_selesai' => $tgl_selesai,
                'nama' => $nama,
                'nama_pengambil' => $nama_pengambil,
                'tgl_ambil' => $tgl_ambil,
                'totalharga' => $totalharga
            ]);

            $json = [
                'sukses' => 'Transaksi Berhasil Diselesaikan!'
            ];


            return $this->response->setJSON($json);
        }
    }



    // data table transaksi keluar
    public function listDataTransaksiKeluar()
    {
        $request = Services::request();
        $datamodel = new ModelDTTransaksiKeluar($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                // $btnSelect = '<button type="button" class="btn btn-dark text-center" onclick="pilihTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Select"><i class="fas fa-hand-pointer"></i></button>';
                // $btnEdit = '<button type="button" class="btn btn-primary text-center" onclick="editTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Edit"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger btn-sm text-center" onclick="hapusTransaksiKeluar(\'' . $list->invoice . '\')" title="Hapus"><i class="fa fa-trash-alt"></i></button>';
                // $btnPrint = '<button type="button" class="btn btn-secondary text-center" onclick="printTransaksi(\'' . $list->ts_id . '\',\'' . $list->detail_id . '\')" title="Print"><i class="fa fa-print"></i></button>';

                $row[] = $no;
                $row[] = $list->invoice;
                $row[] = $list->nama;
                $row[] = $list->tgl_order;
                $row[] = $list->nama_pengambil;
                $row[] = $list->tgl_ambil;
                $row[] =  number_format($list->totalharga, 0, ',', '.');
                $row[] = $btnHapus;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function hapusTransaksiKeluar()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getPost('invoice');

            $tableTransaksiKeluar = new ModelTransaksiKeluar();
            $tableTransaksiKeluar->delete($invoice);

            $json = [
                'sukses' => 'Data Transaksi Keluar , Berhasil Dihapus!'
            ];


            return $this->response->setJSON($json);
        } else {
            exit('Tidak Boleh Diakses!');
        }
    }


    public function modalFilterLaporan()
    {
        $json = [
            'data' => view('transaksi/modalFilterLaporan')
        ];

        return $this->response->setJSON($json);
    }
}
