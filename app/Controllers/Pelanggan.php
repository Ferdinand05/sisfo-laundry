<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pelanggan extends BaseController
{
    public function index()
    {
        return view('pelanggan/vw_pelanggan');
    }
}
