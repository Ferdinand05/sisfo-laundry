<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{

    protected $table            = 'transaksi';
    protected $primaryKey       = 'ts_id';
    protected $allowedFields    = [
        'ts_id', 'ts_tgl', 'ts_pelangganid', 'ts_paketid', 'ts_berat', 'ts_tgl_selesai', 'ts_status', 'ts_status_cucian'
    ];


    public function showJoinData($ts_id)
    {
        return $this->builder('transaksi t')->join('detail_transaksi as d', 't.ts_id=d.dettransaksi_id')->join('paket as p', 't.ts_paketid=paket_id')
            ->where('ts_id', $ts_id)->get();
    }
}
