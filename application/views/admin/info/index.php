<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
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
                        <i class="fa fa-edit"></i> Informasi Toko
                    </div>
                    <form method="post" action="<?= base_url('info/update');?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Nama toko</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?= $edit->nama_toko;?>"
                                                name="nama_toko" id="nama_toko" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Alamat toko</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="alamat_toko" id="alamat_toko"
                                                placeholder=""><?= $edit->alamat_toko;?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Telepon toko</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?= $edit->telepon_toko;?>"
                                                name="telepon_toko" id="telepon_toko" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Email toko</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?= $edit->email_toko;?>"
                                                name="email_toko" id="email_toko" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Pemilik toko</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?= $edit->pemilik_toko;?>"
                                                name="pemilik_toko" id="pemilik_toko" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Website toko</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="<?= $edit->website_toko;?>"
                                                name="website_toko" id="website_toko" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <button type="submit" class="btn btn-primary btn-md">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card card-rounded mt-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-edit"></i> Pengaturan Sistem Print dan Kasir
                    </div>
                    <form method="post" action="<?= base_url('info/print');?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Tipe OS </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="os">
                                                <option value="" disabled selected> - pilih - </option>
                                                <option value="1" <?php if($edit->print == '1') { echo 'selected'; } ?>>
                                                    Windows</option>
                                                <option value="2" <?php if($edit->print == '2') { echo 'selected'; } ?>>
                                                    Linux</option>
                                                <option value="3" <?php if($edit->print == '3') { echo 'selected'; } ?>>
                                                    Mac OS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Ukuran Default </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="print_default">
                                                <option value="" disabled selected> - pilih - </option>
                                                <option value="1"
                                                    <?php if($edit->print_default == '1') { echo 'selected'; } ?>> 58mm
                                                </option>
                                                <option value="2"
                                                    <?php if($edit->print_default == '2') { echo 'selected'; } ?>> 80mm
                                                </option>
                                                <option value="3"
                                                    <?php if($edit->print_default == '3') { echo 'selected'; } ?>> A4
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Model Print </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="print">
                                                <option value="" disabled selected> - pilih - </option>
                                                <option value="1" <?php if($edit->print == '1') { echo 'selected'; } ?>>
                                                    Print with Browser
                                                </option>
                                                <!-- <option value="2" <?php if($edit->print == '2') { echo 'selected'; } ?>> Print PHP EDCPOS</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Gambar
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" accept="image/*" name="gambar"
                                                placeholder="">
                                            <input type="hidden" name="driver2" value="<?= $edit->driver?>"
                                                class="form-control">
                                            <!-- <small class="text-danger pl-2"><b>* If Using Model Print PHP EDCPOS | Localhost
                          Server</b></small> -->
                                            <img src="<?= base_url('assets/image/'.$edit->driver);?>"
                                                style="width:120px;" alt="Logo" class="img-fluid mt-2">
                                        </div>
                                    </div>
                                </div>
                                <!-- kasir pengaturan -->
                                <div class="col-sm-12">
                                    <p style="font-size:14pt;"><b> Pengaturan Kasir</b></p>
                                    <hr>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Footer Struk
                                        </label>
                                        <div class="col-sm-8">
                                            <textarea name="footer_struk" style="height:180px;"
                                                class="form-control"><?= $edit->footer_struk?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Diskon (%)
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="diskon">
                                                <option value="" selected disabled> - pilih -</option>
                                                <option value="1"
                                                    <?php if($edit->diskon == '1') { echo 'selected'; } ?>>Enabled
                                                </option>
                                                <option value="0"
                                                    <?php if($edit->diskon == '0') { echo 'selected'; } ?>>Disabled
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Pajak (%)
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="pajak">
                                                <option value="" selected disabled> - pilih -</option>
                                                <option value="1" <?php if($edit->pajak == '1') { echo 'selected'; } ?>>
                                                    Enabled</option>
                                                <option value="0" <?php if($edit->pajak == '0') { echo 'selected'; } ?>>
                                                    Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">
                                            Diskon (Rp)
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="voucher">
                                                <option value="" selected disabled> - pilih -</option>
                                                <option value="1"
                                                    <?php if($edit->voucher == '1') { echo 'selected'; } ?>>Enabled
                                                </option>
                                                <option value="0"
                                                    <?php if($edit->voucher == '0') { echo 'selected'; } ?>>Disabled
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <button type="submit" class="btn btn-primary btn-md">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>