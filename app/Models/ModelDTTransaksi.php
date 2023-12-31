<?php

namespace App\Models;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
use Config\Services;

class ModelDTTransaksi extends Model
{
    protected $table = "transaksi";
    protected $column_order = array(null, 'invoice', 'nama_pelanggan', 'ts_tgl', 'ts_tgl_selesai', 'totalharga', 'ts_status', null);
    protected $column_search = array('ts_tgl_selesai', 'ts_status', 'ts_status_cucian');
    protected $order = array('nama_pelanggan' => 'ASC');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(IncomingRequest $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($tglawal, $tglakhir)
    {

        if ($tglawal == '' && $tglakhir == '') {
            $this->dt = $this->builder('transaksi')->join('detail_transaksi as det', 'ts_id=det.dettransaksi_id');
        } else {
            $this->dt = $this->builder('transaksi')->join('detail_transaksi as det', 'ts_id=det.dettransaksi_id')
                ->where('ts_tgl >=', $tglawal)->where('ts_tgl <=', $tglakhir);
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables($tglawal, $tglakhir)
    {
        $this->_get_datatables_query($tglawal, $tglakhir);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($tglawal, $tglakhir)
    {
        $this->_get_datatables_query($tglawal, $tglakhir);
        return $this->dt->countAllResults();
    }
    public function count_all($tglawal, $tglakhir)
    {

        if ($tglawal == '' && $tglakhir == '') {
            $this->dt = $this->builder('transaksi')->join('detail_transaksi as d', 'ts_id=d.dettransaksi_id');
        } else {
            $this->dt = $this->builder('transaksi')->join('detail_transaksi as d', 'ts_id=d.dettransaksi_id')
                ->where('ts_tgl >=', $tglawal)->where('ts_tgl <=', $tglakhir);
        }

        $tbl_storage = $this->builder('transaksi')->join('detail_transaksi as det', 'ts_id=det.dettransaksi_id');
        return $tbl_storage->countAllResults();
    }
}
