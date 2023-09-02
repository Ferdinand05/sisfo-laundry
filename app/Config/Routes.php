<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');

// routes Paket
$routes->get('paket', 'Paket::index');
$routes->post('paket/listDataPaket', 'Paket::listDataPaket');
$routes->post('/paket/modalTambahPaket', 'Paket::modalTambahPaket');

// routes Transaksi
$routes->get('transaksi', 'Transaksi::index');


// routes Pelanggan
$routes->get('pelanggan', 'Pelanggan::index');
