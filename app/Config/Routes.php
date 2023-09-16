<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');

// routes Paket
$routes->get('paket', 'Paket::index', ['filter' => 'role:admin,staff,user']);
$routes->post('paket/listDataPaket', 'Paket::listDataPaket');
$routes->post('/paket/modalTambahPaket', 'Paket::modalTambahPaket', ['filter' => 'role:admin']);
$routes->post('/paket/tambahPaket', 'Paket::tambahPaket', ['filter' => 'role:admin']);
$routes->post('/paket/hapusPaket', 'Paket::hapusPaket', ['filter' => 'role:admin']);
$routes->post('/paket/editPaket', 'Paket::editPaket', ['filter' => 'role:admin']);
$routes->post('/paket/updatePaket', 'Paket::updatePaket', ['filter' => 'role:admin']);


// routes Pelanggan
$routes->get('pelanggan', 'Pelanggan::index', ['filter' => 'role:admin,staff']);
$routes->post('pelanggan/listDataPelanggan', 'Pelanggan::listDataPelanggan');
$routes->post('/pelanggan/modalTambahPelanggan', 'Pelanggan::modalTambahPelanggan', ['filter' => 'role:admin,staff']);
$routes->post('/pelanggan/simpanPelanggan', 'Pelanggan::simpanPelanggan', ['filter' => 'role:admin,staff']);
$routes->post('/pelanggan/hapusPelanggan', 'Pelanggan::hapusPelanggan', ['filter' => 'role:admin,staff']);
$routes->post('/pelanggan/editPelanggan', 'Pelanggan::editPelanggan', ['filter' => 'role:admin,staff']);
$routes->post('/pelanggan/updatePelanggan', 'Pelanggan::updatePelanggan', ['filter' => 'role:admin,staff']);


// routes Transaksi
$routes->get('transaksi', 'Transaksi::index', ['filter' => 'role:admin,staff']);
$routes->get('transaksi/daftarTransaksi', 'Transaksi::daftarTransaksi', ['filter' => 'role:admin,staff,user']);
$routes->post('transaksi/modalCariPelanggan', 'Transaksi::modalCariPelanggan');
$routes->post('transaksi/listCariDataPelanggan', 'Transaksi::listCariDataPelanggan');
$routes->post('transaksi/tambahTransaksi', 'Transaksi::tambahTransaksi', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/listDataTransaksi', 'Transaksi::listDataTransaksi');
$routes->post('/transaksi/hapusTransaksi', 'Transaksi::hapusTransaksi', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/detailTransaksi', 'Transaksi::detailTransaksi', ['filter' => 'role:admin,staff,user']);
$routes->post('/transaksi/editTransaksi', 'Transaksi::editTransaksi', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/updateTransaksi', 'Transaksi::updateTransaksi', ['filter' => 'role:admin,staff']);
$routes->get('/transaksi/transaksiKeluar', 'Transaksi::transaksiKeluar', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/ambilDataInvoice', 'Transaksi::ambilDataInvoice', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/modalCariTransaksi', 'Transaksi::modalCariTransaksi', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/listCariDataTransaksi', 'Transaksi::listCariDataTransaksi');
$routes->post('/transaksi/ambilDataTransaksi', 'Transaksi::ambilDataTransaksi', ['filter' => 'role:admin,staff']);

$routes->post('/transaksi/insertTransaksiKeluar', 'Transaksi::insertTransaksiKeluar', ['filter' => 'role:admin,staff']);
$routes->post('/transaksi/listDataTransaksiKeluar', 'Transaksi::listDataTransaksiKeluar');
$routes->post('/transaksi/hapusTransaksiKeluar', 'Transaksi::hapusTransaksiKeluar', ['filter' => 'role:admin,staff']);


// laporan
$routes->post('/transaksi/modalFilterLaporan', 'Transaksi::modalFilterLaporan');
// print
$routes->get('/transaksi/printpdf/(:num)', 'Transaksi::printpdf/$1', ['filter' => 'role:admin,staff']);
$routes->get('/transaksi/printPdfTransaksi', 'Transaksi::printPdfTransaksi', ['filter' => 'role:admin,staff']);
$routes->get('/transaksi/fakturTransaksi/(:num)', 'Transaksi::fakturTransaksi/$1', ['filter' => 'role:admin,staff']);

// admin user
$routes->get('admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('admin/edit/(:num)', 'Admin::edit/$1', ['filter' => 'role:admin']);
$routes->get('admin/delete/(:num)', 'Admin::delete/$1', ['filter' => 'role:admin']);

// login
