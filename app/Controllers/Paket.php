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



    public function tambahPaket()
    {

        $namapaket = $this->request->getPost('namapaket');
        $hargapaket = $this->request->getPost('hargapaket');




        $validation = \Config\Services::validation();

        $validation->setRules([
            'namaPaket' => [
                'label' => 'Nama Paket',
                'rules' => 'required|is_unique[paket.paket_nama]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} ({value}) Sudah Digunakan',
                ]
            ],
            'hargaPaket' => [
                'label' => 'Harga Paket',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                ]
            ]
        ]);

        $data = [
            'namaPaket' => $namapaket,
            'hargaPaket' => $hargapaket
        ];

        if (!$validation->run($data)) {
            $json =  [
                'error' => [
                    'errorNamaPaket' => $validation->getError('namaPaket'),
                    'errorHargaPaket' => $validation->getError('hargaPaket')
                ]
            ];
        } else {


            $this->tablePaket->insert([
                'paket_nama' => $namapaket,
                'paket_harga' => $hargapaket
            ]);

            $json = [
                'sukses' => 'Data Berhasil Diinput'
            ];
        }
        echo json_encode($json);
    }


    // data Table
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
                $btnPilih = '<button type="button" class="btn btn-primary " onclick="editPaket(\'' . $list->paket_id . '\')"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger " onclick="hapusPaket(\'' . $list->paket_id . '\')"><i class="fa fa-trash-alt"></i></button>';
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


    public function hapusPaket()
    {
        if ($this->request->isAJAX()) {

            $paket_id = $this->request->getPost('paket_id');

            $this->tablePaket->delete($paket_id);

            $json = [
                'sukses' => 'Data Berhasil Dihapus!'
            ];
        }
        return $this->response->setJSON($json);
    }

    public function editPaket()
    {
        if ($this->request->isAJAX()) {
            $paket_id = $this->request->getPost('id');

            $tablePaket = $this->tablePaket->find($paket_id);

            $data = [
                'dataPaket' => $tablePaket
            ];

            $json = [
                'data' => view('paket/modalEditPaket', $data)
            ];

            return $this->response->setJSON($json);
        } else {
            exit('Tidak bisa diakses');
        }
    }



    public function updatePaket()
    {

        if ($this->request->isAJAX()) {
            $paket_id = $this->request->getPost('paket_id');
            $paket_nama = $this->request->getPost('paket_nama');
            $paket_harga = $this->request->getPost('paket_harga');


            $validation = \Config\Services::validation();

            $validation->setRules([
                'namaPaket' => [
                    'label' => 'Nama Paket',
                    'rules' => 'required|is_unique[paket.paket_nama,paket_id,' . $paket_id . ']',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => '{field} ({value}) Sudah Digunakan',
                    ]
                ],
                'hargaPaket' => [
                    'label' => 'Harga Paket',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                ]
            ]);

            $data = [
                'namaPaket' => $paket_nama,
                'hargaPaket' => $paket_harga
            ];

            if (!$validation->run($data)) {

                $json =  [
                    'error' => [
                        'errorNamaPaket' => $validation->getError('namaPaket'),
                        'errorHargaPaket' => $validation->getError('hargaPaket')
                    ]
                ];
            } else {


                $this->tablePaket->update($paket_id, [
                    'paket_nama' => $paket_nama,
                    'paket_harga' => $paket_harga
                ]);

                $json = [
                    'sukses' => 'Data Berhasil Diupdate!'
                ];
            }

            return $this->response->setJSON($json);
        }
    }
}
