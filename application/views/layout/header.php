<!doctype html>
<html lang="en">

<head>
    <title><?= $title_web; ?> &mdash; DEPO AKI & BAN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/magnific/jquery.magnific-popup.css'); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css?v=' . time()); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.css'); ?>">
    <!-- Optional JavaScript -->
    <!-- DATATABLES BS 4-->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap4.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/responsive.bootstrap4.min.css'); ?>" />
    <!-- jQuery -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/plugins/magnific/jquery.magnific-popup.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/chart.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.twbsPagination.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
</head>

<body>
    <!-- header -->
    <div id="header">
        <nav class="navbar navbar-expand-lg active py-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= base_url('home'); ?>"><b>DEPO AKI & BAN</b></a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars text-dark"></i></button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= base_url('home'); ?>">HOME <span class="sr-only">(current)</span></a>
                            </li>
                        <?php } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DATA MASTER</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="<?= base_url('menu'); ?>">
                                    <i class="fa fa-cubes pr-1"></i> Barang</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('kategori'); ?>">
                                    <i class="fa fa-tags pr-1"></i> Kategori</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('customer'); ?>">
                                    <i class="fa fa-users pr-1"></i> Customer</a>
                                <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url('users'); ?>">
                                        <i class="fa fa-user pr-1"></i> Pengguna</a>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">STOK</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="<?= base_url('menu/stok'); ?>">
                                    <i class="fa fa-cubes pr-1"></i> Entry Stok</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('menu/persediaan'); ?>">
                                    <i class="fa fa-list pr-1"></i> Daftar Stok Barang</a>
                            </div>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= base_url('kasir'); ?>">KASIR</a>
                        </li>
                        <?php
                        $day = $this->db->get_where('transaksi', ['date'  => date('Y-m-d')])->num_rows();
                        $co = $this->db->get_where('transaksi', ['status' => 'Bayar Nanti'])->num_rows();
                        $cdo = $this->db->get_where('transaksi', [
                            // 'status' => 'Bayar Nanti',
                            'pesanan' => 'Ditempat',
                            'date'  => date('Y-m-d')
                        ])->num_rows();
                        $cbo = $this->db->get_where('transaksi', [
                            // 'status' => 'Bayar Nanti',
                            'pesanan' => 'Booking',
                            'date'  => date('Y-m-d')
                        ])->num_rows();
                        $clo = $this->db->get_where('transaksi', [
                            // 'status' => 'Bayar Nanti',
                            'pesanan' => 'Delivery',
                            'date'  => date('Y-m-d')
                        ])->num_rows();
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ORDER
                                <span class="badge badge-danger"><?= $co; ?></span></a>
                            <div class="dropdown-menu " aria-labelledby="dropdownId">
                                <!--<a class="dropdown-item" href="#">CEK ORDER</a>
                                <div class="dropdown-divider"></div>-->
                                <a class="dropdown-item" href="<?= base_url('order'); ?>">All Order
                                    <span class="badge badge-secondary float-right"><?= $day; ?></span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=1'); ?>">Di Tempat
                                    <span class="badge badge-primary float-right"><?= $cdo; ?></span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=2'); ?>">Booking
                                    <span class="badge badge-warning float-right"><?= $cbo; ?></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=3'); ?>">Delivery
                                    <span class="badge badge-success float-right"><?= $clo; ?></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=4'); ?>"> Blm Lunas
                                    <span class="badge badge-danger float-right"><?= $co; ?></a>
                            </div>
                        </li>
                        <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AKUTANSI</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownId">
                                    <a class="dropdown-item" href="<?= base_url('keuangan'); ?>">Ledger</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url('keuangan/lain'); ?>">Keuangan Lainnya</a>
                                </div>
                            </li>
                        <?php } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">LAPORAN</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                                    <a class="dropdown-item" href="<?= base_url('laporan'); ?>">Transaksi Penjualan</a>
                                <?php } else { ?>
                                    <a class="dropdown-item" href="<?= base_url('laporan?kasir=' . $this->session->userdata('ses_id')); ?>">Transaksi
                                        Penjualan</a>
                                <?php } ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('laporan/produk'); ?>">History Per Menu</a>
                                <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url('laporan/cash'); ?>">Cash Flow</a>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                    <?php
                    $profil = $this->db->get_where('login', ['id' => $this->session->userdata('ses_id')])->row();
                    ?>
                    <ul class="navbar-nav ml-auto mr-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle"></i> <?= $profil->nama_user; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                                    <a class="dropdown-item" href="<?= base_url('info'); ?>">
                                        <i class="fa fa-cog"></i> Pengaturan Toko</a>
                                    <div class="dropdown-divider"></div>
                                <?php } ?>
                                <a class="dropdown-item" href="<?= base_url('user'); ?>">
                                    <i class="fa fa-edit"></i> Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('login/logout'); ?>">
                                    <i class="fa fa-sign-out"></i> Sign Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- header -->