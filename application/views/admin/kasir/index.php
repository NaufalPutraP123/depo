<div class="clearfix"></div>
<div id="home">
    <div class="container-fluid mt-2" id="kasircontainer">
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="row">
            <div class="col-sm-8 mt-4">
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-cubes"></i> Data Barang
                    </div>
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dropdown open mb-3">
                                    <button class="btn btn-secondary btn-block dropdown-toggle" type="button"
                                        id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <?php 
                                            if(!empty($this->input->get('nm'))){
                                                echo $this->input->get('nm');
                                            }else{
                                                echo 'Semua Kategori';
                                            }
                                        ?>
                                    </button>
                                    <div class="dropdown-menu" style="width:100%" aria-labelledby="triggerId">
                                        <?php foreach($kat as $r){?>
                                        <a class="dropdown-item"
                                            href="<?= base_url('kasir?id='.$r->id.'&nm='.$r->kategori);?>">
                                            <?= $r->kategori;?></a>
                                        <div class="dropdown-divider"></div>
                                        <?php }?>
                                        <a class="dropdown-item" href="<?= base_url('kasir');?>">
                                            Semua Kategori</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <form method="get" action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?=$this->input->get('cari');?>"
                                            name="cari" id="cari" placeholder="Cari Barang">
                                        <div class="input-group-append">
                                            <!-- Button trigger modal -->
                                            <button type="submit" class="btn btn-primary btn-md">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <a href="<?= base_url('kasir');?>" class="btn btn-success btn-md btn-block">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive-1 w-100">
                            <?php 
                                if($this->input->get('id')){
                                    $wr = ' WHERE id_kategori = '.(int)$this->input->get('id').' ';
                                    $url   = base_url('menu/dtmenu?id='.(int)$this->input->get('id'));
                                }else if($this->input->get('cari')){
                                    $wr = ' WHERE nama LIKE "%'.$this->input->get('cari').'%" OR kategori.kategori LIKE "%'.$this->input->get('cari').'%"';
                                    $url   = base_url('menu/dtmenu?cari='.$this->input->get('cari'));
                                }else{
                                    $wr = '';
                                    $url   = base_url('menu/dtmenu');
                                }
                                $query = "SELECT kategori.kategori, menu.* FROM menu LEFT JOIN kategori ON menu.id_kategori = kategori.id";	
                                $total = $this->db->query("$query $wr")->num_rows();  
                                $pages = ceil($total/$halperpage);

                                if($total == '0'){ echo '<br/><h4>" Tidak ada Barang "</h4><br/>';}
                            ?>
                            <div id="load-data" class="row-css"></div>
                            <center>
                                <div id="loading"></div>
                            </center>
                            <br />
                            <div class="wrapper">
                                <ul id="pagination-demo" class="pagination"></ul>
                            </div>
                            <script>
                            $(document).ready(function() {
                                $('#pagination-demo').twbsPagination({
                                    totalPages: <?php echo $pages;?>,
                                    visiblePages: 0,
                                    next: 'Next',
                                    prev: 'Prev',
                                    first: '',
                                    last: '',
                                    onPageClick: function(event, page) {
                                        loadData(page);
                                    }
                                });

                                function loadData(pageHome) {
                                    dataString = "pageHome=" + pageHome;
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo $url;?>",
                                        data: dataString,
                                        cache: false,
                                        beforeSend: function() {
                                            $("#loading").html(
                                                '<img src="<?php echo base_url('assets/image/spinner-primary.svg');?>"/>'
                                                );
                                        },
                                        success: function(html) {
                                            $("#loading").html('');
                                            $("#load-data").html(html);
                                        }
                                    });
                                }
                                loadData(0);
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-4">
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-shopping-cart"></i> Keranjang
                    </div>

                    <form method="post" id="AddKasir">
                        <div class="card-body p-2">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">NO BON</label>
                                <div class="col-sm-8">
                                    <input type="text" required readonly class="form-control" value="<?= $no_bon;?>"
                                        name="no_bon" id="no_bon" placeholder="No Bon">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">CUSTOMER</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pelanggan" id="pelanggan"
                                            placeholder="Nama Customer">
                                        <div class="input-group-append">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                                data-target="#modelId">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <a href="" class="btn btn-danger btn-md">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                        <input type="hidden" name="customer_id" id="pelanggan_id" value="0">
                                    </div>
                                </div>
                            </div>
                            <small class="text-danger">
                                <b>
                                    * Untuk Customer yang sudah terdaftar pada sistem
                                </b>
                            </small>
                            <div class="form-group mt-3 row">
                                <label for="" class="col-sm-4 col-form-label">ATAS NAMA</label>
                                <div class="col-sm-8">
                                    <input type="text" required autocomplete="off" class="form-control" name="atas_nama"
                                        id="atas_nama" placeholder="Atas Nama">
                                </div>
                            </div>
                            <div class="float-left pt-2">
                                <i class="fa fa-shopping-cart"></i> List Keranjang
                            </div>
                            <!-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modelId1">
                                <i class="fa fa-eye"></i> Lihat List Tabel
                            </button> -->
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-body p-0">
                            <div id="cart_keranjang"></div>
                        </div>
                        <div class="card-footer p-2">
                            <table class="aTable">
                                <tbody>
                                    <tr>
                                        <th>Status </th>
                                        <td>
                                            <select class="form-control" required name="status" id="status">
                                                <option value="" disabled selected> - Status Pembayaran -</option>
                                                <option>Lunas</option>
                                                <option>Debit</option>
                                                <!-- <option>Debit BCA</option>
                                                <option>Debit BNI</option>
                                                <option>Debit Mandiri</option> -->
                                                <option>Bayar Nanti</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order</th>
                                        <td>
                                            <select class="form-control" required name="pesanan" id="pesanan">
                                                <option value="" disabled selected> - Kategori Order -</option>
                                                <option selected>Ditempat</option>
                                                <option>Booking</option>
                                                <option>Delivery</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Bayar</th>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" value="0" class="form-control form-lg"
                                                    name="total_bayar" id="totalBayar" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tr class="diskon">
                                    <th>Diskon</th>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="Diskon" value="0" min="0" max="100"
                                                class="form-control" name="diskon">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="pajak">
                                    <th>Pajak </th>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="Pajak" value="0" min="0" max="100"
                                                class="form-control" name="pajak">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="voucher">
                                    <th>Diskon</th>

                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="text" id="rupiah" class="form-control" name="voucher">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Grand Total</th>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="text" value="0" class="form-control form-lg" name="grandtotal"
                                                id="GrandTotal" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tbody class="dibayaraja">
                                    <tr>
                                        <th>Dibayar</th>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" id="rupiah1" autocomplete="off" class="form-control"
                                                    name="dibayar">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kembali</th>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" readonly class="form-control" id="kembaliBayar"
                                                    name="kembaliBayar">
                                            </div>
                                            <div id="LaporanKembali"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" id="prosesTransaksi" class="btn btn-primary btn-md btn-block mt-2">
                                <i class="fa fa-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-shopping-cart"></i> Keranjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="cart_modal"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-users"></i> Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example2" style="font-size:10pt;" class="table table-bordered table-striped table"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Customer</th>
                                <th>Nama Customer</th>
                                <th>HP/WA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="tampilkan"></div>
<!-- Modal -->
<div class="modal fade" id="cetak-edit" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="edit-content">

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelIdWA" style="margin-top:5pc;" tabindex="1" role="dialog" data-toggle="modal"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white"><i class="fa fa-whatsapp mr-1"></i> Kirim Ke WhatsApp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="get" action="https://api.whatsapp.com/send" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">No WhatsApp</label>
                        <input type="number" value="628" name="phone" autocomplete="off" id="phone" class="form-control"
                            placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="text" id="text">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

$('.dibayaraja').hide();
$(document).ready(function() {
    $('#status').change(function() {
        var cek = $(this).val();
        if (cek == 'Lunas') {
            $('.dibayaraja').show();
        } else if (cek == 'Debit') {
            $('.dibayaraja').show();
        } else if (cek == 'Debit BCA') {
            $('.dibayaraja').show();
        } else if (cek == 'Debit Mandiri') {
            $('.dibayaraja').show();
        } else if (cek == 'Debit BNI') {
            $('.dibayaraja').show();
        } else {
            $('.dibayaraja').hide();
            $('#rupiah1').val('0');
        }
    });
});
</script>
<?php
    if((int)$this->input->get('id'))
    {
        $url = base_url('menu/data_menu?id='.(int)$this->input->get('id'));
    }else{ 
        $url = base_url('menu/data_menu');
    }

    if($pp->diskon == 0){
?>
<script>
$('.diskon').hide();
</script>
<?php } if($pp->voucher == 0){?>
<script>
$('.voucher').hide();
</script>
<?php } if($pp->pajak == 0){?>
<script>
$('.pajak').hide();
</script>
<?php }?>
<script>
var tabel = null;
var base_url = "<?= base_url('');?>";
$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';
    tabel = $('#example2').DataTable({
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
            [10, 25, 50],
            [10, 25, 50]
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
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="javascript:void(0)" data-id="${row.id}" 
                                    class="btn btn-info btn-sm cek_pilih" title="Pilih Customer" role="button">
                                    <i class="fa fa-user-plus"></i> Add
                                </a>`;
                }
            },
        ],
    });
});
$('#example2 tbody').on('click', '.cek_pilih', function(e) {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "<?= base_url('customer/cek_customer');?>",
        type: "POST",
        data: {
            "id": id
        },
        timeout: 6000,
        dataType: "json",
        beforeSend: function() {

        },
        success: function(data) {
            $('#pelanggan_id').val(data[0].id);
            $('#pelanggan').val(data[0].nama);
            $('#atas_nama').val(data[0].nama);
            $('#modelId').modal('hide');
        },
        'error': function(xmlhttprequest, textstatus, message) {
            if (textstatus === "timeout") {
                alert("request timeout");
            } else {
                alert("request timeout");
            }
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $("#AddKasir").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('kasir/store');?>",
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function() {
                $('#prosesTransaksi').attr('disabled', true);
                $('#prosesTransaksi').addClass('btn-success').removeClass('btn-primary');
                $("#prosesTransaksi").html(
                    '<i class="fas fa-circle-notch fa-spin"></i> Loading');
            },
            success: function(result) {
                if (result == 'Kurang') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pembayaran Anda Kurang Dari Total Bayar !',
                    })
                    // alert('Pembayaran Anda Kurang Dari Total Bayar !');
                    $('#prosesTransaksi').attr('disabled', false);
                    $('#prosesTransaksi').addClass('btn-primary').removeClass(
                    'btn-success');
                    $("#prosesTransaksi").html(
                        '<i class="fa fa-save"></i> Simpan Transaksi');
                } else {
                    $('#prosesTransaksi').attr('disabled', false);
                    $('#prosesTransaksi').addClass('btn-primary').removeClass(
                    'btn-success');
                    $("#prosesTransaksi").html(
                        '<i class="fa fa-save"></i> Simpan Transaksi');
                    $('#AddKasir')[0].reset();
                    $('#example1').DataTable().ajax.reload();
                    $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
                    $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');
                    var id = result;
                    var url_add = '<?= base_url('kasir/show?id=');?>' + id;
                    $.ajax({
                        url: url_add,
                        timeout: 30000,
                        success: function(html) {
                            $('.modal').css('overflow-y', 'auto');
                            $('#cetak-edit').modal('show');
                            $("#edit-content").html(html);
                        },
                        'error': function(xmlhttprequest, textstatus, message) {
                            if (textstatus === "timeout") {
                                alert("request timeout");
                            } else {
                                alert("request timeout");
                            }
                        }
                    });
                }

            },
            error: function(xmlhttprequest, textstatus, message) {
                if (textstatus === "timeout") {
                    alert("request timeout");
                } else {
                    alert("request timeout");
                }

                $('#prosesTransaksi').attr('disabled', false);
                $('#prosesTransaksi').addClass('btn-primary').removeClass('btn-success');
                $("#prosesTransaksi").html('Save');
                // $('#AddKasir')[0].reset();
            }
        });
    });
});
</script>
<script>
$('#rupiah1').trigger('focus');
$(document).ready(function() {
    $('#bayarKasir').click(function() {

        var hargaTot = $("#totalBayar").val();
        var diskon = parseInt($("#Diskon").val());
        var pajak = parseInt($('#Pajak').val());
        var voucher = $('#rupiah').val();

        var HrgTot = hargaTot.replace(/\D/g, '');

        var Hrgvoucher = voucher.replace(/\D/g, '');

        // hitung diskon, pajak, voucher
        var totalDiskon = HrgTot * (diskon / 100);
        var totalPajak = HrgTot * (pajak / 100);

        var totalTot = HrgTot - (totalDiskon + totalPajak);
        var totHv = totalTot - Hrgvoucher;

        if (totHv < 1000) {
            var totTot = (totHv).toFixed();
        } else {
            var totTot = (totHv / 1000).toFixed(3);
        }
        $("#GrandTotal").val(totTot);

        var GTot = $("#GrandTotal").val();
        var dibayar = $('#rupiah1').val();

        var GrandTot = GTot.replace(/\D/g, '');
        var Hrgdibayar = dibayar.replace(/\D/g, '');

        var totHvG = Hrgdibayar - GrandTot;

        if (totHvG < 1000) {
            var totTotG = (totHvG).toFixed();
        } else {
            var totTotG = (totHvG / 1000).toFixed(3);
        }

        if (totTotG >= 0) {
            $("#kembaliBayar").val(totTotG);
            $('#LaporanKembali').html('');
            $('#prosesTransaksi').attr('disabled', false);

        } else {
            $("#kembaliBayar").val(totTotG);
            $('#LaporanKembali').html(
                '<span style="color:red; font-weight:700">*  PEMBAYARAN BELUM CUKUP! </span>');
            $('#prosesTransaksi').attr('disabled', true);
        }
    });
});
$(document).ready(function() {
    $("#AddPelanggan").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{route('kasir.AddPelanggan')}}",
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function() {
                $('#prosesPelanggan').attr('disabled', true);
                $('#prosesPelanggan').addClass('btn-success').removeClass('btn-primary');
                $("#prosesPelanggan").html('<i class="fas fa-circle-notch fa-spin"></i>');
            },
            success: function(html) {
                $('#prosesPelanggan').attr('disabled', false);
                $('#prosesPelanggan').addClass('btn-primary').removeClass('btn-success');
                $("#prosesPelanggan").html('<i class="fas fa-user-plus"></i>');
                $('#AddPelanggan')[0].reset();
                $('#dataTable3').DataTable().ajax.reload();
            },
            error: function(xmlhttprequest, textstatus, message) {
                if (textstatus === "timeout") {
                    alert("request timeout");
                } else {
                    alert("request timeout");
                }
            }
        });
    });

    $('#pelanggan').change(function() {
        var pl = $(this).val();
        if (pl == '') {
            $('#pelanggan_id').val('0');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('#rupiah1').bind("keyup change", function() {
        var hargaTot = $("#GrandTotal").val();
        var dibayar = $('#rupiah1').val();
        var HrgTot = hargaTot.replace(/\D/g, '');
        var Hrgdibayar = dibayar.replace(/\D/g, '');

        var totHvG = Hrgdibayar - HrgTot;

        if (totHvG < 1000) {
            var totTot = (totHvG).toFixed();
        } else {
            var totTot = (totHvG / 1000).toFixed(3);
        }

        if (totTot >= 0) {
            $("#kembaliBayar").val(totTot);
            $('#LaporanKembali').html('');
            // $('#prosesTransaksi').attr('disabled',false);
        } else {
            $("#kembaliBayar").val(totTot);
            $('#LaporanKembali').html(
                '<span style="color:red; font-weight:700">*  PEMBAYARAN BELUM CUKUP! </span>');
            // $('#prosesTransaksi').attr('disabled', true);
        }


    });
});
</script>
<script>
$(document).ready(function() {
    $('#Diskon').bind("keyup change", function() {
        var hargaTot = $("#totalBayar").val();
        var diskon = parseInt($("#Diskon").val());
        var pajak = parseInt($('#Pajak').val());
        var voucher = $('#rupiah').val();

        var HrgTot = hargaTot.replace(/\D/g, '');

        var Hrgvoucher = voucher.replace(/\D/g, '');

        // hitung diskon, pajak, voucher
        var totalDiskon = HrgTot * (diskon / 100);
        var totalPajak = HrgTot * (pajak / 100);

        var totalTot = (HrgTot - totalDiskon) + parseInt(totalPajak);
        var totHv = totalTot - Hrgvoucher;

        if (totHv < 1000) {
            var totTot = (totHv).toFixed();
        } else {
            var totTot = (totHv / 1000).toFixed(3);
        }
        $("#GrandTotal").val(totTot);


    });
});
$(document).ready(function() {
    $('#Pajak').bind("keyup change", function() {
        var hargaTot = $("#totalBayar").val();
        var diskon = parseInt($("#Diskon").val());
        var pajak = parseInt($('#Pajak').val());
        var voucher = $('#rupiah').val();


        var HrgTot = hargaTot.replace(/\D/g, '');

        var Hrgvoucher = voucher.replace(/\D/g, '');

        // hitung diskon, pajak, voucher
        var totalDiskon = HrgTot * (diskon / 100);
        var totalPajak = HrgTot * (pajak / 100);

        var totalTot = (HrgTot - totalDiskon) + parseInt(totalPajak);
        var totHv = totalTot - Hrgvoucher;

        if (totHv < 1000) {
            var totTot = (totHv).toFixed();
        } else {
            var totTot = (totHv / 1000).toFixed(3);
        }
        $("#GrandTotal").val(totTot);


    });
});
$(document).ready(function() {

    $('#rupiah').bind("keyup change", function() {
        var hargaTot = $("#totalBayar").val();
        var diskon = parseInt($("#Diskon").val());
        var pajak = parseInt($('#Pajak').val());
        var voucher = $('#rupiah').val();

        var HrgTot = hargaTot.replace(/\D/g, '');

        var Hrgvoucher = voucher.replace(/\D/g, '');

        // hitung diskon, pajak, voucher
        var totalDiskon = HrgTot * (diskon / 100);
        var totalPajak = HrgTot * (pajak / 100);

        var totalTot = (HrgTot - totalDiskon) + parseInt(totalPajak);
        var totHv = totalTot - Hrgvoucher;

        if (totHv < 1000) {
            var totTot = (totHv).toFixed();
        } else {
            var totTot = (totHv / 1000).toFixed(3);
        }
        $("#GrandTotal").val(totTot);

    });
});
</script>

<script>
// rupiah function
var rupiah = document.getElementById('rupiah');
rupiah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, '');
});

var rupiah1 = document.getElementById('rupiah1');
rupiah1.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah1.value = formatRupiah(this.value, '');
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}
</script>