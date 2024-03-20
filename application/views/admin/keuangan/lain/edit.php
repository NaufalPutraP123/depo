<div class="clearfix"></div>
<?php
    $bulan_tes =array(
        '01'=>"Januari",
        '02'=>"Februari",
        '03'=>"Maret",
        '04'=>"April",
        '05'=>"Mei",
        '06'=>"Juni",
        '07'=>"Juli",
        '08'=>"Agustus",
        '09'=>"September",
        '10'=>"Oktober",
        '11'=>"November",
        '12'=>"Desember"
    );
?>
<div id="home">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <?php 
                    if(!empty($this->session->flashdata('success'))){  
                       echo alert_success($this->session->flashdata('success')); 
                    }
                    if(!empty($this->session->flashdata('failed'))){ 
                       echo alert_failed($this->session->flashdata('failed'));
                    }
                ?>
                <a href="<?php echo base_url('keuangan/lain') ?>" class="btn btn-danger btn-md mt-2">
                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                </a>
                <div class="clearfix"></div>
                <br>
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <h5 class="pt-2"> Edit Keuangan</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?=base_url('keuangan/update_lain')?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <select name="m" id="m" class="form-control">
                                            <?php
                                                $exp = explode('-', $edit->periode);
                                                $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                                $jlh_bln=count($bulan);
                                                $bln1 = array('01','02','03','04','05','06','07','08','09','10','11','12');
                                                $no=1;
                                                for($c=0; $c<$jlh_bln; $c+=1){
                                                    if(!empty($exp[0] == $bln1[$c])){
                                                        echo "<option value='$bln1[$c]' selected> $bulan[$c] </option>";
                                                    }else{ 
                                                        if($bln1[$c] == date('m')){
                                                            echo "<option value='$bln1[$c]' selected> $bulan[$c] </option>";
                                                        }else{
                                                            echo "<option value='$bln1[$c]'> $bulan[$c] </option>";
                                                        }
                                                    }
                                                $no++;}
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <?php
                                            $now=date('Y');
                                            echo "<select name='y' id='y' class='form-control'>";
                                            for ($a=2021;$a<=$now;$a++)
                                            {
                                                if(!empty($edit->year == $a)){
                                                    echo "<option value='$a' selected>$a</option>";
                                                }else{
                                                    if($a == date('Y')){
                                                        echo "<option value='$a' selected>$a</option>";
                                                    }else{
                                                        echo "<option value='$a'>$a</option>";
                                                    }
                                                }
                                            }
                                            echo "</select>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">No Ledger</label>
                                <select name="no_ledger" id="noledger" style="width:100%;" class="form-control select2">
                                    <option selected value="" disabled>- pilih ledger - </option>
                                    <?php foreach($ledger as $r){?>
                                    <option value="<?=$r->no_ledger?>" data-jen="<?=$r->jenis?>"
                                        data-val="<?=$r->keterangan?>"
                                        <?=$edit->no_ledger == $r->no_ledger ? 'selected' : ''?>><?=$r->no_ledger?> -
                                        <?=$r->keterangan?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <input type="hidden" placeholder="Misal : Penggajian Karyawan, Beli Alat Kebersihan"
                                class="form-control" value="<?=$edit->nama_urusan?>" name="nama_urusan" id="nama_urusan"
                                placeholder="">
                            <div class="form-group">
                                <label for="">Jenis Keuangan</label>
                                <select id="jenis" class="form-control @error(" jenis") is-invalid @enderror"
                                    name="jenis">
                                    <option value="" selected disabled>- pilih jenis -</option>
                                    <option value="Pemasukan"
                                        <?=$edit->jenis == 'Pemasukan' ? 'selected="selected"':''?>>Pemasukan</option>
                                    <option value="Pengeluaran"
                                        <?=$edit->jenis == 'Pengeluaran' ? 'selected="selected"':''?>>Pengeluaran
                                    </option>
                                </select>
                            </div>
                            <div class="form-group" id="masuk_uang">
                                <label for="">Jumlah Uang Masuk</label>
                                <input type="text" class="form-control"
                                    value="<?=number_format($edit->jumlah_masuk, 0, '.', '.')?>" name="jumlah_masuk"
                                    id="jumlah_masuk" placeholder="">
                            </div>
                            <div class="form-group" id="keluar_uang">
                                <label for="">Jumlah Uang Keluar</label>
                                <input type="text" class="form-control"
                                    value="<?=number_format($edit->jumlah_keluar, 0, '.', '.')?>" name="jumlah_keluar"
                                    id="jumlah_keluar" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea class="form-control" style="height: 100px" name="keterangan" id="keterangan"
                                    placeholder="Masukan Keterangan Jika ada"><?=$edit->keterangan?></textarea>
                            </div>
                            <div class="float-right">
                                <input type="hidden" name="id" value="<?=$edit->id?>">
                                <button class="btn btn-primary" id="proses">
                                    <i class="fa fa-edit"></i> Edit</button>
                                <a href="<?=base_url('keuangan/lain')?>" class="btn btn-danger">
                                    <i class="fa fa-angle-double-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#noledger').on('change', function() {
    var vald = $(this).find(':selected').attr('data-val');
    var valj = $(this).find(':selected').attr('data-jen');
    if (valj == 'Pemasukan') {
        $('#jenis option[value="Pengeluaran"]').removeAttr("selected");
        $('#jenis option[value="' + valj + '"]').attr('selected', 'selected');
    } else if (valj == 'Pengeluaran') {
        $('#jenis option[value="Pemasukan"]').removeAttr("selected");
        $('#jenis option[value="' + valj + '"]').attr('selected', 'selected');
    } else {
        $('#jenis option[value="Pemasukan"]').removeAttr("selected");
        $('#jenis option[value="Pengeluaran"]').removeAttr("selected");
    }
});
</script>
<script>
var rupiah1 = document.getElementById('jumlah_masuk');
rupiah1.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah1.value = formatRupiah(this.value, '');
});
var rupiah2 = document.getElementById('jumlah_keluar');
rupiah2.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah2.value = formatRupiah(this.value, '');
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