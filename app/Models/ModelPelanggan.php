<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'plg_id';

    protected $allowedFields    = [
        'plg_id', 'plg_nama', 'plg_hp', 'plg_alamat'
    ];
}
