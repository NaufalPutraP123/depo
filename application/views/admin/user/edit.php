<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <?php if(!empty($this->session->flashdata('failed'))){ ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?= $this->session->flashdata('failed');?>
        </div>
        <?php }?>
        <?php if(!empty($this->session->flashdata('success'))){ ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong><?= $this->session->flashdata('success');?></strong>
        </div>
        <?php }?>
        <form action="<?php echo base_url('user/upd');?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-7">
                    <div class="card card-rounded">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-edit"> </i> Edit Akun
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input type="text" class="form-control" value="<?= $user->nama_user;?>" name="nama"
                                    required="required" placeholder="Nama Pengguna">
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" class="form-control" value="<?= $user->email;?>" name="email"
                                    required="required" placeholder="Contoh : admin@gmail.com">
                            </div>
                            <div class="form-group">
                                <label>Telepon</label>
                                <input type="number" class="form-control" value="<?= $user->telepon;?>" name="telepon"
                                    required="required" placeholder="Contoh : 089618173609">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat"
                                    required="required"><?= $user->alamat;?></textarea>
                                <input type="hidden" class="form-control" value="<?= $user->id;?>" name="id">
                                <input type="hidden" class="form-control" value="<?= $user->foto;?>" name="foto">
                            </div>
                            <div class="form-group">
                                <label>Upload Foto <span style="color:red;padding-left:4px;">* opsional</span></label>
                                <br>
                                <input type="file" accept="image/*" name="gambar">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="<?= $user->user;?>" name="user"
                                    required="required" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label>Password <span style="color:red;padding-left:4px;">* opsional</span></label>
                                <input type="password" class="form-control" name="pass"
                                    placeholder="Isi Password Jika di Perlukan Ganti">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <b><i class="fa fa-edit"></i> Edit Profil</b></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card card-rounded">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-image"> </i> Foto Profil
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <?php if($user->foto !== '-'){?>
                                <img src="<?= base_url('assets/image/'.$user->foto);?>" class="img-responsive"
                                    style="width:100%;" alt="#">
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>