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
                <form method="POST" action="<?= base_url('menu/pasok');?>" enctype="multipart/form-data">
                    <div class="card card-rounded">
                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-plus"> Entry Persediaan Barang</i>
                        </div>
                        <div class="card-body">
                            <label for="">Nama Barang</label>
                            <div class="input-group">
                                <input type="text" class="form-control"
                                    value="<?= $tipe == 'edit' ? $edit->nama : '' ?>" id="nama_menu" required
                                    name="nama_menu" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button type="button" id="basic-addon2" class="btn btn-primary btn-md"
                                        data-toggle="modal" data-target="#modelId">
                                        <i class="fa fa-search"></i> Cari Barang
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" required value="<?= $tipe == 'edit' ? $edit->id : '' ?>" name="id"
                                id="kode">
                            <div <?= $tipe == 'edit' ? '' : 'id="stok_jml"' ?>>
                                <div class="form-group mt-3">
                                    <label for="">Jumlah Stok</label>
                                    <input type="number" value="<?= $tipe == 'edit' ? $edit->stok : '' ?>" id="stok"
                                        class="form-control" name="stok" placeholder="">
                                    <input type="hidden" name="stoka" value="" id="stoka">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="">Stok Minim</label>
                                    <input type="number" value="<?= $tipe == 'edit' ? $edit->stok_minim : '' ?>"
                                        id="stok_minim" class="form-control" name="stok_minim" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <b><i class="fa fa-save"></i> Submit</b></button>
                                <a href="<?= base_url('menu');?>" class="btn btn-danger btn-md">
                                    <b><i class="fa fa-angle-double-left"></i> Kembali</b></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div style="padding-bottom:9pc;"></div>

<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-users"></i> Daftar Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1" style="font-size:10.5pt"
                        class="table-sm table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Barang</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Stok Minim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                            '" style="border-radius:10px 10px 10px 10px;height:70px;width:100%" class="img-fluid"/>' +
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
                'data': 'stok'
            },
            {
                'data': 'stok_minim'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="javascript:void(0)" data-id="${row.id}" 
                                    class="btn btn-info btn-sm pilih_cek" title="Pilih Menu" role="button">
                                    <i class="fa fa-check"></i> Pilih
                                </a>`;
                }
            },
        ],
        "fnDrawCallback": function() {
            $('.portfolio-popup').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement
                            .find('img');
                    }
                },
                callbacks: {
                    close: function() {
                        $('#modelId').modal('show');
                    }
                }
            });
            $('.portfolio-popup').click(function(e) {
                $('#modelId').modal('hide');
            });
        }
    });
});
$('#stok_jml').hide();
$('#example1 tbody').on('click', '.pilih_cek', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        type: 'POST',
        url: '<?= base_url('menu/get_menu');?>',
        data: {
            'id': id
        },
        dataType: 'json',
        success: function(data) {
            if (data.errors != null) {
                console.log(data.errors);
            } else {
                $('#kode').val(data[0].id);
                $('#nama_menu').val(data[0].nama);
                $('#stok').val(data[0].stok);
                $('#stoka').val(data[0].stok);
                $('#stok_minim').val(data[0].stok_minim);
                $('#modelId').modal('hide');
                $('#stok_jml').show();
            }
        }
    });
});
</script>