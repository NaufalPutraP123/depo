<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-7 mx-auto">
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
                        <i class="fa fa-user-plus"></i> <?= $title_web;?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td scope="row">Kode Customer</td>
                                    <td><?= $edit->kode_customer;?></td>
                                </tr>
                                <tr>
                                    <td scope="row">Nama Customer</td>
                                    <td><?= $edit->nama;?></td>
                                </tr>
                                <tr>
                                    <td scope="row">Alamat</td>
                                    <td><?= $edit->alamat;?></td>
                                </tr>
                                <tr>
                                    <td scope="row">HP/WA</td>
                                    <td><?= $edit->hp;?></td>
                                </tr>
                                <tr>
                                    <td scope="row">Keterangan</td>
                                    <td><?= $edit->keterangan;?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="float-right">
                            <a href="<?= base_url('customer');?>" class="btn btn-danger btn-md">
                                <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>