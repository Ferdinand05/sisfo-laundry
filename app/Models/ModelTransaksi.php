<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{

    protected $table            = 'transaksi';
    protected $primaryKey       = 'ts_id';
    protected $allowedFields    = [
        'ts_id', 'ts_tgl', 'ts_pelangganid', 'ts_paketid', 'ts_berat', 'ts_tgl_selesai', 'ts_status'
    ];
}
