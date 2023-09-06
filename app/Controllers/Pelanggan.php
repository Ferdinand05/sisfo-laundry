<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDTPelanggan;
use App\Models\ModelPelanggan;
use Config\Services;

class Pelanggan extends BaseController
{
    protected $tablePelanggan;

    public function __construct()
    {
        $this->tablePelanggan = new ModelPelanggan();
    }

    public function index()
    {
        return view('pelanggan/vw_pelanggan');
    }

    // data Table
    public function listDataPelanggan()
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
                $btnPilih = '<button type="button" class="btn btn-secondary " onclick="editPelanggan(\'' . $list->plg_id . '\')"><i class="fa fa-edit"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger " onclick="hapusPelanggan(\'' . $list->plg_id . '\')"><i class="fa fa-trash-alt"></i></button>';
                $row[] = $no;
                $row[] = $list->plg_nama;
                $row[] = $list->plg_hp;
                $row[] = $list->plg_alamat;
                $row[] = $btnPilih . ' ' . $btnHapus;
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

    public function modalTambahPelanggan()
    {
        $json = [
            'data' => view('pelanggan/modalTambahPelanggan')
        ];

        return $this->response->setJSON($json);
    }


    public function simpanPelanggan()
    {
        if ($this->request->isAJAX()) {

            $nama = $this->request->getPost('nama');
            $hp = $this->request->getPost('hp');
            $alamat = $this->request->getPost('alamat');

            $validation = \Config\Services::validation();
            $rules = [
                'nama_pelanggan' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ],
                'hp_pelanggan' => [
                    'label' => 'No HP/Telepon',
                    'rules' => 'required|max_length[13]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'max_length' => '{field} Tidak Lebih dari {param} angka!'
                    ]
                ],
                'alamat_pelanggan' => [
                    'label' => 'Alamat Pelanggan',
                    'rules' => 'string'
                ]
            ];

            $data = [
                'nama_pelanggan' => $nama,
                'hp_pelanggan' => $hp,
                'alamat_pelanggan' => $alamat
            ];

            $validation->setRules($rules);
            if (!$validation->run($data)) {
                $json =  [
                    'error' => [
                        'errorNamaPelanggan' => $validation->getError('nama_pelanggan'),
                        'errorHpPelanggan' => $validation->getError('hp_pelanggan')
                    ]
                ];
            } else {

                $this->tablePelanggan->insert([
                    'plg_nama' => $nama,
                    'plg_hp' => $hp,
                    'plg_alamat' => $alamat
                ]);

                $json = [
                    'sukses' => 'Data Berhasil Ditambahkan'
                ];
            }

            return $this->response->setJSON($json);
        } else {

            exit('Tidak Dapat Diakses');
        }
    }


    public function hapusPelanggan()
    {
        if ($this->request->isAJAX()) {
            $plg_id = $this->request->getPost('plg_id');

            $this->tablePelanggan->delete($plg_id);

            $json = [
                'sukses' => 'Data Berhasil Dihapus!'
            ];

            return $this->response->setJSON($json);
        } else {
            exit('Tidak Bisa Diakses');
        }
    }
}
