<?php
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-type:application/vnd.ms-excel");
    header("Content-disposition:attachment;filename=laporan_penjualan_".date('Y-m-d').".xls");
    header("Content-transfer-Encoding: binary ");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Excel</title>
</head>

<body>
    AKTIVITAS KEUANGAN<br>
    <?= $periode;?>
    <table id="customers">
        <tr>
            <th>No</th>
            <th>No Ledger</th>
            <th>Nama Aktivitas</th>
            <th>Jenis Keuangan</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Date</th>
        </tr>
        <?php $no =1; $msk = 0; $klr = 0;foreach($transaksi as $r){?>
        <tr>
            <td><?= $no;?></td>
            <td><?= $r->no_ledger;?></td>
            <td><?= $r->ket;?></td>
            <td><?= $r->jenis;?></td>
            <td><?= $r->jumlah_masuk;?></td>
            <td><?= $r->jumlah_keluar;?></td>
            <td><?= $r->date;?></td>
        </tr>
        <?php $msk += $r->jumlah_masuk; $klr += $r->jumlah_keluar;}?>
        <tr>
            <th colspan="4">Total</th>
            <th>Rp<?php echo number_format($msk)?></th>
            <th>Rp<?php echo number_format($klr)?></th>
            <th>#</th>
        </tr>
    </table>
</body>

</html>