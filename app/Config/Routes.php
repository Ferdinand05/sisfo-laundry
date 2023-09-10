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
$routes->post('/paket/tambahPaket', 'Paket::tambahPaket');
$routes->post('/paket/hapusPaket', 'Paket::hapusPaket');
$routes->post('/paket/editPaket', 'Paket::editPaket');
$routes->post('/paket/updatePaket', 'Paket::updatePaket');


// routes Pelanggan
$routes->get('pelanggan', 'Pelanggan::index');
$routes->post('pelanggan/listDataPelanggan', 'Pelanggan::listDataPelanggan');
$routes->post('/pelanggan/modalTambahPelanggan', 'Pelanggan::modalTambahPelanggan');
$routes->post('/pelanggan/simpanPelanggan', 'Pelanggan::simpanPelanggan');
$routes->post('/pelanggan/hapusPelanggan', 'Pelanggan::hapusPelanggan');
$routes->post('/pelanggan/editPelanggan', 'Pelanggan::editPelanggan');
$routes->post('/pelanggan/updatePelanggan', 'Pelanggan::updatePelanggan');


// routes Transaksi
$routes->get('transaksi', 'Transaksi::index');
$routes->get('transaksi/daftarTransaksi', 'Transaksi::daftarTransaksi');
$routes->post('transaksi/modalCariPelanggan', 'Transaksi::modalCariPelanggan');
$routes->post('transaksi/listCariDataPelanggan', 'Transaksi::listCariDataPelanggan');
$routes->post('transaksi/tambahTransaksi', 'Transaksi::tambahTransaksi');
$routes->post('/transaksi/listDataTransaksi', 'Transaksi::listDataTransaksi');
$routes->post('/transaksi/hapusTransaksi', 'Transaksi::hapusTransaksi');
$routes->post('/transaksi/detailTransaksi', 'Transaksi::detailTransaksi');
$routes->post('/transaksi/editTransaksi', 'Transaksi::editTransaksi');
$routes->post('/transaksi/updateTransaksi', 'Transaksi::updateTransaksi');
$routes->get('/transaksi/transaksiKeluar', 'Transaksi::transaksiKeluar');
$routes->post('/transaksi/ambilDataInvoice', 'Transaksi::ambilDataInvoice');
$routes->post('/transaksi/modalCariTransaksi', 'Transaksi::modalCariTransaksi');
$routes->post('/transaksi/listCariDataTransaksi', 'Transaksi::listCariDataTransaksi');
$routes->post('/transaksi/ambilDataTransaksi', 'Transaksi::ambilDataTransaksi');

$routes->post('/transaksi/insertTransaksiKeluar', 'Transaksi::insertTransaksiKeluar');
$routes->post('/transaksi/listDataTransaksiKeluar', 'Transaksi::listDataTransaksiKeluar');
$routes->post('/transaksi/hapusTransaksiKeluar', 'Transaksi::hapusTransaksiKeluar');


// laporan
$routes->post('/transaksi/modalFilterLaporan', 'Transaksi::modalFilterLaporan');
