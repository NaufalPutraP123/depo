<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4">
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-users"></i> Tambah
                    </div>
                    <div class="card-body">
                        <?php if(!empty($this->input->get('id'))){?>
                        <form method="post" id="formLedger" action="<?= base_url('keuangan/update');?>">
                            <?php }else{?>
                            <form method="post" id="formLedger" action="<?= base_url('keuangan/store');?>">
                                <?php }?>
                                <?php if(!empty($this->input->get('id'))){?>
                                <div class="form-group">
                                    <label for="">No ledger</label>
                                    <input type="text" class="form-control" value="<?= $edit->no_ledger;?>"
                                        name="no_ledger" id="no_ledger" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea class="form-control" value="" name="keterangan" style="height: 100px;"
                                        id="keterangan" placeholder=""><?= $edit->keterangan ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Jenis</label>
                                    <select class="form-control" name="jenis">
                                        <option value="" disabled selected>- pilih jenis -</option>
                                        <option <?= $edit->jenis == 'Pemasukan' ? 'selected' :'' ?>>Pemasukan</option>
                                        <option <?= $edit->jenis == 'Pengeluaran' ? 'selected' :'' ?>>Pengeluaran
                                        </option>
                                    </select>
                                </div>
                                <input type="hidden" name="id" value="<?= $edit->id ?>">
                                <?php }else {?>
                                <div class="form-group">
                                    <label for="">No ledger</label>
                                    <input type="text" class="form-control" name="no_ledger" id="no_ledger"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea class="form-control" style="height: 100px;" value="" name="keterangan"
                                        id="keterangan" placeholder=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Jenis</label>
                                    <select class="form-control" name="jenis">
                                        <option value="" disabled selected>- pilih jenis -</option>
                                        <option>Pemasukan</option>
                                        <option>Pengeluaran</option>
                                    </select>
                                </div>
                                <?php }?>
                                <button type="submit" class="btn btn-primary" id="proses">
                                    <?php if(!empty($this->input->get('id'))){?>
                                    Edit
                                    <?php }else{?>
                                    Tambah
                                    <?php }?>
                                </button>
                                <?php if(!empty($this->input->get('id'))){?>
                                <a href="<?= base_url('keuangan');?>" class="btn btn-danger">Kembali</a>
                                <?php }?>
                            </form>
                    </div>
                </div>
            </div>
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
                        <i class="fa fa-users"></i> <?= $title_web;?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No ledger</th>
                                        <th>Keterangan</th>
                                        <th>Jenis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no =1;
                                        foreach($keuangan_ledger as $r){
                                    ?>
                                    <tr>
                                        <td><?= $no;?></td>
                                        <td><?=$r->no_ledger;?></td>
                                        <td><?=$r->keterangan;?></td>
                                        <td><?=$r->jenis;?></td>
                                        <td>
                                            <a href="<?= base_url("keuangan?id=$r->id");?>"
                                                class="btn btn-success btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url("keuangan/delete?id=$r->id");?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="javascript:return confirm(`Data ingin dihapus ?`);"
                                                title="Delete">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>