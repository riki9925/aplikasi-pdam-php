<?php
include "../config.php";
?>
<script type="text/javascript">
function datatgl() {
    var date = $('#tanggal').val();
  $('#data').load('modal/tagihan.php?date='+date);
}

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth());
    // Initialize Datepicker
    $('.input-datepicker, .input-daterange').datepicker({weekStart: 1, format: "mm-yyyy",viewMode: "months", minViewMode: "months"}).on('changeDate', function(e){ $(this).datepicker('hide'); });
    $('#tanggal').datepicker('setDate', today);
</script>
        <!-- <script src="js/app.js"></script> -->


<!-- Table Styles Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="header-section">
                <h1>Laporan Pembayaran (LUNAS)</h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="block full">
            <div class="block-title">
                <h2>BULAN LAPORAN</h2>
            </div>
            <input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm" placeholder="yyyy-mm" onchange="datatgl()">
        </div>
    </div>
</div>

<div class="block full" id="data">
</div>
<script type="text/javascript">

$('#btnupdate').hide();
$('#btncancel').hide();
$('#tambah').show();

$( "#form-validation" ).submit(function( event ) {
    if ($('#form-validation').valid()){
       simpan();
    }
    event.preventDefault();
});

$( "#btnupdate" ).click(function( event ) {
    if ($('#form-validation').valid()){
       ubah();
    }
    event.preventDefault();
});

$("#sekarang").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});

function simpan(){
    var pegawai     = $('#id_pegawai').val();
    var pelanggan   = $('#id_pelanggan').val();
    var lalu        = $('#lalu').val().replace(/[^0-9-.]/g, '');
    var sekarang    = $('#sekarang').val().replace(/[^0-9-.]/g, '');
    var jumlah      = $('#jumlah').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'tambah='+pegawai+'&pelanggan='+pelanggan+'&lalu='+lalu+'&sekarang='+sekarang+'&jumlah='+jumlah, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Tambah data meter berhasil', 'success');
                setTimeout(function(){ datatgl(); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data meter gagal', 'warning');
            }
        },
    });
}

function ubah(){
    var id          = $('#id_meter').val();
    var sekarang    = $('#sekarang').val().replace(/[^0-9-.]/g, '');
    var jumlah      = $('#jumlah').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'ubah='+id+'&sekarang='+sekarang+'&jumlah='+jumlah, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit data meter berhasil', 'success');
                setTimeout(function(){ datatgl(); }, 1000);
                actioncancel();
            }
            else{
                swal('PERINGATAN!', 'Edit data meter gagal', 'warning');
            }
        },
    });
}

function hapus(id){                        
    swal({
      title: "PERINGATAN!",
      text: "Apakah anda yakin ingin menghapus?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes!",
      closeOnConfirm: false
    },
    function(){
        $.ajax({
            url     : 'modal/m_meter.php',
            data    : 'hapus='+id, 
            type    : 'POST',
            dataType: 'html',
            success : function(pesan){
                if(pesan=='ok'){
                    swal({title: "SUKSES!",text: "Data telah terhapus!",type:"success",timer: 1500,showConfirmButton: false});
                    setTimeout(function(){ datatgl(); }, 1000);
                }else{
                    swal('PERINGATAN!', 'Hapus data meter gagal', 'warning');
                }
            },
        });
    });
}

function lihat(id){
    $('#submit').hide();
    $('#update').show();
    $('#judul').text('EDIT DATA PELANGGAN');

    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'lihat='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#form-validation')[0].reset();
                $('#id_meter').val(pesan.id_meter);
                // $('#id_pegawai').val(pesan.id_peg).change();
                // $('#id_pelanggan').val(pesan.id_pel).change();
                $('#title-input').text(pesan.pelanggan);
                $('#lalu').val(pesan.lalu);
                $('#sekarang').val(pesan.sekarang);
                $('#jumlah').val(pesan.jumlah);
                $('#btnupdate').show();
                $('#btncancel').show();
                $('#tambah').hide();
                $('#h_pegawai').hide();
                $('#h_pelanggan').hide();
            }
            else{
                swal('PERINGATAN!', 'Lihat data pelanggan gagal', 'warning');
            }
        },
    });
}

function actioncancel(){
    $('#form-validation')[0].reset();
    $('#btnupdate').hide();
    $('#btncancel').hide();
    $('#tambah').show();
    $('#h_pegawai').show();
    $('#h_pelanggan').show();
    $('#title-input').text('INPUT DATA');
}

function check_lalu(){
    var id = $('#id_pelanggan').val();
    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'lalu='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#lalu').val(pesan.sekarang.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                if ($('#jumlah').val() != '') {
                   check_jumlah();
                }
            }
            else{
                $('#lalu').val('0');
            }
        },
    });
}

function check_jumlah(){
    var lalu = $('#lalu').val().replace(/[^0-9-.]/g, '');
    var skrg = $('#sekarang').val().replace(/[^0-9-.]/g, '');
    // swal(lalu+skrg);
    var total = parseInt(skrg)-parseInt(lalu);
    if ($('#lalu').val() == '') {
        swal('PERINGATAN!', 'Volume bulan lalu kosong', 'warning');
        $('#sekarang').val('');
        $('#jumlah').val('');
    }else
    if (parseInt(skrg) < parseInt(lalu)) {
        swal('PERINGATAN!', 'Bulan ini terlalu kecil', 'warning');
        $('#sekarang').val('');
        $('#jumlah').val('');
    }else{
        $('#jumlah').val(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    }
}


// datatgl();
$('#id_pelanggan').select2();
$('#id_pegawai').select2();

</script>