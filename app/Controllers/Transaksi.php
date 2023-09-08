<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelPaket;
use App\Models\ModelTransaksi;
use App\Models\ModelDTPelanggan;
use App\Models\ModelDTTransaksi;
use App\Models\ModelPelanggan;
use App\Models\ModelSelesaiTransaksi;
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

        return view('transaksi/daftarTransaksi');
    }


    public function listDataTransaksi()
    {
        $request = Services::request();
        $datamodel = new ModelDTTransaksi($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
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
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
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
}
