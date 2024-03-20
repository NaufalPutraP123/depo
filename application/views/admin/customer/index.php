<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <a href="<?= base_url('customer/tambah');?>" class="btn btn-success float-right">
                    <i class="fa fa-user-plus"> </i> Tambah Customer</a>
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
                        <i class="fa fa-users"></i> <?= $title_web;?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Customer</th>
                                        <th>Nama Customer</th>
                                        <th>HP/WA</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
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
            "url": "<?= base_url('customer/data_customer');?>", // URL file untuk proses select datanya
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
                'data': 'kode_customer'
            },
            {
                'data': 'nama'
            },
            {
                'data': 'hp'
            },
            {
                'data': 'alamat'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="${base_url}customer/detail/${row.id}" 
                                    class="btn btn-info btn-sm" title="Detail Customer" role="button">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}customer/edit/${row.id}" 
                                    class="btn btn-primary btn-sm" title="Edit Customer" role="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="${base_url}customer/delete?id=${row.id}" 
                                    onclick="javascript:return confirm('Apakah data ini di hapus ?');" 
                                        class="btn btn-danger btn-sm" title="Hapus Data Customer" role="button">
                                    <i class="fa fa-times"></i>
                                </a>`;
                }
            },
        ],
    });
});
</script>