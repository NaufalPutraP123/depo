<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8">
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
                        <i class="fa fa-eye"></i> <?= $title_web;?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td scope="row">Kode Barang</td>
                                        <td><?= $edit->kode_menu;?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Kategori</td>
                                        <td>
                                            <?php foreach($kat as $r){?>
                                            <?php if($r->id == $edit->id_kategori){echo $r->kategori;}?>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Barang</td>
                                        <td><?= $edit->nama;?></td>
                                    </tr>
                                    <tr>
                                        <td>Stok</td>
                                        <td><?= $edit->stok;?></td>
                                    </tr>
                                    <tr>
                                        <td>Harga Pokok</td>
                                        <td>Rp<?= number_format($edit->harga_pokok);?></td>
                                    </tr>
                                    <tr>
                                        <td>Harga Jual</td>
                                        <td>Rp<?= number_format($edit->harga_jual);?></td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td><?= $edit->keterangan;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="float-right">
                            <a href="<?= base_url('menu');?>" class="btn btn-danger btn-md">
                                <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-image"></i> Gambar Barang
                    </div>
                    <div class="card-body text-center">
                        <?php 
                        if($edit->gambar !== '-'){
                            if(file_exists(FCPATH.'assets/image/produk/'.$edit->gambar)){
                        ?>
                        <image src="<?= base_url('assets/image/produk/'.$edit->gambar);?>" class="img-fluid" />
                        <?php }}else{?>
                        <i class="fa fa-image fa-4x"></i>
                        <br>
                        <b>Tidak Ada Gambar !</b>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>