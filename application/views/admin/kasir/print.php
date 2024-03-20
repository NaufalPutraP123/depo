<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Print Struk</title>
    <!-- General CSS Files -->
    <!-- <?php if($os == '1'){?>
        <?php if($cetak == '1'){?>
        <style>
            @page { size: 210mm 297mm } /* output size */
            body.receipt .sheet { width: 58mm; height: 100mm; font-size:12pt; } /* sheet size */
            @media print { body.receipt { width: 58mm; font-size:12pt; } } /* fix for Chrome */
        </style>
        <?php }?>
        <?php if($cetak == '2'){?>
        <style>
            @page { size: 210mm 297mm } /* output size */
            body.receipt .sheet { width: 80mm; height: 100mm; font-size:12pt; } /* sheet size */
            @media print { body.receipt { width: 80mm; font-size:12pt; } } /* fix for Chrome */
        </style>
        <?php }?>
        <?php if($cetak == '3'){?>
        <style>
            @page { size: 210mm 297mm } /* output size */
            body.receipt .sheet { width: 210mm 297mm} /* sheet size */
            @media print { body.receipt { width: 210mm } } /* fix for Chrome */
        </style>
        <?php }?>
    <?php }else{?> 
        <?php if($cetak == '1'){?>
        <style>
            @page { size:  58mm 100mm } /* output size */
            body.receipt .sheet { width: 58mm; height: 100mm; font-size:12pt; } /* sheet size */
            @media print { body.receipt { width: 58mm; font-size:12pt; } } /* fix for Chrome */
        </style>
        <?php }?>
        <?php if($cetak == '2'){?>
        <style>
              @page { size: 80mm 100mm} /* output size */
            body.receipt .sheet { width: 80mm; height: 100mm; font-size:12pt; } /* sheet size */
            @media print { body.receipt { width: 80mm; font-size:12pt; } } /* fix for Chrome */
        </style>
        <?php }?>
        <?php if($cetak == '3'){?>
        <style>
            @page { size: 210mm 297mm } /* output size */
            body.receipt .sheet { width: 210mm 297mm} /* sheet size */
            @media print { body.receipt { width: 210mm } } /* fix for Chrome */
        </style>
        <?php }?>
    <?php }?> -->

    <style>
    html {
        font-family: sans-serif;
        font-size: 8pt !important;
    }

    table {
        width: 100%;
        margin: 0;
        font-size: 8pt !important;
    }

    tr td {
        padding-top: 5px;
        font-size: 8pt !important;
    }

    .right {
        text-align: right;
    }

    center {
        margin: 0;
    }

    .doted {
        border-bottom: 1px solid #333;
    }
    </style>

    <!-- <script>window.print();</script> -->
</head>

<body class="receipt">
    <section>
        <br />
        <center>
            <img src="<?= base_url('assets/image/'.$pp->driver);?>" alt="Logo" style="width:50px;">
            <h3><b> <?= $pp->nama_toko;?> </b></h3>
            <p><?= $pp->alamat_toko;?></p>
        </center>
        <table>
            <tr>
                <td>
                    No Bon
                </td>
                <td>
                    :
                </td>
                <td>
                    <?= $t->no_bon;?>
                </td>
            </tr>
            <tr>
                <td>
                    A/N
                </td>
                <td>
                    :
                </td>
                <td>
                    <?= $t->atas_nama;?>
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
            </tr>
            <tr>
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
        <p class="doted"></p>
        <table>
            <?php $hr = 0; foreach($tp as $r){?>
            <tr>
                <td>
                    <?= $r->qty;?> x
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
        <p class="doted"></p>
        <table>
            <tr>
                <td><b>Total Bayar</b></td>
                <td>:</td>
                <td>
                    Rp<?= number_format($hr);?>
                </td>
            </tr>
            <?php if($pp->diskon > 0){
                $RPdiskon = $hr * $t->diskon / 100;
            ?>
            <tr class="diskon">
                <td><b>Diskon</b></td>
                <td>:</td>
                <td>
                    <?= $t->diskon;?> % / Rp<?= $RPdiskon;?>
                </td>
            </tr>
            <?php }?>
            <?php if($pp->pajak > 0){?>
            <tr class="pajak">
                <td><b>Pajak </b></td>
                <td>:</td>
                <td>
                    <?= $t->pajak;?> %
                </td>
            </tr>
            <?php }?>
            <?php if($pp->voucher > 0){?>
            <tr class="voucher">
                <td><b>Diskon</b></td>
                <td>:</td>
                <td>
                    Rp<?= number_format($t->voucher);?>
                </td>
            </tr>
            <?php }?>
            <tr>
                <td><b>Grand Total</b></td>
                <td>:</td>
                <td>
                    <?php
                        $diskon =  $hr * $t->diskon/100;
                        $pajak =  $hr * $t->pajak/100;
                        $grd = ( $hr - $t->voucher - $diskon) + $pajak;
                    ?>
                    Rp<?= number_format($grd);?>
                </td>
            </tr>
            <tr>
                <td><b>Dibayar</b></td>
                <td>:</td>
                <td>
                    Rp<?= number_format($t->dibayar);?>
                </td>
            </tr>
            <tr>
                <td><b>Kembali</b></td>
                <td>:</td>
                <td>
                    Rp<?= number_format($t->dibayar-$grd);?>
                </td>
            </tr>
        </table>
        <p class="doted"></p>
        <center>
            <?= $pp->footer_struk?> <br> <?=date('d-m-Y H:i:s');?>
        </center>
        <br>
        <br>
    </section>
</body>

</html>