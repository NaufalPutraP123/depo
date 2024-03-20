<style>
#customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td,
#customers th {
    border: 1px solid #ddd;
    padding: 4px;
    font-size: 10.5pt;
}

#customers tr:nth-child(even) {
    background-color: #f2f2f2;
}

#customers tr:hover {
    background-color: #ddd;
}

#customers th {
    padding-top: 5px;
    padding-bottom: 5px;
    text-align: center;
    background-color: #4CAF50;
    color: white;
}
</style>
<!-- <div class="table-responsive p-2" id="KeranjangAdd">
    <?php 
        $total = 0; $no=1; 
        foreach($items as $item){

        if($item['kode_menu'] == ''){

        }else{ 
    ?>
        <span>
            (<?= $item['kode_menu'];?>) <b><?=$item['nama'];?></b>
        </span>
        <div class="clearfix mb-2"></div>
        <table id="customers">
            <tbody>
                <tr>
                    <th scope="row"> Qty</th>
                    <th>Harga</th>
                    <th>#</th>
                </tr>
                <tr>
                    <td>
                        <a href="javascript:void(0)" data-minus="<?= $item['id_menu'];?>" 
                            class="btn btn-primary btn-sm minus"> - </a> 
                        <span> <input type="number" 
                            class="kr_sub" data-sub="<?= $item['id_menu'];?>" value="<?= $item['qty'];?>"></span>
                        <a href="javascript:void(0)" data-plus="<?= $item['id_menu'];?>"
                            class="btn btn-primary btn-sm plus"> + </a>
                    </td>
                    <td>Rp<?= number_format($item['harga_jual'] * $item['qty']);?>,-</td>
                    <td>
                        <a href="javascript:void(0)" data-id="<?= $item['id_menu'];?>" 
                            class="btn btn-danger btn-sm del_cart">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="text" value="<?= $item['keterangan'];?>" placeholder="Keterangan Order" data-id="<?= $item['id_menu'];?>" autocomplete="off" name="keterangan" 
            class="form-control mt-3" id="keterangan">
    <hr>
    <?php $no++; $total += $item['harga_jual'] * $item['qty'];}}?> 
-->
<div class="table-responsive">
    <table class="table table-striped table-sm w-100" id="keranjang@" style="font-size:10pt;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $total = 0; $no=1; 
                foreach($items as $item){

                if($item['kode_menu'] == ''){

                }else{ 
            ?>
            <tr>
                <td scope="row"><?= $no;?></td>
                <td>(<?= $item['kategori'];?>) <b><?=$item['nama'];?></b></td>
                <td>
                    <a href="javascript:void(0)" data-minus="<?= $item['id_menu'];?>"
                        class="badge badge-primary p-2 minus"> - </a>
                    <span>
                        <input type="number" class="kr_sub" min="1" data-sub="<?= $item['id_menu'];?>"
                            value="<?= $item['qty'];?>">
                    </span>
                    <a href="javascript:void(0)" data-plus="<?= $item['id_menu'];?>"
                        class="badge badge-primary p-2 plus"> + </a>
                </td>
                <td>Rp<?= number_format($item['harga_jual'] * $item['qty']);?>,-</td>
                <td>
                    <a href="javascript:void(0)" data-id="<?= $item['id_menu'];?>" class="badge badge-danger del_cart">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
            <?php $no++; $total += $item['harga_jual'] * $item['qty'];}}?>
        </tbody>
    </table>
</div>
<script>
var total = '<?=$total;?>';
var tot = (total / 1000).toFixed(3);
var totAll = 0;

if (total < 1000) {
    totAll = total;
} else {
    totAll = tot;
}

$("#total").val(totAll);
$("#totalBayar").val(totAll);
$("#GrandTotal").val(totAll);

$(document).ready(function() {
    $('.del_cart').on('click', function(e) {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "<?= base_url('kasir/del_cart');?>",
            type: "POST",
            data: {
                "id_menu": id
            },
            timeout: 6000,
            success: function(html) {
                $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
                $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');
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
});

$('.minus').on('click', function(e) {
    var id = $(this).attr('data-minus');
    var qt = $('.kr_sub').val() - 1;
    var url_upd = '<?= base_url('kasir/update_cart?id=');?>' + id;
    $.ajax({
        url: url_upd,
        type: "POST",
        data: {
            "type": "minus",
            "qt": qt
        },
        timeout: 6000,
        beforeSend: function() {

        },
        complete: function() {

        },
        success: function(html) {
            $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
            $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');
            $('#tampilkan').html(html);
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

$('.kr_sub').on('change', function(e) {
    var id = $(this).attr('data-sub');
    var qt1 = $(this).val();
    console.log(qt1);
    var url_keyup = '<?= base_url('kasir/update_cart?id=');?>' + id;

    $.ajax({
        url: url_keyup,
        type: "POST",
        data: {
            "type": "keyup",
            "qt": qt1
        },
        timeout: 6000,
        beforeSend: function() {

        },
        complete: function() {

        },
        success: function(html) {
            $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
            $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');
            $('#tampilkan').html(html);
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

$('.plus').on('click', function(e) {
    var id = $(this).attr('data-plus');
    var qt = $('.kr_sub').val();
    var url_upd = '<?= base_url('kasir/update_cart?id=');?>' + id;
    $.ajax({
        url: url_upd,
        type: "POST",
        data: {
            "type": "plus",
            "qt": qt
        },
        timeout: 6000,
        beforeSend: function() {

        },
        complete: function() {

        },
        success: function(html) {
            $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
            $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');
            $('#tampilkan').html(html);
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

$('#keterangan').on('change', function(e) {
    var id = $(this).attr('data-id');
    var qt = $('#keterangan').val();
    var url_upd = '<?= base_url('kasir/updateket_cart?id=');?>' + id;
    $.ajax({
        url: url_upd,
        type: "POST",
        data: {
            "qt": qt
        },
        timeout: 6000,
        beforeSend: function() {

        },
        complete: function() {

        },
        success: function(html) {
            $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
            $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');
            $('#tampilkan').html(html);
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