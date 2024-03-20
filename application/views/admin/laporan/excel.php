<?php
if($this->input->get('cetak') == 'print'){
  echo '<script>window.print();</script>';
}else{

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header("Content-type:application/vnd.ms-excel");
  header("Content-disposition:attachment;filename=laporan_penjualan_".date('Y-m-d').".xls");
  header("Content-transfer-Encoding: binary ");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Excel</title>
    <?php
if($this->input->get('cetak') == 'print'){?>
    <style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #333;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: #333;
    }
    </style>
    <?php }?>
</head>

<body>
    LAPORAN PENJUALAN<br>
    <?= $periode;?>
    <table id="customers">
        <tr>
            <th>No</th>
            <th>No Bon</th>
            <th>Atas Nama</th>
            <th>Customer</th>
            <th>Kasir</th>
            <th>Tanggal</th>
            <th>Jenis Order</th>
            <th>Status</th>
            <th>Qty</th>
            <th>Grand Modal</th>
            <th>Grand Total</th>
        </tr>
        <?php $no =1; $total = 0; $gm = 0; $qty = 0; foreach($transaksi as $r){?>
        <tr>
            <td><?= $no;?></td>
            <td><?= $r->no_bon;?></td>
            <td><?= $r->atas_nama;?></td>
            <td><?= $r->nama;?></td>
            <td><?= $r->nama_user;?></td>
            <td><?= $r->date;?></td>
            <td><?= $r->pesanan;?></td>
            <td><?= $r->status;?></td>
            <td><?= $r->total_qty;?></td>
            <td><?= $r->grandmodal;?></td>
            <td><?= $r->grandtotal;?></td>
        </tr>
        <?php $no++; $gm += $r->grandmodal; $total += $r->grandtotal; $qty += $r->total_qty; }?>
        <tr>
            <th colspan="8">Total</th>
            <th><?= $qty;?></th>
            <th>Rp<?= number_format($gm ?? 0);?></th>
            <th>Rp<?= number_format($total ?? 0);?></th>
        </tr>
    </table>
</body>

</html>