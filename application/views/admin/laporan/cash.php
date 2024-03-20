<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-md mt-2" data-toggle="modal" data-target="#modelIdFilter">
            <i class="fa fa-search"></i> Pencarian
        </button>
        <a href="<?= base_url('laporan/pdf');?>" target="_blank" class="btn btn-success mt-2 btn-md ml-1">
            <i class="fa fa-download"></i> File PDF
        </a>
        <a href="<?= base_url('laporan/cash');?>" class="btn btn-warning mt-2 btn-md ml-1">
            <i class="fa fa-refresh"></i> Refresh
        </a>
        <div class="clearfix"></div>
        <br>
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="card card-rounded">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-file-text-o mr-2"></i> <?= $title_web;?>
                <?= $periode;?>
            </div>
            <div class="card-body">
                <h5 class="pt-2 text-center"><b>Cash Flow Usaha </b></h5>
                <h5 class="pt-2 text-center"><b><?= $periode;?></b></h5>
                <br>
                <table class="table">
                    <tr>
                        <th colspan="2">Arus Kas yang berasal dari Kegiatan Operasional </th>
                    </tr>
                    <tr>
                        <td>Kas yang diterima oleh Penjualan Produk</td>
                        <td>Rp<?= number_format($total->gr ?? 0);?></td>
                    </tr>
                    <tr>
                        <th colspan="2">Dikurangi : </th>
                    </tr>
                    <tr>
                        <td>Pemodalan oleh Penjualan Produk</td>
                        <td>(Rp<?= number_format($total->gm ?? 0);?>)</td>
                    </tr>
                    <tr style="background:#eee;">
                        <th>Aliran Kas Bersih dari Kegiatan Operasional </th>
                        <th>Rp<?= number_format(($total->gr - $total->gm) ?? 0);?></th>
                    </tr>
                    <tr>
                        <th colspan="2">Aliran Pemasukan Kas yang berasal dari Aktivitas Keuangan Lainnya</th>
                    </tr>
                    <?php $msk = 0; $klr = 0; foreach($keuangan as $r){?>
                    <?php if($r->jenis == 'Pemasukan'){?>
                    <tr>
                        <td><?= $r->ket;?></td>
                        <td>Rp<?= number_format($r->jumlah_masuk ?? 0);?></td>
                    </tr>
                    <?php }else{?>
                    <tr>
                        <td><?= $r->ket;?></td>
                        <td>(Rp<?= number_format($r->jumlah_keluar ?? 0);?>)</td>
                    </tr>
                    <?php }?>
                    <?php $msk += $r->jumlah_masuk; $klr += $r->jumlah_keluar;}?>
                    <tr style="background:#eee;">
                        <th>Total Kas Bersih yang berasal dari Aktivitas Keuangan Lainnya</th>
                        <th>Rp<?= number_format(($msk - $klr) ?? 0);?></th>
                    </tr>
                    <tr style="background:#cdf59a;">
                        <th>Laba Bersih Bulan ini ( <?= $periode;?> )</th>
                        <th>Rp<?= number_format((($total->gr - $total->gm)+($msk - $klr)) ?? 0);?></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelIdFilter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-search"></i> Pencarian Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="<?= base_url('laporan/cash');?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="m" id="m" class="form-control">
                            <option value="" selected>Bulan</option>
                            <?php
                                $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                $jlh_bln=count($bulan);
                                $bln1 = array('01','02','03','04','05','06','07','08','09','10','11','12');
                                $no=1;
                                for($c=0; $c<$jlh_bln; $c+=1){
                                    if(!empty($this->input->get('m') == $bln1[$c])){
                                        echo "<option value='$bln1[$c]' selected> $bulan[$c] </option>";
                                    }else{ 
                                        echo "<option value='$bln1[$c]'> $bulan[$c] </option>";
                                    }
                                $no++;}
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <?php
                            $now=date('Y');
                            echo "<select name='y' id='y' class='form-control'>";
                            echo '
                            <option value="" selected>Tahun</option>';
                            for ($a=2021;$a<=$now;$a++)
                            {
                                if(!empty($this->input->get('y') == $a)){
                                    echo "<option value='$a' selected>$a</option>";
                                }else{
                                    echo "<option value='$a'>$a</option>";
                                }
                            }
                            echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>