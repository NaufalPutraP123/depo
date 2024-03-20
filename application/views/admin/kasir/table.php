<div class="table-responsive w-100">
    <table class="table table-striped table-sm w-100" id="keranjang@" style="font-size:10pt;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Qty</th>
                <th>Sub</th>
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
                <td>(<?= $item['kode_menu'];?>) <b><?=$item['nama'];?></b></td>
                <td>
                    <a href="javascript:void(0)" data-minus1="<?= $item['id_menu'];?>"
                        class="badge badge-primary p-2 btn-sm minus1"> - </a>
                    <span> <input type="number" class="kr_sub1" data-sub1="<?= $item['id_menu'];?>"
                            value="<?= $item['qty'];?>"></span>
                    <a href="javascript:void(0)" data-plus1="<?= $item['id_menu'];?>"
                        class="badge badge-primary p-2 btn-sm plus1"> + </a>
                </td>
                <td>Rp<?= number_format($item['harga_jual'] * $item['qty']);?>,-</td>
                <td>
                    <a href="javascript:void(0)" data-id="<?= $item['id_menu'];?>"
                        class="badge badge-danger p-2 btn-sm del_cart1">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
            <?php $no++;}}?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function() {
    $('.del_cart1').on('click', function(e) {
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
$('.minus1').on('click', function(e) {
    var id = $(this).attr('data-minus1');
    var qt = $('.kr_sub1').val() - 1;
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

$('.kr_sub1').on('keyup', function(e) {
    var id = $(this).attr('data-sub1');
    var qt1 = $('.kr_sub1').val();
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

$('.plus1').on('click', function(e) {
    var id = $(this).attr('data-plus1');
    var qt = $('.kr_sub1').val();
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
</script>