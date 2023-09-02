<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDTPaket;
use App\Models\ModelPaket;
use Config\Services;

class Paket extends BaseController
{
    protected $tablePaket;

    public function __construct()
    {
        $this->tablePaket = new ModelPaket();
    }

    public function index()
    {




        return view('paket/vw_paket');
    }

    public function listDataPaket()
    {
        $request = Services::request();
        $datamodel = new ModelDTPaket($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnPilih = '<button type="button" class="btn btn-secondary " onclick="editPelanggan(\'' . $list->paket_id . '\')"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger " onclick="hapusPelanggan(\'' . $list->paket_id . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->paket_nama;
                $row[] = $list->paket_harga;
                $row[] = $btnPilih . " " . $btnHapus;
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

    public function modalTambahPaket()
    {
        if ($this->request->isAJAX()) {

            $json = [
                'data' => view('paket/modalTambahPaket')
            ];
        }
        return $this->response->setJSON($json);
    }
}
