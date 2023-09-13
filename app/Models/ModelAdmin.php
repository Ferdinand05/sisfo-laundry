<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'email', 'username'];
}
