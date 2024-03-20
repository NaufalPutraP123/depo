<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-3">
                <div class="card card-rounded mb-4">
                    <div class="card-header bg-primary text-white">
                        Kategori
                    </div>
                    <div class="card-body text-center">
                        <h2 class="card-title"><b><?= $ck;?></b></h2>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= base_url('kategori');?>">Lihat Selengkapnya <i
                                class="fa fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card card-rounded mb-4">
                    <div class="card-header bg-primary text-white">
                        Barang
                    </div>
                    <div class="card-body text-center">
                        <h2 class="card-title"><b><?= $cm;?></b></h2>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= base_url('menu');?>">Lihat Selengkapnya <i class="fa fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card card-rounded mb-4">
                    <div class="card-header bg-primary text-white">
                        Customer
                    </div>
                    <div class="card-body text-center">
                        <h2 class="card-title"><b><?= $cc;?></b></h2>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= base_url('customer');?>">Lihat Selengkapnya <i
                                class="fa fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card card-rounded mb-4">
                    <div class="card-header bg-primary text-white">
                        Transaksi Selesai
                    </div>
                    <div class="card-body text-center">
                        <h2 class="card-title"><b><?= $ct;?></b></h2>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= base_url('laporan');?>">Lihat Selengkapnya <i
                                class="fa fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <?php if(!empty($this->input->post('thn'))){ $thn = $this->input->post('thn');  }else{ $thn = date('Y'); }?>
            <div class="col-sm-12">
                <div class="card card-rounded mb-4 mt-3">
                    <div class="card-header bg-primary text-white">
                        Laporan Penjualan <?= $thn;?>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-sm-5">
                                <form method="post" action="<?= base_url('home')?>">
                                    <div class="table-responsive">
                                        <table>
                                            <tr>
                                                <td>
                                                    <select name="thn" class="form-control">
                                                        <option value="">- Pilih Tahun Grafik -</option>
                                                        <?php
                                                        $thn_skr = date('Y');
                                                        for ($x = $thn_skr; $x >= 2021; $x--){
                                                    ?>
                                                        <option value="<?= $x;?>" <?php if($thn == $x){?> selected
                                                            <?php }?>><?= $x;?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary btn-md">
                                                        <i class="fa fa-search"></i></button>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('home')?>" class="btn btn-success btn-md">
                                                        <i class="fa fa-refresh"></i> </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <canvas id="line-chart" height="180" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    var linechart = document.getElementById('line-chart');
    var chart = new Chart(linechart, {
        type: 'bar',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
            ], // Merubah data tanggal menjadi format JSON
            datasets: [{
                label: "Barang Terjual",
                data: [
                    <?php 
                            // php mencari produk
                            for($n=1; $n<=12; $n++){
                                if($n > 9) {
                                    $period = $thn.'-'.$n;
                                }else{
                                    $period = $thn.'-'.'0'.$n;
                                }
                                if($this->session->userdata('ses_level') == 'Admin'){
                                    $penjualan = $this->db->query('SELECT SUM(qty) as qty FROM transaksi_produk WHERE periode = ?',[$period])->row();
                                }else{
                                    $penjualan = $this->db->query('SELECT SUM(qty) as qty FROM transaksi_produk 
                                        WHERE periode = ? AND kasir_id = ?',[$period, $this->session->userdata('ses_id')])->row();
                                }
                        ?>
                    <?= $penjualan->qty;?>,
                    <?php } ?>
                ],
                borderColor: '#3c73a8',
                backgroundColor: '#3c73a8',
                borderWidth: 4,
            }, ],
        },
        options: {
            responsive: true,
        },
    });
    </script>