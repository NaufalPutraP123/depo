<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="clearfix"></div>
<div id="home">
    <div class="container-fluid mt-5">
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
                <a href="users/tambah"><button class="btn btn-success float-right"><i class="fa fa-plus"> </i> Tambah
                        User</button></a>
                <div class="clearfix"></div>
                <br>
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-users"></i> <?= $title_web;?>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <br />
                        <table id="example1" class="table table-bordered table-striped table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>User</th>
                                    <th>Telepon</th>
                                    <th>Level</th>
                                    <th>Alamat</th>
                                    <th style="width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var tabel = null;
var base_url = "<?= base_url('');?>";
$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';
    tabel = $('#example1').DataTable({
        "processing": true,
        "serverSide": true,
        'responsive': true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= base_url('users/data_users');?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50, 100, 150],
            [10, 25, 50, 100, 150]
        ], // Combobox Limit
        "columns": [{
                "data": 'id',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "foto",
                "render": function(data, type, row, meta) {
                    if (row.foto !== '-') {
                        return `<center>
                                        <img src="${base_url}assets/image/${row.foto}" alt="#" 
                                            class="img-responsive" 
                                            style="height:auto;width:46px;border-radius:50%;"/>
                                    </center>`;
                    } else {
                        return `<center>
                                        <i class="fa fa-user-circle fa-3x" 
                                            style="color:#333;"></i>
                                    </center>`;
                    }
                }
            },
            {
                'data': 'nama_user'
            },
            {
                'data': 'user'
            },
            {
                'data': 'telepon'
            },
            {
                'data': 'level'
            },
            {
                'data': 'alamat'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="${base_url}users/edit/${row.id}" 
                                    class="btn btn-primary btn-sm" title="Edit Users" role="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="${base_url}users/delete?id=${row.id}" 
                                    onclick="javascript:return confirm('Apakah data ini di hapus ?');" 
                                        class="btn btn-danger btn-sm" title="Hapus Data Users" role="button">
                                    <i class="fa fa-times"></i>
                                </a>`;
                }
            },
        ],
    });
});
</script>