<?php
helper(['auth']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fear Laundry</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- sweetalert -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url('/logout') ?>" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" role="button">
                        <i class="fas fa-clock"></i>
                        <?= date('d M Y - g:i') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('/') ?>" class="brand-link text-center">
                <i class="fas fa-vest-patches fa-lg p-2 ml-2"></i>
                <span class="brand-text font-weight-bold">FEAR Laundry</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= user()->username ?></a>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <!-- master -->
                        <li class="nav-header">Master</li>
                        <li class="nav-item">
                            <a href="<?= base_url('/paket') ?>" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag text-primary"></i>
                                <p>Jenis Paket/Layanan</p>
                            </a>
                        </li>
                        <li class="nav-item user-panel">
                            <a href="<?= base_url('pelanggan') ?>" class="nav-link">
                                <i class="nav-icon  fas fa-address-book text-info"></i>
                                <p>Pelanggan</p>
                            </a>
                        </li>

                        <!-- transaksi -->
                        <li class="nav-header">Manajemen Transaksi</li>
                        <li class="nav-item ">
                            <a href="<?= base_url('transaksi') ?>" class="nav-link">
                                <i class="nav-icon fas fa-cash-register text-success"></i>
                                <p>Transaksi Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('transaksi/daftarTransaksi') ?>" class="nav-link">
                                <i class="nav-icon  fas fa-list text-danger"></i>
                                <p>Daftar Transaksi</p>
                            </a>
                        </li>
                        <li class="nav-item user-panel">
                            <a href="<?= base_url('/transaksi/transaksiKeluar') ?>" class="nav-link">
                                <i class="nav-icon  fas fa-file-invoice-dollar text-warning"></i>
                                <p>Transaksi Keluar</p>
                            </a>
                        </li>
                        <!-- user -->
                        <li class="nav-header">Manajemen Admin User</li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin') ?>" class="nav-link">
                                <i class="nav-icon  fas fa-users text-primary"></i>
                                <p>Daftar User</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content mt-2">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header bg-primary p-2">
                        <h3 class="card-title"><?= $this->renderSection('header'); ?></h3>
                    </div>
                    <div class="card-body">
                        <?= $this->renderSection('content'); ?>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <?= $this->renderSection('footer') ?>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <p class="text-center small align-middle">Ferdinand. 02/09/23</p>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
</body>

</html>