<?php foreach($hasil as $r){?>
<div class="col-50 mb-3">
    <button class="btn btn-outline-secondary btn-sm pt-2 pb-2 btn-menu btn-block pilih" data-id="<?= $r->id;?>">
        <?php 
        if($r->gambar !== '-'){
            if(file_exists(FCPATH.'assets/image/produk/'.$r->gambar)){
        ?>
        <img src="<?= base_url('assets/image/produk/'.$r->gambar);?>" class="img-fluid w-100 mb-2"
            style="height:120px;" />
        <br>
        <?php }}else{?>
        <i class="fa fa-image fa-4x"></i>
        <br>
        <b>Tidak Ada Gambar </b>
        <br>
        <?php }?>
        ( <?= $r->kategori;?> )
        <br>
        <b style="font-size:10pt;" class="text-primary"><?= $r->nama;?></b>
        <br>
        <b style="font-size:10pt;" class="text-success">Rp<?= number_format($r->harga_jual);?>,-</b>
        <br>
        (STOK : <?= $r->stok;?>x / LIMIT: <?= $r->stok_minim;?>x)
    </button>
</div>
<?php }?>

<script>
$('.pilih').on('click', function(e) {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "<?= base_url('kasir/add_cart');?>",
        type: "POST",
        data: {
            "id": id
        },
        dataType: 'json',
        timeout: 6000,
        beforeSend: function() {

        },
        success: function(data) {
            if (data.status == 'gagal') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal ',
                    text: 'Menu telah mencapai stok limit !',
                })
            } else {
                $('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
                $('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil ',
                    text: 'Menu telah ditambahkan ke keranjang !',
                })
            }
            // alert("Berhasil tambah keranjang !");
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