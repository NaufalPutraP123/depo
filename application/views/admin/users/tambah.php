<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <?php if(!empty($this->session->flashdata('success'))){ ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('success');?>
                </div>
                <?php }?>
                <?php if(!empty($this->session->flashdata('failed'))){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('failed');?>
                </div>
                <?php }?>
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-user-plus"></i> Tambah Users
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="<?php echo base_url('users/add');?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Pengguna</label>
                                        <input type="text" class="form-control" name="nama" required="required"
                                            placeholder="Nama Pengguna">
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="user" required="required"
                                            placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="pass" required="required"
                                            placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label>Level</label>
                                        <select name="level" class="form-control" required="required">
                                            <option value="" disabled selected>- Level Akun -</option>
                                            <option>Admin</option>
                                            <option>Kasir</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" class="form-control" name="email" required="required"
                                            placeholder="E-mail">
                                    </div>
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" name="telepon" required="required"
                                            placeholder="Contoh : 089618173209">
                                    </div>
                                    <div class="form-group">
                                        <label>Pas Foto <small class="text-danger" style="margin-left:5px;">*
                                                Opsional</small></label>
                                        <br>
                                        <input type="file" accept="image/*" name="gambar">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" name="alamat" required="required"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <b><i class="fa fa-save"></i> Submit</b></button>
                        </form>
                        <a href="<?= base_url('users');?>" class="btn btn-danger btn-md">
                            <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>