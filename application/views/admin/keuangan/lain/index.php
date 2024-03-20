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
            <div class="col-sm-12">
                <?php 
                    if(!empty($this->session->flashdata('success'))){  
                       echo alert_success($this->session->flashdata('success')); 
                    }
                    if(!empty($this->session->flashdata('failed'))){ 
                       echo alert_failed($this->session->flashdata('failed'));
                    }
                ?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success btn-md mt-2 mr-2" data-toggle="modal"
                    data-target="#modelId">
                    <i class="fa fa-plus"></i> Tambah Aktivitas Keuangan
                </button>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-md mt-2" data-toggle="modal"
                    data-target="#modelIdFilter">
                    <i class="fa fa-search"></i> Pencarian
                </button>

                <a href="<?= $url_pdf;?>" class="btn btn-success mt-2 btn-md ml-1">
                    <i class="fa fa-download"></i> File Excel
                </a>
                <!-- <a href="<?php echo $url_pdf ?>" class="btn btn-danger btn-md mt-2 ml-2" target="_blank">
                    <i class="fa fa-print"></i> Cetak PDF
                </a> -->
                <a href="<?php echo base_url('keuangan/lain') ?>" class="btn btn-success btn-md mt-2 ml-2">
                    <i class="fas fa-sync"></i> Refresh Page
                </a>
                <div class="clearfix"></div>
                <br>
                <div class="card card-rounded">
                    <div class="card-header bg-primary text-white">
                        <h5 class="pt-2">
                            <?php if(!empty($this->input->get('a') && $this->input->get('b'))){?>
                            ( <?php echo $this->input->get('no_ledger').' - '.$nm_ledger ?> )
                            Periode
                            <?php echo time_explode_date($this->input->get('a'),'id') ?>
                            s.d.
                            <?php echo time_explode_date($this->input->get('b'),'id') ?>
                            <?php }else{?>
                            Periode Bulan <?php echo bln('id').' '.date('Y')?>
                            <?php }?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-1">
                            <table class="table table-light table-striped w-100" id="dataTable1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Ledger</th>
                                        <th>Nama Aktivitas</th>
                                        <th>Jenis Keuangan</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Date</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th>Rp<?php echo number_format($tot->masuk)?></th>
                                        <th>Rp<?php echo number_format($tot->keluar)?></th>
                                        <th>#</th>
                                        <th>#</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelIdFilter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-search"></i> Pencarian Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="<?= base_url('keuangan/lain');?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">No Ledger</label>
                        <select name="no_ledger" style="width:100%;" class="form-control select2">
                            <option selected value="" disabled>- pilih ledger - </option>
                            <?php foreach($ledger as $r){?>
                            <option value="<?= $r->no_ledger;?>"><?= $r->no_ledger?> - <?= $r->keterangan?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Start</label>
                        <input type="date" required class="form-control" value="<?= $this->input->get('a')?>" name="a"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal End</label>
                        <input type="date" required class="form-control" value="<?= $this->input->get('b')?>" name="b"
                            placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelId" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Aktivitas Keuangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url('keuangan/store_lain')?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="m" id="m" class="form-control" required>
                                    <?php
                                        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                        $jlh_bln=count($bulan);
                                        $bln1 = array('01','02','03','04','05','06','07','08','09','10','11','12');
                                        $no=1;
                                        for($c=0; $c<$jlh_bln; $c+=1){
                                            if(!empty($this->input->get('m') == $bln1[$c])){
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
                                    echo "<select name='y' id='y' class='form-control' required>";
                                    for ($a=2021;$a<=$now;$a++)
                                    {
                                        if(!empty($this->input->get('y') == $a)){
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
                            <option value="<?= $r->no_ledger?>" data-jen="<?= $r->jenis?>"
                                data-val="<?= $r->keterangan?>"><?= $r->no_ledger?> - <?= $r->keterangan?></option>
                            <?php }?>
                        </select>
                    </div>
                    <input type="hidden" placeholder="Misal : Penggajian Karyawan, Beli Alat Kebersihan"
                        class="form-control" name="nama_urusan" id="nama_urusan" placeholder="">
                    <div class="form-group">
                        <label for="">Jenis Keuangan</label>
                        <select id="jenis" class="form-control" name="jenis" required>
                            <option value="" selected disabled>- pilih jenis -</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="form-group" id="masuk_uang">
                        <label for="">Jumlah Uang Masuk</label>
                        <input type="text" class="form-control" name="jumlah_masuk" id="jumlah_masuk" placeholder="">
                    </div>
                    <div class="form-group" id="keluar_uang">
                        <label for="">Jumlah Uang Keluar</label>
                        <input type="text" class="form-control" name="jumlah_keluar" id="jumlah_keluar" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" style="height: 100px" name="keterangan" id="keterangan"
                            placeholder="Masukan Keterangan Jika ada"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#masuk_uang').hide();
$('#keluar_uang').hide();
$('#masuk_uang').val(0);
$('#keluar_uang').val(0);
$(document).ready(function() {
    $('#jenis').change(function() {
        var cek = $(this).val();
        if (cek == 'Pemasukan') {
            $('#masuk_uang').show();
            $('#keluar_uang').hide();
            $('#keluar_uang').val(0);
        } else if (cek == 'Pengeluaran') {
            $('#masuk_uang').hide();
            $('#keluar_uang').show();
            $('#masuk_uang').val(0);
        } else {
            $('#masuk_uang').hide();
            $('#keluar_uang').hide();
            $('#masuk_uang').val(0);
            $('#keluar_uang').val(0);
        }
    });
});
$('#noledger').on('change', function() {
    var vald = $(this).find(':selected').attr('data-val');
    var valj = $(this).find(':selected').attr('data-jen');
    $('#nama_urusan').val(vald);
    if (valj == 'Pemasukan') {
        $('#jenis option[value=Pengeluaran]').removeAttr("selected");
        $('#jenis option[value="' + valj + '"]').attr('selected', 'selected');
        $('#masuk_uang').show();
        $('#keluar_uang').hide();
        $('#keluar_uang').val(0);
    } else if (valj == 'Pengeluaran') {
        $('#jenis option[value=Pemasukan]').removeAttr("selected");
        $('#jenis option[value="' + valj + '"]').attr('selected', 'selected');
        $('#masuk_uang').hide();
        $('#keluar_uang').show();
        $('#masuk_uang').val(0);
    } else {
        $('#jenis option[value="Pemasukan"]').removeAttr("selected");
        $('#jenis option[value="Pengeluaran"]').removeAttr("selected");
        $('#masuk_uang').hide();
        $('#keluar_uang').hide();
        $('#masuk_uang').val(0);
        $('#keluar_uang').val(0);
    }
});
var tabel = null;
$(document).ready(function() {
    tabel = $('#dataTable1').DataTable({
        "processing": true,
        'responsive': true,
        "serverSide": true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= $url;?>", // URL file untuk proses select datanya
            "type": "POST",
            "dataType": "JSON",
        },
        "deferRender": true,
        "aLengthMenu": [
            [5, 10, 50],
            [5, 10, 50]
        ], // Combobox Limit
        "columns": [{
                "data": 'id',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'no_ledger'
            },
            {
                data: 'ket'
            },
            {
                data: 'jenis'
            },
            {
                data: 'jumlah_masuk',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'jumlah_keluar',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'date'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    var url_edit = '<?= base_url("keuangan/edit")?>/' + row.id;
                    var url_del = '<?= base_url("keuangan/delete_lain?id=")?>' + row.id;
                    return `<a href="${url_edit}" class="btn btn-success btn-sm"> <i class="fa fa-edit" title="Edit Data keuangan"></i> </a> 
                                <a href="${url_del}" onclick="javascript:return confirm('apakah data ingin dihapus ?');"
                                    class="delete_keuangan btn btn-danger btn-sm"> <i class="fa fa-trash" title="Delete Data Keuangan"></i> </a>`;
                }
            },
        ],
    });
});
$('#dataTable1 tbody').on('click', '.delete_keuangan', function() {
    var id = $(this).attr('data-id');
    var url_destroy = '<?= base_url("keuangan/delete") ?>/' + id;
    swal({
        title: 'Hapus Data ! ',
        text: "Apakah anda yakin data akan dihapus ? ",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                url: url_destroy,
                type: "POST",
                timeout: 60000,
                success: function(html) {
                    $('#dataTable1').DataTable().ajax.reload();
                },
                'error': function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        alert("request timeout");
                    } else {
                        alert("request timeout");
                    }
                }
            });
        } else {
            swal({
                title: "Dibatalkan !",
                icon: "success",
            })
        }
    });
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