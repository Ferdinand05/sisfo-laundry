<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailTransaksi extends Model
{
    protected $table            = 'detail_transaksi';
    protected $primaryKey       = 'detail_id';
    protected $allowedFields    = [
        'detail_id', 'dettransaksi_id', 'nama_pelanggan', 'detpaket_id', 'invoice', 'jumlah_pakaian', 'jenis_pakaian', 'totalharga'
    ];
}
