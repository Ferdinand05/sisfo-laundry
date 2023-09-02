<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPaket extends Model
{

    protected $table            = 'paket';
    protected $primaryKey       = 'paket_id';

    protected $allowedFields    = [
        'paket_id', 'paket_nama', 'paket_harga'
    ];
}
