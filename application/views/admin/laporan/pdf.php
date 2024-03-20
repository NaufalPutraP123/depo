<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title_pdf?></title>
    <style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 9pt;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
    }
    </style>
</head>

<body>
    <h4>
        <center>CASH FLOW USAHA </center>
    </h4>
    <h4>
        <center>Periode <?= $periode?></center>
    </h4>
    <br>
    <table class="table" id="customers">
        <tr>
            <th colspan="2">Arus Kas yang berasal dari Kegiatan Operasional </th>
        </tr>
        <tr>
            <td>Kas yang diterima oleh Penjualan Produk</td>
            <td>Rp<?= number_format($total->gr ?? 0);?></td>
        </tr>
        <tr>
            <th colspan="2">Dikurangi : </th>
        </tr>
        <tr>
            <td>Pemodalan oleh Penjualan Produk</td>
            <td>(Rp<?= number_format(($total->gm) ?? 0);?>)</td>
        </tr>
        <tr style="background:#eee;">
            <th>Aliran Kas Bersih dari Kegiatan Operasional </th>
            <th>Rp<?= number_format(($total->gr - $total->gm) ?? 0);?></th>
        </tr>
        <tr>
            <th colspan="2">Aliran Pemasukan Kas yang berasal dari Aktivitas Keuangan Lainnya</th>
        </tr>
        <?php $msk = 0; $klr = 0; foreach($keuangan as $r){?>
        <?php if($r->jenis == 'Pemasukan'){?>
        <tr>
            <td><?= $r->ket;?></td>
            <td>Rp<?= number_format($r->jumlah_masuk ?? 0);?></td>
        </tr>
        <?php }else{?>
        <tr>
            <td><?= $r->ket;?></td>
            <td>(Rp<?= number_format($r->jumlah_keluar ?? 0);?>)</td>
        </tr>
        <?php }?>
        <?php $msk += $r->jumlah_masuk; $klr += $r->jumlah_keluar;}?>
        <tr style="background:#eee;">
            <th>Total Kas Bersih yang berasal dari Aktivitas Keuangan Lainnya</th>
            <th>Rp<?= number_format(($msk - $klr)  ?? 0);?></th>
        </tr>
        <tr style="background:#cdf59a;">
            <th>Laba Bersih Bulan ini ( <?= $periode;?> )</th>
            <th>Rp<?= number_format((($total->gr - $total->gm)+($msk - $klr)) ?? 0);?></th>
        </tr>
    </table>
</body>

</html>