<div class="table-responsive" style="height:400px;overflow-y:scroll;">
    <table class="table table-striped" id="keranjang@" style="font-size:10.5pt;">
        <thead>
            <tr>
                <th>No</th>
                <th style="width:15%">Kode Barang</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th style="width:20%">Qty</th>
                <th>Sub Total</th>
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
                <td><?= $item['kode_menu'];?></td>
                <td><?=$item['nama'];?></td>
                <td><?=$item['kategori'];?></td>
                <td>
                    <a href="javascript:void(0)" data-minus1="<?= $item['id_menu'];?>"
                        class="btn btn-primary btn-sm minus1"> - </a>
                    <span> <input type="number"
                            style="width:35%;border:1px solid #ddd;border-radius:4px;height:32px;padding-left:5px;"
                            class="kr_sub1" data-sub1="<?= $item['id_menu'];?>" value="<?= $item['qty'];?>"></span>
                    <a href="javascript:void(0)" data-plus1="<?= $item['id_menu'];?>"
                        class="btn btn-primary btn-sm plus1"> + </a>
                </td>
                <td>Rp<?= number_format($item['harga_jual'] * $item['qty']);?>,-</td>
                <td>
                    <a href="javascript:void(0)" data-id="<?= $item['id_menu'];?>"
                        class="btn btn-danger btn-sm del_cart1">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <h5 class="mt-2"><b>Catatan Order</b></h5>
                </th>
                <td colspan="5">
                    <input type="text" value="<?= $item['keterangan'];?>" placeholder="Keterangan Order"
                        data-id="<?= $item['id_menu'];?>" autocomplete="off" name="keterangan" class="form-control"
                        id="keterangan">
                </td>
            </tr>
            <?php $no++; $total += $item['harga_jual'] * $item['qty'];}}?>
        </tbody>
    </table>
</div>
<?php
    $toc = $total + $t->grandtotal;
?>
<script>
var total = '<?=$total;?>';
var totc = '<?= $toc;?>';

var tot = (total / 1000).toFixed(3);
var tota = (totc / 1000).toFixed(3);

var totAll = 0;
var totB = 0;

if (total < 1000) {
    totAll = total;
    totB = tota;
} else {
    totAll = tot;
    totB = tota;
}

$("#totalBayar").val(totAll);
$("#GrandTotal").val(totB);

$(document).ready(function() {
    $('.del_cart1').on('click', function(e) {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "<?= base_url('order/del_cart');?>",
            type: "POST",
            data: {
                "id_menu": id
            },
            timeout: 6000,
            success: function(html) {
                $('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
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
$('.minus1').on('click', function(e) {
    var id = $(this).attr('data-minus1');
    var qt = $('.kr_sub1').val() - 1;
    var url_upd = '<?= base_url('order/update_cart?id=');?>' + id;
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
            $('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
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

$('.kr_sub1').on('keyup', function(e) {
    var id = $(this).attr('data-sub1');
    var qt1 = $('.kr_sub1').val();
    console.log(qt1);
    var url_keyup = '<?= base_url('order/update_cart?id=');?>' + id;

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
            $('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
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

$('.plus1').on('click', function(e) {
    var id = $(this).attr('data-plus1');
    var qt = $('.kr_sub1').val();
    var url_upd = '<?= base_url('order/update_cart?id=');?>' + id;
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
            $('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
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
    var url_upd = '<?= base_url('order/updateket_cart?id=');?>' + id;
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
            $('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
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