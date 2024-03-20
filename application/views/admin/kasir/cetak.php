    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-print"></i> Print Struk</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> -->
    </div>
    <form method="post" id="cetak_struk">
        <div class="modal-body">
            <center>
                <img src="<?= base_url('assets/image/'.$pp->driver);?>" alt="Logo" style="width:80px;">
                <h3><b> <?= $pp->nama_toko;?> </b></h3>
                <p><?= $pp->alamat_toko;?></p>
            </center>
            <p>No Bon : <?= $t->no_bon;?></p>
            <table width="100%">
                <tr>
                    <td>
                        Atas Nama
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?= $t->atas_nama;?>
                    </td>
                    <td>
                        Customer
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?= $t->nama;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Status / Kasir
                    </td>
                    <td>
                        :
                    </td>
                    <?php $user = $this->db->get_where('login',['id' => $t->kasir_id])->row();?>
                    <td>
                        <?= $t->status;?> / <?= $user->nama_user;?>
                    </td>
                    <td>
                        Order
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?= $t->pesanan;?>
                    </td>
                </tr>
            </table>
            <hr>
            <table style="width:100%">
                <?php $hr = 0; foreach($tp as $r){?>
                <tr>
                    <td>
                        <?= $r->qty;?>
                    </td>
                    <td>
                        <?= $r->nama_menu;?>
                    </td>
                    <td>
                        Rp<?= number_format($r->qty * $r->harga_jual);?>
                    </td>
                </tr>
                <?php $hr += $r->harga_jual * $r->qty; }?>
            </table>
            <hr>
            <table>
                <tr>
                    <th>Total Bayar</th>
                    <td>
                        Rp<?= number_format($hr);?>
                    </td>
                </tr>
                <?php 
            if($pp->diskon > 0){
                $RPdiskon = $hr * $t->diskon / 100;
            ?>
                <tr class="diskon">
                    <th>Diskon</th>
                    <td>
                        <?= $t->diskon;?> % / Rp<?= $RPdiskon;?>
                    </td>
                </tr>
                <?php }?>
                <?php if($pp->pajak > 0){?>
                <tr class="pajak">
                    <th>Pajak </th>
                    <td>
                        <?= $t->pajak;?> %
                    </td>
                </tr>
                <?php }?>
                <?php if($pp->voucher > 0){?>
                <tr class="voucher">
                    <th>Diskon</th>
                    <td>
                        Rp<?= number_format($t->voucher);?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <th>Grand Total</th>
                    <td>
                        Rp<?= number_format($t->grandtotal);?>
                    </td>
                </tr>
                <tr>
                    <th>Dibayar</th>
                    <td>
                        Rp<?= number_format($t->dibayar);?>
                    </td>
                </tr>
                <tr>
                    <th>Kembali</th>
                    <td>
                        Rp<?= number_format($t->dibayar-$t->grandtotal);?>
                    </td>
                </tr>
            </table>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <?php if($pp->print == '1'){?>
                            <select name="cetak" class="form-control mb-2">
                                <option value="1" <?php if($pp->print_default == '1'){ echo 'selected' ;}?>> 58mm
                                </option>
                                <option value="2" <?php if($pp->print_default == '2'){ echo 'selected' ;}?>> 80mm
                                </option>
                                <option value="3" <?php if($pp->print_default == '3'){ echo 'selected' ;}?>> A4</option>
                            </select>
                            <?php }?>
                            <input type="hidden" value="<?php echo $pp->os;?>" name="os">
                            <input type="hidden" value="<?php echo $pp->print;?>" name="print">
                            <input type="hidden" value="<?php echo $pp->driver;?>" name="driver">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary btn-block mb-2"><i class="fa fa-print"></i>
                                Cetak
                                Struk</button>
                        </div>
                        <div class="col-sm-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success btn-block mb-2" id="wabutton"
                                data-phone="<?= $t->hp;?>" data-text="
Pesanan : 
<?php $hr = 0; foreach($tp as $r){?>
<?= $r->nama_menu;?> x <?= $r->qty;?> = Rp<?= number_format($r->harga_jual);?> 
<?php $hr  += $r->harga_jual * $r->qty; }?>

Total Bayar Rp<?= number_format($hr);?> 
<?php if($pp->diskon > 0){ $RPdiskon = $hr * $t->diskon / 100;?>
Diskon : <?= $t->diskon;?>%  / Rp<?= $RPdiskon;?> 
<?php }?>
<?php if($pp->pajak > 0){?>
Pajak : <?= $t->pajak;?> %
<?php }?>
<?php if($pp->voucher > 0){?>
Diskon : Rp<?= number_format($t->voucher);?> 
<?php }?>
Grand Total : Rp<?= number_format($t->grandtotal);?>

Dibayar : Rp<?= number_format($t->dibayar);?>

Kembali : Rp<?= number_format($t->dibayar-$t->grandtotal);?>" data-toggle="modal" data-target="#modelIdWA">
                                <i class="fa fa-whatsapp mr-1"></i> Kirim WA
                            </button>
                        </div>
                        <div class="col-sm-3">
                            <a href="<?= base_url('kasir');?>" class="btn btn-secondary btn-block"><i
                                    class="fa fa-check mr-1"></i>
                                Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    <script>
function mobilecheck() {
    var check = false;
    (function(a) {
        if (
            /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i
            .test(a) ||
            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
            .test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
}
$('#wabutton').click(function(e) {
    var phone = $(this).attr('data-phone');
    var text = $(this).attr('data-text');
    if (phone !== '') {
        $('#phone').val(phone);
    }
    $('#text').val(text);
    $("#phone").focus();
    console.log(phone);
    console.log(text);
});

$(document).ready(function() {
    var isMobile = mobilecheck();
    $("#cetak_struk").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('kasir/print?id='.$t->no_bon);?>",
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(html) {
                <?php if($pp->print == '1'){?>
                if (isMobile) {
                    w = window.open(window.location.href, "_blank");
                    w.document.open();
                    w.document.write(html);
                    w.document.close();
                    w.window.print();
                } else {
                    var HTML = html;
                    var WindowObject = window.open("", "PrintWindow",
                        "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes"
                    );
                    WindowObject.document.writeln(HTML);
                    WindowObject.document.close();
                    WindowObject.focus();
                    WindowObject.print();
                    WindowObject.close();
                }
                <?php }?>
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
});
    </script>