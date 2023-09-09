<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiKeluar extends Model
{
    protected $table            = 'transaksi_keluar';
    protected $primaryKey       = 'invoice';
    protected $allowedFields    = [
        'invoice', 'berat', 'tgl_order', 'tgl_selesai', 'nama', 'nama_pengambil', 'tgl_ambil', 'totalharga'
    ];
}
