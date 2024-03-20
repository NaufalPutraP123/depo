<div class="clearfix"></div>
<div id="home">
    <div class="container mt-5">
        <a href="<?= base_url('menu/tambah');?>" class="btn btn-primary">
            <i class="fa fa-plus"> </i> Tambah Barang</a>
        <a href="<?= base_url('menu/import');?>" class="btn btn-success mr-2">
            <i class="fa fa-plus"> </i> Import Menu Excel</a>
        <div class="clearfix"></div>
        <br>
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
            $sql = "SELECT nama FROM menu WHERE stok <= stok_minim";
            $cek = $this->db->query($sql)->num_rows();
            if($cek > 0){
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
                Ada <?= $cek;?> Barang yang dibawah Stok minim
                <a href="<?= base_url('menu/persediaan?cek=limit');?>" class="text-dark mr-2">Cek Disini
                </a>
            </strong>
        </div>
        <?php }?>
        <div class="card card-rounded">
            <div class="card-header bg-primary text-white">
                <i > Daftar Barang </i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Barang</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
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
            "url": "<?= base_url('menu/data_menu');?>", // URL file untuk proses select datanya
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
                "data": "gambar",
                "render": function(data, type, row, meta) {
                    if (data == '-') {
                        return '<center><i class="fa fa-image fa-3x"></i> <br>' +
                            '<small><b> Tidak Ada Gambar !</b></small></center>';
                    } else {
                        return '<div id="portfolio">' +
                            '<div class="portfolio-item">' +
                            '<a href="' + base_url + 'assets/image/produk/' + data +
                            '" class="portfolio-popup">' +
                            '<img src="' + base_url + 'assets/image/produk/' + data +
                            '" style="border-radius:10px 10px 10px 10px;height:70px;width:100%;" class="img-fluid"/>' +
                            '<div class="portfolio-overlay">' +
                            '' +
                            '</div>' +
                            '</a>' +
                            '</div>' +
                            '</div>';
                    }
                }
            },
            {
                'data': 'kode_menu'
            },
            {
                'data': 'kategori'
            },
            {
                'data': 'nama'
            },
            {
                data: 'harga_pokok',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'harga_jual',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {

                    <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                    return `<div class="dropdown open">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                                <i class="fa fa-cog mr-1"></i> pilih aksi
                                            </button>
                                        <div class="dropdown-menu" aria-labelledby="triggerId">
                                            <a href="${base_url}menu/detail/${row.id}" 
                                                class="dropdown-item" title="Detail Barang" role="button">
                                                <i class="fa fa-eye mr-1"></i> Detail Barang
                                            </a>
                                            <a href="${base_url}menu/edit/${row.id}" 
                                                class="dropdown-item" title="Edit Barang" role="button">
                                                <i class="fa fa-edit mr-1"></i> Edit Barang
                                            </a>
                                            <a href="${base_url}menu/delete?id=${row.id}" 
                                                onclick="javascript:return confirm('Apakah data ini di hapus ?');" 
                                                class="dropdown-item" title="Hapus Data Barang" role="button">
                                                <i class="fa fa-times mr-1"></i> Hapus Barang
                                            </a>
                                        </div>
                                    </div>
                                    `;
                    <?php }else{?>
                    return `<div class="dropdown open">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                            <i class="fa fa-cog mr-1"></i> pilih aksi
                                        </button>
                                    <div class="dropdown-menu" aria-labelledby="triggerId">
                                        <a href="${base_url}menu/detail/${row.id}" 
                                            class="dropdown-item" title="Detail Barang" role="button">
                                            <i class="fa fa-eye mr-1"></i> Detail Barang
                                        </a>
                                        <a href="${base_url}menu/edit/${row.id}" 
                                            class="dropdown-item" title="Edit Barang" role="button">
                                            <i class="fa fa-edit mr-1"></i> Edit Barang
                                        </a>
                                    </div>
                                </div>
                                `;
                    <?php }?>
                }
            },
        ],
        "fnDrawCallback": function() {
            $('.portfolio-popup').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement
                            .find('img');
                    }
                }
            });
        }
    });
});
</script>