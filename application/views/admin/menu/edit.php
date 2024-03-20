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
                <form method="POST" action="<?= base_url('menu/update');?>" enctype="multipart/form-data">
                    <div class="card card-rounded">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-edit"></i> <?= $title_web;?>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" value="<?= $edit->id;?>" name="id" id="id"
                                    placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="">Kode Barang</label>
                                <input type="text" class="form-control" value="<?= $edit->kode_menu;?>" name="kode_menu"
                                    id="kode_menu" placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select class="form-control" name="id_kategori">
                                    <option value="" disabled selected>- pilih -</option>
                                    <?php foreach($kat as $r){?>
                                    <option value="<?= $r->id;?>"
                                        <?php if($r->id == $edit->id_kategori){echo 'selected';}?>>
                                        <?= $r->kategori;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" value="<?= $edit->nama;?>" name="nama" id="nama"
                                    placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="">Harga pokok</label>
                                <input type="number" class="form-control" value="<?= $edit->harga_pokok;?>"
                                    name="harga_pokok" id="harga_pokok" placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="">Harga jual</label>
                                <input type="number" class="form-control" value="<?= $edit->harga_jual;?>"
                                    name="harga_jual" id="harga_jual" placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan"
                                    placeholder=""><?= $edit->keterangan;?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Gambar</label>
                                <br>
                                <input type="file" accept="image/*" name="gambar" placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="">Stok Minim</label>
                                <br>
                                <input type="number" name="stok_minim" value="<?= $edit->stok_minim;?>"
                                    placeholder="" />
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <input type="hidden" name="gambar_edit" value="<?= $edit->gambar;?>">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <b><i class="fa fa-save"></i> Save</b></button>
                                <a href="<?= base_url('menu');?>" class="btn btn-danger btn-md">
                                    <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                            </div>
                        </div>
                    </div>
                </form>
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