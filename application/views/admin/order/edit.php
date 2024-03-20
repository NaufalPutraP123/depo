<div class="clearfix"></div>
<div id="home">
    <div class="container-fluid mt-5">
        <div class="clearfix"></div>
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
            if(!empty(in_array($t->status,['Lunas','Debit BCA', 'Debit BNI','Debit Mandiri','Debit']))){ 
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <b> Status Detail Order ini Telah Selesai !</b>
        </div>
        <?php }else{?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <b> Status Detail Order ini Belum Selesai, silahkan selesaikan Transaksi !</b>
        </div>
        <?php }?>
        <div class="row">
            <div class="col-sm-4">
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <i class="fa fa-user"></i> Detail Order
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td scope="row">No Bon</td>
                                        <td><?= $t->no_bon;?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Customer</td>
                                        <td>
                                            <?php 
                                                if($t->customer_id == 0){
                                                    echo '-';
                                                }else{
                                                    echo $t->nama;
                                                } 
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Atas Nama</td>
                                        <td><?= $t->atas_nama;?></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Status Pembayaran</td>
                                        <td>
                                            <?php 
                                                if($t->status == 'Bayar Nanti'){
                                                    echo '<span class="text-danger">
                                                            <i class="fa fa-info-circle"> </i> '.$t->status.'</span>';
                                                }else{
                                                    echo '<span class="text-success">
                                                    <i class="fa fa-check"> </i> '.$t->status.'</span>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Jenis Order</td>
                                        <td>
                                            <?php 
                                                if($t->pesanan == 'Ditempat'){
                                                    echo '<span class="text-primary">
                                                    <i class="fa fa-home"> </i> '.$t->pesanan.'</span>';
                                                }
                                                if($t->pesanan == 'Booking'){
                                                    echo '<span class="text-warning">
                                                    <i class="fa fa-ticket"> </i> '.$t->pesanan.'</span>';
                                                }
                                                if($t->pesanan == 'Delivery'){
                                                    echo '<span class="text-success">
                                                    <i class="fa fa-motorcycle"> </i> '.$t->pesanan.'</span>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Tanggal dan Waktu</td>
                                        <td><?= $t->created_at;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <b><i class="fa fa-list"></i> List Order</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height:310px;overflow-y:scroll;">
                            <table class="table table-bordered table-striped" id="keranjang" style="font-size:10.5pt;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Menu</th>
                                        <th>Kategori</th>
                                        <th>Nama</th>
                                        <th>Catatan</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total = 0; $no=1; 
                                        foreach($tp as $item){

                                        if($item['kode_menu'] == ''){

                                        }else{ 
                                    ?>
                                    <tr>
                                        <td scope="row"><?= $no;?></td>
                                        <td><?= $item['kode_menu'];?></td>
                                        <td><?=$item['kategori'];?></td>
                                        <td><?=$item['nama_menu'];?></td>
                                        <td><?=$item['keterangan'];?></td>
                                        <td>
                                            <?= $item['qty'];?>
                                        </td>
                                        <td>Rp<?= number_format($item['harga_jual'] * $item['qty']);?>,-</td>
                                        <td>
                                            <a href="<?= base_url('order/hapus_item?id='.$item['id'].'&order_id='.$t->id);?>" class="btn btn-danger btn-md" 
                                                onclick="return confirm('Yakin ingin menghapus data ini ?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; $total += $item['harga_jual'] * $item['qty'];}}?>
                                </tbody>
                            </table>
                            <hr>
                            <div class="float-right">
                                <table>
                                    <tr>
                                        <th>Total Bayar</th>
                                        <th>:</th>
                                        <td>
                                            Rp<?= number_format($total);?>
                                        </td>
                                    </tr>
                                    <?php if($pp->diskon > 0){
                                            $RPdiskon = $total * $t->diskon / 100;
                                        ?>
                                    <tr class="diskon">
                                        <td><b>Diskon</b></td>
                                        <td>:</td>
                                        <td>
                                            <?= $t->diskon;?> % / Rp <?= $RPdiskon;?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if($pp->pajak > 0){?>
                                    <tr class="pajak">
                                        <th>Pajak </th>
                                        <th>:</th>
                                        <td>
                                            <?= $t->pajak;?> %
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if($pp->voucher > 0){?>
                                    <tr class="voucher">
                                        <th>Diskon</th>
                                        <th>:</th>
                                        <td>
                                            Rp<?= number_format($t->voucher);?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <th>Grand Total</th>
                                        <th>:</th>
                                        <td>
                                            <?php
                                                $diskon = $total * $t->diskon/100;
                                                $pajak = $total * $t->pajak/100;
                                                $grd = ($total - $t->voucher - $diskon) + $pajak;
                                            ?>
                                            Rp<?= number_format($grd);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibayar</th>
                                        <th>:</th>
                                        <td>
                                            Rp<?= number_format($t->dibayar);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kembali</th>
                                        <th>:</th>
                                        <td>
                                            Rp<?= number_format($t->dibayar-$grd);?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form method="post" id="cetak_struk">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?php if($pp->print == '1'){?>
                                        <select name="cetak" class="form-control mb-2">
                                            <option value="1" <?php if($pp->print_default == '1'){ echo 'selected' ;}?>>
                                                58mm</option>
                                            <option value="2" <?php if($pp->print_default == '2'){ echo 'selected' ;}?>>
                                                80mm</option>
                                            <option value="3" <?php if($pp->print_default == '3'){ echo 'selected' ;}?>>
                                                A4</option>
                                        </select>
                                        <?php }?>
                                        <input type="hidden" value="<?php echo $pp->os;?>" name="os">
                                        <input type="hidden" value="<?php echo $pp->print;?>" name="print">
                                        <input type="hidden" value="<?php echo $pp->driver;?>" name="driver">
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary btn-block mb-2"><i
                                                class="fa fa-print"></i> Cetak Struk</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success btn-block mb-2" id="wabutton"
                                            data-phone="<?= $t->hp;?>" data-text="
Pesanan : 
<?php $hr = 0; foreach($tp1 as $r){?>
<?= $r->nama_menu;?> x <?= $r->qty;?> = Rp<?= number_format($r->qty * $r->harga_jual);?> 
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
Grand Total : Rp<?= number_format($grd);?>

Dibayar : Rp<?= number_format($t->dibayar);?>

Kembali : Rp<?= number_format($t->dibayar-$grd);?>" data-toggle="modal" data-target="#modelIdWA">
                                            <i class="fa fa-whatsapp mr-1"></i> Kirim WA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if($t->status == 'Bayar Nanti'){?>
            <div class="col-sm-8">
                <div class="card card-rounded mt-5">
                    <div class="card-header bg-primary text-white">
                        <!-- Button trigger modal -->
                        <div class="float-right">
                            <button type="button" class="btn btn-success btn-md" data-toggle="modal"
                                data-target="#modelId">
                                <i class="fa fa-plus"></i> Tambah Order
                            </button>
                        </div>
                        <h5 class="pt-2"><b><i class="fa fa-plus"></i> Tambah Order</b></h5>
                    </div>
                    <div class="card-body">
                        <div id="tampilkan_cart"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-rounded mt-5">
                    <div class="card-header bg-primary text-white">
                        <h5 class="pt-2"><b><i class="fa fa-edit"></i> Pembayaran</b></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="POST" action="<?= base_url('order/updated');?>">
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
                                                    <option <?php if($t->pesanan == 'Ditempat'){ echo 'selected';}?>>
                                                        Ditempat</option>
                                                    <option <?php if($t->pesanan == 'Booking'){ echo 'selected';}?>>
                                                        Booking</option>
                                                    <option <?php if($t->pesanan == 'Delivery'){ echo 'selected';}?>>
                                                        Delivery</option>
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
                                                    <input type="text" value="<?= number_format($grd);?>"
                                                        id="totalBayar1" class="form-control form-lg" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Plus Order</th>
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
                                                <input type="text" value="0" class="form-control form-lg"
                                                    name="grandtotal" id="GrandTotal" readonly>
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
                                                    <input type="text" id="rupiah1" autocomplete="off"
                                                        class="form-control" name="dibayar">
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
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" value="<?= $t->no_bon;?>" name="no_bon">
                                            <input type="hidden" value="<?= $t->id;?>" name="idtrx">
                                            <button type="submit" id="prosesTransaksi"
                                                class="btn btn-success btn-md btn-block mt-2">
                                                <i class="fa fa-save"></i> Simpan Transaksi
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if($t->status == 'Lunas'){?>
                <div class="text-center">
                    <h5><b> Pembayaran Sudah Lunas Silahkan Order Baru </b></h5>
                    <a href="<?= base_url('kasir');?>" class="btn btn-success btn-md mt-2">
                        <i class="fa fa-shopping-cart"></i> Kasir
                    </a>
                </div>
                <?php }else{?>
                <div class="text-center">
                    <div class="row">
                        <div class="col-sm-4 mx-auto">
                            <b>- Pilih Kategori -</b>
                            <div class="form-group mt-2">
                                <select class="form-control" name="kategori" id="kategori">
                                    <option value="0">- Semua Kategori -</option>
                                    <?php foreach($kat as $r){?>
                                    <option value="<?= $r->id;?>"><?= $r->kategori;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example1" style="font-size:10.5pt" class="table table-bordered table-striped table"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Menu</th>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <?php }?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button>
            </div>
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
function mobilecheck() {
    var check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i
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
                    w = window.open("<?= base_url('kasir/print?id='.$t->no_bon);?>", "PrintWindow","width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
                    w.window.print();
                    w.document.close();
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
<script>
$(document).ready(function() {
    $('#Diskon').bind("keyup change", function() {
        hitungDiskon();
    });
});
$(document).ready(function() {
    $('#Pajak').bind("keyup change", function() {
        hitungDiskon();

    });
});
$(document).ready(function() {
    $('#rupiah').bind("keyup change", function() {
        hitungDiskon();
    });
});
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

function hitungDiskon() {
    var hargaTot1 = $("#totalBayar1").val();
    var hargaTot = $("#totalBayar").val();
    var diskon = parseInt($("#Diskon").val());
    var pajak = parseInt($('#Pajak').val());
    var voucher = $('#rupiah').val();

    var HrgTot1 = hargaTot1.replace(/\D/g, '');
    var HrgTot = hargaTot.replace(/\D/g, '');

    var Hrgvoucher = voucher.replace(/\D/g, '');

    // hitung diskon, pajak, voucher
    var totalDiskon = (parseInt(HrgTot1) + parseInt(HrgTot)) * (diskon / 100);
    var totalPajak = (parseInt(HrgTot1) + parseInt(HrgTot)) * (pajak / 100);

    var totalTot = ((parseInt(HrgTot1) + parseInt(HrgTot)) - (totalDiskon)) + totalPajak;
    var totHv = totalTot - Hrgvoucher;

    if (totHv < 1000) {
        var totTot = (totHv).toFixed();
    } else {
        var totTot = (totHv / 1000).toFixed(3);
    }
    $("#GrandTotal").val(totTot);
}
var rupiah1 = document.getElementById('rupiah1');
rupiah1.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah1.value = formatRupiah(this.value, '');
});

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
<?php if($pp->diskon == 0){?>
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
$('.dibayaraja').hide();
$(document).ready(function() {
    $('#status').change(function() {
        var cek = $(this).val();
        if (cek == 'Lunas') {
            $('.dibayaraja').show();
            hitungDiskon();
        } else if (cek == 'Debit BCA') {
            $('.dibayaraja').show();
            hitungDiskon();
        } else if (cek == 'Debit') {
            $('.dibayaraja').show();
            hitungDiskon();
        } else if (cek == 'Debit Mandiri') {
            $('.dibayaraja').show();
            hitungDiskon();
        } else if (cek == 'Debit BNI') {
            $('.dibayaraja').show();
            hitungDiskon();
        } else {
            $('.dibayaraja').hide();
            $('#rupiah1').val('');
        }
    });
});
$('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
</script>
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
                            '" style="border-radius:10px 10px 10px 10px;height:70px;" class="img-fluid"/>' +
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
                'data': 'stok'
            },
            {
                data: 'harga_jual',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="javascript:void(0)" data-id="${row.id}" 
                                    class="btn btn-info btn-sm pilih" title="Tambah Order" role="button">
                                    <i class="fa fa-plus"></i> Order
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
    $('#kategori').change(function() {
        var target = $(this).val();
        var url_new = base_url + 'menu/data_menu?id=' + target;
        $('#example1').DataTable().ajax.url(url_new).load();
    });
});
$('#example1 tbody').on('click', '.pilih', function(e) {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "<?= base_url('order/add_cart');?>",
        type: "POST",
        data: {
            "id": id
        },
        timeout: 6000,
        beforeSend: function() {

        },
        success: function(html) {
            $('#tampilkan_cart').load('<?= base_url('order/cart_table?id='.$t->id);?>');
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