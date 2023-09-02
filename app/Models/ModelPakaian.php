<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPakaian extends Model
{

    protected $table            = 'pakaian';
    protected $primaryKey       = 'pkn_id';
    protected $allowedFields    = [
        'pkn_id', 'pkn_transaksiid', 'pkn_jumlah'
    ];
}
